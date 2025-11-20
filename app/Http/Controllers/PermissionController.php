<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Http\Requests\StorePermissionRequest;
use App\Http\Requests\UpdatePermissionRequest;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;


class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            // Use query (not get) so DataTables can paginate efficiently if needed
            $query = Permission::all();

            return Datatables::of($query)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<a href="javascript:void(0)" data-url="' . route('permissions.edit', ['permission' => $row->id]) . '" data-toggle="tooltip" data-id="' . $row->id . '" data-original-title="Edit" class="edit me-3 btn btn-success btn-sm editPermission">Edit</a>';
                    $btn .= ' <a href="javascript:void(0)" data-toggle="tooltip" data-id="' . $row->id . '" data-original-title="Delete" class="ms-3 btn btn-danger btn-sm deletePermission">Delete</a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('auth.permission');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $permission = Permission::create([
            'name' => $request->name,
            'guard_name' => 'web',
        ]);

        return response()->json($permission);
    }

    /**
     * Display the specified resource.
     */
    public function show(Permission $permission)
    {
        return response()->json($permission);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Permission $permission)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Permission $permission)
    {
        $permission->update([
            'name' => $request->name,
        ]);

        return response()->json($permission);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Permission $permission)
    {
        $permission->delete();

        return response()->json(['message' => 'Permission deleted successfully.']);
    }
}
