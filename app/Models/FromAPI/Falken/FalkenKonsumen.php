<?php

namespace App\Models\FromAPI\Falken;

use Illuminate\Database\Eloquent\Model;

class FalkenKonsumen extends Model
{
    protected $connection = 'flk_part';
    protected $table = 'konsumens';
    public $timestamps = false;

    protected $guarded = [];
}