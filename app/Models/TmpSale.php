<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TmpSale extends Model
{
    protected $table = 'tmp_sale';

    protected $fillable = ['bill_id', 'customer_id', 'name', 'address', 'phone', 'mobile', 'item_code', 'qty', 'rate', 'remark'];
}
