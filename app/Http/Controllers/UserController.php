<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            // Use query (not get) so DataTables can paginate efficiently if needed
            $query = User::all();

            return Datatables::of($query)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<a href="javascript:void(0)" data-url="' . route('users.edit', ['user' => $row->uuid]) . '" data-toggle="tooltip" data-id="' . $row->uuid . '" data-original-title="Edit" class="edit me-3 btn btn-success btn-sm editStaff">Edit</a>';
                    $btn .= ' <a href="javascript:void(0)" data-toggle="tooltip" data-id="' . $row->uuid . '" data-original-title="Reset Pass" class="ms-3 btn btn-warning btn-sm resetpassStaff" onclick="resetConfirmation(' . $row->uuid . ')"><b>Reset Password</b></a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        $permissions = Permission::all();
        return view('auth.user', compact('permissions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $user = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'password' => bcrypt('spart112'),
            'status' => 'active',
        ]);
        $permissionIds = $request->input('permissions', []);
        if (!empty($permissionIds)) {
            $permissionNames = Permission::whereIn('id', $permissionIds)->pluck('name')->toArray();
            $user->syncPermissions($permissionNames);
        }
        return response()->json(['message' => 'User created successfully']);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request)
    {
        $user = User::where('uuid', $request->user_id)->first();
        if (! $user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $permissionIds = $user->permissions()->pluck('id')->toArray();

        return response()->json(array_merge($user->toArray(), ['permissions' => $permissionIds]));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $user = User::where('uuid', $request->user_id)->first();
        if (! $user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $user->update([
            'name' => $request->input('name'),
            'username' => $request->input('username'),
            'status' => $request->input('status'),
        ]);

        $permissionIds = $request->input('permissions', []);
        // convert ids -> names and sync (will add/remove as needed)
        if (!empty($permissionIds)) {
            $permissionNames = Permission::whereIn('id', $permissionIds)->where('guard_name', 'web')->pluck('name')->toArray();
            $user->syncPermissions($permissionNames);
        } else {
            // if no permissions sent, revoke all
            $user->syncPermissions([]);
        }

        return response()->json(['message' => 'User updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }

    public function resetpassstaff(Request $request)
    {
        $user = User::where('uuid', $request->user_id)->first();
        if (! $user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $user->update(
            [
                'password' => bcrypt('spart112'),
            ]
        );

        return response()->json(['message' => 'Password reset successfully']);
    }

}
