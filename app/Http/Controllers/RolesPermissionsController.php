<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;










class RolesPermissionsController extends Controller
{
    





    public function SILrolestore () {

        $role = Role::create(['name' => 'writer']);
        $permission = Permission::create(['name' => 'edit articles']);


        $role->givePermissionTo($permission);

    }




    public function roleform (Request $request) {

        //$roles = Role::all()->sortBy("name");

        $action = 'create';
        $role = false;

        if ( isset($request->id) && !empty($request->id) ) {
            $role = Role::find($request->id);
            $action = 'update';
        }

        return view('admin.role-form', [
            'action' => $action,
            'role' => $role,
        ]);
    }






    public function rolestore (Request $request) {



        $validated = $request->validate([
            'name' => ['required', 'unique:roles'],
        ]);


        $id = false;

        $props['user_id'] = Auth::id();

        if ( isset($request->id) && !empty($request->id)) {

            // update
            $role = Role::find($request->id)->update(['name' => $request->name]);
            $id = $request->id;
        } else {

            // create
            $role = Role::create(['name' => $request->name]);
            $id = $role->id;
        }

        return redirect('/admin/roles/view/'.$id);













    }












}
