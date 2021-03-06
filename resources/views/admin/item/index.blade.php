@extends('admin.layout.master')

@section('content')

    <div class="container">

        <ol class="breadcrumb">
            <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li><a href="{{ route($scope . '.index') }}">{{ ucfirst($scope) }}</a></li>
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
                    <th class="text-center"></th>
                </tr>
                </thead>
                <tbody class="text-center">
                @if($datas->count() > 0)
                    <?php
                    $count = 1;
                    ?>
                    @foreach($datas as $data)
                        <tr>
                            <td>{{ $count++ }}</td>
                            <td>{{ $data->item_code }}</td>
                            <td>{{ $data->item_name }}</td>
                            <td>
                                <a href="{{{ route($scope.'.edit', ['id' => $data->id]) }}}"
                                   class="btn btn-xs btn-info">
                                    <i class="glyphicon glyphicon-edit"></i>
                                </a>
                                <a href="{{{ route($scope.'.destroy', ['id' => $data->id]) }}}"
                                   class="btn btn-xs btn-danger"
                                   onclick="return confirm('Are you sure?');">
                                    <i class="glyphicon glyphicon-trash"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach

                    <tr>
                        <td colspan="4">
                            {!! $datas->render() !!}
                        </td>
                    </tr>
                @else
                    <tr>
                        <td colspan="4">No Data Found.</td>
                    </tr>
                @endif
                </tbody>
            </table>
        </div>

    </div>


@endsection