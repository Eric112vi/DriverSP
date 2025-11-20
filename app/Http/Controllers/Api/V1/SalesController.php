<?php

namespace App\Http\Controllers\Api\V1;

use Carbon\Carbon;
use App\Models\Photo;
use App\Models\Sales;
use Illuminate\Http\Request;
use GuzzleHttp\Psr7\Response;
use App\Helpers\ResponseFormatter;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\NgkResource;
use App\Http\Controllers\Controller;
use App\Http\Resources\SalesResource;
use App\Models\FromAPI\Falken\Falken;
use App\Models\FromAPI\NgkPart\NgkPart;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreSalesRequest;
use App\Http\Requests\UpdateSalesRequest;

class SalesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return ResponseFormatter::success([ 'invoice' => SalesResource::collection(Sales::all())], 'Success');
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

    public function getNgkInvoice(Request $request)
    {
        $userId = $request->user()->uuid ?? null;

        $baseQuery = Sales::where('brand', 'NGK');

        if($request->has('status')){
            $status = $request->status;
            if($status == 'HOLD') {
                $baseQuery->where('confirm_status', $status);
            }
            else {
                $baseQuery->where('confirm_status', $status)
                          ->where('confirm_by', $userId);
            }
        } else {
            $baseQuery->where(function ($q) use ($userId) {
                $q->where('confirm_status', 'HOLD')
                  ->orWhere(function ($q2) use ($userId) {
                      $q2->where('confirm_status', 'ONGOING')
                         ->where('confirm_by', $userId);
                  });
            });
        }

        if ($request->has('from_date') && $request->has('to_date')) {
            $invoices = $baseQuery
                ->whereBetween('invoice_date', [$request->from_date, $request->to_date])
                ->get();
        } else {
            $invoices = $baseQuery
                ->where('invoice_date', Carbon::now()->toDateString())
                ->get();
        }

        return ResponseFormatter::success(['invoice' => SalesResource::collection($invoices)], 'Success');
    }

    public function getMitsuInvoice(Request $request)
    {
        $userId = $request->user()->uuid ?? null;

        $baseQuery = Sales::where('brand', 'MTSB');

        if($request->has('status')){
            $status = $request->status;
            if($status == 'HOLD') {
                $baseQuery->where('confirm_status', $status);
            }
            else {
                $baseQuery->where('confirm_status', $status)
                          ->where('confirm_by', $userId);
            }
        } else {
            $baseQuery->where(function ($q) use ($userId) {
                $q->where('confirm_status', 'HOLD')
                  ->orWhere(function ($q2) use ($userId) {
                      $q2->where('confirm_status', 'ONGOING')
                         ->where('confirm_by', $userId);
                  });
            });
        }

        if ($request->has('from_date') && $request->has('to_date')) {
            $invoices = $baseQuery
                ->whereBetween('invoice_date', [$request->from_date, $request->to_date])
                ->get();
        } else {
            $invoices = $baseQuery
                ->where('invoice_date', Carbon::now()->toDateString())
                ->get();
        }

        return ResponseFormatter::success(['invoice' => SalesResource::collection($invoices)], 'Success');
    }

    public function getPhilipsInvoice(Request $request)
    {
        $userId = $request->user()->uuid ?? null;

        $baseQuery = Sales::where('brand', 'PHP');

        if($request->has('status')){
            $status = $request->status;
            if($status == 'HOLD') {
                $baseQuery->where('confirm_status', $status);
            }
            else {
                $baseQuery->where('confirm_status', $status)
                          ->where('confirm_by', $userId);
            }
        } else {
            $baseQuery->where(function ($q) use ($userId) {
                $q->where('confirm_status', 'HOLD')
                  ->orWhere(function ($q2) use ($userId) {
                      $q2->where('confirm_status', 'ONGOING')
                         ->where('confirm_by', $userId);
                  });
            });
        }

        if ($request->has('from_date') && $request->has('to_date')) {
            $invoices = $baseQuery
                ->whereBetween('invoice_date', [$request->from_date, $request->to_date])
                ->get();
        } else {
            $invoices = $baseQuery
                ->where('invoice_date', Carbon::now()->toDateString())
                ->get();
        }

        return ResponseFormatter::success(['invoice' => SalesResource::collection($invoices)], 'Success');
    }

    public function getFalkenInvoice(Request $request)
    {
        $userId = $request->user()->uuid ?? null;

        $baseQuery = Sales::where('brand', 'FLK');

        if($request->has('status')){
            $status = $request->status;
            if($status == 'HOLD') {
                $baseQuery->where('confirm_status', $status);
            }
            else {
                $baseQuery->where('confirm_status', $status)
                          ->where('confirm_by', $userId);
            }
        } else {
            $baseQuery->where(function ($q) use ($userId) {
                $q->where('confirm_status', 'HOLD')
                  ->orWhere(function ($q2) use ($userId) {
                      $q2->where('confirm_status', 'ONGOING')
                         ->where('confirm_by', $userId);
                  });
            });
        }

        if ($request->has('from_date') && $request->has('to_date')) {
            $invoices = $baseQuery
                ->whereBetween('invoice_date', [$request->from_date, $request->to_date])
                ->get();
        } else {
            $invoices = $baseQuery
                ->where('invoice_date', Carbon::now()->toDateString())
                ->get();
        }

        return ResponseFormatter::success(['invoice' => SalesResource::collection($invoices)], 'Success');
    }
    
    public function getPartpkuInvoice(Request $request)
    {
        $userId = $request->user()->uuid ?? null;

        $baseQuery = Sales::where('brand', 'UNV')->cabang('md_pku');

        if($request->has('status')){
            $status = $request->status;
            if($status == 'HOLD') {
                $baseQuery->where('confirm_status', $status);
            }
            else {
                $baseQuery->where('confirm_status', $status)
                          ->where('confirm_by', $userId);
            }
        } else {
            $baseQuery->where(function ($q) use ($userId) {
                $q->where('confirm_status', 'HOLD')
                  ->orWhere(function ($q2) use ($userId) {
                      $q2->where('confirm_status', 'ONGOING')
                         ->where('confirm_by', $userId);
                  });
            });
        }

        if ($request->has('from_date') && $request->has('to_date')) {
            $invoices = $baseQuery
                ->whereBetween('invoice_date', [$request->from_date, $request->to_date])
                ->get();
        } else {
            $invoices = $baseQuery
                ->where('invoice_date', Carbon::now()->toDateString())
                ->get();
        }

        return ResponseFormatter::success(['invoice' => SalesResource::collection($invoices)], 'Success');
    }

    public function uploadPhotos(Request $request, $invoice)
    {
        // if (!$request->user()->hasPermissionTo('save_imported_deal_photo')) {
        //     return ResponseFormatter::error(null, 'Unauthorized', 403);
        // }
        try {
            $sales = Sales::findOrFail($invoice);
            
            if ($request->hasFile('photos')) {
                DB::beginTransaction();
                try {
                    $photo = Photo::where('invoice_id', $invoice)->get();
                    foreach ($photo as $p) {
                        Storage::delete('public/' . $p->photo_path);
                        $p->delete();
                    }
                    $files = $request->file('photos');
                    if (!is_array($files)) {
                        $files = [$files];
                    }
                    $uploadedPhotos = [];
                    foreach ($files as $index => $photo) {
                        $filename = 'photo_' . time() . '_' . uniqid() . '_' . preg_replace('/[^A-Za-z0-9\-\.]/', '', $photo->getClientOriginalName());
                        // Change this line - remove 'public/' from the path
                        $path = $photo->storeAs('images', $filename, 'public');

                        if (!$path) {
                            throw new \Exception('Failed to store file');
                        }

                        $photos = Photo::create([
                            'invoice_id' => $invoice,
                            'photo_path' => $path // Store the relative path
                        ]);
                        
                        // Update URL generation
                        $uploadedPhotos[] = [
                            'id' => $photos->id,
                            'url' => asset('storage/' . $path)
                        ];
                    }
                    
                    DB::commit();
                    return ResponseFormatter::success(
                        200,
                        'Deal photos uploaded successfully'
                    );
                } catch (\Exception $e) {
                    DB::rollBack();
                    //delete uploaded files if any error occurs
                    if (!empty($uploadedPhotos)) {
                        foreach ($uploadedPhotos as $photo) {
                            Storage::delete('public/' . basename($photo['url']));
                        }
                    }
                    throw $e;
                }
            }
            
            return ResponseFormatter::error(
                null,
                'No photos provided',
                400
            );
        } catch (\Exception $e) {
            if ($request->hasFile('photos')) {
                $photos = Photo::where('invoice_id', $invoice)->get();
                foreach ($photos as $photo) {
                    Storage::delete('public/' . $photo->photo_path);
                }
            }
            
            return ResponseFormatter::error(
                null,
                'Failed to upload photos: ' . $e->getMessage(),
                500
            );
        }
    }

    public function startDelivery(Request $request, $invoice)
    {
        $sales = Sales::findOrFail($invoice);
        if($sales->confirm_status == 'ONGOING'){
            return ResponseFormatter::error(
                null,
                'Delivery has been on progress',
                400
            );
        }
        else if($sales->confirm_status == 'DONE'){
            return ResponseFormatter::error(
                null,
                'Item has already been delivered',
                400
            );
        }
        $sales->confirm_status = 'ONGOING';
        $sales->confirm_by = $request->user()->uuid;
        $sales->save();
        return ResponseFormatter::success(
            200,
            'Delivery on progress'
        );
    }

    public function confirm(Request $request, $invoice)
    {
        $sales = Sales::findOrFail($invoice);
        if($sales->confirm_status == 'HOLD'){
            return ResponseFormatter::error(
                null,
                'Delivery not started yet',
                400
            );
        }
        else if($sales->confirm_status == 'DONE'){
            return ResponseFormatter::error(
                null,
                'Item has already been delivered',
                400
            );
        }
        $sales->confirm_status = 'DONE';
        $sales->confirm_by = $request->user()->uuid;
        $sales->confirm_at = now();
        $sales->confirm_notes = $request->input('confirm_notes', null);
        $sales->save();
        return ResponseFormatter::success(
            200,
            'Delivery completed'
        );
    }
}
