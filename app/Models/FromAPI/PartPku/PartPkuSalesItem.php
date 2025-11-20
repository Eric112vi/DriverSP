<?php

namespace App\Models\FromAPI\PartPku;

use Illuminate\Database\Eloquent\Model;

class PartPkuSalesItem extends Model
{
    protected $connection = 'pku_part';
    protected $table = 'sales_items';
    public $timestamps = false;

    protected $guarded = [];
}