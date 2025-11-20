<?php

namespace App\Models\FromAPI\NgkPart;

use Illuminate\Database\Eloquent\Model;

class NgkSalesItem extends Model
{
    protected $connection = 'ngk_part';
    protected $table = 'sales_items';
    public $timestamps = false;

    protected $guarded = [];
}