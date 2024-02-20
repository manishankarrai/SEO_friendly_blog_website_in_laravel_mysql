<!doctype html>
<html lang="en" data-layout="horizontal" data-topbar="light" data-sidebar="light" data-sidebar-size="sm-hover"
    data-layout-mode="light" data-body-image="img-1" data-preloader="disable" data-layout-style="default"
    data-layout-width="boxed" data-layout-position="fixed">

<head>

    <meta charset="utf-8" />
    <title> myblog | Blogging Website</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ url('public/icon.png') }}">

    <!-- jsvectormap css -->
    <link href="{{ url('public/assets/libs/jsvectormap/css/jsvectormap.min.css') }}" rel="stylesheet" type="text/css" />

    <!--Swiper slider css-->
    <link href="{{ url('public/assets/libs/swiper/swiper-bundle.min.css') }}" rel="stylesheet" type="text/css" />

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
    {{-- <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" /> --}}

    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" />
    <!--datatable responsive css-->
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css" />

    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">

    <link href="{{ url('public/assets/js/select2/dist/css/select2.min.css') }}" rel="stylesheet" type="text/css" />

    <style>
        .btn-secondary {
            background-color: #000 !important;
        }

        .sidepanel {
            width: 0;
            position: fixed;
            z-index: 1111;
            height: 100%;
            top: 0;
            left: 0;
            background-color: #DD2B1C;
            overflow-x: hidden;
            transition: 0.2s;
            padding-top: 60px;
        }

        .sidepanel a {
            padding: 8px 0px 8px 60px;
            text-decoration: none;
            font-size: 15px;
            color: #FFFFFF;
            display: block;
            transition: 1s;
        }

        .sidepanel a:hover {
            color: #f1f1f1;
        }

        .sidepanel .closebtn {
            position: absolute;
            top: 0;
            right: 25px;
            font-size: 36px;
        }

        .openbtn {
            font-size: 20px;
            cursor: pointer;
            background-color: #111;
            color: white;
            padding: 10px 15px;
            border: none;
        }

        .openbtn:hover {
            background-color: #444;
        }
    </style>


</head>
