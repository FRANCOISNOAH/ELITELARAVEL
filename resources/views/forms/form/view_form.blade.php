@php
    $page = $form->title;
    ($view_type === 'preview') and $page .= ' - Preview*';
    $module = ($view_type === 'preview') ? 'My Form' : config('app.name');
    $fields = $form->fields()->filled()->get();
    $mobile = false;
    $responce = true;
@endphp

@section('title', " {$page}")

@extends('layouts.auth')


@section('content')
    <div id="loader"></div>
    <div id="form_content">
        <div class="row">
            <div class="col-md-12 text-center"><img src="{{ asset('assets/images/bloo_logo.png') }}" alt="Bloo"
                                                    class="bloologoform"></div>
        </div>
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-flat">
                    <div class="panel-heading">
                        <h5 class="panel-title">{{ $page }}</h5>
                    </div>
                    @php $formatted_fields = []; @endphp

                    @if ($form->status === App\Models\Form::STATUS_CLOSED)
                        <div class="panel-body">
                            {{ optional($form->availability)->closed_form_message ?? 'Sorry, this form has been closed to responses.' }}
                        </div>
                    @else
                        @if($view_type === 'form')

                            <div class="panel-body">
                                @php
                                    $mobile = isset( $_GET['mobile'] ) ? $_GET['mobile'] : "";
                                @endphp

                                <form id="user-form"
                                      @if($mobile == "true") action="{{ ($view_type === 'form') ? route('forms.responses.store.mobile2', $form->code) : "#" }}"
                                      method="{{ ($view_type === 'form') ? "post" : "get" }}" autocomplete="off"
                                      @else  action="{{ ($view_type === 'form') ? route('forms.responses.store', $form->code) : "#" }}"
                                      method="{{ ($view_type === 'form') ? "post" : "get" }}" @endif>


                                    @if ($view_type === 'form')
                                        @csrf
                                    @endif


                                    <div id="form-fields" class="mt-15 mb-15">
                                        @php $formatted_fields = []; @endphp
                                        @if ($fields->count())
                                            {{-- <p class="content-group text-danger"><strong>Fields with * are required</strong></p> --}}
                                            @foreach ($fields as $field)
                                                @php $template = get_form_templates($field->template) @endphp
                                                <div class="field" data-id="{{ $field->id }}"
                                                     data-attribute="{{ $field->attribute }}"
                                                     style="display: {{$field->display}}"
                                                     data-attribute-type="{{ $template['attribute_type'] === 'string' ? 'single' : 'multiple' }}">
                                                    {!! $template['main_template'] !!}
                                                </div>
                                                @php
                                                    $only_attributes = ['attribute', 'template', 'question', 'required', 'options'];
                                                    $formatted_fields[$field->attribute] = $field->only($only_attributes);
                                                @endphp
                                            @endforeach
                                        @endif
                                    </div>


                                    <input type="hidden" name="site_id"
                                           value="<?= isset($_GET['site_id']) ? $_GET['site_id'] : ""; ?>">
                                    <input type="hidden" name="country_id"
                                           value="<?= isset($_GET['country_id']) ? $_GET['country_id'] : ""; ?>">
                                    <input type="hidden" name="ville"
                                           value="<?= isset($_GET['ville']) ? $_GET['ville'] : ""; ?>">
                                    <input type="hidden" name="lat"
                                           value="<?= isset($_GET['lat']) ? $_GET['lat'] : ""; ?>">
                                    <input type="hidden" name="lng"
                                           value="<?= isset($_GET['lng']) ? $_GET['lng'] : ""; ?>">
                                    <input type="hidden" name="token"
                                           value="<?= isset($_GET['token']) ? $_GET['token'] : ""; ?>">
                                    <div class="text-left mt-20">
                                        <button id="submit"
                                                type="{{ ($view_type === 'form') ? 'submit' : 'button' }}"
                                                class="btn btn-primary"
                                                data-loading-text="@lang('Chargement des données')"
                                                data-complete-text="Submit Form"
                                                @if($responce === false) disabled @endif
                                        >{{ trans('Soumettre_le_formulaire') }}</button>
                                    </div>
                                </form>
                            </div>
                        @else
                            <div class="panel-body">
                                        <form id="user-form"
                                              action="{{ ($view_type === 'form') ? route('forms.responses.store', $form->code) : "#" }}"
                                              method="{{ ($view_type === 'form') ? "post" : "get" }}" autocomplete="off">
                                            @if ($view_type === 'form')
                                                @csrf
                                            @endif
                                            <div id="form-fields" class="mt-15 mb-15">
                                                @php $formatted_fields = []; @endphp
                                                @if ($fields->count())
                                                    {{-- <p class="content-group text-danger"><strong>Fields with * are required</strong></p> --}}
                                                    @foreach ($fields as $field)
                                                        @php $template = get_form_templates($field->template) @endphp
                                                        <div class="field" data-id="{{ $field->id }}"
                                                             data-attribute="{{ $field->attribute }}"
                                                             data-attribute-type="{{ $template['attribute_type'] === 'string' ? 'single' : 'multiple' }}">
                                                            {!! $template['main_template'] !!}
                                                        </div>
                                                        @php
                                                            $only_attributes = ['attribute', 'template', 'question', 'required', 'options'];
                                                            $formatted_fields[$field->attribute] = $field->only($only_attributes);
                                                        @endphp
                                                    @endforeach
                                                @endif
                                            </div>

                                            <div class="text-left mt-20">
                                                <button id="submit"
                                                        type="{{ ($view_type === 'form') ? 'submit' : 'button' }}"
                                                        class="btn btn-primary" data-loading-text="Please Wait..."
                                                        data-complete-text="Submit Form">Submit Form
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>

