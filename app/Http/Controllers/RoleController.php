<?php

namespace App\Http\Controllers;


use App\Models\User;
use Illuminate\Http\Request;
use App\DataTables\RoleDataTable;
use Illuminate\Support\Collection;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->can('Manage Role'))
        {
            $roles = Role::all();

            return view('role.index')->with('roles', $roles);
        }
        else
        {
            return redirect()->back()->with('error', 'Permission denied.');
        }

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(Auth::user()->can('Create Role'))
        {
            $user = Auth::user()->with('hrm')->first();
            //dd($user);
            if($user->hrm->type == 'super admin' || $user->hrm->type == 'company')
            {
                $permissions = Permission::all()->pluck('name', 'id')->toArray();
            }
            else
            {
                $permissions = new Collection();
                foreach($user->roles as $role)
                {
                    $permissions = $permissions->merge($role->permissions);
                }
                $permissions = $permissions->pluck('name', 'id')->toArray();

            }

            return view('role.create', ['permissions' => $permissions]);
        }
        else
        {
            return redirect()->back()->with('error', 'Permission denied.');
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
        if(Auth::user()->can('Create Role'))
        {
            $role = Role::where('name', '=', $request->name)->first();
            if(isset($role))
            {
                return redirect()->back()->with('error', __('The Role has Already Been Taken.'));
            }
            else
            {
                $this->validate(
                    $request, [
                                'name' => 'required|max:100|unique:roles,name,NULL,id',
                                'permissions' => 'required',
                            ]
                );

                $name             = $request['name'];
                $role             = new Role();
                $role->name       = $name;
                $permissions      = $request['permissions'];
                $role->save();

                foreach($permissions as $permission)
                {
                    $p    = Permission::where('id', '=', $permission)->firstOrFail();
                    $role = Role::where('name', '=', $name)->first();
                    $role->givePermissionTo($p);
                }

                return redirect()->route('roles.index')->with('success', 'Role successfully created.');

            }


        }
        else
        {
            return redirect()->back()->with('error', 'Permission denied.');
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
    public function edit($role)
    {
        $role = Role::with('permissions')->find($role);
        if(Auth::user()->can('Edit Role'))
        {
            //$role = Role::find($id)->with('permission');
            $user = Auth::user()->with('hrm')->first();
            if($user->hrm->type == 'super admin' || $user->hrm->type == 'company')
            {
                $permissions = Permission::all()->pluck('name', 'id')->toArray();

            }
            else
            {
                $permissions = new Collection();
                foreach($user->roles as $role1)
                {
                    $permissions = $permissions->merge($role1->permissions);
                }
                $permissions = $permissions->pluck('name', 'id')->toArray();
            }

            //dd($permissions,$role);
            return view('role.edit', compact('role', 'permissions'));
        }
        else
        {
            return redirect()->back()->with('error', 'Permission denied.');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Role $role)
    {
        if (Auth::user()->can('Edit Role')) {
            if ($role->name == 'employee') {
                $this->validate($request, [
                    'permissions' => 'required',
                ]);
            } else {
                $this->validate($request, [
                    'name' => 'required|max:100|unique:roles,name,' . $role['id'] . ',id',
                    'permissions' => 'required',
                ]);
            }

            $input = $request->except(['permissions']);
            $permissions = $request['permissions'];
            $role->fill($input)->save();

            $p_all = Permission::all();

            foreach ($p_all as $p) {
                $role->revokePermissionTo($p);
            }

            foreach ($permissions as $permission) {
                $p = Permission::where('id', '=', $permission)->firstOrFail();
                $role->givePermissionTo($p);
            }

            return redirect()
                ->route('roles.index')
                ->with('success', 'Role successfully updated.');
        } else {
            return redirect()
                ->back()
                ->with('error', 'Permission denied.');
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
        if(Auth::user()->can('Delete Role'))
        {
            $role = Role::findOrFail($id);
            $role->delete();

            return redirect()->route('roles.index')->with(
                'success', 'Role successfully deleted.'
            );
        }
        else
        {
            return redirect()->back()->with('error', 'Permission denied.');
        }
    }

    public function loadDatatable(RoleDataTable $datatable)
    {
        return $datatable->ajax();
    }
}
