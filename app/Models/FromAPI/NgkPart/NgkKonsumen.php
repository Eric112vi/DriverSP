<?php

namespace App\Models\FromAPI\NgkPart;

use Illuminate\Database\Eloquent\Model;

class NgkKonsumen extends Model
{
    protected $connection = 'ngk_part';
    protected $table = 'konsumens';
    public $timestamps = false;

    protected $guarded = [];
}