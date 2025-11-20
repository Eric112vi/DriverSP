<?php

namespace App\Http\Resources;

use App\Models\FromAPI\NgkPart\NgkKonsumen;
use App\Models\Sales;
use App\Models\Konsumen;
use App\Models\SalesItem;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NgkResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {

        return [
            'id' => $this->id,
            'invoice_number' => $this->no_invoice,
            'invoice_date' => $this->tanggal_invoice,
            'payment_type' => $this->tipe_bayar,
            'due_days' => $this->due_days,
            'due_date' => $this->due_date,
            'customer_code' => $this->kode_konsumen,
            'customer_name' => $this->nama_konsumen,
            'customer_address' => NgkKonsumen::where('kode_konsumen', $this->kode_konsumen)->where('cabang', $this->cabang)->first()->alamat ?? null,
            'customer_city' => $this->customer_city,
            'customer_phone' => $this->customer_phone,
            'customer_nik' => $this->customer_nik,
            'customer_npwp' => $this->customer_npwp,
            'salesman_code' => $this->salesman_code,
            'salesman_name' => $this->salesman_name,
            'ppn' => $this->ppn,
            'discount' => $this->discount,
            'total_discount' => $this->total_discount,
            'total_price' => $this->total_price,
            'notes' => $this->notes,
            'confirm_status' => $this->confirm_status,
            'confirm_image_path' => $this->confirm_image_path,
            'confirm_by' => $this->confirm_by,
            'confirm_at' => $this->confirm_at,
            'confirm_notes' => $this->confirm_notes,
            'source_id' => $this->source_id,
            'brand' => $this->brand,
            'cabang' => $this->cabang,
            'sales_item' => $this->salesItems ? $this->salesItems->map(function ($item) {
                return [
                    'id' => $item->id,
                    'invoice_number' => $item->no_invoice,
                    'kode_barang' => $item->kode_barang,
                    'nama_barang' => $item->nama_barang,
                    'quantity' => $item->quantity,
                    'harga_jual' => $item->harga_jual,
                    'total_harga' => $item->total_harga,
                ];
            })  : [],
        ];
    }    
}