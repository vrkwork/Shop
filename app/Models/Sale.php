<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    protected $table = 'sale';

    protected $fillable = ['sale_detail_id', 'item_code', 'qty', 'rate', 'remark', 'profit'];

    public function purchase()
    {
        return $this->belongsTo('App\Models\SaleDetail');
    }
}
