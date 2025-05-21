<?php
namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    // Show all users
    public function list(Request $request)
    {
        $query = User::query();

        // Search filter
        $query->when($request->keywords, function ($q) use ($request) {
            $q->where('name', 'like', "%{$request->keywords}%")
              ->orWhere('email', 'like', "%{$request->keywords}%");
        });

        // Role filter
        $query->when($request->role, function ($q) use ($request) {
            $q->where('role', $request->role);
        });

        $users = $query->get();
        return view("users.list", compact('users'));

    }

    // Show add/edit form
    public function edit(User $user = null)
    {
        $user = $user ?? new User();
        return view("users.form", compact('user'));
    }

    // Save new or updated user
    public function save(Request $request, User $user = null)
    {
    $user = $user ?? new User();

    // Fill user data except password
    $user->fill($request->only(['name', 'email', 'role']));

    // Set password only if it's a new user
    if (!$user->exists) {
        $user->password = bcrypt('password123');
    }

    $user->save();
    return redirect()->route('users_list');
    }


    // Delete a user
    public function delete(User $user)
    {
        $user->delete();
        return redirect()->route('users_list');
    }

    public function doLogin(Request $request)
    {
        // Validate input
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8',
        ]);

        // Fetch user from database
        $user = User::where('email', $request->email)->first();

        // Debugging: Check if user exists
        if (!$user) {
            return back()->with('error', 'User not found.');
        }

        // Debugging: Check if password is correct
        if (!Hash::check($request->password, $user->password)) {
            return back()->with('error', 'Incorrect password.');
        }

        // Authenticate user
        Auth::login($user);
        return redirect('/')->with('success', 'Login successful!');
    }
}
