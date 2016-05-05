<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Purchase\PurchaseAddValidation;
use App\Models\Item;
use App\Models\Purchase;
use App\Models\PurchaseDetail;
use App\Models\Stock;
use App\Models\Supplier;
use App\Models\TmpPurchase;
use Illuminate\Http\Request;
use Lang;


class PurchaseController extends BaseController
{
    protected $scope = 'purchase';
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
        $bill_id = PurchaseDetail::select('bill_id')->orderBy('bill_id', 'desc')->first();
        $items = TmpPurchase::select('item.item_name as item_name', 'tmp_purchase.id', 'tmp_purchase.bill_id', 'tmp_purchase.name', 'tmp_purchase.address', 'tmp_purchase.phone', 'tmp_purchase.item_code', 'tmp_purchase.qty', 'tmp_purchase.rate', 'tmp_purchase.remark')
            ->leftJoin('item', 'item.item_code', '=', 'tmp_purchase.item_code')
            ->orderBy('tmp_purchase.id', 'asc')
            ->get();

        if ($bill_id) {
            $bill_id = ++$bill_id->bill_id;
        } else {
            $bill_id = 1;
        }
        return view('admin.' . $this->scope . '.add', compact('scope', 'user', 'bill_id', 'items'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PurchaseAddValidation $request)
    {
        TmpPurchase::create([
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
    }

    /**
     * Save data from tmp_purchase table to purchase_detail & purchase.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function save(Request $request)
    {
        $supplier_id = 0;
        $registered = 'N';
        if($request->get('payment_mode') == 'credit') {
            $supplier_id = $request->get('supplier_id');
            $registered = 'Y';
        }

        $tmp = TmpPurchase::all();

        $data = PurchaseDetail::create([
            'bill_id' => $tmp[0]->bill_id,
            'supplier_id' => $supplier_id,
            'registered' => $registered,
            'name' => $tmp[0]->name,
            'address' => $tmp[0]->address,
            'phone' => $tmp[0]->phone,
            'payment_mode' => $request->get('payment_mode')
        ]);

        foreach($tmp as $value) {
            $purchaseData = Purchase::create([
                'purchase_detail_id' => $data->id,
                'item_code' => $value->item_code,
                'qty' => $value->qty,
                'rate' => $value->rate,
                'remark' => $value->remark
            ]);

            Stock::create([
                'purchase_id' => $purchaseData->id,
                'item_code' => $value->item_code,
                'qty' => $value->qty
            ]);
        }

        $this->clearTmpPurchase();

        return redirect()->route($this->scope . '.create')->with('message', Lang::get('response.CUSTOM_MESSAGE_SUCCESS', ['message' => 'Purchase record saved.']));
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = $this->checkTmpPurchaseData($id);
        $data->delete();
        return redirect()->route($this->scope . '.create');
    }

    public function destroyAll()
    {
        $this->clearTmpPurchase();

        return redirect()->route($this->scope . '.create');
    }

    public function clearTmpPurchase()
    {
        TmpPurchase::truncate();
    }




    /*
     * Helper functions
     *
     * */

    public function checkTmpPurchaseData($id)
    {
        $this->data = TmpPurchase::find($id);
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
            $suppliers = Supplier::select('id', 'name')->orderBy('name', 'asc')->get();
            return response()->view('admin.' . $this->scope . '.payment', compact('suppliers'));
        }
        else
            return '';
    }
}
