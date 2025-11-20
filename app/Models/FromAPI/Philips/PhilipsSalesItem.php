<?php

namespace App\Models\FromAPI\Philips;

use Illuminate\Database\Eloquent\Model;

class PhilipsSalesItem extends Model
{
    protected $connection = 'philips_part';
    protected $table = 'sales_items';
    public $timestamps = false;

    protected $guarded = [];
}