<?php

namespace App\Models\FromAPI\Mitsu;

use Illuminate\Database\Eloquent\Model;

class Mitsu extends Model
{
    protected $connection = 'mitsu_part';
    protected $table = 'sales';
    public $timestamps = false;

    protected $guarded = [];

    public function salesItems()
    {
        return $this->hasMany(MitsuSalesItem::class, 'no_invoice', 'no_invoice');
    }
}