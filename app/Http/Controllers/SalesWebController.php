<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Photo;
use App\Models\Sales;
use Illuminate\Http\Request;
use App\Helpers\ResponseFormatter;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Resources\SalesResource;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreSalesRequest;
use App\Http\Requests\UpdateSalesRequest;
use Yajra\DataTables\Facades\DataTables;


class SalesWebController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function falken(Request $request)
    {
        if ($request->ajax()) {
            // Use query (not get) so DataTables can paginate efficiently if needed
            $query = Sales::with('photos')->where('brand', 'FLK');

            return Datatables::of($query)
                ->addIndexColumn()
                ->addColumn('photos', function ($row) {
                    // Map Photo models to public URLs; return array of URLs
                    if (!$row->photos || $row->photos->isEmpty()) {
                        return [];
                    }

                    return $row->photos->map(function ($p) {
                        return asset('storage/' . ltrim($p->photo_path, '/'));
                    })->toArray();
                })
                ->make(true);
        }


        return view('universal/falken-medan');
    }

    public function invoice_detail(Request $request)
    {
        $invoice_id = $request->query('id');
        $sales = Sales::with('photos', 'salesItems')->where('id', $invoice_id)->first();
        return response()->json([
            'invoice' => SalesResource::make($sales)
        ]);
    }
    

    public function ngk(Request $request)
    {
        if ($request->ajax()) {
            // Use query (not get) so DataTables can paginate efficiently if needed
            $query = Sales::with('photos')->where('brand', 'NGK');

            return Datatables::of($query)
                ->addIndexColumn()
                ->addColumn('photos', function ($row) {
                    // Map Photo models to public URLs; return array of URLs
                    if (!$row->photos || $row->photos->isEmpty()) {
                        return [];
                    }

                    return $row->photos->map(function ($p) {
                        return asset('storage/' . ltrim($p->photo_path, '/'));
                    })->toArray();
                })
                ->make(true);
        }


        return view('universal/ngk-medan');
    }
    public function philips(Request $request)
    {
        if ($request->ajax()) {
            // Use query (not get) so DataTables can paginate efficiently if needed
            $query = Sales::with('photos')->where('brand', 'PHP');

            return Datatables::of($query)
                ->addIndexColumn()
                ->addColumn('photos', function ($row) {
                    // Map Photo models to public URLs; return array of URLs
                    if (!$row->photos || $row->photos->isEmpty()) {
                        return [];
                    }

                    return $row->photos->map(function ($p) {
                        return asset('storage/' . ltrim($p->photo_path, '/'));
                    })->toArray();
                })
                ->make(true);
        }


        return view('universal/philips-medan');
    }
    public function mitsuboshi(Request $request)
    {
        if ($request->ajax()) {
            // Use query (not get) so DataTables can paginate efficiently if needed
            $query = Sales::with('photos')->where('brand', 'MTSB');

            return Datatables::of($query)
                ->addIndexColumn()
                ->addColumn('photos', function ($row) {
                    // Map Photo models to public URLs; return array of URLs
                    if (!$row->photos || $row->photos->isEmpty()) {
                        return [];
                    }

                    return $row->photos->map(function ($p) {
                        return asset('storage/' . ltrim($p->photo_path, '/'));
                    })->toArray();
                })
                ->make(true);
        }


        return view('universal/mitsu-medan');
    }
    
    public function universal(Request $request)
    {
        if ($request->ajax()) {
            // Use query (not get) so DataTables can paginate efficiently if needed
            $query = Sales::with('photos')->where('brand', 'UNV')->where('cabang', session('kode_cabang'));

            return Datatables::of($query)
                ->addIndexColumn()
                ->addColumn('photos', function ($row) {
                    // Map Photo models to public URLs; return array of URLs
                    if (!$row->photos || $row->photos->isEmpty()) {
                        return [];
                    }

                    return $row->photos->map(function ($p) {
                        return asset('storage/' . ltrim($p->photo_path, '/'));
                    })->toArray();
                })
                ->make(true);
        }


        return view('universal/universal-other-branch');
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
    public function store(StoreSalesRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Sales $sale)
    {
        return ResponseFormatter::success(['invoice' => SalesResource::make($sale)], 'Success');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Sales $sales)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSalesRequest $request, Sales $sales)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sales $sales)
    {
        //
    }

}
