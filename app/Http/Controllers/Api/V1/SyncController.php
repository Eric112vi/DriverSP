<?php

namespace App\Http\Controllers\Api\V1;

use Carbon\Carbon;
use App\Models\Sales;
use Illuminate\Http\Request;
use App\Helpers\ResponseFormatter;
use Illuminate\Support\Facades\DB;
use App\Models\FromAPI\Mitsu\Mitsu;
use App\Http\Controllers\Controller;
use App\Models\FromAPI\Falken\Falken;
use App\Models\FromAPI\NgkPart\NgkPart;
use App\Models\FromAPI\PartPku\PartPku;
use App\Models\FromAPI\Philips\Philips;
use App\Models\FromAPI\Mitsu\MitsuKonsumen;
use App\Models\FromAPI\NgkPart\NgkKonsumen;
use App\Models\FromAPI\Falken\FalkenKonsumen;
use App\Models\FromAPI\PartPku\PartPkuKonsumen;
use App\Models\FromAPI\Philips\PhilipsKonsumen;

class SyncController extends Controller
{
    // public function syncNgk(Request $request)
    // {
    //     if($request->has('from_date') && $request->has('to_date')) {
    //         $dateFrom = $request->from_date ? $request->from_date : now();
    //         $dateTo = $request->to_date ? $request->to_date : now();
    //         $invoices = NgkPart::where('cabang', 'md_mdn')
    //             ->whereBetween('tanggal_invoice', [$dateFrom, $dateTo])
    //             ->with('salesItems')
    //             ->get();
    //     } else {
    //         $invoices = NgkPart::where('cabang', 'md_mdn')
    //             ->where('tanggal_invoice', '2025-09-04')
    //             ->with('salesItems')
    //             ->get();
    //     }
    //     dd($invoices->count());
    //     foreach($invoices as $invoice) {
    //         $existingInvoice = Sales::where('source_id', $invoice->id)->where('cabang', 'NGK-MDN')->first();
    //         if(!$existingInvoice) {
    //             $konsumen = NgkKonsumen::where('kode_konsumen', $invoice->kode_konsumen)
    //                 ->where('cabang', $invoice->cabang)
    //                 ->first();
    //             $sales = Sales::create([
    //                 'invoice_number' => $invoice->no_invoice,
    //                 'invoice_date' => $invoice->tanggal_invoice,
    //                 'payment_type' => $invoice->tipe_bayar,
    //                 'due_days' => $invoice->due_days,
    //                 'due_date' => $invoice->due_date,
    //                 'customer_code' => $invoice->kode_konsumen,
    //                 'customer_name' => $invoice->nama_konsumen,
    //                 'customer_address' => $konsumen ? $konsumen->alamat : null,
    //                 'customer_city' => $konsumen ? $konsumen->kota : null,
    //                 'customer_phone' => $konsumen ? $konsumen->no_telp : null,
    //                 'customer_nik' => $konsumen ? $konsumen->nik : null,
    //                 'customer_npwp' => $konsumen ? $konsumen->npwp : null,
    //                 'salesman_name' => $invoice->nama_salesman,
    //                 'ppn' => $invoice->ppn,
    //                 'discount' => $invoice->percentdisc,
    //                 'total_discount' => $invoice->rpdisc,
    //                 'total_price' => $invoice->total_harga,
    //                 'notes' => $invoice->notes,
    //                 'confirm_status' => 'HOLD',
    //                 'source_id' => $invoice->id,
    //                 'cabang' => 'NGK-MDN',
    //                 'brand' => 'NGK',
    //                 'created_at' => $invoice->created_at,
    //                 'updated_at' => $invoice->updated_at,
    //             ]);
    //             $totalQuantity = 0;
    //             foreach($invoice->salesItems as $salesItem) {
    //                 $sales->salesItems()->create([
    //                     'invoice_id' => $sales->id,
    //                     'kode_barang' => $salesItem->kode_barang,
    //                     'nama_barang' => $salesItem->nama_barang,
    //                     'quantity' => $salesItem->quantity,
    //                     'harga_jual' => $salesItem->harga_jual,
    //                     'total_harga' => $salesItem->total_harga,
    //                 ]);
    //                 $totalQuantity += $salesItem->quantity;
    //             }
    //             $sales->update(['total_quantity' => $totalQuantity]);
    //         }
    //     }

    //     return ResponseFormatter::success(['invoices' => $invoices], 'Sync NGK Success');
    // }

