@extends('admin.layout.master')

@section('style')
    @parent
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/js/jquery-ui/jquery-ui.min.css') }}">
@endsection

@section('content')

    <div class="container">

        <ol class="breadcrumb">
            <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li><a href="{{ route('report.' . $scope . '.index') }}">{{ ucfirst($scope) }}</a></li>
            <li class="active">Report</li>
        </ol>

        <div class="col-sm-4 col-sm-offset-4">
            <div class="row text-center">
                <h4>{{ ucfirst($scope) }}</h4>
            </div>

            <div class="divide30"></div>

            <div class="row">
                <label class="col-sm-4 text-right">From:</label>

                <div class="col-sm-5">
                    <input class="form-control" type="text" id="datepicker1"
                           value="{{ date("m/d/Y") }}">
                    @if($errors->has('sdate'))
                        {{ $errors->first('sdate') }}
                    @endif
                </div>
            </div>

            <div class="divide15"></div>

            <div class="row">
                <label class="col-sm-4 text-right">To:</label>

                <div class="col-sm-5">
                    <input class="form-control" type="text" id="datepicker2"
                           value="{{ date("m/d/Y") }}">
                    @if($errors->has('edate'))
                        {{ $errors->first('edate') }}
                    @endif
                </div>
            </div>

            <div class="divide15"></div>

            <div class="row">
                <div class="col-sm-offset-4 col-sm-4">
                    <button class="btn btn-primary" id="summary_button">Submit</button>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('script')
    @parent

    <script type="text/javascript" src="{{ asset('assets/js/jquery-ui/jquery-ui.min.js') }}"></script>

    <script>
        $(function () {
            $("#datepicker1").datepicker();
        });

        $(function () {
            $("#datepicker2").datepicker();
        });
    </script>

    <script>
        $(document).ready(function () {
            $('#summary_button').click(function () {
                var url = '{{ route('report.' . $scope . '.create') }}';

                var sdate = $('#datepicker1').val();
                var edate = $('#datepicker2').val();

                var flag = false;

                if (sdate != '') {
                    url += '?sdate=' + sdate;
                    flag = true;
                }

                if (edate != '') {
                    if (flag) {
                        url += '&edate=' + edate;
                    } else {
                        url += '?edate=' + edate;
                    }
                }

                location.href = url;
            });
        });
    </script>
@endsection