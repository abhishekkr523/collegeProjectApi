<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use App\Exports\UsersExport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;

class UserController extends Controller
{
    public function dashboard(){
return "user dashboard";
    }

    public function index(Request $request)
    {
        $search = $request->input('search');
        $roleId = $request->input('role_id'); // Get role ID from request

        $users = User::when($search, function ($query, $search) {
                return $query->where('name', 'LIKE', "%{$search}%")
                ->orWhere('email', 'LIKE', "%{$search}%");
            })
            ->when($roleId, function ($query, $roleId) {
                return $query->whereHas('roles', function ($q) use ($roleId) {
                    $q->where('id', $roleId);
                });
            })
            ->get();
        if ($users->isEmpty()) {
            return response()->json([
                'message' => 'No matching user found.',
                'status' => false
            ], 200);
        }
        // Return users as JSON (for API) or view (for web routes)
        return response()->json($users);
    }

    // Store new user
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
           
        ]);
// dd($user);
        return response()->json($user, 201);
    }

    // Update user
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|email|unique:users,email,' . $user->id,
            'password' => 'sometimes|required|string|min:6',
            'department' => 'nullable|string',
            'branch' => 'nullable|string',
            'rollnumber' => 'nullable|string',
            'subject' => 'nullable|string',
            'semester' => 'nullable|string',
            'session_start' => 'nullable|string',
            'session_end' => 'nullable|string',
        ]);

        if ($request->has('name')) $user->name = $request->name;
        if ($request->has('email')) $user->email = $request->email;
        if ($request->has('password')) $user->password = Hash::make($request->password);
        if ($request->has('department')) $user->department = $request->department;
        if ($request->has('branch')) $user->branch = $request->branch;
        if ($request->has('rollnumber')) $user->rollnumber = $request->rollnumber;
        if ($request->has('subject')) $user->subject = $request->subject;
        if ($request->has('semester')) $user->semester = $request->semester;
        if ($request->has('session_start')) $user->session_start = $request->session_start;
        if ($request->has('session_end')) $user->session_end = $request->session_end;

        $user->save();

        return response()->json($user);
    }

    // Delete user
    public function destroy(User $user)
    {
        $user->delete();

        return response()->json(['message' => 'User deleted successfully']);
    }

    // Assign role to user
    public function assignRole(Request $request, User $user)
    {
        $request->validate([
            'role_id' => 'required|exists:roles,id',
        ]);

        $role = Role::find($request->role_id);
       dd($role);
        $user->roles()->syncWithoutDetaching([$role->id]);

        return response()->json(['message' => 'Role assigned successfully']);
    }

    public function getUsersByRole($roleId)
    {
        // Find the role by ID
        $role = Role::with('users')->find($roleId);

        if (!$role) {
            return response()->json(['message' => 'Role not found'], 404);
        }

        return response()->json($role->users, 200);
    }
    public function export()
    {
        return Excel::download(new UsersExport, 'users.xlsx');
    }
}

