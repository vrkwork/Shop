@extends('admin.layout.master')

@section('content')

    <div class="container">

        <ol class="breadcrumb">
            <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li><a href="{{ route($scope . '.index') }}">{{ ucfirst($scope) }}</a></li>
            <li class="active">Add</li>
        </ol>

        @include('admin.common.flash_message')

        <div class="col-sm-4 col-sm-offset-4">
            <div class="row text-center">
                <h4>Add New {{ ucfirst($scope) }}</h4>
            </div>

            <div class="divide30"></div>

            <div class="row">
                <form class="form-horizontal" method="POST" action="{{ route('item.store') }}">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label class="col-sm-5 control-label">Item Code:</label>

                        <div class="col-sm-4">
                            <input class="form-control" type="text" name="item_code"
                                   value="{{ old('item_code')?old('item_code'):'' }}" autofocus>
                            @if($errors->has('item_code'))
                                {{ $errors->first('item_code') }}
                            @endif
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-5 control-label">Item Name:</label>

                        <div class="col-sm-7">
                            <input class="form-control" type="text" name="item_name"
                                   value="{{ old('item_name')?old('item_name'):'' }}">
                            @if($errors->has('item_name'))
                                {{ $errors->first('item_name') }}
                            @endif
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-offset-5 col-sm-4">
                            <button class="btn btn-primary" type="submit" name="submit">ADD</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection