<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Cabang;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Helpers\ResponseFormatter;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;

class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function login(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'username' => 'required|string',
                'password' => 'required|string',
            ]);
            $user = User::where('username', $validatedData['username'])->first();
            if (!$user) {
                return ResponseFormatter::error(null, 'User not found!');
            }

            if (!Hash::check($validatedData['password'], $user->password)) {
                return ResponseFormatter::error(null, 'Wrong password!');
            }

            $token = $user->createToken('accessToken', ['*'], now()->addHour(24))->plainTextToken;
            $response = [
                'accessToken' => $token,
                'token_type' => 'Bearer',
                'user' => $user,
            ];
            return ResponseFormatter::success($response, 'Login Successfully');
        } catch (\Throwable $th) {
            return ResponseFormatter::error(null, 'Failed to login');
        }
    }
    public function adminLogin(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        if (Auth::attempt($request->only('username', 'password'))) {
            $user = Auth::user();
            
            // Get all cabang codes from database
            $cabangCodes = Cabang::orderBy('id')->pluck('kode_cabang')->toArray();
            // Find which cabang permission this user has
            $userCabang = null;
            foreach ($cabangCodes as $code) {
                if ($user->hasPermissionTo('cabang_'.strtolower($code))) {
                    $userCabang = Cabang::where('kode_cabang', $code)->first();
                    break;
                }
            }
            
            if (!$userCabang) {
                Auth::logout();
                return back()->with('loginError', 'No cabang permission assigned');
            }

            $request->session()->regenerate();
            $request->session()->put('kode_cabang', $userCabang->kode_cabang);
            
            // Check previous month for tutup buku
            $previousMonth = Carbon::now()->subMonth()->format('F-Y');
            return redirect()->intended(route('dashboard'));
        }

        return back()->with('loginError', 'Login Failed');
    }

    /**
     * Display the specified resource.
     */
    public function logout(Request $request)
    {
        try {
            $user = $request->user();
        
            if (!$user) {
                return ResponseFormatter::error('User not found!');
            }
    
            $user->tokens()->delete();
            return ResponseFormatter::success(null, 'Logout Successfully');
        } catch (\Throwable $th) {
            return ResponseFormatter::error(null, 'Failed to logout');
        }
        
    }

    public function adminLogout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect(route('login'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function register(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'username' => 'required|string|unique:users,username|max:255',
            ]);

            $user = new User();
            $user->name = $validatedData['name'];
            $user->username = $validatedData['username'];
            $user->password = Hash::make('password');
            $user->uuid = (string) Str::uuid(); 
            $user->remember_token = Str::random(10);
            $user->save();

            return ResponseFormatter::success($user, 'User registered successfully');
        } catch (\Throwable $th) {
            return ResponseFormatter::error(null, 'Failed to register');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function changepassword(Request $request)
    {
        $validatedData = $request->validate([
            'old_password' => 'required|string',
            'new_password' => 'required|string',
        ]);

        $user = $request->user();

        if (!Hash::check($validatedData['old_password'], $user->password)) {
            return ResponseFormatter::error('Wrong password!');
        }

        $user->password = Hash::make($validatedData['new_password']);
        $user->save();

        return ResponseFormatter::success($user, 'Password changed successfully');
    }

    public function resetuserpassword(Request $request)
    {
        // Double-check permission
        if (!$request->user()->hasPermissionTo('reset_password')) {
            return ResponseFormatter::error(null, 'Unauthorized', 403);
        }
        $request->validate([
            'uuid' => 'required|exists:users,uuid',
        ]);
    
        $user = User::find($request->uuid);
    
        if (!$user) {
            return ResponseFormatter::error(null, 'User not found', 404);
        }
    
        $user->password = Hash::make('password'); 
        $user->password_changed_at = now();
        $user->save();
    
        return ResponseFormatter::success($user, 'Password reset successfully');
    }

    public function getallusers(Request $request)
    {
        $users = User::where('username', '!=', 'admin')->orderBy('username')->get();
        return ResponseFormatter::success($users, 'Get all users successfully');
    }
    
    // public function userpermission(string $uuid)
    // {
    //     $user = User::find($uuid);
    //     if (!$user) {
    //         return ResponseFormatter::error(null, 'User not found', 404);
    //     }
    
    //     // Format user data
    //     $userData = [
    //         'uuid' => $user->uuid,
    //         'name' => $user->name,
    //         'username' => $user->username,
    //         'status' => $user->status,
    //         'password_changed_at' => $user->password_changed_at,
    //         'created_at' => $user->created_at,
    //         'updated_at' => $user->updated_at,
    //     ];
    
    //     // Fetch and format permissions
    //     $permissions = $user->permissions()->pluck('name')->map(function ($permission) {
    //         return [
    //             'permission_name' => $permission,
    //             'formatted_value' => ucwords(str_replace('_', ' ', $permission)),
    //         ];
    //     });
    
    //     // Combine user data and permissions
    //     $response = [
    //         'user' => $userData,
    //         'permissions' => $permissions
    //     ];
    
    //     return ResponseFormatter::success($response, 'Get user permissions successfully');
    // }

    // public function updateuserpermission(Request $request)
    // {
    //     // Double-check permission
    //     if (!$request->user()->hasPermissionTo('update_permission')) {
    //         return ResponseFormatter::error(null, 'Unauthorized', 403);
    //     }

    //     try {
    //         $validatedData = $request->validate([
    //             'uuid' => 'required|exists:users,uuid',
    //             'permissions' => 'required|array',
    //             'permissions.*' => 'string|exists:permissions,name'
    //         ]);

    //         $user = User::find($request->uuid);
    //         if (!$user) {
    //             return ResponseFormatter::error(null, 'User not found', 404);
    //         }

    //         // Sync the new permissions
    //         $user->syncPermissions($validatedData['permissions']);

    //         // Get updated permissions
    //         $updatedPermissions = $user->permissions()->pluck('name')->map(function ($permission) {
    //             return [
    //                 'permission_name' => $permission,
    //                 'formatted_value' => ucwords(str_replace('_', ' ', $permission)),
    //             ];
    //         });

    //         return ResponseFormatter::success($updatedPermissions, 'User permissions updated successfully');
    //     } catch (\Throwable $th) {
    //         return ResponseFormatter::error(null, 'Failed to update user permissions: ' . $th->getMessage());
    //     }
    // }

    public function deactivateuser(Request $request)
    {
        // Double-check permission
        if (!$request->user()->hasPermissionTo('deactivate_user')) {
            return ResponseFormatter::error(null, 'Unauthorized', 403);
        }

        $user = User::find($request->uuid);
        if (!$user) {
            return ResponseFormatter::error(null, 'User not found', 404);
        }
    
        $user->status = 'inactive';
        $user->save();
    
        return ResponseFormatter::success($user, 'User deactivated successfully');
    }

    public function activateuser(Request $request)
    {
        $user = User::find($request->uuid);
        if (!$user) {
            return ResponseFormatter::error(null, 'User not found', 404);
        }
        if (!$request->user()->hasPermissionTo('activate_user')) {
            return ResponseFormatter::error(null, 'Unauthorized', 403);
        }
        $user->status = 'active';
        $user->save();
    
        return ResponseFormatter::success($user, 'User activated successfully');
    }

    // public function updaterolepermission(Request $request)
    // {
    //     try {
    //         $validatedData = $request->validate([
    //             'role_name' => 'required|string|exists:roles,name',
    //             'permissions' => 'required|array',
    //             'permissions.*' => 'string|exists:permissions,name'
    //         ]);

    //         $role = Role::where('name', $validatedData['role_name'])->first();
    //         if (!$role) {
    //             return ResponseFormatter::error(null, 'Role not found', 404);
    //         }

    //         // Sync the new permissions
    //         $role->syncPermissions($validatedData['permissions']);

    //         // Get updated permissions
    //         $updatedPermissions = $role->permissions()->pluck('name')->map(function ($permission) {
    //             return [
    //                 'permission_name' => $permission,
    //                 'formatted_value' => ucwords(str_replace('_', ' ', $permission)),
    //             ];
    //         });

    //         return ResponseFormatter::success($updatedPermissions, 'Role permissions updated successfully');
    //     } catch (\Throwable $th) {
    //         return ResponseFormatter::error(null, 'Failed to update role permissions: ' . $th->getMessage());
    //     }
    // }

    // public function getrolepermissions(Request $request)
    // {
    //     try {
    //         $validatedData = $request->validate([
    //             'role_name' => 'required|string|exists:roles,name',
    //         ]);

    //         $role = Role::where('name', $validatedData['role_name'])->first();
    //         if (!$role) {
    //             return ResponseFormatter::error(null, 'Role not found', 404);
    //         }

    //         // Get and format permissions
    //         $permissions = $role->permissions()->pluck('name')->map(function ($permission) {
    //             return [
    //                 'permission_name' => $permission,
    //                 'formatted_value' => ucwords(str_replace('_', ' ', $permission)),
    //             ];
    //         });

    //         return ResponseFormatter::success($permissions, 'Get role permissions successfully');
    //     } catch (\Throwable $th) {
    //         return ResponseFormatter::error(null, 'Failed to get role permissions: ' . $th->getMessage());
    //     }
    // }

    public function setBranch(Request $request)
    {
        $request->validate([
            'kode_cabang' => 'required|string',
        ]);

        session(['kode_cabang' => $request->kode_cabang]);

        try {
            $previousRoute = app('router')->getRoutes()->match(
                request()->create(url()->previous())
            )->getName();
            
            // Define exact route names that should redirect to dashboard
            $exactRouteNames = [
                'falken',
                'philips',
                'mitsu',
                'universal',
                'ngk',
            ];

            // Check for exact route name match
            if (in_array($previousRoute, $exactRouteNames)) {
                return redirect()->route('dashboard');
            }
        } catch (\Exception $e) {
            // Handle the exception
        }

        return redirect()->back();
    }
    
}
