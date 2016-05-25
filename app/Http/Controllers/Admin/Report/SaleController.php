<?php

namespace App\Http\Controllers\Admin\Report;

use App\Http\Controllers\BaseController;
use App\Models\Sale;
use App\Models\SaleDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
        $total_sale = [];

        $sdate = $request->get('sdate');
        $edate = $request->get('edate');

        $tmp_sdate = (date('Y-m-d G:i:s', strtotime($sdate)));

        $tmp_edate = $edate . ' 23:59:59';
        $tmp_edate = (date('Y-m-d G:i:s', strtotime($tmp_edate)));

        $sale_detail = SaleDetail::select('id', 'bill_id', 'name')
            ->whereBetween('created_at', [$tmp_sdate, $tmp_edate])
            ->get();

        foreach($sale_detail as $value) {
            $tmp_total_sale = DB::table('sale')
                ->select(DB::raw('sum(qty*rate) AS total_p'))
                ->where('sale_detail_id', $value->id)
                ->get();
            $total_sale[$value->id] = $tmp_total_sale[0]->total_p;
        }


        return view('admin.report.' . $this->scope . '.create', compact('scope', 'user', 'sale_detail', 'total_sale', 'sdate', 'edate'));
    }

    public function single_report($bill_id)
    {
        $scope = $this->scope;
        $user = $this->user;

        $sale_detail = SaleDetail::where('bill_id', $bill_id)->first();

        if($sale_detail) {
            $sale = Sale::select('sale.item_code as item_code', 'sale.qty as qty', 'sale.rate as rate', 'item.item_name as item_name')
                ->leftJoin('item', 'item.item_code', '=', 'sale.item_code')
                ->where('sale.sale_detail_id', $sale_detail->id)
                ->get();
            return view('admin.report.' . $this->scope . '.single_report', compact('scope', 'user', 'sale', 'sale_detail'));
        } else {
            abort(404);
        }



    }

    public function search_bill_id()
    {
        $scope = $this->scope;
        $user = $this->user;

        return view('admin.report.' . $this->scope . '.bill_id', compact('scope', 'user'));
    }



}
