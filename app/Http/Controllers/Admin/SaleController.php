<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Sale\SaleAddValidation;
use App\Models\Customer;
use App\Models\Item;
use App\Models\Purchase;
use App\Models\Sale;
use App\Models\SaleDetail;
use App\Models\Stock;
use App\Models\TmpSale;
use Illuminate\Http\Request;
use Lang;


class SaleController extends BaseController
{
    protected $scope = 'sale';
    protected $data;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $scope = $this->scope;
        $user = $this->user;
        $bill_id = SaleDetail::select('bill_id')->orderBy('bill_id', 'desc')->first();
        $items = TmpSale::select('item.item_name as item_name', 'tmp_sale.id', 'tmp_sale.bill_id', 'tmp_sale.name', 'tmp_sale.address', 'tmp_sale.phone', 'tmp_sale.item_code', 'tmp_sale.qty', 'tmp_sale.rate', 'tmp_sale.remark')
            ->leftJoin('item', 'item.item_code', '=', 'tmp_sale.item_code')
            ->orderBy('tmp_sale.id', 'asc')
            ->get();

        if ($bill_id) {
            $bill_id = $bill_id->bill_id + 1;
        } else {
            $bill_id = 1;
        }
        return view('admin.' . $this->scope . '.add', compact('scope', 'user', 'bill_id', 'items'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param SaleAddValidation|SaleAddValidation|Request\Sale $request
     * @return \Illuminate\Http\Response
     */
    public function store(SaleAddValidation $request)
    {
        $stock_qty = Stock::where('item_code', $request->get('item_code'))->sum('qty');
        if($stock_qty >= $request->get('qty')) {
            TmpSale::create([
                'bill_id' => $request->get('bill_id'),
                'name' => $request->get('name'),
                'address' => $request->get('address'),
                'phone' => $request->get('phone'),
                'item_code' => $request->get('item_code'),
                'qty' => $request->get('qty'),
                'rate' => $request->get('rate'),
                'remark' => $request->get('remark')
            ]);

            return redirect()->route($this->scope . '.create');
        } else {
            return redirect()->route($this->scope . '.create')->with('message', Lang::get('response.CUSTOM_MESSAGE_ALERT', ['message' => 'Not enough stock for the given item.']));
        }


    }

    /**
     * Save data from tmp_sale table to sale_detail & sale.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function save(Request $request)
    {
        $profit = [];
        $customer_id = 0;
        $registered = 'N';
        if($request->get('payment_mode') == 'credit') {
            $customer_id = $request->get('customer_id');
            $registered = 'Y';
        }

        $tmp = TmpSale::all();

        /* Calculating Profit */
        foreach($tmp as $value) {
            $stock_qty = Stock::where('item_code', $value->item_code)
                ->orderBy('id', 'asc')
                ->first();

            if($stock_qty->qty > $value->qty) {
                $item = Purchase::where('id', $stock_qty->purchase_id)->first();
                $profit[$value->id] = ($value->rate - $item->rate) * $value->qty;
            } else {
                $stock_qty = Stock::where('item_code', $value->item_code)->orderBy('id', 'asc')->get();
                $tmp_stock_qty = $value->qty;

                $i =0;
                while($tmp_stock_qty)
                {
                    $item = Purchase::where('id', $stock_qty[$i++]->purchase_id)->first();
                    $qty = $item->qty;
                    if($tmp_stock_qty < $qty) {
                        $qty = $tmp_stock_qty;
                    }
                    $profit[$value->id] += ($value->rate - $item->rate) * $qty;

                    $tmp_stock_qty -= $qty;
                }
            }
        }

        $data = SaleDetail::create([
            'bill_id' => $tmp[0]->bill_id,
            'customer_id' => $customer_id,
            'registered' => $registered,
            'name' => $tmp[0]->name,
            'address' => $tmp[0]->address,
            'phone' => $tmp[0]->phone,
            'discount' => $request->get('discount'),
            'payment_mode' => $request->get('payment_mode')
        ]);

        foreach($tmp as $value) {
            Sale::create([
                'sale_detail_id' => $data->id,
                'item_code' => $value->item_code,
                'qty' => $value->qty,
                'rate' => $value->rate,
                'remark' => $value->remark,
                'profit' => $profit[$value->id]
            ]);

            /* Subtracting items from Stock table. */
            $stock_qty = Stock::where('item_code', $value->item_code)
                ->orderBy('id', 'asc')
                ->first();
            if($stock_qty->qty >= $value->qty) {
                Stock::where('id', $stock_qty->id)
                    ->update(['qty' => ($stock_qty->qty - $value->qty)]);
            } else {
                $stock_qty = Stock::where('item_code', $value->item_code)->orderBy('id', 'asc')->get();
                $tmp_stock_qty = $value->qty;

                $i =0;
                while($tmp_stock_qty)
                {
                    if($tmp_stock_qty >= $stock_qty[$i]->qty) {
                        Stock::where('id', $stock_qty[$i]->id)
                            ->update(['qty' => 0]);
                        $tmp_stock_qty -= $stock_qty[$i]->qty;
                    } else {
                        Stock::where('id', $stock_qty[$i]->id)
                            ->update(['qty' => ($stock_qty[$i]->qty - $tmp_stock_qty)]);
                        $tmp_stock_qty = 0;
                    }
                    $i++;
                }
            }
            Stock::where('qty', 0)->delete();
        }

        $this->clearTmpSale();

        return redirect()->route($this->scope . '.create')->with('message', Lang::get('response.CUSTOM_MESSAGE_SUCCESS', ['message' => 'Sale record saved.']));
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = $this->checkTmpSaleData($id);
        $data->delete();
        return redirect()->route($this->scope . '.create');
    }

    public function destroyAll()
    {
        $this->clearTmpSale();

        return redirect()->route($this->scope . '.create');
    }

    public function clearTmpSale()
    {
        TmpSale::truncate();
    }




    /*
     * Helper functions
     *
     * */

    public function checkTmpSaleData($id)
    {
        $this->data = TmpSale::find($id);
        if(!$this->data) {
            return redirect()->route($this->scope . '.index')->with('message', Lang::get('response.INVALID_REQUEST'))->send();
        }

        return $this->data;
    }




    /*
     * Ajax request & responses
     */

    public function findItemByItemCode($item_code)
    {
        $item_code = (int) $item_code;
        $item = Item::select('item_name')->where('item_code', $item_code)->first();
        if ($item)
            return $item->item_name;
        else
            return '';
    }

    public function findItemByItemName($item_name)
    {
        $item = Item::select('item_code')->where('item_name', $item_name)->first();
        if ($item)
            return $item->item_code;
        else
            return '';
    }

    public function paymentMode($payment_mode)
    {
        if($payment_mode == 'credit')
        {
            $customers = Customer::select('id', 'name')->orderBy('name', 'asc')->get();
            return response()->view('admin.' . $this->scope . '.payment', compact('customers'));
        }
        else
            return '';
    }
}
