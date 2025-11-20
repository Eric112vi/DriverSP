<?php

namespace App\Http\Controllers;

use App\Models\Cabang;
use App\Http\Requests\StoreCabangRequest;
use App\Http\Requests\UpdateCabangRequest;
use App\Models\Permission;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class CabangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            // Use query (not get) so DataTables can paginate efficiently if needed
            $query = Cabang::all();

            return Datatables::of($query)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<a href="javascript:void(0)" data-url="' . route('branches.edit', ['branch' => $row->id]) . '" data-toggle="tooltip" data-id="' . $row->id . '" data-original-title="Edit" class="edit me-3 btn btn-success btn-sm editBranch">Edit</a>';
                    $btn .= ' <a href="javascript:void(0)" data-toggle="tooltip" data-id="' . $row->id . '" data-original-title="Delete" class="ms-3 btn btn-danger btn-sm deleteBranch">Delete</a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('auth.cabang');
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
        $branch = Cabang::create([
            'nama_cabang' => $request->nama_cabang,
            'kode_cabang' => $request->kode_cabang,
        ]);

        Permission::create([
            'name' => 'cabang_' . $branch->kode_cabang,
            'guard_name' => 'web',
        ]);

        return response()->json($branch);
    }

    /**
     * Display the specified resource.
     */
    public function show(Cabang $branch)
    {
        return response()->json($branch);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cabang $branch)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Cabang $branch)
    {
        Permission::where('name', 'cabang_' . $branch->kode_cabang)->update([
            'name' => 'cabang_' . $request->kode_cabang,
        ]);
        $branch->update([
            'nama_cabang' => $request->nama_cabang,
            'kode_cabang' => $request->kode_cabang,
        ]);
        return response()->json($branch);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cabang $branch)
    {
        $branch->delete();

        $permission = Permission::where('name', 'cabang_' . $branch->kode_cabang)->first();
        if ($permission) {

            $permission->delete();
        }

        return response()->json(['message' => 'Branch deleted successfully']);
    }
}
