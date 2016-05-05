@extends('admin.layout.master')

@section('content')

    <div class="container">

        <ol class="breadcrumb">
            <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li><a href="{{ route($scope . '.index') }}">{{ ucfirst($scope) }}</a></li>
            <li class="active">Add</li>
        </ol>


        <div class="col-sm-12">

            @include('admin.common.flash_message')

            <div class="row text-center">
                <h4>Sale Entry</h4>
            </div>

            <form class="form-inline" method="POST" action="{{ route('sale.store') }}">
                {{ csrf_field() }}
                <input type="hidden" name="bill_id" value="{{ $bill_id }}">

                <div class="divide15"></div>

                <div class="row">
                    <div class="col-sm-2 text-left">
                        <label>Sale ID: {{ $bill_id }}</label>
                    </div>
                    <div class="col-sm-offset-8 col-sm-2 text-right">
                        <label>Date: </label>
                        {{ date('j M Y') }}
                    </div>
                </div>

                <div class="row">
                    <div class="form-group">
                        <label>Customer Name:</label>
                        <input class="form-control" name="name" type="text" size="25"
                               value="{{ (count($items)>0)?$items[0]->name:'' }}">
                    </div>
                    <div class="form-group">
                        <label>Customer Address:</label>
                        <input class="form-control" name="address" type="text" size="25"
                               value="{{ (count($items)>0)?$items[0]->address:'' }}">
                    </div>
                    <div class="form-group">
                        <label>Phone:</label>
                        <input class="form-control" name="phone" type="text"
                               value="{{ (count($items)>0)?$items[0]->phone:'' }}">
                    </div>
                </div>

                <hr>

                @include('admin.common.error_message')

                <div class="row">
                    <div class="form-group">
                        <label>Goods ID:</label>
                        <input class="form-control" name="item_code" type="text" size="5" id="item_code" autofocus>
                    </div>
                    <div class="form-group">
                        <label>Goods Name:</label>
                        <input class="form-control" name="item_name" type="text" size="25" id="item_name">
                    </div>
                    <div class="form-group">
                        <label>Qty:</label>
                        <input class="form-control" name="qty" type="text" size="1">
                    </div>
                    <div class="form-group">
                        <label>Rate:</label>
                        <input class="form-control" name="rate" type="text" size="4">
                    </div>
                    <div class="form-group">
                        <label>Remarks:</label>
                        <input class="form-control" name="remark" type="text">
                    </div>
                    <button class="btn btn-primary" type="submit" name="next">NEXT</button>
                </div>
            </form>

            <hr>

            <div class="row">
                <table class="table table-hover table-bordered table_white">
                    <thead>
                    <tr>
                        <th class="col-sm-1 text-center">SN</th>
                        <th class="col-sm-1 text-center">Goods ID</th>
                        <th class="col-sm-4 text-center">Goods Name</th>
                        <th class="col-sm-1 text-center">Qty</th>
                        <th class="col-sm-1 text-center">Rate</th>
                        <th class="col-sm-1 text-center">Total</th>
                        <th class="col-sm-2 text-center">Remarks</th>
                        <th class="col-sm-1 text-center">Delete</th>
                    </tr>
                    </thead>
                    <tbody class="text-center">

                    <?php $sn = 1; ?>
                    @if($items->count() > 0)
                        @foreach($items as $item)
                            <tr>
                                <td>{{ $sn++ }}</td>
                                <td>{{ $item->item_code }}</td>
                                <td>{{ $item->item_name }}</td>
                                <td>{{ $item->qty }}</td>
                                <td>{{ $item->rate }}</td>
                                <td>{{ $item->qty * $item->rate }}</td>
                                <td>{{ $item->remark }}</td>
                                <td>
                                    <a href="{{ route($scope . '.destroy', ['id' => $item->id]) }}">
                                        <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="8">No Products Selected</td>
                        </tr>
                    @endif
                    </tbody>
                </table>
            </div>

            <div class="divide15"></div>

            <form method="POST" action="{{ route('sale.save') }}">
                {{ csrf_field() }}
                <div class="row col-sm-offset-4 col-sm-4">
                    <table class="table table-striped table-bordered table_white">
                        <tbody>
                        <tr>
                            <?php
                            $sub_total = 0;
                            foreach ($items as $item) {
                                $sub_total += $item->qty * $item->rate;
                            }
                            ?>
                            <td class="col-sm-8">Sub Total</td>
                            <td class="text-right" id="sub_total">{{ $sub_total }}</td>
                        </tr>

                        <tr>
                            <td class="col-sm-8">Discount</td>
                            <td class="text-right"><input type="text" name="discount" id="discount" size="3"></td>
                        </tr>

                        <tr>
                            <td class="col-sm-8">Total Amount</td>
                            <td class="text-right" id="total"></td>
                        </tr>

                        <tr class="danger">
                            <td class="col-sm-8">Payment Mode</td>
                            <td class="text-right">
                                <select class="form-control" name="payment_mode" id="payment_mode">
                                    <option value="cash">Cash</option>
                                    <option value="credit">Credit</option>
                                </select>
                            </td>
                        </tr>
                        <tr id="select_customer"></tr>
                        </tbody>
                    </table>
                </div>

                <div class="clear"></div>
                <div class="divide50"></div>

                <div class="row">

                    <button class="btn btn-primary" name="add">Save</button>
                    <button class="btn btn-warning" name="print">Print</button>

                </div>
            </form>

            <div class="divide15"></div>

            <div class="row">
                <form method="get" action="{{ route($scope . '.destroyAll') }}">
                    {{ csrf_field() }}
                    <button class="btn btn-danger" type="submit" name="clear">Cancel</button>
                </form>
            </div>

        </div>
    </div>

@endsection

@section('script')
    @parent

    <script>
        $(document).ready(function () {
            $('#item_code').change(function () {
                var item_code = $('#item_code').val();

                if (item_code != '') {
                    $.ajax({
                        type: 'GET',
                        url: '{{ url('sale/find-item-by-item-code') }}' + '/' + item_code,
                        error: function () {
                            console.log('error......');
                        },
                        success: function (data) {
                            $('#item_name').val(data);
                        }
                    });
                }
            });

            $('#item_name').change(function () {
                var item_name = $('#item_name').val();

                if (item_name != '') {
                    $.ajax({
                        type: 'GET',
                        url: '{{ url('sale/find-item-by-item-name') }}' + '/' + item_name,
                        error: function () {
                            console.log('error......');
                        },
                        success: function (data) {
                            $('#item_code').val(data);
                        }
                    });
                }
            });

            $('#discount').change(function () {
                var sub_total = '{{ $sub_total }}';
                var discount = $('#discount').val();

                $('#total').html(sub_total - discount);
            });

            $('#payment_mode').change(function () {
                var payment_mode = $('#payment_mode').val();

                $.ajax({
                    type: 'GET',
                    url: '{{ url('sale/payment-mode') }}' + '/' + payment_mode,
                    error: function () {
                        console.log('error in payment mode');
                    },
                    success: function (data) {
                        $('#select_customer').html(data);
                    }
                });
            });
        });

    </script>
@endsection