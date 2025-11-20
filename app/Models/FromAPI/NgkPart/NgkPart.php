<?php

namespace App\Models\FromAPI\NgkPart;

use Illuminate\Database\Eloquent\Model;

class NgkPart extends Model
{
    protected $connection = 'ngk_part';
    protected $table = 'sales';
    public $timestamps = false;

    protected $guarded = [];

    public function salesItems()
    {
        return $this->hasMany(NgkSalesItem::class, 'no_invoice', 'no_invoice');
    }
}