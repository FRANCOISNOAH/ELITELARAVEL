@section('title', " BLOO|My Forms | Edit Form")

@extends('admin.top-nav')

@section('laraform_style')
    <!-- Laraform Link Style -->
    <link href="{{ asset('favicon.ico') }}" rel="icon">
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet">
    <link href="{{ asset('assets/css/icons/icomoon/styles.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/core.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/components.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/colors.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/custom.css') }}" rel="stylesheet">
    @endsection

@section('content')
{{--    <div class="panel panel-flat border-left-xlg border-left-primary">--}}
{{--        <div class="panel-heading">--}}
{{--            <h4 class="panel-title text-semibold">My Forms</h4>--}}
{{--            <div class="heading-elements">--}}
{{--                <a href="{{ route('forms.index') }}" class="btn btn-primary heading-btn">All Forms</a>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}

    <div class="panel panel-flat border-top-lg border-top-primary">
        <div class="panel-heading">
            <h5 class="panel-title">{{trans('Edit Form')}}  - {{ $form->title }}</h5>
        </div>
        <div class="panel-body">
            @include('forms.form._form', ['type' => 'edit'])
        </div>
    </div>
@endsection
@section('laraform_script1')
    <script src="{{ asset('assets/js/plugins/pace.min.js') }}"></script>
    <script src="{{ asset('assets/js/core/libraries/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/js/core/libraries/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/blockui.min.js') }}"></script>
@endsection

@section('laraform_script2')
    <script src="{{ asset('assets/js/core/app.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/ripple.min.js') }}"></script>
    <script src="{{ asset('assets/js/custom/main.js') }}"></script>
@endsection
