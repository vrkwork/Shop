<!DOCTYPE HTML>
<html>
<head>
    <title>Admin Login</title>

    <link rel="stylesheet" type="text/css" href="{{ asset('assets/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/style-login.css') }}">

</head>
<body class="login_body">

<div class="login_wrapper_main">

    <div class="container">
        <form class="login_wrapper" role="form" action="{{ url('auth/login') }}" method="post">
            {{ csrf_field() }}

            <div class="input-group userpass">
                <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
                <input type="text" class="form-control login_input" name="username" placeholder="Username" required
                       autofocus>
            </div>

            <div class="input-group userpass">
                <span class="input-group-addon"><span class="glyphicon glyphicon-asterisk"></span></span>
                <input type="password" class="form-control login_input" name="password" placeholder="Password" required>
            </div>

            <div class="checkbox">
                <label>
                    <input type="checkbox" name="remember">Remember me
                </label>
            </div>

            <button class="btn btn-lg btn-primary btn-block" type="submit" name="submit">Sign In</button>
        </form>
    </div>
    <!-- container Ends -->

</div>
<!-- wrapper_main Ends -->

<script src="{{ asset('assets/js/jquery.min.js') }}"></script>
<script src="{{ asset('assets/bootstrap/js/bootstrap.min.js') }}"></script>
</body>
</html>