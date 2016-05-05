<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Item\ItemAddValidation;
use App\Http\Requests\Item\ItemUpdateValidation;
use App\Models\Item;
use Lang;


class ItemController extends BaseController
{
    protected $scope = 'item';
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

        $datas = Item::orderBy('item_code', 'asc')->paginate($this->pagination_limit);
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
    public function store(ItemAddValidation $request)
    {
        if (Item::where('item_code', $request->get('item_code'))->count() > 0) {
            return redirect()->route($this->scope . '.index')->with('message', Lang::get('response.CUSTOM_MESSAGE_SUCCESS', ['message' => 'Duplicate Item Code.']));
        }

        Item::create([
            'item_code' => $request->get('item_code'),
            'item_name' => $request->get('item_name')
        ]);

        return redirect()->route($this->scope . '.create')->with('message', Lang::get('response.CUSTOM_MESSAGE_SUCCESS', ['message' => 'New ' . $this->scope . ' has been added successfully.']));
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
    public function update(ItemUpdateValidation $request, $id)
    {
        $data = $this->checkData($id);
        if (Item::where('id', '!=', $id)->where('item_code', $request->get('item_code'))->count() > 0) {
            return redirect()->route($this->scope . '.index')->with('message', Lang::get('response.CUSTOM_MESSAGE_SUCCESS', ['message' => 'Duplicate Item Code.']));
        }

        $data->item_code = $request->get('item_code');
        $data->item_name = $request->get('item_name');
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
        $this->data = Item::find($id);
        if(!$this->data) {
            return redirect()->route($this->scope . '.index')->with('message', Lang::get('response.INVALID_REQUEST'))->send();
        }

        return $this->data;
    }
}
