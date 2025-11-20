<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sales extends Model
{
    /** @use HasFactory<\Database\Factories\SalesFactory> */
    use HasFactory;
    protected $guarded = [];

    public function salesItems()
    {
        return $this->hasMany(SalesItem::class, 'invoice_id', 'id');
    }

    public function photos()
    {
        return $this->hasMany(Photo::class, 'invoice_id', 'id');
    }
}
