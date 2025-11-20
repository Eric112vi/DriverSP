<?php

namespace App\Models\FromAPI\Mitsu;

use Illuminate\Database\Eloquent\Model;

class MitsuSalesItem extends Model
{
    protected $connection = 'mitsu_part';
    protected $table = 'sales_items';
    public $timestamps = false;

    protected $guarded = [];
}