<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SaleDetail extends Model
{
    protected $table = 'sale_detail';

    protected $fillable = ['bill_id', 'customer_id', 'registered', 'name', 'address', 'phone', 'mobile', 'discount', 'payment_mode'];

    public function purchase()
    {
        return $this->hasMany('App\Models\Sale');
    }
}