@endsection

@section('laraform_script1')
    <script src="{{ asset('assets/js/plugins/pace.min.js') }}"></script>
    <script src="{{ asset('assets/js/core/libraries/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/js/core/libraries/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/blockui.min.js') }}"></script>
@endsection

@section('plugin-scripts')
    <script src="{{ asset('assets/js/plugins/uniform.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/autosize.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/noty.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/ion_rangeslider.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/pickadate/picker.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/pickadate/picker.date.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/pickadate/picker.time.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/pickadate/legacy.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/select2.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/validation/validate.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/validation/additional-methods.min.js') }}"></script>
@endsection

@section('page-script')
    <script src="{{ asset('assets/js/custom/pages/validation.js') }}"></script>
    <script type="text/javascript">
        function showPage() {
            document.getElementById("loader").style.display = "none";
            document.getElementById("form_content").style.display = "block";
        }

        window.addEventListener("load", function () {
            showPage();
        });
    </script>
    <script type="text/javascript">
        window.onload = function () {
            @foreach ($conditions as $item)
            $("#user-form input[name='{{$item->field_name}}']").click(function () {
                if ($('input:radio[name="{{$item->field_name}}"]:checked').val() === "{{$item->value}}") {
                    @foreach($item->conditional_fields as $key => $field)
                    document.querySelector(`[data-id="{{$field->field_id}}"]`).style.display = "{{$item->display}}";
                    @endforeach
                } else {
                    @foreach($item->conditional_fields as $key => $field)
                    document.querySelector(`[data-id="{{$field->field_id}}"]`).style.display = "none";
                    let firstDiv{{$key}} = document.querySelector(`[data-id="{{$field->field_id}}"]`).firstElementChild;
                    let secondDiv{{$key}} = firstDiv{{$key}}.firstElementChild;
                    let thirdDiv{{$key}} = secondDiv{{$key}}.firstElementChild;
                    let lastDiv{{$key}} = thirdDiv{{$key}}.lastElementChild;
                    lastDiv{{$key}}.value = "";
                    @endforeach
                }
            });
            @endforeach
        };
    </script>
    @include('forms.partials._script-view')
@endsection

