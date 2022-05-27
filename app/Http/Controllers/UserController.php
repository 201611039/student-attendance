<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {    
        $this->authorize('user-view');

        return view('users.index', [
            'users' => User::getUsers(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('user-add');

        return view('users.add', [
            'groups' => Role::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserRequest $request)
    {
        // create neccessary data to store
        $groups = collect($request->safe()->only(['groups']))->flatten();
        $data = collect($request->safe()->except(['groups']))->merge(['password' => bcrypt(strtoupper($request->last_name))])->toArray();

        // add user data to database
        User::firstOrCreate($data)
        ->assignRole($groups);

        // notify and redirect to user list page
        toastr()->success('User created successfully');
        return redirect()->route('users.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return view('users.edit', [
            'user' => $user,
            'groups' => Role::all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        // create neccessary data to store
        $groups = collect($request->safe()->only(['groups']))->flatten();
        $data = $request->safe()->except(['groups']);

        // update user data to database
        $user->update($data);
        $user->syncRoles($groups);

        // notify and redirect to user list page
        toastr()->success('User updated successfully');
        return redirect()->route('users.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        if ($user->trashed()) {
            $this->authorize('user-activate');
            $user->restore();
            $action = 'restored';
        } else {
            $this->authorize('user-deactivate');
            $user->delete();
            $action = 'deleted';
        }

        toastr()->success("User $action successfully");
        return redirect()->route('users.index');
    }

    public function destroyPermanently(User $user)
    {
        $this->authorize('user-delete');
        $user->delete();

        toastr()->success("User removed permanently successfully");
        return redirect()->route('users.index');
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'password' => ['required', 'string', 'min:6', 'confirmed'],
            'old_password' => ['required', 'string', function ($attribute, $value, $fail) {
                if (!Hash::check($value, request()->user()->password)) {
                    $fail('The '.str_replace('_', ' ', $attribute).' incorrect .');
                }
            }]
        ]);

        request()->user()->update([
            'password' => bcrypt($request->password)
        ]);

        toastr()->success('Password updated successfully');
        return back();
    }
}
