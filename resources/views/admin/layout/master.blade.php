<!DOCTYPE html>
<html lang="en">
<head>
    <title>{{ ucfirst($scope) }}</title>
    @section('style')
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/bootstrap/css/bootstrap.min.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/style.css') }}">
    @endsection

    @yield('style')
</head>
<body class="body_blue_2">

<div class="navbar navbar-inverse navbar-static-top body_blue_1" role="navigation">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">Hi, {{ $user->username }}</a>
        </div>
        <div class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
                <li><a href="{{ route('dashboard')  }}">Dashboard</a></li>
                <li class="dropdown">
                    <a href="" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                       aria-expanded="false">New <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="{{ route('item.create') }}">New Item Entry</a></li>
                        <li><a href="{{ route('supplier.create') }}">New Supplier Entry</a></li>
                        <li><a href="{{ route('customer.create') }}">New Customer Entry</a></li>
                        <li><a href="">Create New User</a></li>
                        <li><a href="">Manage User</a></li>
                        <li><a href="">Other</a></li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                       aria-expanded="false">List <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="{{ route('item.index') }}">Item List</a></li>
                        <li><a href="{{ route('supplier.index') }}">Supplier List</a></li>
                        <li><a href="{{ route('customer.index') }}">Customer List</a></li>
                    </ul>
                </li>
                <li><a href="{{ route('purchase.create') }}">Purchase</a></li>
                <li><a href="{{ route('sale.create') }}">Sales</a></li>
                <li class="dropdown">
                    <a href="" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                       aria-expanded="false">Credit Payment <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="">Customer Credit Payment</a></li>
                        <li><a href="">Supplier Credit Payment</a></li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                       aria-expanded="false">Report <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="{{ route('report.summary.index') }}">Report Summary</a></li>
                        <li><a href="{{ route('report.stock.index') }}">Stock Report</a></li>
                        <li><a href="{{ route('report.sale.search_bill_id') }}">Sales Bill No.</a></li>
                        <li><a href="{{ route('report.purchase.search_bill_id') }}">Purchase Bill No.</a></li>
                        <li><a href="{{ route('report.profit.index') }}">Profit / Loss</a></li>
                        <li><a href="">Cash / Credit</a></li>
                    </ul>
                </li>

                <li><a href="">About Software</a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li><a href="{{ url('auth/logout') }}">Logout</a></li>
            </ul>
        </div>
        <!--/.nav-collapse -->
    </div>
</div>

@yield('content')

<div class="footer">
    <div class="container">
        <p class="text-muted">Place sticky footer content here.</p>
    </div>
</div>

@section('script')
    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/bootstrap/js/bootstrap.min.js') }}"></script>
@endsection

@yield('script')

</body>
</html>