<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    protected $table = 'purchase';

    protected $fillable = ['purchase_detail_id', 'item_code', 'qty', 'rate', 'remark'];

    public function purchaseDetail()
    {
        return $this->belongsTo('App\Models\PurchaseDetail');
    }

    public function item()
    {
        return $this->belongsTo('App\Models\Item');
    }
}
