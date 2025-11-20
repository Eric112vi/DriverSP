<?php

namespace App\Models\FromAPI\Falken;

use Illuminate\Database\Eloquent\Model;

class FalkenSalesItem extends Model
{
    protected $connection = 'flk_part';
    protected $table = 'sales_items';
    public $timestamps = false;

    protected $guarded = [];
}