    public function syncNgk(Request $request)
    {
        if ($request->has('from_date') && $request->has('to_date')) {
            $invoices = NgkPart::where('cabang', 'md_mdn')->where('status', '!=', 'BATAL')
                ->whereBetween('tanggal_invoice', [$request->from_date, $request->to_date])
                ->with('salesItems')
                ->get();
        } else {
            $invoices = NgkPart::where('cabang', 'md_mdn')->where('status', '!=', 'BATAL')
                ->where('tanggal_invoice', Carbon::now()->toDateString())
                ->with('salesItems')
                ->get();
        }

        if ($invoices->isEmpty()) {
            return ResponseFormatter::success(null, 'Tidak ada faktur baru untuk disinkronkan.');
        }

        $customerCodes = $invoices->pluck('kode_konsumen')->unique();
        $konsumens = NgkKonsumen::where('cabang', 'md_mdn')
            ->whereIn('kode_konsumen', $customerCodes)
            ->get()
            ->keyBy('kode_konsumen');

        $existingSourceIds = Sales::where('brand', 'NGK')
            ->whereIn('source_id', $invoices->pluck('id'))
            ->pluck('source_id');

        $invoicesToSync = $invoices->whereNotIn('id', $existingSourceIds);

        DB::transaction(function () use ($invoicesToSync, $konsumens) {
            foreach ($invoicesToSync as $invoice) {
                $konsumen = $konsumens->get($invoice->kode_konsumen);

                $totalQuantity = $invoice->salesItems->sum('quantity');

                $sales = Sales::create([
                    'invoice_number' => $invoice->no_invoice,
                    'invoice_date' => $invoice->tanggal_invoice,
                    'payment_type' => $invoice->tipe_bayar,
                    'due_days' => $invoice->due_days,
                    'due_date' => $invoice->due_date,
                    'customer_code' => $invoice->kode_konsumen,
                    'customer_name' => $invoice->nama_konsumen,
                    'customer_address' => $konsumen ? $konsumen->alamat : null,
                    'customer_city' => $konsumen ? $konsumen->kota : null,
                    'customer_phone' => $konsumen ? $konsumen->no_telp : null,
                    'customer_nik' => $konsumen ? $konsumen->nik : null,
                    'customer_npwp' => $konsumen ? $konsumen->npwp : null,
                    'salesman_name' => $invoice->nama_salesman,
                    'ppn' => $invoice->ppn,
                    'discount' => $invoice->percentdisc,
                    'total_discount' => $invoice->rpdisc,
                    'total_price' => $invoice->total_harga,
                    'total_quantity' => $totalQuantity,
                    'notes' => $invoice->notes,
                    'confirm_status' => 'HOLD',
                    'source_id' => $invoice->id,
                    'cabang' => 'md_mdn',
                    'brand' => 'NGK',
                    'created_at' => $invoice->created_at,
                    'updated_at' => $invoice->updated_at,
                ]);

                $salesItemsData = [];
                foreach ($invoice->salesItems as $salesItem) {
                    $salesItemsData[] = [
                        'invoice_id' => $sales->id,
                        'kode_barang' => $salesItem->kode_barang,
                        'nama_barang' => $salesItem->nama_barang,
                        'quantity' => $salesItem->quantity,
                        'harga_jual' => $salesItem->harga_jual,
                        'total_harga' => $salesItem->total_harga,
                    ];
                }

                $sales->salesItems()->insert($salesItemsData);
            }
        });

        return ResponseFormatter::success(
            ['synced_count' => $invoicesToSync->count()],
            'Sinkronisasi NGK Berhasil'
        );
    }
    public function syncFalken(Request $request)
    {
        if ($request->has('from_date') && $request->has('to_date')) {
            $invoices = Falken::where('cabang', 'md_mdn')->where('status', '!=', 'BATAL')
                ->whereBetween('tanggal_invoice', [$request->from_date, $request->to_date])
                ->with('salesItems')
                ->get();
        } else {
            $invoices = Falken::where('cabang', 'md_mdn')->where('status', '!=', 'BATAL')
                ->where('tanggal_invoice', Carbon::now()->toDateString())
                ->with('salesItems')
                ->get();
        }

        if ($invoices->isEmpty()) {
            return ResponseFormatter::success(null, 'Tidak ada faktur baru untuk disinkronkan.');
        }

        $customerCodes = $invoices->pluck('kode_konsumen')->unique();
        $konsumens = FalkenKonsumen::where('cabang', 'md_mdn')
            ->whereIn('kode_konsumen', $customerCodes)
            ->get()
            ->keyBy('kode_konsumen');

        $existingSourceIds = Sales::where('brand', 'FLK')
            ->whereIn('source_id', $invoices->pluck('id'))
            ->pluck('source_id');

        $invoicesToSync = $invoices->whereNotIn('id', $existingSourceIds);

        DB::transaction(function () use ($invoicesToSync, $konsumens) {
            foreach ($invoicesToSync as $invoice) {
                $konsumen = $konsumens->get($invoice->kode_konsumen);

                $totalQuantity = $invoice->salesItems->sum('quantity');

                $sales = Sales::create([
                    'invoice_number' => $invoice->no_invoice,
                    'invoice_date' => $invoice->tanggal_invoice,
                    'payment_type' => $invoice->tipe_bayar,
                    'due_days' => $invoice->due_days,
                    'due_date' => $invoice->due_date,
                    'customer_code' => $invoice->kode_konsumen,
                    'customer_name' => $invoice->nama_konsumen,
                    'customer_address' => $konsumen ? $konsumen->alamat : null,
                    'customer_city' => $konsumen ? $konsumen->kota : null,
                    'customer_phone' => $konsumen ? $konsumen->no_telp : null,
                    'customer_nik' => $konsumen ? $konsumen->nik : null,
                    'customer_npwp' => $konsumen ? $konsumen->npwp : null,
                    'salesman_name' => $invoice->nama_salesman,
                    'ppn' => $invoice->ppn,
                    'discount' => $invoice->percentdisc,
                    'total_discount' => $invoice->rpdisc,
                    'total_price' => $invoice->total_harga,
                    'total_quantity' => $totalQuantity,
                    'notes' => $invoice->notes,
                    'confirm_status' => 'HOLD',
                    'source_id' => $invoice->id,
                    'cabang' => 'md_mdn',
                    'brand' => 'FLK',
                    'created_at' => $invoice->created_at,
                    'updated_at' => $invoice->updated_at,
                ]);

                $salesItemsData = [];
                foreach ($invoice->salesItems as $salesItem) {
                    $salesItemsData[] = [
                        'invoice_id' => $sales->id,
                        'kode_barang' => $salesItem->kode_barang,
                        'nama_barang' => $salesItem->nama_barang,
                        'quantity' => $salesItem->quantity,
                        'harga_jual' => $salesItem->harga_jual,
                        'total_harga' => $salesItem->total_harga,
                    ];
                }

                $sales->salesItems()->insert($salesItemsData);
            }
        });

        return ResponseFormatter::success(
            ['synced_count' => $invoicesToSync->count()],
            'Sinkronisasi Falken Berhasil'
        );
    }

