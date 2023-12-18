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
                <div class="ml-3 title">2. Sites de collecte</div>
            </div>
            <div class="col-md-4 indicator active">
                <div class="d-flex justify-content-between align-items-center">
                    <hr>
                    <div class="circle"></div>
                </div>
                <div class="ml-3 title">3. Questionnaire</div>
            </div>
        </div>

    <div class="row mt-3 register last">
        <div class="col-md-12">
            <h1>{{ trans('Topics') }}</h1>
            <div class="row">
                <div class="col-md-3">
                    <div onclick="emptyForm()" class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-center create-form">
                                <i class="fas fa-file-medical mr-3"></i>
                                Ne pas utiliser de template
                            </div>
                        </div>
                    </div>
                </div>
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

            <div class="row">
                <div class="col-12">
                    <a href="{{route('operation.second',['operation'=>$operation->id])}}"
                       class="float-right bloo-color btn mr-3">
                        <i class="fas fa-arrow-left"></i></a>
                </div>
            </div>
        </div>

    </div>
@stop


@section('js-script')
    <script>
        function emptyForm(code) {
            window.location.href = "/forms/{{$form->code}}"
        }
    </script>
    <script>
        $('.topic').on('click', function (e) {
            let topic_id = e.target.id;
            $.get('/json-templates2?topic_id=' + topic_id,function(data) {
                $('#templates').empty().append(data);
                $('.template').on('click',function (e) {
                    Swal.fire({
                        title: 'Êtes-vous sûr?',
                        text: 'Voulez-vous vraiment utilser ce template?',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Oui, lancer la requête!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            let template_id = e.target.id;
                            let id1 = "{{$operation->id}}";
                            let id2 = e.target.id;
                            let url = "/usetemplate/" + id1 + "/" + id2;

                            // Effectuer la requête AJAX
                            $.ajax({
                                url: url,
                                type: "GET",
                                success: function(data) {
                                    // Traitement des données de la réponse
                                    setTimeout(function () {
                                        window.location.href = data.redirect;
                                    }, 500);
                                },
                                error: function(jqXHR, textStatus, errorThrown) {
                                    // Gestion des erreurs
                                    console.error("Erreur lors de la requête AJAX:", textStatus, errorThrown);
                                }
                            });
                        }
                    });
                });
            });
        });
    </script>
@stop
