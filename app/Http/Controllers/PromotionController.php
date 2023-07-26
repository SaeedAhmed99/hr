<?php

namespace App\Http\Controllers;

use App\Models\Notice;
use App\Models\Employee;
use App\Models\Promotion;
use App\Models\Designation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\DataTables\PromotionDataTable;
use Illuminate\Support\Facades\Session;

class PromotionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        if (Auth::user()->can('Manage Promotion') || Auth::user()->can('Show Promotion')) {
            if (!Auth::user()->can('Create Promotion')) {
                $employees = Employee::where('user_id', '=', Auth::user()->id)->get();
                // $promotions = Promotion::where('employee_id', '=', $emp->id)->get();
            } else {
                // $promotions = Promotion::all();
                $employees = Employee::all();
            }
            $designations = Designation::all();

            return view('promotion.index', compact('employees', 'designations'));
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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        if (Auth::user()->can('Create Promotion')) {
            $rules = [
                'employee' => 'required',
                'designation' => 'required_without:salary',
                'salary' => 'required_without:designation',
                'promotion_title' => 'required',
                'promotion_date' => 'required_without:promotion_effective_immidiate',
            ];
            if (isset($request->salary)) {
                $rules['salary'] = 'integer|gt:old_salary';
            }
            $request->validate($rules);
            $employee = Employee::findOrFail($request->employee);

            $promotion = new Promotion();
            $promotion->employee_id = $request->employee;

            $promotion->old_designation_id = $employee->designation_id;
            $promotion->new_designation_id = ($request->designation) ? $request->designation : $employee->designation_id;

            $promotion->old_salary = $employee->salary;
            $promotion->new_salary = ($request->salary) ? $request->salary : $employee->salary;

            $promotion->promotion_title = $request->promotion_title;
            $promotion->promotion_date = isset($request->promotion_effective_immidiate) ? now() : $request->promotion_date;
            $promotion->description = $request->description;
            $promotion->promoted_by = auth()->id();
            $promotion->save();

            if (isset($request->promotion_effective_immidiate)) {
                $employee->designation_id = $promotion->new_designation_id;
                $employee->salary = $promotion->new_salary;
                if ($employee->isDirty()) {
                    $employee->save();
                }
            }

            $designation = Designation::whereIn('id', [
                $promotion->new_designation_id, $promotion->old_designation_id
            ])->get();

            $message = "";

            if ($promotion->old_designation_id != $promotion->new_designation_id) {
                $message .= "Promoted from " . $designation->firstWhere('id', $promotion->old_designation_id)->name . " to " . $designation->firstWhere('id', $promotion->new_designation_id)->name;
            }

            if ($promotion->old_designation_id != $promotion->new_designation_id and $promotion->old_salary != $promotion->new_salary) {
                $message .= " with ";
            }

            if ($promotion->old_salary != $promotion->new_salary) {
                $message .= "Increament from " . $promotion->old_salary . " to " . $promotion->new_salary;
            }

            Notice::create([
                'type' => "Promotion",
                'title' => $message,
                'body' => $promotion->description,
                'notice_date' => $promotion->promotion_date,
                'employee_id' => $employee->id
            ]);

            return redirect()
                ->route('promotion.index')
                ->with('success', __('Transfer successfully created.'));
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
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit($id)
    {
        if (Auth::user()->can('Edit Promotion')) {
            $promotion = Promotion::with('old_designation', 'employee.user')->find($id);
            return response()->json($promotion);
        } else {
            return response()->json(['error' => __('Permission denied.')], 401);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        if (Auth::user()->can('Edit Promotion')) {
            // $request->validate([
            //     'employee_update' => 'required',
            //     'designation_update' => 'required',
            //     'promotion_title_update' => 'required',
            //     'promotion_date_update' => 'required',
            // ]);
            $request->validate([
                'employee_id' => 'required',
                'designation' => 'required_without:salary',
                'salary' => 'required_without:designation|gt:old_salary',
                'promotion_title' => 'required',
                'promotion_date' => 'required_without:promotion_effective_immidiate',
            ]);

            $promotion = Promotion::find($id);
            $employee = Employee::find($promotion->employee_id);
            $promotion->old_designation_id = $employee->designation_id;
            $promotion->new_designation_id = ($request->designation) ? $request->designation : $employee->designation_id;

            $promotion->old_salary = $employee->salary;
            $promotion->new_salary = ($request->salary) ? $request->salary : $employee->salary;

            $promotion->promotion_title = $request->promotion_title;
            $promotion->promotion_date = isset($request->promotion_effective_immidiate) ? now() : $request->promotion_date;
            $promotion->description = $request->description;
            $promotion->promoted_by = auth()->id();
            $promotion->save();

            if (isset($request->promotion_effective_immidiate)) {
                $employee->designation_id = $promotion->new_designation_id;
                $employee->salary = $promotion->new_salary;
                if ($employee->isDirty()) {
                    $employee->save();
                }
            }

            return redirect()
                ->route('promotion.index')
                ->with('success', __('Document type successfully updated.'));
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
        if (Auth::user()->can('Delete Promotion')) {
            $travel = Promotion::findOrFail($id);
            $travel->delete();

            Session::flash('message', 'Category successfully updated!');
        } else {
            return redirect()
                ->back()
                ->with('error', __('Permission denied.'));
        }
    }

    public function loadDatatable(PromotionDataTable $datatable)
    {
        return $datatable->ajax();
    }
}
