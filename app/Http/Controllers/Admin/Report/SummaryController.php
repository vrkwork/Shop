<?php

namespace App\Http\Controllers\Admin\Report;

use App\Http\Controllers\BaseController;
use App\Models\Purchase;
use App\Models\Sale;
use Illuminate\Http\Request;
use Lang;


class SummaryController extends BaseController
{
    protected $scope = 'summary';
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

        $sdate = $request->get('sdate');
        $edate = $request->get('edate');

        $tmp_sdate = (date('Y-m-d G:i:s', strtotime($sdate)));

        $tmp_edate = $edate . ' 23:59:59';
        $tmp_edate = (date('Y-m-d G:i:s', strtotime($tmp_edate)));

        $purchases = Purchase::select('qty', 'rate')->whereBetween('created_at', [$tmp_sdate, $tmp_edate])->get();
        $total_purchase = 0;
        foreach($purchases as $purchase) {
            $total_purchase += $purchase->qty * $purchase->rate;
        }

        $sales = Sale::select('qty', 'rate')->whereBetween('created_at', [$tmp_sdate, $tmp_edate])->get();
        $total_sale = 0;
        foreach($sales as $sale) {
            $total_sale += $sale->qty * $sale->rate;
        }

        return view('admin.report.' . $this->scope . '.create', compact('scope', 'user', 'total_purchase', 'total_sale', 'sdate', 'edate'));
    }


}
