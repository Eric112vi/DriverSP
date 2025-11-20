<?php

namespace App\Models\FromAPI\PartPku;

use Illuminate\Database\Eloquent\Model;

class PartPkuKonsumen extends Model
{
    protected $connection = 'pku_part';
    protected $table = 'konsumens';
    public $timestamps = false;

    protected $guarded = [];
}