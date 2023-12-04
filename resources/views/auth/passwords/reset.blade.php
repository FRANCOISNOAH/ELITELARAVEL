@extends('layouts.auth')

@section('form')
    <form id="login" autocomplete="off">
        @csrf
        <div class="row">
            <div class="col-12">
                <h2 class="content-group-lg" style="margin-top: 0;">{{ __('Reset Password') }}
                </h2>

            </div>
        </div>


        <span id="errorContainer" class="error help-block text-center text-danger"> </span>
        <span  class="error-message help-block text-center text-danger"> </span>

        <input type="hidden" name="token" value="{{ $token }}">

        <span class="error-email help-block text-center text-danger"> </span>
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" id="alt-addon"><i class="fa fa-user"></i></span>
            </div>
            <input type="email" class="form-control" placeholder="Email" arial-label="Email"
                   aria-describedby="alt-addon" name="email" >
        </div>

        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" id="login-password"><i class="fa fa-lock"></i></span>
            </div>
            <input type="password" class="form-control"
                   placeholder="Mot de passe" arial-label="Password"
                   aria-describedby="login-password"
                   name="password"
                   data-toggle="password"
            >
            <div class="input-group-append">
                <span class="input-group-text" id="alt-addon"><i class="fas fa-eye"></i></span>
            </div>
        </div>

        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" id="login-password"><i class="fa fa-lock"></i></span>
            </div>
            <input type="password" class="form-control"
                   placeholder="Confirmation de mot de passe"
                   aria-describedby="login-password"
                   name="password_confirmation"
                   data-toggle="password"
            >
            <div class="input-group-append">
                <span class="input-group-text" id="alt-addon"><i class="fas fa-eye"></i></span>
            </div>
        </div>


        <div class="form-group">
            <button type="submit" class="btn btn-block bg-bloo">Connexion</button>
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
                    url: "{{ route('password.update') }}",
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
                        $(".error-message").empty(); // Vide le contenu précédent

                        for (let field in errors) {
                            if (errors.hasOwnProperty(field)) {
                                let errorHTML = "<span>" + errors[field].join(', ') + "</span><br>";
                                $(".error-message").append(errorHTML);
                            }
                        }
                        setTimeout(function () {
                            $(".error-message").empty();
                        }, 5000);
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
