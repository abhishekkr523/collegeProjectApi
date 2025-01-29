<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Models\User;
use App\Models\Role;

class AuthController extends Controller
{

    // public function register(Request $request)
    // {
    //     $request->validate([
    //         'name' => 'required|string|max:255',
    //         'email' => 'required|string|email|max:255|unique:users',
    //         'password' => 'required|string|min:8',
    //     ]);

    //     // Check if this is the first user
    //     $isFirstUser = User::count() === 0;

    //     // Create the user
    //     $user = User::create([
    //         'id' => \Illuminate\Support\Str::uuid(),
    //         'name' => $request->name,
    //         'email' => $request->email,
    //         'password' => Hash::make($request->password),
    //     ]);

    //     // Assign roles
    //     if ($isFirstUser) {
    //         // Assign admin role to the first user
    //         $adminRole = Role::where('name', 'admin')->firstOrFail();
    //         $user->roles()->attach($adminRole->id);
    //     } else {
    //         // Assign default user role
    //         $defaultRole = Role::where('name', 'user')->firstOrFail();
    //         $user->roles()->attach($defaultRole->id);
    //     }

    //     return response()->json([
    //         'message' => $isFirstUser ? 'Admin registered successfully.' : 'User registered successfully.',
    //         'user' => $user,
    //     ]);
    // }
    public function register(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:8',
    ]);

    // Check if this is the first user
    $isFirstUser = User::count() === 0;

    // Create the user
    $user = User::create([
        'id' => \Illuminate\Support\Str::uuid(),
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
    ]);

    // Assign roles
    if ($isFirstUser) {
        // Assign admin role to the first user
        $adminRole = Role::where('name', 'admin')->firstOrFail();
        $user->roles()->attach($adminRole->id);
    } else {
        // Assign default user role
        $defaultRole = Role::where('name', 'user')->firstOrFail();
        $user->roles()->attach($defaultRole->id);
    }

    // Create a Sanctum token
    $roles = $user->roles->pluck('name')->toArray(); // Get user roles
    $token = $user->createToken('auth_token', $roles)->plainTextToken;

    return response()->json([
        'message' => $isFirstUser ? 'Admin registered successfully.' : 'User registered successfully.',
        'token' => $token,  // Return the token after registration
        'user' => [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'roles' => $roles,
        ],
    ]);
}


    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        // Find the user by email
        $user = User::where('email', $request->email)->first();

        // Check if user exists and password matches
        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        // Create a Sanctum token
        $roles = $user->roles->pluck('name')->toArray(); // Get user roles
        $token = $user->createToken('auth_token', $roles)->plainTextToken;

        return response()->json([
            'message' => 'Login successful',
            'token' => $token,
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'roles' => $roles,
            ],
        ]);
    }

    // Logout user
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Logged out successfully']);
    }

    public function assignRole(Request $request)
    {
        // Step 1: Check if user exists
        $user = User::find($request->user_id);

        // If the user doesn't exist, return an error response
        if (!$user) {
            return response()->json(['message' => 'User not found.'], 404);
        }

        // Step 2: Check if roles exist (manually checking each role)
        $roles = Role::whereIn('id', $request->roles)->get();

        // If the number of roles fetched doesn't match the number of roles provided,
        // it means some of the provided role IDs were invalid.
        if ($roles->count() !== count($request->roles)) {
            return response()->json(['message' => 'One or more role IDs are invalid.'], 400);
        }

        // Step 3: Attach roles to the user
        $user->roles()->sync($request->roles); // Use sync to attach the roles

        return response()->json([
            'message' => 'Roles assigned successfully.',
            'user' => $user->load('roles'), // Return the user with their updated roles
        ]);
    }
}
