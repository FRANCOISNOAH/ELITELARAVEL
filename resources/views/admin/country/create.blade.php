@extends("layouts.admin4")

@section('ariane')
    <br/>
    <div aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item active"><a href="{{route('countries.index')}}"
                                                  class="bloo-color"><strong>Pays</strong></a></li>
            <li class="breadcrumb-item"><span class="bloo-color"><strong>Creation des pays</strong></span></li>
        </ol>
    </div>
    <hr/>
@stop


@section('content')
    <form id="myForm">
        @csrf
        <div class="row">
            <div class="col-md-8 offset-2">
                <div class="mb-2">
                    <label class="mb-0">Nom en francais</label>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" id="name_fr" name="name_fr">
                    </div>
                    <span class="name_fr help-block text-center text-danger"> </span>
                </div>

                <div class="mb-2">
                    <label class="mb-0">Nom en anglais</label>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" id="name_en" name="name_en">
                    </div>
                    <span class="name_en help-block text-center text-danger"> </span>
                </div>


                <br>
                <div class="form-group">
                    <button type="submit" class="btn btn-block bg-bloo">Sauvegarder</button>
                </div>
            </div>
        </div>
    </form>
@stop

@section('js-script')
    <script>
        !function ($) {
            //eyeOpenClass: 'fa-eye',
            //eyeCloseClass: 'fa-eye-slash',
            'use strict';
            $(function () {
                $('[data-toggle="password"]').each(function () {
                    let input = $(this);
                    let eye_btn = $(this).parent().find('.input-group-text');
                    eye_btn.css('cursor', 'pointer').addClass('input-password-hide');
                    eye_btn.on('click', function () {
                        if (eye_btn.hasClass('input-password-hide')) {
                            eye_btn.removeClass('input-password-hide').addClass('input-password-show');
                            eye_btn.find('.fas').removeClass('fa-eye').addClass('fa-eye-slash')
                            input.attr('type', 'text');
                        } else {
                            eye_btn.removeClass('input-password-show').addClass('input-password-hide');
                            eye_btn.find('.fas').removeClass('fa-eye-slash').addClass('fa-eye')
                            input.attr('type', 'password');
                        }
                    });
                });
            });
        }(window.jQuery);

        $(document).ready(function () {
            // Lorsque le formulaire est soumis
            $("#myForm").submit(function (event) {
                event.preventDefault();
                // Récupérer les données du formulaire
                $("#myForm .is-invalid").each(function () {
                    $(this).removeClass("is-invalid");
                });
                $("#myForm span:not(.submit)").each(function () {
                    $(this).empty();
                });
                // Récupérer les données du formulaire
                let formData = $(this).serialize();
                // Envoyer les données via AJAX
                $.ajax({
                    type: "POST", // ou GET selon votre configuration
                    url: "{{route('countries.store')}}", // Remplacez par l'URL correcte
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

