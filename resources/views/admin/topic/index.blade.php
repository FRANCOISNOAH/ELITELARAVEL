@extends("layouts.admin4")

@section('content')
    <div class="container-fluid">
        <div class="row mt-3 register last">
            <h1>{{ trans('Topics') }}</h1>
            <div class="col-md-12">
                <div class="row">
                    @foreach($topics as $topic)
                        <div class="col-md-3">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex align-items-center topic  create-form" id="{{ $topic->id }}">
                                        <i class="fas fa-file-alt mr-3"></i>
                                        {{ $topic->name }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <hr/>
                <h1>{{ trans('Templates') }}</h1>
                <span id="templates">

                </span>
            </div>

        </div>
    </div>

    <!-- Modals -->
    <div class="modal fade bd-example-modal-lg" id="modal-default" tabindex="-1" role="dialog"
         aria-labelledby="myLargeModalLabel" aria-hidden="true">

        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">{{ trans('Create a topic') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <form method="POST" action="{{ route('topic.store') }}">
                        @csrf
                        <div class="form-group">
                            <label for="name">{{ trans('Name') }}</label>
                            <input type="text" class="form-control" name="name" id="name"
                                   placeholder="{{ trans('Name') }}" value="{{ old('name') }}" required autofocus>
                        </div>

                        <div class="form-group">
                            <label for="description">{{ trans('Description') }}</label>
                            <input type="text" class="form-control" name="description" id="description"
                                   placeholder="{{ trans('Description') }}" value="{{ old('description') }}" required>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-info btn-block">{{ trans('Save') }} <i
                                    class="icon-arrow-right14 position-right"></i></button>
                        </div>

                        <div class="content-divider text-muted form-group"><span></span></div>
                        <button type="button" class="btn btn-secondary btn-block"
                                data-dismiss="modal">{{ trans('Close') }}</button>
                    </form>
                </div>
                <div class="modal-footer">
                    <!-- Ajoutez du contenu ici si nécessaire -->
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->

    </div>

    <div class="modal fade bd-example-modal-lg" id="template-default" tabindex="-1" role="dialog"
         aria-labelledby="myLargeModalLabel" aria-hidden="true">

        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">{{ trans('Create a template') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <form method="POST" action="{{ route('template.store') }}">
                        @csrf
                        <div class="form-group has-feedback has-feedback-left">
                            <input type="text" class="form-control" name="name" id="name" placeholder="@lang("Name")"
                                   value="{{ old('name') }}" required autofocus>
                            <div class="form-control-feedback">
                                <i class="icon-user text-muted"></i>
                            </div>
                        </div>

                        <div class="form-group has-feedback has-feedback-left">
                            <input type="text" class="form-control" name="description" id="description"
                                   placeholder="@lang("Description")" value="{{ old('description') }}" required
                                   autofocus>
                            <div class="form-control-feedback">
                                <i class="icon-book3 text-muted"></i>
                            </div>
                        </div>

                        <div class="form-group has-feedback has-feedback-left">
                            <select class="form-control" name="topic_id" id="description">
                                @foreach($topics as $topic)
                                    <option value="{{ $topic->id }}">{{ $topic->name }}</option>
                                @endforeach
                            </select>
                            <div class="form-control-feedback">
                                <i class="icon-book3 text-muted"></i>
                            </div>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn bg-teal btn-block">{{ trans('savee') }} <i
                                    class="icon-arrow-right14 position-right"></i></button>
                        </div>

                        <div class="content-divider text-muted form-group"><span></span></div>
                        <button type="button" class="btn btn-default btn-block content-group" data-dismiss="modal"><font
                                style="vertical-align: inherit;"><font
                                    style="vertical-align: inherit;">{{ trans('Close') }}</font></font></button>
                    </form>
                </div>
                <div class="modal-footer">
                    <!-- Ajoutez du contenu ici si nécessaire -->
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
@endsection

@section('page-script')

    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

    <script src="{{ asset('assets/js/custom/pages/response-summary.js') }}"></script>
    <script>
        $('.topic').on('click', function (e) {
            let topic_id = e.target.id;
            $.get('/json-templates2?topic_id=' + topic_id,function(data) {
                $('#templates').empty().append(data);
                $('.template').on('click',function (e) {
                    let template_id = e.target.id;
                    let url = "/forms/"+ template_id;
                    window.open(url, "_blank");
                })
            });
        });

    </script>

@endsection
