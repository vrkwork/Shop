<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerCredit extends Model
{
    protected $table = 'customer_credit';

    protected $fillable = ['bill_id', 'customer_id', 'amount'];
}