    public function syncPhilips(Request $request)
    {
        if ($request->has('from_date') && $request->has('to_date')) {
            $invoices = Philips::where('cabang', 'md_mdn')->where('status', '!=', 'BATAL')
                ->whereBetween('tanggal_invoice', [$request->from_date, $request->to_date])
                ->with('salesItems')
                ->get();
        } else {
            $invoices = Philips::where('cabang', 'md_mdn')->where('status', '!=', 'BATAL')
                ->where('tanggal_invoice', Carbon::now()->toDateString())
                ->with('salesItems')
                ->get();
        }

        if ($invoices->isEmpty()) {
            return ResponseFormatter::success(null, 'Tidak ada faktur baru untuk disinkronkan.');
        }

        $customerCodes = $invoices->pluck('kode_konsumen')->unique();
        $konsumens = PhilipsKonsumen::where('cabang', 'md_mdn')
            ->whereIn('kode_konsumen', $customerCodes)
            ->get()
            ->keyBy('kode_konsumen');

        $existingSourceIds = Sales::where('brand', 'PHP')
            ->whereIn('source_id', $invoices->pluck('id'))
            ->pluck('source_id');

        $invoicesToSync = $invoices->whereNotIn('id', $existingSourceIds);

        DB::transaction(function () use ($invoicesToSync, $konsumens) {
            foreach ($invoicesToSync as $invoice) {
                $konsumen = $konsumens->get($invoice->kode_konsumen);

                $totalQuantity = $invoice->salesItems->sum('quantity');

                $sales = Sales::create([
                    'invoice_number' => $invoice->no_invoice,
                    'invoice_date' => $invoice->tanggal_invoice,
                    'payment_type' => $invoice->tipe_bayar,
                    'due_days' => $invoice->due_days,
                    'due_date' => $invoice->due_date,
                    'customer_code' => $invoice->kode_konsumen,
                    'customer_name' => $invoice->nama_konsumen,
                    'customer_address' => $konsumen ? $konsumen->alamat : null,
                    'customer_city' => $konsumen ? $konsumen->kota : null,
                    'customer_phone' => $konsumen ? $konsumen->no_telp : null,
                    'customer_nik' => $konsumen ? $konsumen->nik : null,
                    'customer_npwp' => $konsumen ? $konsumen->npwp : null,
                    'salesman_name' => $invoice->nama_salesman,
                    'ppn' => $invoice->ppn,
                    'discount' => $invoice->percentdisc,
                    'total_discount' => $invoice->rpdisc,
                    'total_price' => $invoice->total_harga,
                    'total_quantity' => $totalQuantity,
                    'notes' => $invoice->notes,
                    'confirm_status' => 'HOLD',
                    'source_id' => $invoice->id,
                    'cabang' => 'md_mdn',
                    'brand' => 'PHP',
                    'created_at' => $invoice->created_at,
                    'updated_at' => $invoice->updated_at,
                ]);

                $salesItemsData = [];
                foreach ($invoice->salesItems as $salesItem) {
                    $salesItemsData[] = [
                        'invoice_id' => $sales->id,
                        'kode_barang' => $salesItem->kode_barang,
                        'nama_barang' => $salesItem->nama_barang,
                        'quantity' => $salesItem->quantity,
                        'harga_jual' => $salesItem->harga_jual,
                        'total_harga' => $salesItem->total_harga,
                    ];
                }

                $sales->salesItems()->insert($salesItemsData);
            }
        });

        return ResponseFormatter::success(
            ['synced_count' => $invoicesToSync->count()],
            'Sinkronisasi Philips Berhasil'
        );
    }

