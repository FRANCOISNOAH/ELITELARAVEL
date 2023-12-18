@php
    use Illuminate\Support\Str;
    $r = \Route::current()->getAction();
    $route = (isset($r['as'])) ? $r['as'] : '';
@endphp

    <!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}"/>

    <title>Bloo | @yield('title')</title>

    <!-- Google Fonts : Baloo 2, Roboto -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Baloo+2:wght@400;500;700&family=Rubik:wght@300&display=swap"
          rel="stylesheet">

    <!-- Font Awesome Icons -->
    <!-- <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp"
    crossorigin="anonymous"> -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"
          integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>

    <!-- Tempusdominus Style 4 -->
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.39.0/css/tempusdominus-bootstrap-4.min.css"
          integrity="sha512-3JRrEUwaCkFUBLK1N8HehwQgu8e23jTH4np5NHOmQOobuC4ROQxFwFgBLTnhcnQRMs84muMh0PnnwXlPq5MGjg=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>

    <!-- DataTable -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.4/css/dataTables.bootstrap4.min.css"
          crossorigin="anonymous" referrerpolicy="no-referrer">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.dataTables.min.css"
          crossorigin="anonymous" referrerpolicy="no-referrer">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css"
          crossorigin="anonymous" referrerpolicy="no-referrer">

    <!-- Theme style -->
    <!-- <link rel="stylesheet" href="dist/css/adminlte.min.css"> -->
    <link rel="stylesheet" href="{{ asset('assets/css/dashboard/admin-lte/adminlte.min.css') }}">

    {{-- PERSONNAL STYLES --}}
    <link href="{{ asset('assets/css/custom.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/mystyle.admin.css') . '?' . time() }}" rel="stylesheet">


    @yield('plugin-css')

    @yield('personal-css')


    <style>
        /* ====== Global ====== */
        /* 1. Font configuration */

        /* ======= Main Header ====== */
        nav.main-header ul li {
            font-size: 1.5rem;
        }

        .brand-link .brand-image {
            margin-top: 0px;
        }

        /* ======= aside ======== */
        /* 1. Logo */
        aside a.brand-link {
            border-bottom: 1px solid transparent !important;
        }

        /* 2. Menu */
        /* 2.1 Main Header */
        nav.main-header {
            color: #0080BC;
            border-bottom: 0px;
        }

        nav.main-header .navbar-nav li.nav-item a.nav-link {
            color: #0080BC;
        }

        /* 2.2 Aside */
        aside.main-sidebar {
            background-color: #0080BC;
            color: #fff;
        }

        .sidebar {
            padding-right: 0px;
            padding-left: 0px;
        }

        [class*="sidebar-dark-"] .nav-sidebar > .nav-item.menu-open > .nav-link, [class*="sidebar-dark-"] .nav-sidebar > .nav-item:hover > .nav-link, [class*="sidebar-dark-"] .nav-sidebar > .nav-item > .nav-link:focus {
            background-color: #fff;
            color: #0080BC;
            border-radius: 0%;
        }

        .sidebar nav ul.nav li.nav-item a {
            color: #fff;
            display: inline-block;
            width: 100%;
            margin-bottom: 0px;
        }

        .sidebar nav ul.nav li.nav-item.active a, .sidebar nav ul.nav li.nav-item.active a:hover {
            color: #0080BC;
        }

        .sidebar nav ul.nav li.nav-item.active {
            background-color: #fff;
        }

        .sidebar nav ul.nav li.nav-item {
            border-bottom: 1px solid #fff;
        }

        /* ====== Content-Wrapper ====== */
        /* 1. Global */
        .content-wrapper {
            background-color: #fff;
        }

        /* 2. statistics */
        .statistics-section .card .card-body.red-stats-bg {
            background: -moz-linear-gradient(to right, #eb7278, #DB0042);
            background: -webkit-linear-gradient(to right, #eb7278, #DB0042);
            background: -ms-linear-gradient(to right, #eb7278, #DB0042);
            background: -o-linear-gradient(to right, #eb7278, #DB0042);
            background: linear-gradient(to right, #eb7278, #DB0042);
            line-height: 2.5rem;
            border-radius: 10px;
            cursor: pointer;
        }

        .statistics-section .card:hover .card-body.red-stats-bg {
            background: -moz-linear-gradient(to right, #DB0042, #eb7278);
            background: -webkit-linear-gradient(to right, #DB0042, #eb7278);
            background: -ms-linear-gradient(to right, #DB0042, #eb7278);
            background: -o-linear-gradient(to right, #DB0042, #eb7278);
            background: linear-gradient(to right, #DB0042, #eb7278);
            line-height: 2.5rem;
            border-radius: 10px;
            cursor: pointer;
        }

        .statistics-section .card .card-body.blue-stats-bg {
            background: -moz-linear-gradient(to right, #49BDEF, #1591D9);
            background: -webkit-linear-gradient(to right, #49BDEF, #1591D9);
            background: -ms-linear-gradient(to right, #49BDEF, #1591D9);
            background: -o-linear-gradient(to right, #49BDEF, #1591D9);
            background: linear-gradient(to right, #49BDEF, #1591D9);
            line-height: 2.5rem;
            border-radius: 10px;
            cursor: pointer;
        }

        .statistics-section .card:hover .card-body.blue-stats-bg {
            background: -moz-linear-gradient(to right, #1591D9, #49BDEF);
            background: -webkit-linear-gradient(to right, #1591D9, #49BDEF);
            background: -ms-linear-gradient(to right, #1591D9, #49BDEF);
            background: -o-linear-gradient(to right, #1591D9, #49BDEF);
            background: linear-gradient(to right, #1591D9, #49BDEF);
            line-height: 2.5rem;
            border-radius: 10px;
            cursor: pointer;
        }

        .statistics-section .card .card-body.green-stats-bg {
            background: -moz-linear-gradient(to right, #89CDC1, #199F8A);
            background: -webkit-linear-gradient(to right, #89CDC1, #199F8A);
            background: -ms-linear-gradient(to right, #89CDC1, #199F8A);
            background: -o-linear-gradient(to right, #89CDC1, #199F8A);
            background: linear-gradient(to right, #89CDC1, #199F8A);
            line-height: 2.5rem;
            border-radius: 10px;
            cursor: pointer;
        }

        .statistics-section .card:hover .card-body.green-stats-bg {
            background: -moz-linear-gradient(to right, #199F8A, #89CDC1);
            background: -webkit-linear-gradient(to right, #199F8A, #89CDC1);
            background: -ms-linear-gradient(to right, #199F8A, #89CDC1);
            background: -o-linear-gradient(to right, #199F8A, #89CDC1);
            background: linear-gradient(to right, #199F8A, #89CDC1);
            line-height: 2.5rem;
            border-radius: 10px;
            cursor: pointer;
        }

        .statistics-section .card .card-body.orange-stats-bg {
            background: -moz-linear-gradient(to right, #F08F45, #DA5D12);
            background: -webkit-linear-gradient(to right, #F08F45, #DA5D12);
            background: -ms-linear-gradient(to right, #F08F45, #DA5D12);
            background: -o-linear-gradient(to right, #F08F45, #DA5D12);
            background: linear-gradient(to right, #F08F45, #DA5D12);
            line-height: 2.5rem;
            border-radius: 10px;
            cursor: pointer;
        }

        .statistics-section .card:hover .card-body.orange-stats-bg {
            background: -moz-linear-gradient(to right, #DA5D12, #F08F45);
            background: -webkit-linear-gradient(to right, #DA5D12, #F08F45);
            background: -ms-linear-gradient(to right, #DA5D12, #F08F45);
            background: -o-linear-gradient(to right, #DA5D12, #F08F45);
            background: linear-gradient(to right, #DA5D12, #F08F45);
            line-height: 2.5rem;
            border-radius: 10px;
            cursor: pointer;
        }

        .statistics-section {
            border-bottom: 1px solid #A9A9A9;
        }

        .statistics-section .card {
            box-shadow: none;
        }

        .statistics-section .card .card-body {
            color: #fff
        }

        .statistics-section .card .card-body .number {
            font-size: 4rem;
        }

        .statistics-section .card .card-body .title {
            font-size: 1.1rem;
        }

        /* 3. create operation content */
        /* 3.1 Indicators */
        .indicator hr {
            border: 4px solid #DBEEF4;
            margin-right: 2px;
            flex-grow: 1;
        }

        .indicator .circle {
            width: 25px;
            height: 25px;
            border-radius: 12.5px;
            border: 5px solid #DBEEF4;
        }

        .indicator .title {
            color: #A9A9A9;
        }

        .indicator.active .title {
            color: #0080BC;
        }

        .indicator.active hr {
            border: 4px solid #0080BC;
            margin-right: 2px;
            flex-grow: 1;
        }

        .indicator.active .circle {
            width: 25px;
            height: 25px;
            border-radius: 12.5px;
            border: 5px solid #0080BC;
        }

        /* 3.2. Content - Card */
        .card-body .card-title {
            float: none;
            display: block;
        }

        .register input {
            background-color: #E7F6F6;
        }

        .register .input-group-append .input-group-text {
            color: #0080BC;
        }

        .register input::placeholder { /* Chrome, Firefox, Opera, Safari 10.1+ */
            color: #89D1E6;;
            opacity: 1; /* Firefox */
        }

        .register input::-ms-input-placeholder { /* Internet Explorer 10-11 */
            color: #89D1E6;;
        }

        .register input::-ms-input-placeholder { /* Microsoft Edge */
            color: #89D1E6;;
        }

        .register.last .create-form i {
            font-size: 4rem;
        }

        /* Operation list */
        .statut-point {
            width: 10px;
            height: 10px;
            border-radius: 5px;
            display: inline-block;
        }

        .table th, table.dataTable > tbody > tr.child span.dtr-title {
            font-weight: 400;
            color: #0080BC;
        }

        table.dataTable.dtr-inline.collapsed > tbody > tr > td.dtr-control:before, table.dataTable.dtr-inline.collapsed > tbody > tr > th.dtr-control:before {
            background-color: #0080BC;
        }

        table.dataTable > tbody > tr.child span.dtr-title {
            display: inline-block;
            min-width: 75px;
        }
    </style>

</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li>
        </ul>

        <!-- Right navbar links -->
        <ul class="navbar-nav ml-auto">
            <!-- Notifications Dropdown Menu -->
            <li class="nav-item dropdown">
                <a class="nav-link" data-toggle="dropdown" href="#">
                    <i class="fas fa-bell"></i>
                    <span class="badge badge-danger navbar-badge"></span>
                </a>

            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="dropdown" href="#">
                    <i class="fas fa-headset"></i>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="dropdown" href="#">
                    <i class="fas fa-user-circle"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                    <span class="dropdown-header">{{auth()->user()->name}}</span>
                    <div class="dropdown-divider"></div>
                    <span class="dropdown-header">role</span>

                    <span class="dropdown-header">
                            Administrateur :
                        </span>

                    <div class="dropdown-divider"></div>
                    {{--                    <a href="{{route("parameters.index")}}" class="dropdown-item">--}}
                    {{--                        <i class="fas fa-id-card-alt mr-2"></i> Profile--}}
                    {{--                        <span class="float-right text-muted text-sm"></span>--}}
                    {{--                    </a>--}}
                    <div class="dropdown-divider"></div>
                    <form method="post" action="{{route("logout")}}" id="logout">
                        @csrf
                    </form>
                    <a href="#" class="dropdown-item" onclick="document.getElementById('logout').submit();">
                        <i class="fas fa-sign-out-alt mr-2"></i>Se déconnecter
                        <span class="float-right text-muted text-sm"></span>
                    </a>
                </div>
            </li>
        </ul>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <a href="/" class="brand-link d-block">
            <img src="https://blooapp.live/assets/images/bloo_logo_white.png" alt="Bloo" class="brand-image">
            <span class="brand-text font-weight-light">&nbsp;</span>
        </a>

        <!-- Sidebar -->
        <div class="sidebar">
            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                    data-accordion="false">
                    <!-- Add icons to the links using the .nav-icon class
                        with font-awesome or any other icon font library -->

                    @if(auth()->user()->roles->pluck('id')[0] === 1)
                    <li  class="nav-item ">
                        <a href="{{route('operation.index')}}" class="nav-link">
                            <i class="nav-icon fas fa-th"></i>
                            <p>
                                Tableau de bord
                            </p>
                        </a>
                    </li>
                    @endif

                    @if(auth()->user()->roles->pluck('id')[0] !== 1)
                    <li  class="nav-item">
                        <a href="{{route('operation.index')}}" class="nav-link">
                            <i class="nav-icon fas fa-th"></i>
                            <p>
                                Opérations
                            </p>
                        </a>
                    </li>
                    @endif

                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-comment-alt"></i>
                            <p>
                                Messages
                            </p>
                        </a>
                    </li>


                    <li class="nav-item">
                        <a href="{{route('user.index')}}" class="nav-link">
                            <i class="nav-icon fas fa-users"></i>
                            <p>
                                Utilisateurs
                            </p>
                        </a>
                    </li>

                    @if(auth()->user()->roles->pluck('id')[0] === 1)
                    <li  class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-money-check-alt"></i>
                            <p>
                                Paiements
                            </p>
                        </a>
                    </li>
                    <li  class="nav-item">
                        <a href="{{route('role.index')}}" class="nav-link">
                            <i class="nav-icon fas fa-cog"></i>
                            <p>
                                Roles
                            </p>
                        </a>
                    </li>
                    <li  class="nav-item">
                        <a href="{{route('permission.index')}}" class="nav-link">
                            <i class="nav-icon fas fa-cog"></i>
                            <p>
                                Permissions
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{route('countries.index')}}" class="nav-link">
                            <i class="nav-icon fas fa-cog"></i>
                            <p>
                                Pays
                            </p>
                        </a>
                    </li>
                    <li  class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-cog"></i>
                            <p>
                                Paramètres
                            </p>
                        </a>
                    </li>
                    @endif
                </ul>
            </nav>
            <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
    </aside>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Main content -->
        <div class="content">
            <div class="container-fluid">

                <div class="row mt-3 statistics-section">
                    <div class="col-sm-3">
                        <div class="card">
                            <div class="card-body d-flex align-items-center red-stats-bg">
                                <span class="number mr-2">O</span>
                                <span class="title">Opérations</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="card">
                            <div class="card-body d-flex align-items-center blue-stats-bg">
                                <span class="number mr-2">O</span>
                                <span class="title">Opérateur</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="card">
                            <div class="card-body d-flex align-items-center green-stats-bg">
                                <span class="number mr-2">O</span>
                                <span class="title">Lecteurs</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="card">
                            <div class="card-body d-flex align-items-center orange-stats-bg">
                                <span class="number mr-2">O</span>
                                <span class="title">Jrs restant</span>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="mt-2">

                </div>
                @include('admin.common.flash')
                @yield('content')
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <!-- Main Footer -->
    <footer class="main-footer">
        <!-- Default to the left -->
        <div class="footer text-center bloo-color">
            &copy; {{ date('Y') }} Bloo. @lang("All rights reserved")
        </div>
    </footer>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.3.1.min.js"
        integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
<!-- datatable -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/js/dataTables.dataTables.min.js"
        integrity="sha512-fQmyZE5e3plaa6ADOXBM17WshoZzDIvo7sR4GC1VsmSKqm13Ed8cO2kPwFPAOoeF0RcdhuQQlPq46X/HnPmllg=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js" crossorigin="anonymous"
        referrerpolicy="no-referrer"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js" crossorigin="anonymous"
        referrerpolicy="no-referrer"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.bootstrap4.min.js" crossorigin="anonymous"
        referrerpolicy="no-referrer"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.colVis.min.js" crossorigin="anonymous"
        referrerpolicy="no-referrer"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js" crossorigin="anonymous"
        referrerpolicy="no-referrer"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js" crossorigin="anonymous"
        referrerpolicy="no-referrer"></script>

<!-- popper.js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"
        integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49"
        crossorigin="anonymous"></script>
<!-- Bootstrap 4 -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"
        integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T"
        crossorigin="anonymous"></script>

<!-- momentjs -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"
        integrity="sha512-qTXRIMyZIFb8iQcfjXWCO8+M5Tbc38Qi5WzdPOYZHIlZpzBHG3L3by84BBBOiRGiEb7KKtAOAs5qYdUiZiQNNQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/locale/fr.min.js"
        integrity="sha512-RAt2+PIRwJiyjWpzvvhKAG2LEdPpQhTgWfbEkFDCo8wC4rFYh5GQzJBVIFDswwaEDEYX16GEE/4fpeDNr7OIZw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<!-- Tempusdominus Bootstrap 4 -->
<script
    src="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.39.0/js/tempusdominus-bootstrap-4.min.js"
    integrity="sha512-k6/Bkb8Fxf/c1Tkyl39yJwcOZ1P4cRrJu77p83zJjN2Z55prbFHxPs9vN7q3l3+tSMGPDdoH51AEU8Vgo1cgAA=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/js/dataTables.bootstrap4.min.js"
        integrity="sha512-OQlawZneA7zzfI6B1n1tjUuo3C5mtYuAWpQdg+iI9mkDoo7iFzTqnQHf+K5ThOWNJ9AbXL4+ZDwH7ykySPQc+A=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.bootstrap.min.js" crossorigin="anonymous"
        referrerpolicy="no-referrer"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.bootstrap4.min.js" crossorigin="anonymous"
        referrerpolicy="no-referrer"></script>
<script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js" crossorigin="anonymous"
        referrerpolicy="no-referrer"></script>

<!-- AdminLTE App -->
<script src=" {{ asset('assets/js/dashboard/admin-lte/adminlte.min.js') }} "></script>

@yield('js-script')
@yield("page-script")
@yield("laraform_script1")
@yield('plugin-scripts')
</body>
</html>
