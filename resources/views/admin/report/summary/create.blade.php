@extends('admin.layout.master')

@section('content')

    <div class="container">

        <ol class="breadcrumb">
            <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li><a href="{{ route('report.' . $scope . '.index') }}">{{ ucfirst($scope) }}</a></li>
            <li class="active">Create</li>
        </ol>


        <div class="col-sm-4 col-sm-offset-4">
            <div class="row text-center">
                <h4>Add New {{ ucfirst($scope) }}</h4>
            </div>

            <div class="divide30"></div>

            <div class="row">
                <table class="table table-hover table-bordered table_white">
                    <tbody>
                    <tr>
                        <td><a href="{{ route('report.purchase.create')."?sdate=".$sdate."&edate=".$edate }}"><strong>Purchase</strong></a></td>
                        <td>{{ $total_purchase }}</td>
                    </tr>
                    <tr>
                        <td><a href="{{ route('report.sale.index')."?sdate=".$sdate."&edate=".$edate }}"><strong>Sale</strong></a></td>
                        <td>{{ $total_sale }}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection