<?php

namespace App\Http\Resources;

use App\Models\User;
use App\Models\Sales;
use App\Models\Konsumen;
use App\Models\SalesItem;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SalesResource extends JsonResource
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
            'invoice_number' => $this->invoice_number,
            'invoice_date' => $this->invoice_date,
            'payment_type' => $this->payment_type,
            'due_days' => $this->due_days,
            'due_date' => $this->due_date,
            'customer_code' => $this->customer_code,
            'customer_name' => $this->customer_name,
            'customer_address' => $this->customer_address,
            'customer_city' => $this->customer_city,
            'customer_phone' => $this->customer_phone,
            'customer_nik' => $this->customer_nik,
            'customer_npwp' => $this->customer_npwp,
            'salesman_name' => $this->salesman_name,
            'ppn' => $this->ppn,
            'discount' => $this->discount,
            'total_discount' => $this->total_discount,
            'total_price' => $this->total_price,
            'total_quantity' => $this->total_quantity,
            'notes' => $this->notes,
            'confirm_status' => $this->confirm_status,
            'confirm_by' => [
                'id' => $this->confirm_by,
                'name' => User::where('uuid', $this->confirm_by)->value('name') ?? null,
            ],
            'confirm_at' => $this->confirm_at,
            'confirm_locaion' => $this->confirm_location,
            'confirm_notes' => $this->confirm_notes,
            'source_id' => $this->source_id,
            'brand' => $this->brand,
            'cabang' => $this->cabang,
            'sales_item' => $this->salesItems ? $this->salesItems->map(function ($item) {
                return [
                    'id' => $item->id,
                    'invoice_number' => $item->invoice_number,
                    'kode_barang' => $item->kode_barang,
                    'nama_barang' => $item->nama_barang,
                    'quantity' => $item->quantity,
                    'harga_jual' => $item->harga_jual,
                    'total_harga' => $item->total_harga,
                ];
            })  : [],
            'photos' => $this->photos ? $this->photos->map(function ($photo) {
                return [
                    'id' => $photo->id,
                    'photo_path' => asset('storage/' . $photo->photo_path),
                ];
            }) : [],
        ];
    }    
}