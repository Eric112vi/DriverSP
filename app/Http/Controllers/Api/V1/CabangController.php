<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Cabang;
use Illuminate\Http\Request;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\CabangResource;

class CabangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $branches = Cabang::all()->filter(function ($cabang) use ($user) {
            $permissionName = 'cabang_' . strtolower($cabang->kode_cabang);
            return $user->hasPermissionTo($permissionName);
        });
        return ResponseFormatter::success([ 'cabang' => CabangResource::collection($branches)], 'Success');
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Cabang $branch)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cabang $branch)
    {
        //
    }
}
