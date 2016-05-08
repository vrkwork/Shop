@extends('admin.layout.master')

@section('content')

    <div class="container">

        <ol class="breadcrumb">
            <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li><a>Report</a></li>
            <li class="active">Search {{ ucfirst($scope) }} Bill</li>
        </ol>


        @include('admin.common.flash_message')

        <div class="col-sm-4 col-sm-offset-4">
            <div class="row text-center">
                <h4>Search By {{ ucfirst($scope) }} Bill No.</h4>
            </div>

            <div class="divide30"></div>

            <div class="row">
                <label class="col-sm-4 text-right">Bill No.:</label>

                <div class="col-sm-5">
                    <input class="form-control" type="text" id="bill_id">
                </div>
            </div>

            <div class="divide15"></div>

            <div class="row">
                <div class="col-sm-offset-4 col-sm-4">
                    <button class="btn btn-primary" id="submit_button">Submit</button>
                </div>
            </div>
        </div>

    </div>

@endsection

@section('script')
    @parent
    <script>
        $(document).ready(function () {
            $('#submit_button').click(function () {
                var url = '/report/sale/';

                url += $('#bill_id').val();

                location.href = url;
            });
        });
    </script>
@endsection