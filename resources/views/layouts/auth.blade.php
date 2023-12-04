@php
    use Illuminate\Support\Str;
    $r = \Route::current()->getAction();
    $route = (isset($r['as'])) ? $r['as'] : '';
@endphp
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bloo | Elite</title>
    <link rel="shortcut icon" href="{{asset("assets2/images/bloo_favicon.png")}}" />
    <!-- Google Fonts : Baloo 2, Roboto -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Baloo+2:wght@400;500;700&family=Rubik:wght@300&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/bbbootstrap/libraries@main/choices.min.css" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" />
    <link rel="stylesheet" href="{{asset("assets/css/style.css")}}" />
    <link rel="stylesheet" href="{{asset("assets/css/custom.css")}}" />
    <link rel="stylesheet" href="{{asset("assets/css/mystyle.admin.css")}}" />
    <style>
        #errorContainer {
            text-align: justify;
        }

        #errorContainer ul {
            list-style-type: none; /* Supprime les puces */
            padding: 0; /* Supprime le padding par défaut des listes */
        }

        #errorContainer ul li {
            margin-bottom: 5px; /* Ajoute un espacement entre les éléments de liste */
        }
    </style>

</head>
<body class="hold-transition sidebar-mini">

<section id="header">
    <div class="container">
        <div class="connection-info-0">
            <span class="bloo-color mr-3">Pas encore utilisateur ?</span>
            <a class="btn bloo-outline" href="{{route('register')}}">Créer un compte</a>
        </div>
        <div class="row d-flex justify-content-between py-3 align-items-center connection-bloc px-3">
            <a href="{{route('login')}}">
                <img class="logo" alt="Bloo" src="{{asset("assets/images/bloo_logo.png")}}">
            </a>

            <div class="connection-info align-items-center">
                <span class="bloo-color mr-3">Pas encore utilisateur ?</span>
                <a class="btn bloo-outline" href="{{route('register')}}">Créer un compte</a>
            </div>
        </div>
    </div>
</section>

<section id="content">
    <div class="container">
        <div class="row">
            <div class="col-md-8 offset-md-2 col-lg-6 offset-lg-3 form-container">
                @yield('form')
            </div>
        </div>
    </div>
</section>


<!-- REQUIRED SCRIPTS -->
<!-- jQuery -->

<!-- ✅ FIRST - load jquery ✅ -->
<script
    src="https://code.jquery.com/jquery-3.6.0.min.js"
    integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
    crossorigin="anonymous">
</script>

<!-- ✅ SECOND - load jquery validate ✅ -->
<script
    src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"
    integrity="sha512-37T7leoNS06R80c8Ulq7cdCDU5MNQBwlYoy1TX/WUsLFC2eYNqtKlV0QjH7r8JpG/S0GUMZwebnVFLPd6SU5yg=="
    crossorigin="anonymous"
    referrerpolicy="no-referrer">
</script>

<!-- ✅ THIRD - load additional methods ✅ -->
<script
    src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/additional-methods.min.js"
    integrity="sha512-XZEy8UQ9rngkxQVugAdOuBRDmJ5N4vCuNXCh8KlniZgDKTvf7zl75QBtaVG1lEhMFe2a2DuA22nZYY+qsI2/xA=="
    crossorigin="anonymous"
    referrerpolicy="no-referrer"
></script>
<!-- datatable -->


<!-- Bootstrap 4 -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T" crossorigin="anonymous"></script>

<!-- momentjs -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js" integrity="sha512-qTXRIMyZIFb8iQcfjXWCO8+M5Tbc38Qi5WzdPOYZHIlZpzBHG3L3by84BBBOiRGiEb7KKtAOAs5qYdUiZiQNNQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/locale/fr.min.js" integrity="sha512-RAt2+PIRwJiyjWpzvvhKAG2LEdPpQhTgWfbEkFDCo8wC4rFYh5GQzJBVIFDswwaEDEYX16GEE/4fpeDNr7OIZw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<!-- Tempusdominus Bootstrap 4 -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.39.0/js/tempusdominus-bootstrap-4.min.js" integrity="sha512-k6/Bkb8Fxf/c1Tkyl39yJwcOZ1P4cRrJu77p83zJjN2Z55prbFHxPs9vN7q3l3+tSMGPDdoH51AEU8Vgo1cgAA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<!-- AdminLTE App -->
<script src="{{asset("assets/js/dashboard/admin-lte/adminlte.min.js")}}"></script>
<script src="{{asset("assets/js/plugins/uniform.min.js")}}"></script>
<script src="{{asset("assets/js/custom/pages/validation.js")}}"></script>
{{--<script src="{{asset("assets/js/custom/pages/auth.js")}}"></script>--}}
<!-- Sweet Alert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/gh/bbbootstrap/libraries@main/choices.min.js"></script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script src="{{ asset('assets/js/custom/pages/response-summary.js') }}"></script>
@yield('script')
</body>
</html>