    public function syncMitsu(Request $request)
    {
        if ($request->has('from_date') && $request->has('to_date')) {
            $invoices = Mitsu::where('cabang', 'md_mdn')->where('status', '!=', 'BATAL')
                ->whereBetween('tanggal_invoice', [$request->from_date, $request->to_date])
                ->with('salesItems')
                ->get();
        } else {
            $invoices = Mitsu::where('cabang', 'md_mdn')->where('status', '!=', 'BATAL')
                ->where('tanggal_invoice', Carbon::now()->toDateString())
                ->with('salesItems')
                ->get();
        }

        if ($invoices->isEmpty()) {
            return ResponseFormatter::success(null, 'Tidak ada faktur baru untuk disinkronkan.');
        }

        $customerCodes = $invoices->pluck('kode_konsumen')->unique();
        $konsumens = MitsuKonsumen::where('cabang', 'md_mdn')
            ->whereIn('kode_konsumen', $customerCodes)
            ->get()
            ->keyBy('kode_konsumen');

        $existingSourceIds = Sales::where('brand', 'MTSB')
            ->whereIn('source_id', $invoices->pluck('id'))
            ->pluck('source_id');

        $invoicesToSync = $invoices->whereNotIn('id', $existingSourceIds);

        DB::transaction(function () use ($invoicesToSync, $konsumens) {
            foreach ($invoicesToSync as $invoice) {
                $konsumen = $konsumens->get($invoice->kode_konsumen);

                $totalQuantity = $invoice->salesItems->sum('quantity');

                $sales = Sales::create([
                    'invoice_number' => $invoice->no_invoice,
                    'invoice_date' => $invoice->tanggal_invoice,
                    'payment_type' => $invoice->tipe_bayar,
                    'due_days' => $invoice->due_days,
                    'due_date' => $invoice->due_date,
                    'customer_code' => $invoice->kode_konsumen,
                    'customer_name' => $invoice->nama_konsumen,
                    'customer_address' => $konsumen ? $konsumen->alamat : null,
                    'customer_city' => $konsumen ? $konsumen->kota : null,
                    'customer_phone' => $konsumen ? $konsumen->no_telp : null,
                    'customer_nik' => $konsumen ? $konsumen->nik : null,
                    'customer_npwp' => $konsumen ? $konsumen->npwp : null,
                    'salesman_name' => $invoice->nama_salesman,
                    'ppn' => $invoice->ppn,
                    'discount' => $invoice->percentdisc,
                    'total_discount' => $invoice->rpdisc,
                    'total_price' => $invoice->total_harga,
                    'total_quantity' => $totalQuantity,
                    'notes' => $invoice->notes,
                    'confirm_status' => 'HOLD',
                    'source_id' => $invoice->id,
                    'cabang' => 'md_mdn',
                    'brand' => 'MTSB',
                    'created_at' => $invoice->created_at,
                    'updated_at' => $invoice->updated_at,
                ]);

                $salesItemsData = [];
                foreach ($invoice->salesItems as $salesItem) {
                    $salesItemsData[] = [
                        'invoice_id' => $sales->id,
                        'kode_barang' => $salesItem->kode_barang,
                        'nama_barang' => $salesItem->nama_barang,
                        'quantity' => $salesItem->quantity,
                        'harga_jual' => $salesItem->harga_jual,
                        'total_harga' => $salesItem->total_harga,
                    ];
                }

                $sales->salesItems()->insert($salesItemsData);
            }
        });

        return ResponseFormatter::success(
            ['synced_count' => $invoicesToSync->count()],
            'Sinkronisasi Mitsuboshi Berhasil'
        );
    }

