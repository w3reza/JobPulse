<?php

namespace App\Http\Controllers\Backend;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{

    public function UserList()
    {
        // Get all users
        $users = User::with('roles')->get();

        // Show the view
        return view('backend.pages.user.user_all', compact('users'));
    }

    public function CompanyList()
    {
        // Get all users
        $users = User::with('roles')
        ->whereHas('roles', function ($query) {
            $query->where('name', 'company');
        })
        ->get();

        // Show the view
        return view('backend.pages.user.company_list', compact('users'));
    }

    public function create()
    {
        // Show the form to create a new user
        return view('users.create');
    }

    public function store(Request $request)
    {
        // Validate input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'type' => 'required|in:company,candidate',

        ]);

        // Create the user
        if ($request->input('type') == 'company') {
            $user = User::create([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'password' => bcrypt($request->input('password')),
                'status' => 'disabled',
            ]);
            $user = User::find($user->id);
            $user->assignRole('company');

        }
        if ($request->input('type') == 'candidate') {
        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
            'status' => 'enabled',
        ]);
        $user = User::find($user->id);
        $user->assignRole('candidate');
        }





        return response()->json(['message' => 'User created successfully.']);
        return redirect()->route('users.index')->with('success', 'Manager created successfully.');
    }

    public function AssignRole()
    {
        $user = User::find(2);
        $user->assignRole('user');
    }
}
