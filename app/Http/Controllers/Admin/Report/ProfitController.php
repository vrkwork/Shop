<?php

namespace App\Http\Controllers\Admin\Report;

use App\Http\Controllers\BaseController;
use App\Models\Sale;
use App\Models\SaleDetail;
use Faker\Provider\cs_CZ\DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Lang;

class ProfitController extends BaseController
{
    protected $scope = 'profit';
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
        $profit = [];

        $sdate = $request->get('sdate');
        $edate = $request->get('edate');

        $begin = new \DateTime( $sdate );
        $end = new \DateTime( $edate );

        $end = $end->modify( '+1 day' );

        $interval = new \DateInterval('P1D');
        $daterange = new \DatePeriod($begin, $interval ,$end);

        $count = 0;
        foreach($daterange as $date){
            $profit[$count]['profit'] = Sale::whereBetween('created_at', [$date->format("Y-m-d G:i:s"), $date->format("Y-m-d") . ' 23:59:59'])->sum('profit');
            $discount = SaleDetail::whereBetween('created_at', [$date->format("Y-m-d G:i:s"), $date->format("Y-m-d") . ' 23:59:59'])->sum('discount');
            $profit[$count]['profit'] -= $discount;
            $profit[$count]['date'] = $date->format("Y-m-d");
            $count++;
        }

        return view('admin.report.' . $this->scope . '.create', compact('scope', 'user', 'profit', 'sdate', 'edate'));
    }
}
