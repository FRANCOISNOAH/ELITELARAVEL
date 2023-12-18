@extends('layouts.auth')

@section('form')
    <form id="login" autocomplete="off">
        @csrf
        <div class="row">
            <div class="col-12 mb-2">
                <h1 class="content-group-lg">Nouveau compte</h1>
            </div>
        </div>


        <span  class="error-message help-block text-center text-danger"> </span>

        <div class="mb-2">
            <label class="mb-0">Nom de l'entreprise</label>
            <input type="text" class="form-control" id="company" name="company">
            <span  class="company help-block text-center text-danger"> </span>
        </div>

        <div class="mb-2">
            <label class="mb-0">Nom</label>
            <input type="text" class="form-control" id="name" name="name">
            <span  class="name help-block text-center text-danger"> </span>
        </div>

        <div class="mb-2">
            <label class="mb-0">Pays</label>
            <select id="country" name="country" class="form-control">
                @foreach($countries as $country)
                    <option value="{{$country->id}}">{{$country->name_fr}}</option>
                @endforeach
            </select>
            <span  class="country help-block text-center text-danger"> </span>
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
                       id="password"
                       name="password"
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
                       data-toggle="password"
                >
                <div class="input-group-append">
                    <span class="input-group-text" id="alt-addon"><i class="fas fa-eye"></i></span>
                </div>
            </div>
        </div>

        <div class="form-group my-3">
            <button type="submit"  class="btn btn-block bg-bloo">Créer</button>
        </div>
    </form>


@stop

@section('script')
    <script>
        // Hide / Show password
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
            // When the form is submitted
            $("#login").submit(function (e) {
                e.preventDefault(); // Prevent the default form submission

                // Vérifiez si les champs de mot de passe correspondent
                if (!passwordsMatch()) {
                    $(".error-message").text("Les champs de mot de passe ne correspondent pas.");
                    setTimeout(function () {
                        $(".error-message").empty();
                    }, 5000);
                    return;
                }

                // Get CSRF token
                let csrfToken = $('meta[name="csrf-token"]').attr('content');
                // Get form data
                let formData = $(this).serialize();
                // Perform an AJAX request
                $.ajax({
                    type: "POST",
                    url: "{{ route('post.register') }}",
                    data: formData,
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    success: function (response) {
                        // Rediriger l'utilisateur vers la page de confirmation après un certain délai (facultatif)
                        setTimeout(function () {
                            window.location.href = response.redirect;
                        }, 2000);
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

            // Fonction pour vérifier si les champs de mot de passe correspondent
            function passwordsMatch() {
                let password = $("input[name='password']").val();
                let confirmPassword = $("input[name='password_confirmation']").val();
                return password === confirmPassword;
            }
        });
    </script>
@stop
