@extends('admin.layout.master')

@section('content')

    <div class="container">

        <ol class="breadcrumb">
            <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li><a href="{{ route($scope . '.index') }}">{{ ucfirst($scope) }}</a></li>
            <li class="active">Edit</li>
        </ol>


        <div class="col-sm-8 col-sm-offset-2">
            <div class="row text-center">
                <h4>Edit {{ ucfirst($scope) }}</h4>
            </div>

            <div class="divide30"></div>

            <div class="row">
                <form class="form-horizontal" method="POST" action="{{ route($scope . '.update', ['id' => $data->id]) }}">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Name:</label>

                        <div class="col-sm-4">
                            <input class="form-control" type="text" name="name"
                                   value="{{ old('name')?old('name'):$data->name }}"
                                   placeholder="Customer Name"
                                   autofocus>
                            @if($errors->has('name'))
                                {{ $errors->first('name') }}
                            @endif
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label">Address:</label>

                        <div class="col-sm-5">
                            <input class="form-control" type="text" name="address"
                                   value="{{ old('address')?old('address'):$data->address }}"
                                   placeholder="Address">
                            @if($errors->has('address'))
                                {{ $errors->first('address') }}
                            @endif
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label">Phone:</label>

                        <div class="col-sm-3">
                            <input class="form-control" type="text" name="phone"
                                   value="{{ old('phone')?old('phone'):$data->phone }}"
                                   placeholder="Phone Number">
                            @if($errors->has('phone'))
                                {{ $errors->first('phone') }}
                            @endif
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label">Mobile:</label>

                        <div class="col-sm-3">
                            <input class="form-control" type="text" name="mobile"
                                   value="{{ old('mobile')?old('mobile'):$data->mobile }}"
                                   placeholder="Mobile Number">
                            @if($errors->has('mobile'))
                                {{ $errors->first('mobile') }}
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