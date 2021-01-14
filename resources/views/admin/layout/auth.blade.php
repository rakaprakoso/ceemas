@extends('ceemas::admin.layout.main')
@section('second_layout')

<body class="hold-transition login-page">

<div class="login-box">
    <!-- /.login-logo -->
    <div class="card card-outline card-primary">
        <div class="card-header text-center">
            <a href="{{route('home')}}" class="h1"><b>Ceemas</b></a>
        </div>
        <div class="card-body">




            @yield('content')

            <p class="mb-1">
                <a href="forgot-password.html">I forgot my password</a>
            </p>
            <p class="mb-0">
                <a href="register.html" class="text-center">Register a new membership</a>
            </p>
        </div>

        <!-- /.card-body -->
    </div>
    <!-- /.card -->
</div>

@endsection
