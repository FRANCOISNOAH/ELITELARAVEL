@php
    $page = "{$form->title} - Response";
    $response_count = $form->responses()->has('fieldResponses')->count();
    $response_type_shown_is_summary = ($query === 'summary');

    $current_user = auth()->user();
@endphp

@extends('admin.top2')

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

@section('plugin-css')
    @stack('styles')
@endsection

@section('title', "My Form | {$page}")

@section('content')

@include('partials.alert', ['name' => 'index'])

<div class="panel panel-flat">
    <div class="panel-heading">
        @php $symbol = $form::getStatusSymbols()[$form->status]; @endphp
        <h5 class="panel-title">{{ $page }} <span class="label bg-{{ $symbol['color'] }} position-left">{{ $symbol['label'] }}</span></h5>
        <div class="heading-elements">
            <div class="btn-group heading-btn">
                    @include('forms.partials._form-menu')
            </div>

        </div>
    </div>

    <div class="panel-body">
		{!! str_convert_line_breaks($form->description) !!}
    </div>
</div>

<div class="panel panel-flat">
    <div class="panel-heading">
        <h5 class="panel-title">{{ $response_count . ' ' . Str::plural(trans('response'), $response_count) }}</h5>
        <div class="heading-elements">
            <div class="heading-btn">
                <a id="download_pdf">
                    <img src=" {{ asset('assets/images/PDF_24.png') }}" />
                </a>
                <a href="{{ route('forms.responses.index', $form->code) }}" class="btn {{ ($response_type_shown_is_summary) ? 'bg-bloo-c1' : 'btn-default' }}">{{ trans('summary') }}</a>
                <a href="{{ route('forms.responses.index', [$form->code, 'type' => 'individual']) }}" class="btn {{ (!$response_type_shown_is_summary) ? 'bg-bloo-c1' : 'btn-default' }}">{{ trans('individual') }}</a>
            </div>
        </div>
    </div>
</div>

@includeWhen($response_count, "forms.response.{$query}")

@includeWhen(($form->status === $form::STATUS_OPEN), 'forms.partials._form-share')

@includeWhen(($form->user_id !== $current_user->id), 'forms.partials._form-collaborate')

@include('forms.partials._form_availability')
@endsection

@section('laraform_script1')
    <script src="{{ asset('assets/js/plugins/pace.min.js') }}"></script>
    <script src="{{ asset('assets/js/core/libraries/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/js/core/libraries/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/blockui.min.js') }}"></script>
@endsection

@section('plugin-scripts')
    <script src="{{ asset('assets/js/plugins/noty.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/bootbox.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/uniform.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/autosize.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/tagsinput.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/validation/validate.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/validation/additional-methods.min.js') }}"></script>
@endsection
@section('laraform_script2')
    <script src="{{ asset('assets/js/core/app.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/ripple.min.js') }}"></script>
    <script src="{{ asset('assets/js/custom/main.js') }}"></script>
@endsection
@section('page-script')
    @stack('script')

    <script>
        $(function () {
            autosize($('.elastic'));

            $('.tags-input').tagsinput({
                maxTags: 20,
                maxChars: 255,
                trimValue: true,
                tagClass: function(item){
                    return 'label bg-bloo-c1';
                },
            });

            function notify(type, message) {
                noty({
                    width: 200,
                    text: message,
                    type: type,
                    dismissQueue: true,
                    timeout: 6000,
                    layout: 'top',
                    buttons: false
                });
            }
        });
    </script>
@endsection
