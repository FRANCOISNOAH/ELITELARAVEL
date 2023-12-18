@extends("layouts.admin4")

@section('ariane')
    <br/>
    <div aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item active"><a href="{{route('user.index')}}" class="bloo-color"><strong>Utilisateurs</strong></a></li>
            <li class="breadcrumb-item"><span class="bloo-color"><strong>Creation des utilisateurs</strong></span></li>
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
                    <label class="mb-0">Nom</label>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" id="name" name="name">
                    </div>
                    <span  class="name help-block text-center text-danger"> </span>
                </div>

                <div class="mb-2">
                    <label class="mb-0">Email</label>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="alt-addon"><i class="fa fa-user"></i></span>
                        </div>
                        <input type="text" class="form-control" arial-label="Email"
                               aria-describedby="alt-addon" id="email" name="email"/>
                    </div>
                    <span  class="email help-block text-center text-danger"> </span>
                </div>

                <div class="mb-2">
                    <label class="mb-0">Mot de passe</label>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="login-password"><i class="fa fa-lock"></i></span>
                        </div>
                        <input type="password" class="form-control"
                               aria-describedby="login-password"
                               name="password"
                               id="password"
                               data-toggle="password"
                        >
                        <div class="input-group-append">
                            <span class="input-group-text" id="alt-addon"><i class="fas fa-eye"></i></span>
                        </div>
                    </div>
                    <span  class="password help-block text-center text-danger"> </span>
                </div>


                <div class="mb-2">
                    <label class="mb-0">Confirmation du mot de passe</label>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="login-password"><i class="fa fa-lock"></i></span>
                        </div>
                        <input type="password" class="form-control"
                               aria-describedby="login-password"
                               name="password_confirmation"
                               id="password_confirmation"
                               data-toggle="password"
                        >
                        <div class="input-group-append">
                            <span class="input-group-text" id="alt-addon"><i class="fas fa-eye"></i></span>
                        </div>
                    </div>
                    <span  class="password_confirmation help-block text-center text-danger"> </span>
                </div>

                <div class="mb-2">
                    <label class="mb-0">Selectionnez le pays</label>
                    <div class="input-group mb-3">
                        <select name="country" id="country" class="form-control">
                            @foreach($countries as $country)
                                <option value="{{$country->id}}">{{$country->name_fr}}</option>
                            @endforeach
                        </select>
                    </div>
                    <span  class="country help-block text-center text-danger"> </span>
                </div>

                <div class="mb-2">
                    <label class="mb-0">Selectionnez le role</label>
                    <div class="input-group mb-3">
                        <select id="role" name="role" class="form-control">
                            @if(auth()->user()->hasRole(['SuperAdmin']))
                                @foreach($roles as $role)
                                    <option value="{{{$role->id}}}">{{$role->name}}</option>
                                @endforeach
                            @elseif(auth()->user()->hasAnyRole(['Admin','Client']))
                                <option value="3">Operateur</option>
                                <option value="5">Lecteur</option>
                            @endif
                        </select>
                    </div>
                    <span  class="role help-block text-center text-danger"> </span>
                </div>

                <div class="mb-2" id="companydiv">
                    <label class="mb-0">Nom de l'entreprise</label>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" id="company" name="company">
                    </div>
                    <span  class="company help-block text-center text-danger"> </span>
                </div>

                @if(!auth()->user()->hasRole(['Client']))
                <div class="mb-2" id="clientdiv">
                    <label class="mb-0">Selectionnez le client</label>
                    <div class="input-group mb-3">
                        <select id="user_id" name="user_id" class="form-control">
                            @foreach($clients as $client)
                                <option value="{{$client->id}}">{{$client->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <span  class="user_id help-block text-center text-danger"> </span>
                </div>
                @endif


                <div class="iform-group">
                    <label>Activer le compte ?</label>
                    <div class="input-group mb-3">
                        <select id="activate" name="activate" class="form-control">
                            <option value="1">OUI</option>
                            <option value="0">NON</option>
                        </select>
                    </div>
                    <span  class="activate help-block text-center text-danger"> </span>
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
            // Cacher le champ "client" au chargement de la page
            $("#clientdiv").hide();
            $("#companydiv").hide();

            // Lorsque le champ "role" change
            $("#role").change(function () {
                // Récupérer la valeur sélectionnée dans le champ "role"
                let selectedRole = $(this).val();
                // Vérifier si le champ "client" doit être affiché
                if (selectedRole == 3 || selectedRole == 5) {
                    $("#clientdiv").show();
                } else {
                    $("#clientdiv").hide();
                }
                if(selectedRole == 4){
                    $("#companydiv").show();
                }else{
                    $("#companydiv").hide();
                }
            });

            // Lorsque le formulaire est soumis
            $("#myForm").submit(function (event) {
                event.preventDefault();
                // Vérifier si le champ "client" est visible avant d'envoyer les données
                let isClientVisible = $("#clientdiv").is(":visible");

                let isCompanyVisible = $("#companydiv").is(":visible");

                // Vérifier si les champs "password" et "password_confirmation" sont identiques
                let password = $("#password").val();
                let confirmPassword = $("#password_confirmation").val();

                if (password !== confirmPassword) {
                    $("#password").addClass('is-invalid');
                    $("#password_confirmation").addClass('is-invalid');
                    $(".error-message").text("Les champs de mot de passe ne correspondent pas.");
                    setTimeout(function () {
                        $(".error-message").empty();
                    }, 5000);
                    return;
                }

                // Récupérer les données du formulaire
                var formData = $(this).serialize();

                // Ajouter une condition pour exclure le champ "client" si nécessaire
                if (!isClientVisible) {
                    // Exclure le champ "client" des données du formulaire
                    formData = formData.replace(/&?user_id=[^&]*/, '');
                }

                if (!isCompanyVisible) {
                    // Exclure le champ "client" des données du formulaire
                    formData = formData.replace(/&?company=[^&]*/, '');
                }

                // Envoyer les données via AJAX
                $.ajax({
                    type: "POST", // ou GET selon votre configuration
                    url: "{{route('user.store')}}", // Remplacez par l'URL correcte
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
