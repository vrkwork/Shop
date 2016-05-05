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
                <tr class="info">
                    <th class="text-center">SN</th>
                    <th class="text-center">Item Code</th>
                    <th class="text-center">Item Name</th>
                    <th class="text-center">Qty</th>
                </tr>
                </thead>
                <tbody class="text-center">
                <?php $count = 1; ?>
                @foreach($item as $value)
                    <tr onclick="redirect_link('{{ $value->item_code }}')">
                        <td>{{ $count++ }}</td>
                        <td>{{ $value->item_code }}</td>
                        <td>{{ $value->item_name }}</td>
                        <td>{{ $stock[$value->id ]}}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

    </div>

    <script>
        function redirect_link(item_code)
        {
            var url = '{{ url('report/stock') }}' + '/' + item_code;
            location.href = url;
        }
    </script>


@endsection