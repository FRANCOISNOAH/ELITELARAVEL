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
            <div class="col-md-4 indicator active">
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
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body py-2">
                                        <h5 class="card-title">Editer les sites de collecte</h5>
                                        <div class="d-flex align-items-center" onclick="gotomap({{$operation->id}})">
                                            <i role="button" class="fas fa-map-marker-alt icon-operation mr-2"></i>
                                            Cliquer pour ajouter ou modifier
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="card">
                                    <form id="myForm">
                                        @csrf
                                        <div class="card-body py-2">
                                            <input type="checkbox"
                                                   name="pickup-period" id="pickup-period" class="float-right"/>
                                            <h5 class="card-title">Définir les horaires de collecte</h5>
                                            <div class="row">
                                                <div class="col-6 mt-2" id="heure-debut-container">
                                                    <div class="form-group">
                                                        <label>Heure de début</label>
                                                        <div class="input-group date" id="heure-debut"
                                                             data-target-input="nearest">
                                                            <input type="time" class="form-control" id="heure_debut" name="heure_debut"/>
                                                        </div>
                                                        <span class="error heure_debut help-block text-center text-danger"></span>
                                                    </div>
                                                </div>
                                                <div class="col-6 mt-2" id="heure-fin-container">
                                                    <label>Heure de fin</label>
                                                    <div class="form-group">
                                                        <div class="input-group date" id="heure-fin"
                                                             data-target-input="nearest">
                                                            <input type="time" class="form-control" id="heure_fin" name="heure_fin"/>
                                                        </div>
                                                        <span class="error heure_fin help-block text-center text-danger"></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Sites de collecte</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body p-0">
                                <table class="table table-sm sites">
                                    <tbody>

                                    @foreach($sites as $site)
                                        <tr>
                                            <td class="d-flex justify-content-between">
                                                {{ $site->name }}
                                                <i data-siteid="{{ $site->id }}" class="delete-btn fas fa-minus-circle"
                                                   title="Supprimer le site"></i>
                                            </td>
                                        </tr>
                                    @endforeach

                                    </tbody>
                                </table>
                            </div>
                            <!-- /.card-body -->
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <a href="#" class="float-right bloo-color"><i
                                onclick="submitForm()" class="fas fa-arrow-right"></i></a>
                        <a href="{{route('operation.edit',['operation'=> $operation->id])}}"
                           class="float-right bloo-color"><i
                                class="fas fa-arrow-left mr-3"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </form>
@stop


@section('js-script')
    <script>
        $(document).ready(function () {
            $("#heure-debut-container, #heure-fin-container").hide();

            $("#pickup-period").on("click", function () {
                if ($(this).prop("checked")) {
                    $("#heure-debut-container, #heure-fin-container").show();
                } else {
                    $("#heure-debut-container, #heure-fin-container").hide();
                }
            });

            $('.delete-btn').on('click', function () {
                let siteId = $(this).data('siteid');
                // Confirmation de la suppression (vous pouvez personnaliser cela)
                if (confirm('Voulez-vous vraiment supprimer ce site ?')) {
                    // Envoyer la requête Ajax pour la suppression
                    $.ajax({
                        url: '/operation_third_step/' + siteId,
                        type: 'DELETE',
                        data: {
                            "_token": "{{ csrf_token() }}"
                        },
                        success: function (response) {
                            // Gérer la réponse de la requête (par exemple, actualiser la page)
                            console.log(response);
                            location.reload(); // Vous pouvez remplacer cela par le traitement souhaité
                        },
                        error: function (error) {
                            // Gérer les erreurs
                            console.error(error);
                        }
                    });
                }
            });
        });

        function submitForm() {
            event.preventDefault();
            // Récupérer les données du formulaire
            $("#myForm .is-invalid").each(function () {
                $(this).removeClass("is-invalid");
            });
            $("#myForm span:not(.submit)").each(function () {
                $(this).empty();
            });

            // Récupérer les données du formulaire
            let formData = $("#myForm").serialize();
            formData += "&operation_id=" + {{$operation->id}};

            if (!$("#pickup-period").prop("checked")) {
                formData = formData.replace(/&?heure_debut=[^&]*/, '');
                formData = formData.replace(/&?heure_fin=[^&]*/, '');
            }

            $.ajax({
                url: '/operation_third_step',
                type: 'POST',
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
        }

        function gotomap(id) {
            window.location.href = "/operation_sites/" + id;
        }
    </script>
@stop



