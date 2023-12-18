@extends('admin.layouts.admin')

@section('ariane')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h3 class="m-0">Créez un opération</h3>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{route('operation.index')}}"><h5>Operations</h5></a></li>
                <li class="breadcrumb-item active">Creation d'une operation</li>
            </ol>
        </div>
    </div>
    <hr/>
@stop

@section('content')
    <form id="myForm">
        @csrf
        @method("PUT")
        <div class="row">
            <div class="col-md-4 indicator active">
                <div class="d-flex justify-content-between align-items-center">
                    <hr>
                    <div class="circle"></div>
                </div>
                <div class="ml-3 title">1. Infos générales</div>
            </div>
            <div class="col-md-4 indicator">
                <div class="d-flex justify-content-between align-items-center">
                    <hr>
                    <div class="circle"></div>
                </div>
                <div class="ml-3">2. Sites de collecte</div>
            </div>
            <div class="col-md-4 indicator">
                <div class="d-flex justify-content-between align-items-center">
                    <hr>
                    <div class="circle"></div>
                </div>
                <div class="ml-3 title">3. Questionnaire</div>
            </div>
        </div>

        <div class="row mt-3 register">
            <span class="error-message danger"></span>
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body py-2">
                                <h5 class="card-title">Nom de l'opération</h5>
                                <div class="form-group mt-2">
                                    <input id="name" name="name" required class="form-control" type="text"
                                           value="{{$operation->form->title}}"/>
                                </div>
                                <span class="error name help-block text-center text-danger"></span>

                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body py-2">
                                <h5 class="card-title">Profils des répondants</h5>
                                <div class="form-group mt-2">
                                    <input id="profils" name="profils" required class="form-control" type="text"
                                           value="{{$operation->profils}}">
                                    <span class="error profils help-block text-center text-danger"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body py-2">
                                <h5 class="card-title">Durée de l'opération</h5>
                                <div class="row">
                                    <div class="col-6 mt-2">
                                        <div class="form-group">
                                            <div class="input-group date" id="date-debut">
                                                <input id="dateDebut" name="dateDebut" type="date" class="form-control"
                                                       value="{{$operation->form->start}}"/>
                                            </div>

                                            <span class="error dateDebut help-block text-center text-danger"></span>
                                        </div>
                                    </div>
                                    <div class="col-6 mt-2">
                                        <div class="form-group">
                                            <div class="input-group date" id="date-fin">
                                                <input id="dateFin" name="dateFin" required type="date"
                                                       class="form-control"
                                                       value="{{$operation->form->end}}"/>
                                            </div>
                                            <span class="error dateFin help-block text-center text-danger"> </span>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body py-2">
                                <h5 class="card-title">Nombre d'opérateurs</h5>
                                <div class="row">
                                    <div class="col-12 mt-2">
                                        <div class="form-group">
                                            <input id="operators" name="operators" class="form-control" type="number"
                                                   value="{{$operation->operators}}"
                                                   required>
                                            <span class="error operators help-block text-center text-danger"> </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body py-2">
                                <h5 class="card-title">Message d'indisponibilte du formulaire</h5>
                                <div class="row">
                                    <div class="col-12 mt-2">
                                        <div class="form-group">
                                            <textarea id="message" class="form-control" name="message">{{$operation->form->message}}</textarea>
                                            <span class="error message help-block text-center text-danger"> </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                    <span class="float-right bloo-color submit">
                        <i id="submitForm" class="fas fa-arrow-right" role="button"></i>
                    </span>
                    </div>
                </div>
            </div>
        </div>
    </form>
@stop


@section('js-script')
    <script>
        $(document).ready(function () {
            $("#submitForm").on("click", function (e) {
                event.preventDefault();
                // Récupérer les données du formulaire
                $("#myForm .is-invalid").each(function () {
                    $(this).removeClass("is-invalid");
                });
                $("#myForm span:not(.submit)").each(function () {
                    $(this).empty();
                });
                let formData = $("#myForm").serialize();
                // Envoyer les données via AJAX
                $.ajax({
                    type: "POST", // ou GET selon votre configuration
                    url: "{{route('operation.update',['operation'=> $operation])}}",
                    data: formData,
                    success: function (response) {
                        setTimeout(function () {
                            window.location.href = response.redirect;
                        }, 1500);
                    },
                    error: function (error) {
                        let errors = error.responseJSON.errors;

                        for (let key in errors) {
                            if (errors.hasOwnProperty(key)) {
                                let errorMessage = errors[key][0];
                                let element = $("#" + key);
                                if (element.length > 0) {
                                    element.addClass('is-invalid');
                                }
                                let errorElement = $("." + key);
                                if (errorElement.length > 0) {
                                    errorElement.empty().text(errorMessage);
                                }
                            }
                        }
                    }
                });
            });
        });
    </script>
@stop



