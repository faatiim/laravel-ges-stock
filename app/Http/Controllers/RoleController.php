<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\StoreRoleRequest;
use App\Http\Requests\Auth\UpdateRoleRequest;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Session;



class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
                
        $roles = Role::with('permissions')->paginate(10);// ou all() si pas de pagination
        $permissions = Permission::all();
        return view('dash.users.roles.index', compact('roles','permissions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(StoreRoleRequest $request)
    {

        $role = Role::create([
            'name' => $request->name,
            'guard_name' => 'web',
        ]);
        $permissionNames = Permission::whereIn('id', $request->permissions)
        ->where('guard_name', 'web')
        ->pluck('name')
        ->toArray();
    
        $role->syncPermissions($permissionNames); // plus simple et fiable
    
        Session::flash('success', 'Rôle créé avec succès.');
        return redirect()->route('roles.index');
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {

        $editRole = Role::with('permissions')->findOrFail($id);
        $roles = Role::latest()->paginate(10);
        $permissions = Permission::all();

        return view('dash.users.roles.index', compact('editRole', 'roles', 'permissions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRoleRequest $request, Role $role)
    {
         // Ne synchroniser que les permissions valides
    $permissionNames  = Permission::whereIn('id', $request->permissions)
    ->where('guard_name', 'web')
    ->pluck('name')
    ->toArray();

    $role->update(['name' => $request->name]);
    $role->syncPermissions($permissionNames );

    Session::flash('success', 'Rôle mis à jour avec succès.');
    return redirect()->route('roles.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        $role->delete();

        Session::flash('success', 'Rôle supprimé avec succès.');
        return redirect()->route('roles.index');
    }
}
