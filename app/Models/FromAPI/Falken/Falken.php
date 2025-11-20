<?php

namespace App\Models\FromAPI\Falken;

use Illuminate\Database\Eloquent\Model;

class Falken extends Model
{
    protected $connection = 'flk_part';
    protected $table = 'sales';
    public $timestamps = false;

    protected $guarded = [];

    public function salesItems()
    {
        return $this->hasMany(FalkenSalesItem::class, 'no_invoice', 'no_invoice');
    }
}