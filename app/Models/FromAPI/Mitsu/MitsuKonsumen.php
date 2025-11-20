<?php

namespace App\Models\FromAPI\Mitsu;

use Illuminate\Database\Eloquent\Model;

class MitsuKonsumen extends Model
{
    protected $connection = 'mitsu_part';
    protected $table = 'konsumens';
    public $timestamps = false;

    protected $guarded = [];
}