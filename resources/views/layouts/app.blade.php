<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="light" data-sidebar-size="lg" data-sidebar-image="none" data-layout-mode="light" data-body-image="img-1" data-preloader="disable">

<head>

    <meta charset="utf-8" />
    <title>Sign In | myblog </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <!-- App favicon -->
    <link rel="shortcut icon" href="{{ url('public/icon.png')}}">

    <!-- Layout config Js -->
    <script src="{{ url('public/assets/js/layout.js') }}"></script>
    <!-- Bootstrap Css -->
    <link href="{{ url('public/assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="{{ url('public/assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="{{ url('public/assets/css/app.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- custom Css-->
    <link href="{{ url('public/assets/css/custom.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ url('public/assets/css/style.css') }}" rel="stylesheet" type="text/css" />
    <style>

    </style>

</head>

<body >

            @yield('content')
        <!-- footer -->
<footer>
    <div class="container" >
        <div class="row">
            <div class="col-lg-12">
                <div class="text-center">
                    <p class="mb-0">Version v1.10 &nbsp; <script>
                        document.write(new Date().getFullYear())
                    </script> </p>

                </div>
            </div>
        </div>
    </div>
</footer>
<!-- end Footer -->
</div>
<!-- end auth-page-wrapper -->

<!-- JAVASCRIPT -->
<script src="{{ url('public/assets/libs/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{ url('public/assets/libs/simplebar/simplebar.min.js')}}"></script>
<script src="{{ url('public/assets/libs/node-waves/waves.min.js')}}"></script>
<script src="{{ url('public/assets/libs/feather-icons/feather.min.js')}}"></script>
<script src="{{ url('public/assets/js/pages/plugins/lord-icon-2.1.0.js')}}"></script>
<script src="{{ url('public/assets/js/plugins.js')}}"></script>

<!-- password-addon init -->
<script src="{{ url('public/assets/js/pages/password-addon.init.js')}}"></script>
</body>

</html>
