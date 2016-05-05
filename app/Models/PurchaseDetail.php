<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseDetail extends Model
{
    protected $table = 'purchase_detail';

    protected $fillable = ['bill_id', 'supplier_id', 'registered', 'name', 'address', 'phone', 'mobile', 'discount', 'payment_mode'];

    public function purchase()
    {
        return $this->hasMany('App\Models\Purchase');
    }
}
