@extends('layouts.auth')

@section('form')
    <form id="login" autocomplete="off">
        @csrf
        <div class="row">
            <div class="col-12">
                <h1 class="content-group-lg" style="margin-top: 0;">Prenez le contrôle
                </h1>
                <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Ex quisquam consectetur,
                    vel nisi perferendis, voluptates recusandae animi est incidunt culpa sequi mollitia
                    aut nostrum non qui. Amet ut doloremque et!</p>
            </div>
        </div>

        <span class="error-email help-block text-center text-danger"> </span>
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" id="alt-addon"><i class="fa fa-user"></i></span>
            </div>
            <input type="email" class="form-control" placeholder="Email" arial-label="Email"
                   aria-describedby="alt-addon" name="email" value="{{$email}}" readonly>
        </div>

        <span class="error-password help-block text-center text-danger"> </span>
        <span class="error help-block text-center text-danger"> </span>
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" id="login-password"><i class="fa fa-lock"></i></span>
            </div>
            <input type="password" class="form-control"
                   placeholder="Password" arial-label="Password"
                   aria-describedby="login-password"
                   name="password"
                   data-toggle="password"
            >
            <div class="input-group-append">
                <span class="input-group-text" id="alt-addon"><i class="fas fa-eye"></i></span>
            </div>
        </div>

        <a href="{{route('login')}}" class="mb-1">
            changer d'email ?
        </a>
        <a href="{{route('password.request',$email)}}" class="float-right mb-1">
            mot de passe oublié ?
        </a>

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
            $(document).ready(function () {
                // When the form is submitted
                $("#login").submit(function (e) {
                    e.preventDefault(); // Prevent the default form submission

                    // Get CSRF token
                    let csrfToken = $('meta[name="csrf-token"]').attr('content');

                    // Get form data
                    let formData = $(this).serialize();

                    // Perform an AJAX request
                    $.ajax({
                        type: "POST",
                        url: "{{ route('password.post') }}", // Replace with your actual login route
                        data: formData,
                        headers: {
                            'X-CSRF-TOKEN': csrfToken
                        },
                        success: function (response) {
                            if (response.success) {
                                window.location.href = response.redirect;
                            }else{
                                $(".error-email").text(response.message).fadeIn().delay(3000).fadeOut();
                                console.log();
                            }
                        },
                        error: function (error) {
                            console.log(error);
                            if(error.responseJSON){
                                if(error.responseJSON.errors.email[0]){
                                    $(".error-email").text(error.responseJSON.errors.email[0]).fadeIn().delay(3000).fadeOut();
                                }
                            }
                        }
                    });
                });

                // Link to change email
                $("a[href='#change-email']").on('click', function (e) {
                    e.preventDefault();
                });

                // Link for password recovery
                $("a[href='#password-recovery']").on('click', function (e) {
                    e.preventDefault();

                });
            });

            // Link to change email
            $("a[href='#change-email']").on('click', function (e) {
                e.preventDefault();

            });

            // Link for password recovery
            $("a[href='#password-recovery']").on('click', function (e) {
                e.preventDefault();

            });
        });
    </script>
@stop
