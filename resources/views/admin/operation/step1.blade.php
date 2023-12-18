@extends("layouts.admin4")

@section('ariane')
    <br/>
    <div aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item active"><a href="{{route('user.index')}}" class="bloo-color"><strong>Operations</strong></a></li>
            <li class="breadcrumb-item"><span class="bloo-color"><strong>Creation d'une operations</strong></span></li>
        </ol>
    </div>
    <hr/>
@stop

@section('content')
    <form id="myForm">
        @csrf
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
                                           placeholder="Ex. Evaluation campagne Yop"/>
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
                                           placeholder="Ex. Age - Sexe - CSP - Activite - ...">
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
                                                       placeholder="Date Début"/>
                                            </div>

                                            <span class="error dateDebut help-block text-center text-danger"></span>
                                        </div>
                                    </div>
                                    <div class="col-6 mt-2">
                                        <div class="form-group">
                                            <div class="input-group date" id="date-fin">
                                                <input id="dateFin" name="dateFin" required type="date"
                                                       class="form-control"
                                                       placeholder="Date Fin"/>
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
                                                   placeholder="00"
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
                                            <textarea id="message" class="form-control" name="message"></textarea>
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
                    url: "{{route('operation.store')}}", // Remplacez par l'URL correcte
                    data: formData,
                    success: function (response) {
                        setTimeout(function () {
                            window.location.href = response.redirect;
                        }, 500);
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



