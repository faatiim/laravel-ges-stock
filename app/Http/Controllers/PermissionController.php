<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Session;

class PermissionController extends Controller
{
    public function index()
    {
        $permissions = Permission::latest()->paginate(10);
        return view('dash.users.permissions.index', compact('permissions'));
    }

    public function store(Request $request)
    {

        $request->validate([
            'name' => 'required|string|unique:permissions,name',
        ]);
    
        Permission::create([
            'name' => $request->name,
            'guard_name' => 'web', // ✅ essentiel !
        ]);
    
        Session::flash('success', 'Permission créée avec succès.');
        return redirect()->route('permissions.index');
    }

    public function edit(Permission $permission)
    {
        return view('dash.users.permissions.edit', compact('permission'));
    }

    public function update(Request $request, Permission $permission)
    {
        $request->validate([
            'name' => 'required|string|unique:permissions,name,' . $permission->id,
        ]);

        $permission->update(['name' => $request->name]);
        Session::flash('success', 'Permission mise à jour.');
        return redirect()->route('permissions.index');
    }

    public function destroy(Permission $permission)
    {
        $permission->delete();
        Session::flash('success', 'Permission supprimée.');
        return redirect()->route('permissions.index');
    }
}
