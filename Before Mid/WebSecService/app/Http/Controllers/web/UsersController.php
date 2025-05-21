<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Artisan;

class UsersController extends Controller
{
    public function register()
{
    $roles = Role::all(); // Fetch roles from database
    return view('users.register', compact('roles'));
}


    public function doRegister(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'role' => 'required|exists:roles,name', // Ensure role exists in DB
        'security_question' => 'nullable|string',
        'security_answer' => 'nullable|string',
        'password' => 'required|confirmed|min:8',
    ]);

    $user = new User();
    $user->name = $request->name;
    $user->email = $request->email;
    $user->security_question = $request->security_question ?? null;
    $user->security_answer = $request->security_answer ? Hash::make($request->security_answer) : null;
    $user->password = Hash::make($request->password);

    $user->save();

    // Assign Role to User (Ensure it is added to model_has_roles)
    $user->assignRole($request->role);

    return redirect('/login')->with('success', 'Registration successful! You can now log in.');
}



    public function login()
    {
        return view('users.login');
    }

    public function doLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8',
        ]);

        $user = User::where('email', $request->email)->first();

        // If user does not exist
        if (!$user) {
            return back()->with('error', 'User not found.');
        }

        // Authenticate and log in user
        Auth::login($user);

        return redirect('/')->with('success', 'Login successful!');
    }


    public function doLogout()
    {
        Auth::logout();
        return redirect('/login')->with('success', 'You have been logged out.');
    }

    public function profile()
    {
        $user = $user??auth()->user();
        if(auth()->id()!=$user?->id) {
            if(!auth()->user()->hasPermissionTo('show_users')) abort(401);}
        
        $permissions = [];
        foreach
        ($user->permissions as $permission) {
                $permissions[] = $permission;
            }
        foreach
        ($user->roles as $role) {
        foreach
        ($role->permissions as $permission) {
                    $permissions[] = $permission;
                }
            }
            return view('users.profile', compact('user', 'permissions'));
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required|min:8',
            'new_password' => 'required|confirmed|min:8',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->with('error', 'Current password is incorrect.');
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return back()->with('success', 'Password updated successfully.');
    }

    public function forgotPassword()
    {
        return view('users.forgot_password');
    }

    public function verifySecurityQuestion(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'security_answer' => 'required|string',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->security_answer, $user->security_answer)) {
            return back()->withErrors(['security_answer' => 'Incorrect answer.']);
        }

        return view('users.reset_password', compact('user'));
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'password' => 'required|confirmed|min:8',
        ]);

        $user = User::find($request->user_id);
        $user->password = Hash::make($request->password);
        $user->save();

        return redirect('/login')->with('success', 'Password reset successfully. You can now log in.');
    }

    public function edit(User $user)
{
    $roles = Role::all(); 
    $permissions = Permission::all();

    // Attach current roles & permissions for checkboxes
    foreach ($roles as $role) {
        $role->assigned = $user->hasRole($role->name);
    }

    foreach ($permissions as $permission) {
        $permission->assigned = $user->hasPermissionTo($permission->name);
    }

    return view('users.edit', compact('user', 'roles', 'permissions'));
}


public function save(Request $request, User $user = null)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email,' . ($user ? $user->id : 'NULL'),
        'role' => 'required|string|exists:roles,name', // ✅ Ensure role exists
        'security_question' => 'nullable|string',
        'security_answer' => 'nullable|string',
        'password' => $user ? 'nullable|min:8' : 'required|min:8|confirmed',
    ]);

    $user = $user ?? new User();
    $user->name = $request->name;
    $user->email = $request->email;

    if (auth()->user()->can('edit_users')) {
        $user->role = $request->role; // ✅ Update `users` table
    }

    $user->security_question = $request->security_question ?? null;

    if ($request->filled('security_answer')) {
        $user->security_answer = Hash::make($request->security_answer);
    }

    if ($request->filled('password')) {
        $user->password = Hash::make($request->password);
    } elseif (!$user->exists) {
        return back()->with('error', 'Password is required when adding a new user.');
    }

    $user->save();

    // ✅ **Ensure Role is Updated in `model_has_roles` Table**
    if (auth()->user()->can('edit_users')) {
        $user->syncRoles([$request->role]); // ✅ Sync roles properly

        // ✅ **Force Remove All Permissions & Reassign**
        $user->permissions()->detach(); // 🔥 Force remove all existing permissions
        $permissions = $request->permissions ?? []; // Default to empty array
        $user->syncPermissions($permissions); // ✅ Reassign new permissions

        // ✅ **Clear Cached Permissions**
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
    }

    return redirect()->route('users_edit', $user->id)->with('success', 'User saved successfully.');
}

    public function delete(User $user)
    {
        $user->delete();
        return redirect()->route('users_list')->with('success', 'User deleted successfully.');
    }


}