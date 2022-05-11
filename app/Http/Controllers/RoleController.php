<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index()
    {
        $this->authorize('group-view');

        return view('groups.index', [
            'roles' => Role::withTrashed()->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('group-add');

        return view('groups.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $this->authorize('group-add');

        $request->validate([
            'name' => ['required', 'string', 'unique:roles,name', 'max:50']
        ]);

        Role::firstOrCreate([
            'name' => $request->input('name'),
            'guard_name' => 'web'
        ]);

        toastr()->success('Group created successfully');
        return redirect()->route('groups.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Role  $group
     * @return \Illuminate\Http\Response
     */
    public function show(Role $group)
    {
        $this->authorize('group-grant-permission');

        $permissions = Permission::query()->get();
        $permissions = $permissions
        ->groupBy(function ($item) {
            return str_before($item['name'], '-', 0);
        })->sortKeys();

        return view('groups.permissions', [
            'group' => $group,
            'permissions' => $permissions
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Role  $group
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $group)
    {
        $this->authorize('group-update');

        return view('groups.edit', [
            'group' => $group
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Role  $group
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Role $group)
    {
        $this->authorize('group-update');

        $request->validate([
            'name' => ['required', 'string', "unique:roles,name,$group->id,id", 'max:50']
        ]);

        $group->update([
            'name' => $request->name,
        ]);

        toastr()->success('Group updated successfully');
        return redirect()->route('groups.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Role $group
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Role $group)
    {
        if ($group->trashed()) {
            $this->authorize('group-activate');
            $group->restore();
            $action = 'restored';
        } else {
            $this->authorize('group-deactivate');
            $group->delete();
            $action = 'deleted';
        }

        toastr()->success("group $action successfully");
        return redirect()->route('groups.index');
    }

    /**
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroyPermanently(Role $group)
    {
        $this->authorize('group-delete');
        $group->delete();

        toastr()->success("group removed permanently successfully");
        return redirect()->route('groups.index');
    }
}
