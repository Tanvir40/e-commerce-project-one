<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Models\User;

class RoleManagement extends Controller
{
    //role index
    function role_management(){
        $users = User::get();
        $roles = Role::get();
        $permissions = Permission::get();
        return view('admin.role.index',[
            'users'=>$users,
            'permissions'=>$permissions,
            'roles'=>$roles,
        ]);
    }
    // add permission
    function add_permission(Request $request){
        $request->validate([
            'permission_name'=>'required',
        ]);
        $permission = Permission::create(['name' => $request->permission_name]);
        return back()->with('add_permission', 'Permission Added Successfully');
    }
    //add role
    function add_role(Request $request){
        $request->validate([
            'role_name'=>'required',
            'permission'=>'required',
        ]);
        $role = Role::create(['name' => $request->role_name]);
        $role->givePermissionTo($request->permission);
        return back()->with('add_role', 'Role Added Successfully');
    }

    //assaign role
    function assaign_role(Request $request){
        $request->validate([
            'user_id'=>'required',
            'role_id'=>'required',
        ]);
        $user = User::find($request->user_id);
        $user->assignRole($request->role_id);;
        return back()->with('assaign_role','Assaign Role Added Successfully');
    }

    //edit permissions
    function edit_permissions($user_id){
        $permissions = Permission::get();
        $user_info = User::find($user_id);
        return view('admin.role.edit',[
            'permissions'=>$permissions,
            'user_info'=>$user_info,
        ]);
    }

    //update permission
    function update_permission(Request $request){
        $user = User::find($request->user_id);
        $user->syncPermissions($request->permission);
        return back();
    }

    //remove role
    function remove_role($user_id){
        $user = User::find($user_id);
        $user->roles()->detach();
        return back()->with('delete','Role Deleted Successfully');
    }


    //edit permission
    function edit_permission($role_id){
        $role = Role::find($role_id);
        $permissions = Permission::all();
        return view('admin.role.edit_permission',[
            'role'=>$role,
            'permissions'=>$permissions,
        ]);
    }

    //update role permission
    function update_role_permission(Request $request){
        $role = Role::find($request->role_id);
        $role->syncPermissions($request->permission);
        return back();
    }


}
