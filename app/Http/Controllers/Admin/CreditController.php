<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Customer\CustomerAddValidation;
use App\Http\Requests\Customer\CustomerUpdateValidation;
use App\Models\Customer;
use Lang;


class CreditController extends BaseController
{
    protected $scope = 'credit';
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

        $datas = Customer::orderBy('name', 'asc')->paginate($this->pagination_limit);
        return view('admin.' . $this->scope . '.index', compact('scope', 'user', 'datas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CustomerAddValidation $request)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CustomerUpdateValidation $request, $id)
    {
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
    }

    /*
     * Helper function
     *
     * */
    public function checkData($id)
    {
    }
}
