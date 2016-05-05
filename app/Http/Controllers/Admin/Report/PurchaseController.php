<?php

namespace App\Http\Controllers\Admin\Report;

use App\Http\Controllers\BaseController;
use App\Models\Purchase;
use App\Models\PurchaseDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
        $scope = $this->scope;
        $user = $this->user;
        return view('admin.report.' . $this->scope . '.index', compact('scope', 'user'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $scope = $this->scope;
        $user = $this->user;
        $purchase = [];
        $total_purchase = [];

        $sdate = $request->get('sdate');
        $edate = $request->get('edate');

        $tmp_sdate = (date('Y-m-d G:i:s', strtotime($sdate)));

        $tmp_edate = $edate . ' 23:59:59';
        $tmp_edate = (date('Y-m-d G:i:s', strtotime($tmp_edate)));

        $purchase_detail = PurchaseDetail::select('id', 'bill_id', 'name')
            ->whereBetween('created_at', [$tmp_sdate, $tmp_edate])
            ->get();

        foreach($purchase_detail as $value) {
//            $total_purchase[$value->id] = Purchase::where('purchase_detail_id', $value->id)->sum('qty');

            $tmp_total_purchase = DB::table('purchase')
                ->select(DB::raw('sum(qty*rate) AS total_p'))
                ->where('purchase_detail_id', $value->id)
                ->get();
            $total_purchase[$value->id] = $tmp_total_purchase[0]->total_p;
        }

        /*foreach($purchase_detail as $value) {
            $purchase[$value->id] = Purchase::select('item_code', 'qty', 'rate')
                ->where('purchase_detail_id', $value->id)
                ->get();
        }*/


        return view('admin.report.' . $this->scope . '.create', compact('scope', 'user', 'purchase_detail', 'total_purchase'));
    }

    public function single_report($id)
    {
        $scope = $this->scope;
        $user = $this->user;

        $purchase = Purchase::select('purchase.item_code as item_code', 'purchase.qty as qty', 'purchase.rate as rate', 'item.item_name as item_name')
            ->leftJoin('item', 'item.item_code', '=', 'purchase.item_code')
            ->where('purchase.purchase_detail_id', $id)
            ->get();

        return view('admin.report.' . $this->scope . '.single_report', compact('scope', 'user', 'purchase'));
    }


}