    public function syncPku(Request $request)
    {
        if ($request->has('from_date') && $request->has('to_date')) {
            $invoices = PartPku::where('cabang', 'md_pku')->where('status', '!=', 'BATAL')
                ->whereBetween('tanggal_invoice', [$request->from_date, $request->to_date])
                ->with('salesItems')
                ->get();
        } else {
            $invoices = PartPku::where('cabang', 'md_pku')->where('status', '!=', 'BATAL')
                ->where('tanggal_invoice', Carbon::now()->toDateString())
                ->with('salesItems')
                ->get();
        }
        if ($invoices->isEmpty()) {
            return ResponseFormatter::success(null, 'Tidak ada faktur baru untuk disinkronkan.');
        }

        $customerCodes = $invoices->pluck('kode_konsumen')->unique();
        $konsumens = PartPkuKonsumen::where('cabang', 'md_pku')
            ->whereIn('kode_konsumen', $customerCodes)
            ->get()
            ->keyBy('kode_konsumen');

        $existingSourceIds = Sales::where('brand', 'UNV')->where('cabang', 'md_pku')
            ->whereIn('source_id', $invoices->pluck('id'))
            ->pluck('source_id');

        $invoicesToSync = $invoices->whereNotIn('id', $existingSourceIds);

        DB::transaction(function () use ($invoicesToSync, $konsumens) {
            foreach ($invoicesToSync as $invoice) {
                $konsumen = $konsumens->get($invoice->kode_konsumen);

                $totalQuantity = $invoice->salesItems->sum('quantity');

                $sales = Sales::create([
                    'invoice_number' => $invoice->no_invoice,
                    'invoice_date' => $invoice->tanggal_invoice,
                    'payment_type' => $invoice->tipe_bayar,
                    'due_days' => $invoice->due_days,
                    'due_date' => $invoice->due_date,
                    'customer_code' => $invoice->kode_konsumen,
                    'customer_name' => $invoice->nama_konsumen,
                    'customer_address' => $konsumen ? $konsumen->alamat : null,
                    'customer_city' => $konsumen ? $konsumen->kota : null,
                    'customer_phone' => $konsumen ? $konsumen->no_telp : null,
                    'customer_nik' => $konsumen ? $konsumen->nik : null,
                    'customer_npwp' => $konsumen ? $konsumen->npwp : null,
                    'salesman_name' => $invoice->nama_salesman,
                    'ppn' => $invoice->ppn,
                    'discount' => $invoice->percentdisc,
                    'total_discount' => $invoice->rpdisc,
                    'total_price' => $invoice->total_harga,
                    'total_quantity' => $totalQuantity,
                    'notes' => $invoice->notes,
                    'confirm_status' => 'HOLD',
                    'source_id' => $invoice->id,
                    'cabang' => 'md_pku',
                    'brand' => 'UNV',
                    'created_at' => $invoice->created_at,
                    'updated_at' => $invoice->updated_at,
                ]);

                $salesItemsData = [];
                foreach ($invoice->salesItems as $salesItem) {
                    $salesItemsData[] = [
                        'invoice_id' => $sales->id,
                        'kode_barang' => $salesItem->kode_barang,
                        'nama_barang' => $salesItem->nama_barang,
                        'quantity' => $salesItem->quantity,
                        'harga_jual' => $salesItem->harga_jual,
                        'total_harga' => $salesItem->total_harga,
                    ];
                }

                $sales->salesItems()->insert($salesItemsData);
            }
        });

        return ResponseFormatter::success(
            ['synced_count' => $invoicesToSync->count()],
            'Sinkronisasi Part PKU Berhasil'
        );
    }

    
}
