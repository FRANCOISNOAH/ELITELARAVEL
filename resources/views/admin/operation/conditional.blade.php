@extends("layouts.admin4")

@section('title','Dashbord')

@section('laraform_script1')
    <script src="{{ asset('assets/js/plugins/pace.min.js') }}"></script>

    <script src="{{ asset('assets/js/core/libraries/jquery.min.js') }}"></script>

    <script src="{{ asset('assets/js/core/libraries/bootstrap.min.js') }}"></script>

    <script src="{{ asset('assets/js/plugins/blockui.min.js') }}"></script>

    <script>
        $('.question').on('click', function (e) {
            let questionid = parseInt(e.target.dataset.id);
            $('#response').empty();

            $.get('/json_response/' + questionid,function(data) {
                $('#response').empty();
                $('#questions').show();
                $('#question_id').val(questionid);
                $('.hide').show();
                let id = parseInt(questionid);
                $('.response').each(function (index, objet) {
                    if(objet.id <= id){
                        objet.disabled = true;
                    }else{
                        objet.disabled = false;
                    }
                });

                $.each(data, function(index, stateObj){
                    $('#response').append("<div class='col-md-3'><div class='card'><div class='card-body'>" +
                        "<div class='d-flex align-items-center create-form'>" +
                        "<div class='form-check'>"+
                        "<input class='form-check-input' type='radio' name='value' value='" +
                        stateObj.value+
                        "'>"+
                        "<label class='form-check-label'>"+
                         stateObj.value+
                        "</label>"+
                        "</div></div></div></div></div>");
                });


            });
        });
    </script>
@endsection

@section('content')
    <div class="mt-3 register last">

        <h2 class="mb-2">Gestion des conditions</h2>
        <span class="text-danger">
            <i>
                Seules les questions du formulaire dont les réponses ne sont pas obligatoires peuvent être utilisées pour les conditions <br/>
                Veuillewz vous rassurer d'avoir des questions dont la reponse n'est pas obligatoire.
            </i>
        </span>

        <form type="submit" method="post" action="{{route('forms.conditionalpost')}}">
        @csrf
            <input type="hidden" name="question" id="question_id" />
        <p class="text-info mt-3">Cliquez sur une question : </p>

        <div class="col-md-12 mt-3 row">
                @foreach($questions as $key => $field)
                    @if($field->template === "multiple-choices")
                        <div class="col-md-3">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex align-items-center create-form question"
                                        data-id="{{$field->id}}">
                                        Question {{$key + 1 }} : {{$field->question}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
        </div>

        <p class="text-info mt-1 hide" style="display: none">Choisir la valeur de la reponse : </p>

        <div class='col-md-12 row' id='response'>

        </div>

        <p class="text-info mt-1 hide" style="display: none">Choisir les questions à afficher : </p>

        <div class='col-md-12 row' id="questions" style="display:none">
            @foreach($questions as $key => $field)
                @if($field->required === 0)
                    <div class="col-md-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex align-items-center create-form"
                                     data-id="{{$field->id}}">
                                    <div class="form-check">
                                        <input class="form-check-input response" id="{{$field->id}}" type="checkbox" name="questions_check[]" value="{{$field->id}}" >
                                        <label class="form-check-label" for="defaultCheck1">
                                            Question {{$key + 1 }} : {{$field->question}}
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>

            <div class="col-md-3 float-md-right">
                <input type="submit" class="form-control btn hide" style="display: none" value="enregistrer">
            </div>

        </form>

    </div>
@endsection
