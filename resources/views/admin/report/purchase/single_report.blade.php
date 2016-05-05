@extends('admin.layout.master')

@section('content')

    <div class="container">

        <ol class="breadcrumb">
            <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li><a>Report</a></li>
            <li><a href="{{ route('report.summary.index') }}">Summary</a></li>
            <li><a>{{ ucfirst($scope) }}</a></li>
        </ol>


        <div class="divide30"></div>

        <div class="row col-sm-10 col-sm-offset-1">
            <table class="table table-hover table-bordered table_white">
                <thead>
                <tr>
                    <th>SN</th>
                    <th>Item Code</th>
                    <th>Item Name</th>
                    <th>Qty</th>
                    <th>Rate</th>
                    <th>Total</th>
                </tr>
                </thead>
                <tbody>

                <?php
                $i = 1;
                $total = 0;
                ?>
                @foreach($purchase as $value)

                    <tr>
                        <td class="text-center">{{ $i++ }}</td>
                        <td class="text-center">{{ $value->item_code }}</td>
                        <td class="text-left">{{ $value->item_name }}</td>
                        <td class="text-center">{{ $value->qty }}</td>
                        <td class="text-center">{{ $value->rate }}</td>
                        <td class="text-right">{{ $value->qty * $value->rate }}</td>
                        <?php $total += $value->qty * $value->rate; ?>
                    </tr>
                @endforeach

                <tr>
                    <td colspan="6"></td>
                </tr>
                <tr>
                    <td colspan="5" class="text-right"><strong>Total</strong></td>
                    <td class="text-right">{{ $total}}</td>
                </tr>
                </tbody>
            </table>
        </div>

    </div>

@endsection