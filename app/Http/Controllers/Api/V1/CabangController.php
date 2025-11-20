<?php

namespace App\Http\Controllers;

use App\Models\Cabang;
use App\Models\Permission;
use Illuminate\Http\Request;
use App\Helpers\ResponseFormatter;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\StoreCabangRequest;
use App\Http\Requests\UpdateCabangRequest;

class CabangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return ResponseFormatter::success([ 'cabang' => Cabang::all()], 'Success');
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
