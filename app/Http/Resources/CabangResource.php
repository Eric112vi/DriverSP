<?php

namespace App\Http\Resources;

use App\Models\User;
use App\Models\Sales;
use App\Models\Konsumen;
use App\Models\SalesItem;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CabangResource extends JsonResource
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
            'nama_cabang' => $this->nama_cabang,
            'kode_cabang' => $this->kode_cabang,
        ];
    }    
}