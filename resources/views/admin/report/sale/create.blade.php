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
                    <th>Bill No</th>
                    <th>Supplier Name</th>
                    <th>Total</th>
                </tr>
                </thead>
                <tbody>

                @foreach($sale_detail as $value)
                    <tr onclick="redirect_link('{{ $value->bill_id }}')">
                        <td class="text-center">{{ $value->bill_id }}</td>
                        <td class="text-left">{{ $value->name }}</td>
                        <td class="text-right">{{ $total_sale[$value->id] }}</td>
                    </tr>
                @endforeach

                <tr>
                    <td colspan="3"></td>
                </tr>
                <tr>
                    <td colspan="2" class="text-right"><strong>Total</strong></td>
                    <td class="text-right">{{ collect($total_sale)->sum() }}</td>
                </tr>
                </tbody>
            </table>
        </div>

    </div>

    <script>
        function redirect_link(bill_id)
        {
            var url = '{{ url('report/sale') }}' + '/' + bill_id;
            location.href = url;
        }
    </script>

@endsection