<?php

namespace App\Http\Controllers;

use File;
use DateTimeZone;
use App\Models\Hrm;
use App\Models\User;
use App\Models\Shift;
use App\Models\Branch;
use App\Models\Document;
use App\Models\Employee;
use App\Mail\MeetingMail;
use App\Models\Department;
use App\Models\Designation;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\BankInformation;
use App\Models\EmployeeDocument;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\DataTables\EmployeeDataTable;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()->can('Manage Employee')) {
            if (0) {
                $employees = Employee::where('user_id', '=', Auth::user()->id)->get();
            } else {
                $employees = Employee::all();
            }

            return view('employee.index', compact('employees'));
        } else {
            return redirect()
                ->back()
                ->with('error', __('Permission denied.'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (Auth::user()->can('Create Employee')) {
            $documents = Document::all();
            $branches = Branch::all();
            $departments = Department::all();
            $designations = Designation::all();
            $employees = User::all();
            $roles = Role::all();
            $all_employee = Employee::all();
            $shifts = Shift::all();
            $employeesId = Auth::user()->employeeIdFormat($this->employeeNumber());
            //dd($employeesId);
            $timezonelist = DateTimeZone::listIdentifiers(DateTimeZone::ALL);

            return view('employee.create', compact('employees', 'employeesId', 'departments', 'designations', 'documents', 'branches', 'roles', 'all_employee', 'shifts', 'timezonelist'));
        } else {
            return redirect()
                ->back()
                ->with('error', __('Permission denied.'));
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (Auth::user()->can('Create Employee')) {
            $request->validate(
                [
                    'name' => 'required',
                    'gender' => 'required',
                    'email' => 'required|unique:users',
                    'password' => 'required',
                    'document.*' => 'mimes:jpeg,png,jpg,gif,svg,pdf,doc,zip|max:20480',
                    'role' => 'required',
                ],
                [
                    'name.required' => 'Name is required',
                    'gender.required' => 'Gender is required',
                    'email.required' => 'Email is required',
                    'password.required' => 'Password is required',
                    'document.*.required' => 'Document is required',
                    'role' => 'Role is required',
                ],
            );

            $employee = DB::transaction(function () use ($request) {
                $user = User::create([
                    'name' => $request['name'],
                    'email' => $request['email'],
                    'password' => Hash::make($request['password']),
                    'lang' => 'en',
                    'timezone' => $request->timezone,
                ]);

                if ($request->hasFile('photo')) {
                    $filenameWithExt = $request->file('photo')->getClientOriginalName();
                    $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                    $extension = $request->file('photo')->getClientOriginalExtension();
                    $fileNameToStore = $filename . '_' . time() . '.' . $extension;
                    $dir = public_path('storage/avatar/');
                    $image_path = $dir . $user['avater'];

                    if (File::exists($image_path)) {
                        File::delete($image_path);
                    }
                    if (!file_exists($dir)) {
                        mkdir($dir, 0777, true);
                    }
                    // $path = $request->file('photo')->storeAs('avatar', $fileNameToStore, 'public');
                    $path = $request->file('photo')->move($dir, $fileNameToStore);
                }

                if (!empty($request->photo)) {
                    $user['avater'] = $fileNameToStore;
                }
                if ($user->isDirty()) {
                    $user->save();
                }
                // $user->save();
                $role_r = Role::findById($request->role);
                $user->assignRole($role_r);

                Hrm::create([
                    'user_id' => $user->id,
                    'type' => 'employee',
                    'active_status' => 1,
                ]);

                if (!empty($request->document) && !is_null($request->document)) {
                    $document_implode = implode(',', array_keys($request->document));
                } else {
                    $document_implode = null;
                }


                $employee = Employee::create([
                    'user_id' => $user->id,
                    'dob' => new Carbon($request->dob),
                    'gender' => $request['gender'],
                    'phone' => $request['phone'],
                    'address' => $request['address'],
                    'employee_id' => $this->employeeNumber(),
                    'branch_id' => $request['branch_id'],
                    'department_id' => $request['department_id'],
                    'designation_id' => $request['designation_id'],
                    'date_of_joining' => new Carbon($request->company_doj),
                    'documents' => $document_implode,
                    'salary_type' => $request['salary_type'],
                    'salary' => $request['salary'],
                    'shift_id' => $request['shift_id'],
                    'can_overtime' => $request['can_overtime'],
                    'start_time' => $request['start_time'],
                    'end_time' => $request['end_time'],
                    'reporting_boss_id' => $request['reporting_boss'],
                ]);

                // dd($request['shift_id']);
                // $employee->save();

                BankInformation::create([
                    'employee_id' => $employee->id,
                    'account_holder_name' => $request['account_holder_name'],
                    'account_number' => $request['account_number'],
                    'bank_name' => $request['bank_name'],
                    'bank_identifier_code' => $request['bank_identifier_code'],
                    'bank_location' => $request['branch_location'],
                    'tax_payer_id' => $request['tax_payer_id'],
                ]);

                if ($request->hasFile('document')) {
                    foreach ($request->document as $key => $document) {
                        $filenameWithExt = $request->file('document')[$key]->getClientOriginalName();
                        $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                        $extension = $request->file('document')[$key]->getClientOriginalExtension();
                        $fileNameToStore = $filename . '_' . time() . '.' . $extension;
                        $dir = storage_path('uploads/document/');
                        $image_path = $dir . $filenameWithExt;

                        if (File::exists($image_path)) {
                            File::delete($image_path);
                        }

                        if (!file_exists($dir)) {
                            mkdir($dir, 0777, true);
                        }
                        $path = $request->file('document')[$key]->storeAs('uploads/document/', $fileNameToStore);
                        $employee_document = EmployeeDocument::create([
                            'employee_id' => $employee['employee_id'],
                            'document_id' => $key,
                            'document_value' => $fileNameToStore,
                        ]);
                        $employee_document->save();
                    }
                }

                return $employee;
            });

            // Mail::to($employee->user->email)->send(new MeetingMail([
            //     'title' => "Dear, ".$employee->user->name,
            //     'body' => "Your account has been created in HRMplus. Your credentials are: <br> Email: ".$employee->user->email."<br>Password: ".$request['password']
            // ]));

            return redirect()
                ->route('employee.index')
                ->with('success', __('Employee  successfully created.'));
        } else {
            return redirect()
                ->back()
                ->with('error', __('Permission denied.'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     */
    public function show($employee, Request $request)
    {
        $employee = Employee::with('designation')->find($employee);
        if ($request->ajax()) {
            return response()->json($employee);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (Auth::user()->can('Edit Employee')) {
            $documents = Document::all();
            $employee = Employee::find($id);
            $bankinfo = BankInformation::where('employee_id', '=', $employee->id)->first();
            $employeesId = Auth::user()->employeeIdFormat($employee->employee_id);
            //dd($bankinfo);
            $shifts = Shift::all();
            $timezonelist = DateTimeZone::listIdentifiers(DateTimeZone::ALL);
            return view('employee.edit', compact('employee', 'employeesId', 'documents', 'bankinfo', 'shifts', 'timezonelist'));
        } else {
            return redirect()
                ->back()
                ->with('error', __('Permission denied.'));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if (Auth::user()->can('Edit Employee')) {
            $request->validate(
                [
                    'name' => 'required',
                    'gender' => 'required',
                    'email' => 'required',
                    'document.*' => 'mimes:jpeg,png,jpg,gif,svg,pdf,doc,zip|max:20480',
                ],
                [
                    'name.required' => 'Name is required',
                    'gender.required' => 'Gender is required',
                    'email.required' => 'Email is required',
                    'password.required' => 'Password is required',
                    'document.*.required' => 'Document is required',
                ],
            );
            DB::transaction(function () use ($request, $id) {
                $employee = Employee::findOrFail($id);

                $employee->dob = $request->dob;
                $employee->gender = $request->gender;
                $employee->phone = $request->phone;
                $employee->address = $request->address;
                $employee->date_of_joining = $request->company_doj;
                $employee->salary_type = $request->salary_type;
                $employee->can_overtime = $request->can_overtime;
                $employee->start_time = $request->start_time;
                $employee->end_time = $request->end_time;
                $employee->shift_id = $request->shift_id;
                $employee->save();

                //dd( $employee);

                $user = User::findOrFail($employee->user_id);
                $user->name = $request->name;
                $user->email = $request->email;
                $user->timezone = $request->timezone;
                $user->save();

                if ($request->hasFile('photo')) {
                    $filenameWithExt = $request->file('photo')->getClientOriginalName();
                    $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                    $extension = $request->file('photo')->getClientOriginalExtension();
                    $fileNameToStore = $filename . '_' . time() . '.' . $extension;
                    $dir = public_path('storage/avatar/');
                    $image_path = $dir . $user['avater'];

                    if (File::exists($image_path)) {
                        File::delete($image_path);
                    }
                    if (!file_exists($dir)) {
                        mkdir($dir, 0777, true);
                    }
                    $path = $request->file('photo')->move($dir, $fileNameToStore);
                }

                if (!empty($request->photo)) {
                    $user['avater'] = $fileNameToStore;
                }
                if ($user->isDirty()) {
                    $user->save();
                }

                $bankinfo = BankInformation::where('employee_id', '=', $employee->employee_id)->first();
                if ($bankinfo) {
                    $bankinfo->account_holder_name = $request->account_holder_name;
                    $bankinfo->account_number = $request->account_number;
                    $bankinfo->bank_name = $request->bank_name;
                    $bankinfo->bank_identifier_code = $request->bank_identifier_code;
                    $bankinfo->bank_location = $request->bank_location;
                    $bankinfo->tax_payer_id = $request->tax_payer_id;
                    $bankinfo->save();
                    //dd($bankinfo);
                }

                if ($request->document) {
                    foreach ($request->document as $key => $document) {
                        if (!empty($document)) {
                            $filenameWithExt = $request->file('document')[$key]->getClientOriginalName();
                            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                            $extension = $request->file('document')[$key]->getClientOriginalExtension();
                            $fileNameToStore = $filename . '_' . time() . '.' . $extension;

                            $dir = storage_path('uploads/document/');
                            $image_path = $dir . $filenameWithExt;

                            if (File::exists($image_path)) {
                                File::delete($image_path);
                            }
                            if (!file_exists($dir)) {
                                mkdir($dir, 0777, true);
                            }
                            $path = $request->file('document')[$key]->storeAs('uploads/document/', $fileNameToStore);

                            $employee_document = EmployeeDocument::where('employee_id', $employee->employee_id)
                                ->where('document_id', $key)
                                ->first();

                            if (!empty($employee_document)) {
                                $employee_document->document_value = $fileNameToStore;
                                $employee_document->save();
                            } else {
                                $employee_document = new EmployeeDocument();
                                $employee_document->employee_id = $employee->employee_id;
                                $employee_document->document_id = $key;
                                $employee_document->document_value = $fileNameToStore;
                                $employee_document->save();
                            }
                        }
                    }
                }
            });


            return redirect()
                ->route('employee.index')
                ->with('success', 'Employee successfully updated.');
        } else {
            return redirect()
                ->back()
                ->with('error', __('Permission denied.'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (Auth::user()->can('Delete Employee')) {
            $employee = Employee::findOrFail($id);
            $user = User::where('id', '=', $employee->user_id)->first();
            $emp_documents = EmployeeDocument::where('employee_id', $employee->employee_id)->get();
            $hrm = Hrm::where('user_id', '=', $employee->user_id)->first();

            $employee->delete();
            $user->delete();
            $hrm->delete();
            $bankinfo = BankInformation::where('employee_id', '=', $employee->employee_id)->first();
            if ($bankinfo) {
                $bankinfo->delete();
            }
            $dir = storage_path('uploads/document/');
            foreach ($emp_documents as $emp_document) {
                $emp_document->delete();
                if (!empty($emp_document->document_value)) {
                    unlink($dir . $emp_document->document_value);
                }
            }

            return redirect()
                ->route('employee.index')
                ->with('success', 'Employee successfully deleted.');
        } else {
            return redirect()
                ->back()
                ->with('error', __('Permission denied.'));
        }
    }

    function employeeNumber()
    {
        $latest = Employee::latest('id')->first();
        if (!$latest) {
            return 1;
        }

        return $latest->employee_id + 1;
    }

    public function loadDatatable(EmployeeDataTable $datatable)
    {
        return $datatable->ajax();
    }

    public function getDocument(EmployeeDocument $employeeDocument)
    {
        if (Auth::user()->can('Manage Employee') or $employeeDocument->employee_id == auth()->user()->employee->id) {
            if (file_exists(storage_path("app/uploads/document/" . $employeeDocument->document_value))) {
                return response()->file(storage_path("app/uploads/document/" . $employeeDocument->document_value));
            }
            abort(404);
        }
    }

    public function employeeSearch(Request $request)
    {
        $employees = User::where('name', 'like', "%$request->term%")->with('employee')->whereHas('employee')->get();
        $result = [];

        foreach ($employees as $employee) {
            $result[] = [
                'id' => $employee->employee->id,
                'text' => $employee->name,
            ];
        }
        return response()->json(['results' => $result]);
    }
}
