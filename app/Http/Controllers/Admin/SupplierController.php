<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Supplier\SupplierAddValidation;
use App\Http\Requests\Supplier\SupplierUpdateValidation;
use App\Models\Supplier;
use Lang;


class SupplierController extends BaseController
{
    protected $scope = 'supplier';
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

        $datas = Supplier::orderBy('name', 'asc')->paginate($this->pagination_limit);
        return view('admin.' . $this->scope . '.index', compact('scope', 'user', 'datas'));
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
        return view('admin.' . $this->scope . '.add', compact('scope', 'user'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SupplierAddValidation $request)
    {
        if (Supplier::where('mobile', $request->get('mobile'))->count() > 0) {
            return redirect()->route($this->scope . '.index')->with('message', Lang::get('response.CUSTOM_MESSAGE_SUCCESS', ['message' => 'Duplicate mobile number.']));
        }

        Supplier::create([
            'name' => $request->get('name'),
            'address' => $request->get('address'),
            'phone' => $request->get('phone'),
            'mobile' => $request->get('mobile')
        ]);

        return redirect()->route($this->scope . '.index')->with('message', Lang::get('response.CUSTOM_MESSAGE_SUCCESS', ['message' => 'New ' . $this->scope . ' has been added successfully.']));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = $this->checkData($id);
        $scope = $this->scope;
        $user = $this->user;
        return view('admin.' . $this->scope . '.edit', compact('scope', 'user', 'data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(SupplierUpdateValidation $request, $id)
    {
        $data = $this->checkData($id);
        if (Supplier::where('id', '!=', $id)->where('mobile', $request->get('mobile'))->count() > 0) {
            return redirect()->route($this->scope . '.index')->with('message', Lang::get('response.CUSTOM_MESSAGE_SUCCESS', ['message' => 'Duplicate supplier with same mobile number.']));
        }

        $data->name = $request->get('name');
        $data->address = $request->get('address');
        $data->phone = $request->get('phone');
        $data->mobile = $request->get('mobile');
        $data->save();

        return redirect()->route($this->scope . '.index')->with('message', Lang::get('response.CUSTOM_MESSAGE_SUCCESS', ['message' => ucfirst($this->scope) . ' has been updated successfully.']));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = $this->checkData($id);
        $data->delete();
        return redirect()->route($this->scope . '.index')->with('message', Lang::get('response.CUSTOM_MESSAGE_SUCCESS', ['message' => ucfirst($this->scope) . ' has been deleted successfully.']));
    }

    /*
     * Helper function
     *
     * */
    public function checkData($id)
    {
        $this->data = Supplier::find($id);
        if(!$this->data) {
            return redirect()->route($this->scope . '.index')->with('message', Lang::get('response.INVALID_REQUEST'))->send();
        }

        return $this->data;
    }
}
