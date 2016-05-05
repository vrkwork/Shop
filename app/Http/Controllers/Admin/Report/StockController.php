<?php

namespace App\Http\Controllers\Admin\Report;

use App\Http\Controllers\BaseController;
use App\Models\Stock;
use App\Models\Item;
use Lang;


class StockController extends BaseController
{
    protected $scope = 'stock';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $scope = $this->scope;
        $user = $this->user;

        $stock = [];

        $item = Item::all();
        $item = $item->sortBy('item_code');

        foreach($item as $value)
        {
            $stock[$value->id] = Stock::where('item_code', $value->item_code)->sum('qty');
        }
        
        return view('admin.report.' . $this->scope . '.index', compact('scope', 'user', 'stock', 'item'));
    }

    public function create($item_code)
    {
        $scope = $this->scope;
        $user = $this->user;

        $item = Item::where('item_code', $item_code)->first();

        $stock = Stock::select('stock.qty as qty', 'purchase.rate as rate', 'purchase_detail.bill_id as bill_id')
            ->leftJoin('purchase', 'purchase.id', '=', 'stock.purchase_id')
            ->leftJoin('purchase_detail', 'purchase_detail.id', '=', 'purchase.purchase_detail_id')
            ->where('stock.item_code', $item_code)
            ->get();

        return view('admin.report.' . $this->scope . '.create', compact('scope', 'user', 'stock', 'item'));
    }

}
