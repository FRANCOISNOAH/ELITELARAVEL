<?php $r = \Route::current()->getAction(); ?>
<?php $route = isset($r['as']) ? $r['as'] : ''; ?>
    <!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="icon" type="image/png" href="{{ asset('assets/images/bloo_favicon.png') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title> Bloo | @yield('page_title')</title>
    <link rel="icon" type="image/png" href="{{ asset('assets/images/bloo_favicon.png') }}">


    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    {{--    modal css --}}
    <link rel="stylesheet" href="{{asset('css/modal.css')}}">

    <link href="https://fonts.googleapis.com/css2?family=Baloo+2:wght@400;500;700&family=Rubik:wght@300&display=swap"
          rel="stylesheet">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="{{ asset('admin/bower_components/bootstrap/dist/css/bootstrap.min.css') }}">
    <!-- Font Awesome -->
    {{-- <link rel="stylesheet" href="{{asset('admin/bower_components/font-awesome/css/font-awesome.min.css')}}"> --}}
    <link rel="stylesheet" href="{{ asset('admin/bower_components/fontawesome/css/all.min.css') }}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="{{ asset('admin/bower_components/Ionicons/css/ionicons.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('admin/dist/css/AdminLTE.min.css') }}">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="{{ asset('admin/dist/css/skins/_all-skins.min.css') }}">
    <script src="https://js.pusher.com/7.0/pusher.min.js"></script>
    <script src="https://raw.githack.com/eKoopmans/html2pdf/master/dist/html2pdf.bundle.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/gitbrent/pptxgenjs@latest/dist/pptxgen.bundle.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/gitbrent/pptxgenjs@latest/demos/common/demos.js"></script>

    @yield('plugin-css')
    @yield('page-css')
    {{-- @yield('laraform_style') --}}

    <!-- Laraform Link Style -->
    <link href="{{ asset('favicon.ico') }}" rel="icon">
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet">
    <link href="{{ asset('assets/css/icons/icomoon/styles.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/core.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/components.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/colors.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/custom.css') . '?' . time() }}" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>


    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <!-- Google Font -->
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.back.css') . '?' . time() }}">
</head>

@php
    $body_class = $classes['body'] ?? '';
    $current_user = auth()->user();
@endphp

    <!-- ADD THE CLASS layout-top-nav TO REMOVE THE SIDEBAR. -->

<body class="hold-transition skin-black layout-top-nav {{ $body_class }}">

<div class="wrapper" id="app">
    <header class="main-header">
        <nav class="navbar navbar-fixed-top">
            <div class="container">
                <div class="navbar-header">
                    <a href=@if (auth()
        ->user()
    ->hasRole('Superadmin|Client|Opérateur|Lecteur|Admin')) "{{ route('theadministration.index') }}"    @else "#" @endif
                    class="navbar-brand"><img class="b_logo"
                                              src="{{ asset('assets/images/bloo_logo.png') }}" /></a>
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                            data-target="#navbar-collapse">
                        <i class="fa fa-bars"></i>
                    </button>
                </div>


            </div>
            <!-- /.container-fluid -->
        </nav>
    </header>
    <!-- Full Width Column -->

    <div class="page-container">
        <div class="page-content">
            <div class="content-wrapper">
                <div class="container">
                    <div class="content">
                        @yield('content-header')

                        @include('admin.common.flash')

                        @yield('content')
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /.content-wrapper -->

    <footer class="main-footer">
        <div class="container">
            <div class="row">
                <div class="pull-right hidden-xs">
                    <b>Powered by </b><a href="#" id="infinites">Bloo</a>
                </div>
                <ul class="col-xs-12 col-sm-10 text-center">
                    <li><a
                            href="#">{{ trans('footer_privacy') }}</a>
                    </li>
                    <li><a href="#">{{ trans('Conditions_utilisation') }}</a>
                    </li>
                </ul>
            </div>
        </div>
        <!-- /.container -->
    </footer>
    @yield('admin_lte_script')

    @yield('laraform_script1')

    @yield('plugin-scripts')

    @yield('laraform_script2')

    @yield('page-script')

    <script>
        let user_id = '{{optional(auth()->user())->id}}';
        window.User = {
            id: user_id
        }
    </script>


</div>
<!-- ./wrapper -->
</body>

</html>
