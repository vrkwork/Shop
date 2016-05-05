@extends('admin.layout.master')

@section('content')

    <div class="container">

        <ol class="breadcrumb">
            <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li><a href="{{ route('report.' . $scope . '.index') }}">{{ ucfirst($scope) }}</a></li>
            <li class="active">List</li>
        </ol>


        @include('admin.common.flash_message')

        <div class="col-sm-offset-2 col-sm-8">
            <table class="table table-hover table-bordered table_white">
                <thead>
                <tr>
                    <th colspan="4" class="text-center">Item -> {{ $item->item_name }} ({{ $item->item_code }})</th>
                </tr>
                <tr class="info">
                    <th class="text-center">SN</th>
                    <th class="text-center">Bill No.</th>
                    <th class="text-center">Qty</th>
                    <th class="text-center">Rate</th>
                </tr>
                </thead>
                <tbody class="text-center">
                    <?php $count = 1; ?>
                    @foreach($stock as $value)
                        <tr>
                            <td>{{ $count++ }}</td>
                            <td>{{ $value->bill_id }}</td>
                            <td>{{ $value->qty }}</td>
                            <td>{{ $value->rate }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>


@endsection