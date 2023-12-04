@extends('layouts.auth')

@section('form')
    <form id="login"  autocomplete="off">
        @csrf
        <div class="row">
            <div class="col-12">
                <h2 class="content-group-lg" style="margin-top: 0;">{{ __('Reset Password') }}
                </h2>
                <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Ex quisquam consectetur,
                    vel nisi perferendis, voluptates recusandae animi est incidunt culpa sequi mollitia
                    aut nostrum non qui. Amet ut doloremque et!</p>
            </div>
        </div>

        <span class="error help-block text-center text-danger"></span>
        <span class="success help-block text-center text-success"></span>

        <div class="input-group mb-3">

            <div class="input-group-prepend">
                <span class="input-group-text" id="alt-addon"><i class="fa fa-user"></i></span>
            </div>

            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $email}}" required autocomplete="email" autofocus readonly />


            @error('email')
            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
            @enderror
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-block bg-bloo"> {{ __('Send Password Reset Link') }}</button>
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
                    url: "{{ route('password.email') }}",
                    data: formData,
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    success: function (response) {
                        if (response.success) {
                            $(".success").text(response.message).fadeIn().delay(3000).fadeOut();
                        }
                    },
                    error: function (error) {
                        console.log(error);
                        // Display a generic error message asynchronously
                        $(".error").text("An error occurred. Please try again.").fadeIn().delay(3000).fadeOut();
                    }
                });
            });
        });
    </script>
@stop
