<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>AdminLTE 3</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="/assets/vendor/ceemas/plugins/fontawesome-free/css/all.min.css">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="/assets/vendor/ceemas/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    @yield('vendor_style')
    <!-- Theme style -->
    <link rel="stylesheet" href="/assets/vendor/ceemas/dist/css/adminlte.min.css">
    @yield('additional_head')
</head>

<body>

    @yield('second_layout')

    <!-- jQuery -->
    <script src="/assets/vendor/ceemas/plugins/jquery/jquery.min.js"></script>
    <script src="/assets/vendor/ceemas/plugins/jquery-ui/jquery-ui.min.js"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
        $.widget.bridge('uibutton', $.ui.button)

    </script>
    <!-- Bootstrap 4 -->
    <script src="/assets/vendor/ceemas/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    @yield('vendor_script')
    <!-- AdminLTE App -->
    <script src="/assets/vendor/ceemas/dist/js/adminlte.min.js"></script>

    {{-- Delete Later --}}

    <!-- AdminLTE for demo purposes -->
    <script src="/assets/vendor/ceemas/dist/js/demo.js"></script>
    <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
    <script src="/assets/vendor/ceemas/dist/js/pages/dashboard.js"></script>
    @yield('additional_script')
</body>

</html>
