<?php

namespace App\Models\FromAPI\Philips;

use Illuminate\Database\Eloquent\Model;

class Philips extends Model
{
    protected $connection = 'philips_part';
    protected $table = 'sales';
    public $timestamps = false;

    protected $guarded = [];

    public function salesItems()
    {
        return $this->hasMany(PhilipsSalesItem::class, 'no_invoice', 'no_invoice');
    }
}