<?php

namespace App\Http\Controllers;

use App\Models\Hrm;
use App\Models\User;
use Illuminate\Http\Request;
use App\DataTables\UserDataTable;
use App\Models\Employee;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use File;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()->can('Manage User')) {
            $users = User::all();
            //dd($users);

            return view('user.index', compact('users'));
        }
        // else
        // {
        //     return redirect()->back()->with('error', __('Permission denied.'));
        // }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (Auth::user()->can('Create User')) {
            $user = Auth::user();
            $roles = Role::all();
            //dd($roles);
            return view('user.create', compact('roles'));
        } else {
            return response()->json(['error' => __('Permission denied.')], 401);
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
        if (Auth::user()->can('Create User')) {
            $request->validate(
                [
                    'name' => 'required',
                    'email' => 'required|unique:users',
                    'password' => 'required',
                    'role' => 'required',
                ],
                [
                    'name.required' => 'Name is required',
                    'email.required' => 'Email is required',
                    'password.required' => 'Password is required',
                    'role.required' => 'Role is required',
                ],
            );

            $role_r = Role::findById($request->role);
            $user = User::create([
                'name' => $request['name'],
                'email' => $request['email'],
                'password' => Hash::make($request['password']),
                'lang' => !empty($default_language) ? $default_language->value : '',
            ]);

            Hrm::create([
                'user_id' => $user->id,
                'type' => $role_r->name,
                'active_status' => 1,
            ]);
            $user->assignRole($role_r);
            //$user->userDefaultData();

            return redirect()
                ->route('user.index')
                ->with('success', __('User successfully created.'));
        } else {
            return response()->json(['error' => __('Permission denied.')], 401);
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
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (Auth::user()->can('Edit User')) {
            $user = User::find($id);
            $roles = Role::all();
            //dd($roles);
            //$roles = Role::all();
            $role_name = $user->getRoleNames();

            // dd($user->getRoleNames()[0]);
            return view('user.edit', compact('user', 'roles', 'role_name'));
        } else {
            return response()->json(['error' => __('Permission denied.')], 401);
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
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'unique:users,email,' . $id,
        ]);
        if ($validator->fails()) {
            $messages = $validator->getMessageBag();

            return redirect()
                ->back()
                ->with('error', $messages->first());
        }

        if (Auth::user()->can('Edit User')) {
            $user = User::findOrFail($id);
            //dd($request->role);
            $role = Role::findById($request->role);

            $input = $request->all();
            $input['password'] = Hash::make($request['password']);
            //$input['type'] = $role->name;
            $user->fill($input)->save();

            $user->syncRoles($role);
            //Hrm::where('user_id',$user->id)->update(['type'=> $role->name]);

            return redirect()
                ->route('user.index')
                ->with('success', 'User successfully updated.');
        } else {
            return response()->json(['error' => __('Permission denied.')], 401);
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
        if (Auth::user()->can('Delete User')) {
            $user = User::findOrFail($id);
            $hrm_user = Hrm::where('user_id', '=', $id);
            $employee = Employee::where('user_id', '=', $id);
            $user->delete();
            $hrm_user->delete();
            $employee->delete();

            return redirect()
                ->route('user.index')
                ->with('success', 'User successfully deleted.');
        } else {
            return redirect()
                ->back()
                ->with('error', __('Permission denied.'));
        }
    }

    public function loadDatatable(UserDataTable $datatable)
    {
        return $datatable->ajax();
    }

    public function profile($user = NULL)
    {
        if ($user and Auth::user()->can("Manage Employee")) {
            $userDetail = User::findOrFail($user);
        } else if (Auth::user()->isEmployee()) {
            $userDetail = Auth::user();
        } else {
            abort(401);
        }

        return view('user.profile')->with('userDetail', $userDetail);
    }

    public function changePassword()
    {
        $userDetail = Auth::user();

        return view('user.change_password', compact('userDetail'));
    }

    public function profile_update(Request $request, $id)
    {
        // $user = Auth::user();
        $user = User::find($id);
        // $user = User::findOrFail($userDetail['id']);

        $request->validate([
            'name' => 'required',
            'dob' => 'required',
            'phone' => 'required',
            'address' => 'required',
            'photo' => 'mimes:jpeg,png,jpg|max:20480',
        ]);
        //dd($request->name);

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
        $user['name'] = $request['name'];
        if ($user->isDirty()) {
            $user->save();
        }

        $employee = Employee::where('user_id', '=', $user->id)->first();
        $employee->dob = $request->dob;
        $employee->phone = $request->phone;
        $employee->address = $request->address;
        if ($employee->isDirty()) {
            $employee->save();
        }

        return redirect()
            ->back()
            ->with('success', 'Profile successfully updated.');
        //dd($employee);
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:6',
            'confirm_password' => 'required|same:new_password',
        ]);
        $objUser = Auth::user();
        $request_data = $request->All();
        $current_password = $objUser->password;
        if (Hash::check($request_data['current_password'], $current_password)) {
            $user_id = Auth::User()->id;
            $obj_user = User::find($user_id);
            $obj_user->password = Hash::make($request_data['new_password']);
            $obj_user->save();

            return redirect()
                ->back()
                ->with('success', __('Password successfully updated.'));
        } else {
            return redirect()
                ->back()
                ->with('error', __('Please enter correct current password.'));
        }
    }
}
