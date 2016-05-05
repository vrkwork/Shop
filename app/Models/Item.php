<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $table = 'item';

    protected $fillable = ['item_code', 'item_name'];

    public function purchase()
    {
        return $this->hasMany('App\Models\Purchase');
    }
}
