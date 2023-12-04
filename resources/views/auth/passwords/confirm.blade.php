@extends('layouts.auth')

@section('form')
    <form id="login" autocomplete="off">
        @csrf
        <div class="row">
            <div class="col-12">
                <h1 class="content-group-lg" style="margin-top: 0;">Prenez le contrôle
                </h1>
                <div class="col-12 alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <strong>Votre mot de passe a ete reinitialisé avec success.</strong>
                </div>
            </div>
        </div>

        <span class="error help-block text-center text-danger"></span>
        <span  class="error-message help-block text-center text-danger"> </span>
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" id="alt-addon"><i class="fa fa-user"></i></span>
            </div>

            <input type="text" class="form-control" placeholder="Email" arial-label="Email"
                   aria-describedby="alt-addon" name="email"/>
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-block bg-bloo">Connexion</button>
        </div>
    </form>
@stop

@section('script')
    <script>
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
                    url: "{{ route('login.post') }}",
                    data: formData,
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    success: function (response) {
                        if (response.success) {
                            window.location.href = response.redirect;
                        } else {
                            if (response.errors && response.errors.email) {
                                $(".error").text(response.errors.email[0]).fadeIn().delay(3000).fadeOut();
                            } else {
                                $(".error").text("An error occurred. Please try again.").fadeIn().delay(3000).fadeOut();
                            }
                        }
                    },
                    error: function (error) {
                        // Handle other errors
                        console.error("Error:", error);
                        // Display a generic error message asynchronously
                        $(".error").text("An error occurred. Please try again.").fadeIn().delay(3000).fadeOut();
                    }
                });
            });
        });
    </script>
@stop
