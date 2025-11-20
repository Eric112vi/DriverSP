<?php

namespace App\Models\FromAPI\Philips;

use Illuminate\Database\Eloquent\Model;

class PhilipsKonsumen extends Model
{
    protected $connection = 'philips_part';
    protected $table = 'konsumens';
    public $timestamps = false;

    protected $guarded = [];
}