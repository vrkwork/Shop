<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TmpPurchase extends Model
{
    protected $table = 'tmp_purchase';

    protected $fillable = ['bill_id', 'supplier_id', 'name', 'address', 'phone', 'mobile', 'item_code', 'qty', 'rate', 'remark'];
}
