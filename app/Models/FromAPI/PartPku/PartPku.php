<?php

namespace App\Models\FromAPI\PartPku;

use Illuminate\Database\Eloquent\Model;

class PartPku extends Model
{
    protected $connection = 'pku_part';
    protected $table = 'sales';
    public $timestamps = false;

    protected $guarded = [];

    public function salesItems()
    {
        return $this->hasMany(PartPkuSalesItem::class, 'no_invoice', 'no_invoice');
    }
}