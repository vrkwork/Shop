@extends('admin.layout.master')

@section('content')

    <div class="container">

        <ol class="breadcrumb">
            <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li><a href="{{ route('report.' . $scope . '.index') }}">{{ ucfirst($scope) }}</a></li>
            <li class="active">Create</li>
        </ol>


        <div class="col-sm-8 col-sm-offset-2">
            <div class="row text-center">
                <h3>Gross Profit Report From {{ $sdate }} To {{ $edate }}</h3>
            </div>

            <div class="divide30"></div>

            <div class="row">
                <table class="table table-hover table-bordered table_white">
                    <theah>
                        <tr>
                            <th class="col-sm-2 text-center">SN</th>
                            <th class="col-sm-4 text-center">Date</th>
                            <th class="col-sm-6 text-center">Gross Profit</th>
                        </tr>
                    </theah>
                    <tbody>
                    <?php $count = 1; ?>
                    @foreach($profit as $value)
                        <tr>
                            <td class="text-center">{{ $count++ }}</td>
                            <td class="text-center">{{ $value['date'] }}</td>
                            <td class="text-center">{{ $value['profit'] }}</td>
                        </tr>
                    @endforeach
                    <tr>
                        <td colspan="3"></td>
                    </tr>
                    <tr>
                        <td colspan="2" class="text-right"><strong>Total</strong></td>
                        <td></td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection