<?php $subscription = \App\Subscription::where('user_id', auth()->user()->id)->get()->first(); ?>
@extends('admin.top-nav')
@section('page_title', trans('operations'))
@section('content-header')

@endsection

@section('content')
<div class="panel panel-flat panel-wb" style="margin-bottom: 0px">
    <div class="panel-body" style="padding: 0;">
        <div class="row">
            <div class="col-lg-9 col-xs-12">
                <!-- DONUT CHART -->
                <div class="box">
                    <div class="box-header with-border">
                        <p class="box-title" >{{trans('informations_generales')}} <span style="color: #0065A1; font-size:15px;">{{$operation->nom}}</span></p>
                    </div>
                    <div class="box-body">
                        <div class="col-sm-6 col-lg-3">
                            <div class="info">
                                <p class="label">{{ trans('Date_debut') }}</p>
                                <p class="info-value">{{$operation->date_start}}</p>
                            </div>
                            <div class="info">
                                <p class="label">{{ trans('Dat_fin') }}</p>
                                <p class="info-value">{{$operation->date_end}}</p>
                            </div>
                        </div>
                        <div class="col-sm-6 col-lg-3">
                            <div class="info">
                                <p class="label">Villes</p>
                                <p class="info-value">
                                    {{$Villes->count()}}
                                </p>
                            </div>
                            <div class="info">
                                <p class="label">Sites</p>
                                <p class="info-value">{{$operation->sites()->count()}}</p>
                            </div>
                        </div>
                        <div class="col-sm-6 col-lg-3">
                            <div class="info">
                                <p class="label">{{trans('Lecteurs') }}</p>
                                <p class="info-value">{{$operation->users()->where('role','0')->count()}}</p>
                            </div>
                            <div class="info">
                                <p class="label">{{ trans('Opérateurs') }}</p>
                                <p class="info-value">{{$operation->users()->where('role','1')->count()}}</p>
                            </div>
                        </div>
                        <div class="col-sm-6 col-lg-3">
{{--                            <div class="info">--}}
{{--                                <p class="label">{{ trans('Client') }}</p>--}}
{{--                                <p class="info-value">{{$operation->entreprise->nom}}</p>--}}
{{--                            </div>--}}
                            <div class="info">
                                <p class="label">{{ trans('Fondé') }}</p>
                                <p class="info-value">
{{--                                    @php--}}
{{--                                        $entreprise = $operation->entreprise()->with('users')->get()->last();--}}
{{--                                        $user = $entreprise->users()->get()->last();--}}
{{--                                    @endphp--}}
{{--                                    @if($user != null)--}}
{{--                                        {{ $user->first_name }} --}}
{{--                                    @endif--}}
                                </p>
                            </div>
                        </div>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
            <div class="col-lg-3 col-xs-12">
                <div class="box box-solid panel-wb">
                    <!-- /.box-header -->
                    <div class="box-body" style="padding: 0 ;">
                        <div class="row">
                            <div class="col-lg-12 col-xs-6">
                                <div class="small-box bg-white">
                                    <a href="{{ route('forms.show', [$operation->form->code]) }}" class="btn form-control">{{ trans('Afficher_le_questionnaire') }}</a>
                                </div>
                            </div>
                            <div class="col-lg-12 col-xs-6">
                                <div class="small-box bg-white">
                                    <a href="{{ route('operation.index') }}"  class="btn form-control">{{ trans('Selectionner_une_opération') }}</a>
                                </div>
                            </div>
                            @if(auth()->user()->role == 4)
                                @if($subscription->offer_id === 1)
                            <div class="col-lg-12 col-xs-6" id="token">
                                <div class="small-box bg-white">
                                    <a href="#"  class="btn form-control">{{trans("You still have")}}
                                       {{auth()->user()->getAccount()}} $</a>
                                </div>
                            </div>
                            @endif
                            @endif

                        </div>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
        </div>
    </div>
</div>

<div class="panel panel-flat panel-wb">
    <div class="panel-body" style="padding: 0;">
        <div class="row">
            <div class="col-md-9">
                <div class="box" style="height: 100%;">
                    <div class="box-header with-border">
                        <ul class="box-title" style="padding-left: 4px;">
                            <li>{{ trans('response_stats') }}</li>
                            <a class="dropdown-toggle" style="color:#0065A1; font-size:16px;" data-toggle="dropdown" href="#">
                                    {{ trans('sort_by') }}
                                </a>
                              <select id="countries"  class="browser-default custom-select custom-select-lg mb-3" style="font-size: 12px;">
                                 <option selected value="0">...</option>
                                 <option value="1">{{ trans('Country') }}</option>
                                 <option value="2"> {{ trans('Sites') }}</option>
                                  <option value="3">{{ trans('Cities') }}</option>
                                  <option value="4">{{ trans('Operators') }}</option>
                             </select>

                            <select id="select1" class="browser-default custom-select custom-select-lg mb-3" style="font-size: 12px; display:none;">

                            </select>
                            <select id="select2" class="browser-default custom-select custom-select-lg mb-3" style="font-size: 12px; display:none;">

                            </select>
                            <select id="select3" class="browser-default custom-select custom-select-lg mb-3" style="font-size: 12px; display:none;">

                            </select>
                            <select id="select4" class="browser-default custom-select custom-select-lg mb-3" style="font-size: 12px; display:none;">

                            </select>
                        </ul>
                        <span class="pull-right">
                            {{-- <i class="fa fa-file-powerpoint" style="font-size: 20px" aria-hidden="true"></i> --}}
                            <a id="download_pdf" >
                               <img src="{{ asset('assets/images/PDF_24.png') }}" ></img>
                             </a>
                            <a id="download_country_pdf" style="display: none" >
                               <img src="{{ asset('assets/images/PDF_24.png') }}" ></img>
                             </a>
                            <a id="download_site_pdf" style="display: none" >
                               <img src="{{ asset('assets/images/PDF_24.png') }}" ></img>
                             </a>
                            <a id="download_ville_pdf" style="display: none" >
                               <img src="{{ asset('assets/images/PDF_24.png') }}" ></img>
                             </a>
                            <a id="download_user_pdf" style="display: none" >
                               <img src="{{ asset('assets/images/PDF_24.png') }}" ></img>
                             </a>
                             @if (auth()->user()->hasRole('Superadmin|Client|Admin'))
                            <a href="{{ route('forms.response.export', $form->code) }}" id="download_exel">
                                <img src="{{ asset('assets/images/exel.png') }}" ></img>
                            </a>
                                <a id="download_country_exel" style="display: none">
                                <img src="{{ asset('assets/images/exel.png') }}" ></img>
                                </a>

                                <a id="download_site_exel" style="display: none">
                                <img src="{{ asset('assets/images/exel.png') }}" ></img>
                                </a>

                                <a id="download_ville_exel" style="display: none">
                                <img src="{{ asset('assets/images/exel.png') }}" ></img>
                                </a>

                                <a id="download_user_exel" style="display: none">
                                <img src="{{ asset('assets/images/exel.png') }}" ></img>
                                </a>
                            @endif
                        </span>
                    </div>

                    <div class="box-body row" id="responses">
                        {!! $view !!}
                    </div>

                    <!-- /.box-body -->
                </div>
            </div>
            <div class="col-md-3">

                @if(auth()->user()->role == 4)
                    @if($subscription->offer_id === 2)
                <div class="box box-success">
                    <div class="box-header">
                        <div class="row">

                            <div class="col-md-12">
                                <p class="box-title">
                                    {{ trans('Lecteurs') }}
                                </p>
                                @if (auth()->user()->hasRole('Superadmin|Client|Admin'))
                                    @if($operation->status != "TERMINER")
                                <i class="fa fa-plus-circle pull-right" aria-hidden="true" id="getlecteur" title="{{ $operation->id }}"
                                   data-toggle="modal"
                                   data-target="#modal-default"></i>
                                        @endif
                                @endif
                            </div>

                        </div>
                    </div>

                    <div class="box-body" id="lecteurs">
                        <table class="datatable table stripe">
                            <thead>
                            <tr>
                                <th></th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                          @foreach ($operation->users as $user )
                             @if ($user->role === 0)
                                 <tr>
                                     <td>
                                       {{ $user->first_name }}
                                      <span class="pull-right">
                                          @if (auth()->user()->hasRole('Superadmin|Client|Admin'))
                                              @if($operation->status != "TERMINER")
                                               <i class="fa fa-minus-circle removelecteur"  id="removelecteur" title="{{ $user->id }}"  lang="{{ $operation->id }}" aria-hidden="true"></i>
                                              @endif
                                        @endif
                                      </span>
                                    </td>
                                     <td>
                                          @if(Cache::has('user-is-online-' . $user->id))
                                                <li class="text-success">Online</li>
                                            @else
                                                <li class="text-secondary">Offline</li>
                                        @endif
                                     </td>
                                 </tr>
                              @endif
                          @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
                    @endif
                @endif

                <div class="box box-info">
                    <div class="box-header">
                        <div class="row">
                            <div class="col-md-12">
                                <p class="box-title">
                                    {{ trans('Opérateurs') }}
                                </p>
                                @if (auth()->user()->hasRole('Superadmin|Client|Admin'))
                                    @if($operation->status != "TERMINER")
                                         <i class="fa fa-plus-circle pull-right" aria-hidden="true" id="getoperateur" title="{{ $operation->id }}" data-toggle="modal" data-target="#operateur-default"></i>
                                    @endif
                                @endif
                            </div>
                            </div>
                    </div>

                    <div class="box-body" id="operateurs">
                        <table class="datatable table stripe">
                            <thead>
                            <tr>
                                <th></th>
                                <th></th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach ($operation->users as $user )
                                    @if ($user->role === 1)
                                <tr>
                                    @php
                                      $location = \App\Location::where('user_id',$user->id)->get()->last();
                                      $responce = \App\FormResponse::where('form_id',$operation->form_id)->where('respondent_id',$user->id)->get()->count();

                                    @endphp
                                    <td class="m_operateur"
                                    @if(!is_null($location))
                                        data_lat="{{$location->lat}}" data_lng="{{$location->lng}}"
                                    @endif
                                    >

                                        <span class="op_first_name">{{ $user->first_name }}</span>
                                        <span class="pull-right">
                                            @if (auth()->user()->hasRole('Superadmin|Client|Admin'))
                                                @if($operation->status != "TERMINER")
                                                            <i class="fa fa-minus-circle removeoperateur"  id="removeoperateur" title="{{ $user->id }}"  lang="{{ $operation->id }}" aria-hidden="true"></i>
                                                @endif
                                            @endif
                                       </span>
                                    </td>
                                    <td>
                                        @if(Cache::has('user-is-online-' . $user->id))
                                                <li class="text-success">Online</li>
                                            @else
                                                <li class="text-secondary">Offline</li>
                                        @endif

                                    </td>
                                    <td>
                                        <a href="{{route('AllPoints',[$operation->id,$user->id])}}" target="_blank">{{trans('Location')}}</a>
                                    </td>
                                </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                        <div class="text-center">
                            <a href="{{route("messages_index")}}">
                                <button class="btn btn-xs-bloo disabled m_btn_op m_btn_message">
                                    <i class="icon ions ion-chatboxes"></i>
                                    {{ trans('Message') }}
                                </button>
                            </a>
                            <button class="btn btn-xs-bloo disabled m_btn_op m_btn_location"><i class="icon ions ion-location"></i> {{ trans('Localisation') }}</button>
                        </div>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->

                <div class="box box-info">
                    <div class="box-header">
                        <div class="row">
                            <div class="col-md-12">
                                <p class="box-title" id="mapTitle">
                                    {{ trans('Localisation') }}
                                </p>
                            </div>
                        </div>

                    </div>

                    <div class="box-body" id="map_lecteurs">

                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->

            </div>
        </div>
    </div>
</div>


    <div id="print" style="display: none"  >
         <div class="box-body row" id="responsesprint" >
             {!! $viewprint !!}
         </div>
     </div>

    <div class="modal fade bd-example-modal-lg"  id="modal-default" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Fermer">
                    <span aria-hidden="true"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">×</font></font></span>
                </button>
                <h4 class="modal-title"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">{{ trans('add_lecteurs1')}}</font></font></h4>
            </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('ajoutlecteur') }}" name="lecteur" id="lecteur">
                        @csrf
                        <input type="hidden" name="operation" value="{{ $operation->id }}" />
                        <div id="datalecteurs">

                        </div>
                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Fermer</font></font></button>
                        <button type="submit" class="btn btn-primary"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">{{ trans('savee') }}</font></font></button>
                    </form>
                </div>
                <div class="modal-footer">

                </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<div class="modal fade" id="operateur-default" style="display: none;">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Fermer">
                <span aria-hidden="true"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">×</font></font></span></button>
                <h4 class="modal-title"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">{{ trans('add_ops') }}</font></font></h4>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('ajoutoperateur') }}" name="operateur" id="operateur">
                    @csrf
                    <input type="hidden" name="operation" value="{{ $operation->id }}" />
                    <div id="dataoperateurs">

                    </div>
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">{{ trans('Close') }}</font></font></button>
                    <button type="submit" class="btn btn-primary" id="send" ><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">{{ trans('savee') }}</font></font></button>
                </form>
            </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

@endsection

@section('laraform_script1')
    <script src="{{ asset('assets/js/plugins/pace.min.js') }}"></script>

    <script src="{{ asset('assets/js/core/libraries/jquery.min.js') }}"></script>

    <script src="{{ asset('assets/js/core/libraries/bootstrap.min.js') }}"></script>

    <script src="{{ asset('assets/js/plugins/blockui.min.js') }}"></script>

    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD4bZln12ut506FLipFx-kXh95M-zZdUfc&libraries=places&callback=initMap" defer></script>

    <script type="text/javascript">
    </script>

    <script type="text/javascript">
        function scrollToAnchor(hash) {

            tag = $(hash);

            $('html,body').animate({scrollTop: tag.offset().top}, 'slow', function() {
                window.location.hash = hash
            });
        }
        function initMap() {
            let lat = "";
            let lng = "";
            let first_name = "";
            let last_name = "";

            let map = new google.maps.Map(document.getElementById("map_lecteurs"), {
                center: { lat: 4.050000, lng: 9.700000 },
                zoom: 15
            });

            $('.m_operateur').click(function(){
                if($(this).hasClass('op_active')){
                    lat = "";
                    lng = "";
                    first_name = "";
                    last_name = "";

                    $(this).removeClass('op_active');
                    $('.m_btn_op').addClass('disabled');
                }else{
                    lat = $(this).attr("data_lat");
                    lng = $(this).attr("data_lng");
                    first_name = $(this).find(".op_first_name").html();
                    last_name = $(this).find(".op_last_name").html();
                    $(this).addClass('op_active');
                    $('.m_btn_op').removeClass('disabled');
                }
            });

            $('.m_btn_location').click(function(e){
                if($(e.target).hasClass('disabled'))
                    return

                let tagId = e.target.id;
                scrollToAnchor('#'+tagId);

                let position = { lat: parseFloat(lat), lng: parseFloat(lng) };

                map.setCenter(position);
                let marker = new google.maps.Marker({
                    position: position,
                    map,
                    animation: google.maps.Animation.DROP
                });
                let contentString = "" +
                    "<div class=\"infowindow-content\">\n" +
                    "    <span class=\"place-name title\">"+ first_name + "</span><br>" +
                    "    <span class=\"place-address\">"+ last_name +"</span>\n" +
                    "</div>";

                let infowindow = new google.maps.InfoWindow({
                    content: contentString
                    });
                marker.addListener("click", () => {
                    infowindow.open(map, marker);
                });
            });
        }

        function addlecteur() {
            $('#listlecteur').on('click', function (e) {

                let lecteur_id = e.target.id;

            });
        }

        $('#getlecteur').on('click', function (e) {

            let operation_id = e.target.title;
            $.get('/listlecteurs/' + operation_id, function (data) {
                 $('#datalecteurs').empty();
                 $('#datalecteurs').append(data);
            });
        });

        $('.removelecteur').on('click', function (e) {

            let operation_id = e.target.lang;
            let user_id = e.target.title;
            $.get('/removelecteurs/' + user_id + '/' + operation_id , function (data) {
                if(data && $.parseJSON('true') == true){
                    $(e.target).parents('tr').remove();
                }
            });
        });

        $('.removeoperateur').on('click', function (e) {

            let operation_id = e.target.lang;
            let user_id = e.target.title;
            $.get('/removeoperateurs/' + user_id + '/' + operation_id , function (data) {
                if(data && $.parseJSON('true') == true){
                    $(e.target).parents('tr').remove();
                    $.get('/json-operateurstable/' + operation_id, function (data) {
                        $(e.target).parents('tr').remove();
                        $('#token').empty();
                        @if(auth()->user()->payg === 1)
                        $('#token').append(data);
                        @endif
                    });
                }
            });
        });

        $('#getoperateur').on('click', function (e) {
            let operation_id = e.target.title;
            $.get('/listoperateurs/' + operation_id, function (data) {
                $('#dataoperateurs').empty();
                $('#dataoperateurs').append(data);
            });
        });
    </script>

    <script type="text/javascript">


        let printpdf = () => {

            let now = new Date();
            let annee   = now.getFullYear();
            let mois    = now.getMonth() + 1;
            let jour    = now.getDate();
            let imgData = 'data:image/png;base64,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'
            let element = document.getElementById('responsesprint');
            let opt = {
                margin:      [20, 20, 20, 20] ,
                pagebreak: { mode: ['avoid-all', 'css', 'legacy'] },
                enableLinks: true,
                filename:     '{{$operation->nom}}.pdf',
                image:        { type: 'jpeg', quality: .95 },
                html2canvas:  {scale: 1},
                jsPDF:        { unit: 'mm', format: 'letter', orientation: 'landscape' }
            };

            html2pdf().from(element).set(opt).toPdf().get('pdf').then(function (pdf) {
                let totalPages = pdf.internal.getNumberOfPages();

                for (i = 1; i <= totalPages; i++) {
                    pdf.setPage(i);
                    // pdf.addFont('Baloo-Regular.ttf', 'custom', 'normal');
                    //
                    // pdf.setFont('custom');
                    pdf.setFont("helvetica");
                    pdf.setFontSize(10);
                    pdf.setFontType("bolditalic");

                    @if( app()->getLocale() === "fr" )
                    pdf.text('Page ' + i + '/' + totalPages,  260, 210);
                    pdf.text('Imprimé le : '+jour+"/"+mois+"/"+annee ,05, 275);
                    @endif

                    @if( app()->getLocale() === "en")
                    pdf.text('Page ' + i + '/' + totalPages,  260, 210);
                    pdf.text('Printed on : '+jour+"/"+mois+"/"+annee, 05, 210);
                    @endif

                    @if( app()->getLocale() === "pt")
                    pdf.text('Página ' + i + '/' + totalPages,  260, 210);
                    pdf.text('Imprima : '+jour+"/"+mois+"/"+annee ,05, 210);
                    @endif

                    pdf.addImage(imgData, "PNG",  258, 05);
                    pdf.text('{{$operation->nom}}',05,12);
                }
            }).save();
        };

        function reload(){
            window.location.reload();
        }

        document.getElementById('download_pdf').onclick = function () {
            // Simple Slide

            let impresion =  document.getElementById('print');
            impresion.style.display = 'block';
            impresion.style.visibility = 'hidden';
            let data_for_chart2 = {!! json_encode($data_for_chart2) !!};

            if (typeof data_for_chart2 === 'object' && data_for_chart2 instanceof Array && data_for_chart2.length) {
                google.charts.setOnLoadCallback(function () {
                    drawCharts(data_for_chart2);
                    printpdf();
                    setInterval(reload, 3000)
                });
            }

        };
    </script>
@endsection

@section('page-script')
    <script>
        $(function() {

            $('.datatable').DataTable(
                {
                    "bLengthChange" : false, //thought this line could hide the LengthMenu
                    "searching": false,
                    "language": {
                        @if( app()->getLocale() === "fr" )
                        "url": "//cdn.datatables.net/plug-ins/1.10.21/i18n/French.json"
                        @endif
                            @if( app()->getLocale() === "en")
                        "url": "//cdn.datatables.net/plug-ins/1.10.21/i18n/English.json"
                        @endif
                            @if( app()->getLocale() === "es")
                        "url": "//cdn.datatables.net/plug-ins/1.10.21/i18n/Spanish.json"
                        @endif
                            @if( app()->getLocale() === "pt")
                        "url": "//cdn.datatables.net/plug-ins/1.10.21/i18n/Portuguese.json"
                        @endif
                    }

                })
        });
    </script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

    <script src="{{ asset('assets/js/custom/pages/response-summary.js') }}"></script>

    <script>
        google.charts.load('current', {'packages':['corechart']});

        let data_for_chart = {!! json_encode($data_for_chart) !!};
        if (typeof data_for_chart === 'object' && data_for_chart instanceof Array && data_for_chart.length) {
            google.charts.setOnLoadCallback(function () {
                 drawCharts(data_for_chart);
            });
        }


        let data_for_chart2 = {!! json_encode($data_for_chart2) !!};
        if (typeof data_for_chart2 === 'object' && data_for_chart2 instanceof Array && data_for_chart2.length) {
            google.charts.setOnLoadCallback(function () {
                drawCharts(data_for_chart2);
             });
        }


        $(function () {
            // Resize chart on sidebar width change and window resize
            $(window).on('resize', function () {
                drawCharts(data_for_chart);
            });
        });
    </script>

    <script>

        // Enable pusher logging - don't include this in production
        Pusher.logToConsole = true;

        let pusher = new Pusher('1702f90c00112df631a4', {
            cluster: 'ap2'
        });
        let channel = pusher.subscribe('responce-channel');
        channel.bind('my-event', function(data) {
            // alert(JSON.stringify(data));
            // location.reload(true);
            $.get('/operation/{!! $operation->id !!}' ,function(response) {
                $('#responses').empty()
                    .append(response.response_view);

                $('#responsesprint').empty()
                    .append(response.response_view2)

                $('#operateurs').empty()
                    .append(response.response_operateurs);

                $(function() {
                    $('#datatable2').DataTable(
                        {
                            "bLengthChange" : false, //thought this line could hide the LengthMenu
                            "searching": false,
                            "language": {
                                @if( app()->getLocale() === "fr" )
                                "url": "//cdn.datatables.net/plug-ins/1.10.21/i18n/French.json"
                                @endif
                                    @if( app()->getLocale() === "en")
                                "url": "//cdn.datatables.net/plug-ins/1.10.21/i18n/English.json"
                                @endif
                                    @if( app()->getLocale() === "es")
                                "url": "//cdn.datatables.net/plug-ins/1.10.21/i18n/Spanish.json"
                                @endif
                                    @if( app()->getLocale() === "pt")
                                "url": "//cdn.datatables.net/plug-ins/1.10.21/i18n/Portuguese.json"
                                @endif
                            }

                        })
                });



                data_for_chart = JSON.parse(response.data_for_chart);
                drawCharts(data_for_chart);

                // data_for_chart2 = JSON.parse(response.data_for_chart2);
                // drawCharts(data_for_chart2);

                $(function () {
                    // Resize chart on sidebar width change and window resize
                    $(window).on('resize', function () {
                        drawCharts(data_for_chart);
                        // drawCharts(data_for_chart2);
                    });
                });
            });

        });
    </script>

    <script>
        $('#countries').on('change', function(e){

            let sortoption  = e.target.value;

            if(sortoption == 0)
            {
                $.get('/operation/'+'{{$operation->id}}',function(response) {

                    let element1 = document.getElementById('select1');
                    let element2 = document.getElementById('select2');
                    let element3 = document.getElementById('select3');
                    let element4 = document.getElementById('select4');
                    element1.style.display = "none";
                    element2.style.display = "none";
                    element3.style.display = "none";
                    element4.style.display = "none";

                    let button1 = document.getElementById('download_pdf');
                    let button2 = document.getElementById('download_country_pdf');
                    let button3 = document.getElementById('download_site_pdf');
                    let button4 = document.getElementById('download_ville_pdf');
                    let button5 = document.getElementById('download_user_pdf');

                    let button6 = document.getElementById('download_exel');
                    let button7 = document.getElementById('download_country_exel');
                    let button8 = document.getElementById('download_site_exel');
                    let button9 = document.getElementById('download_ville_exel');
                    let button10 = document.getElementById('download_user_exel');

                    button1.style.display = "initial";
                    button2.style.display = "none";
                    button3.style.display = "none";
                    button4.style.display = "none";
                    button5.style.display = "none";

                    button6.style.display = "initial";
                    button7.style.display = "none";
                    button8.style.display = "none";
                    button9.style.display = "none";
                    button10.style.display = "none";

                    $('#responses').empty()
                        .append(response.response_view);

                    data_for_chart = JSON.parse(response.data_for_chart);

                    drawCharts(data_for_chart);

                    $('#responsesprint').empty()
                        .append(response.response_view2);


                    // data_for_chart2 = JSON.parse(response.data_for_chart2);
                    //
                    // drawCharts(data_for_chart2);

                    $(function () {
                        // Resize chart on sidebar width change and window resize
                        $(window).on('resize', function () {
                            drawCharts(data_for_chart);
                        });
                    });

                    document.getElementById('download_country_pdf').onclick = function () {
                        let impresion =  document.getElementById('print');
                        impresion.style.display = 'initial';
                        impresion.style.visibility = 'hidden';
                        data_for_chart2 = JSON.parse(response.data_for_chart2);
                        drawCharts(data_for_chart2);
                        printpdf();
                        setInterval(reload, 3000);
                    };

                });

            }
            if(sortoption == 1)
            {
                $.get('/jsonmapcountries2',function(data) {
                    $('#select1').empty();
                    let element1 = document.getElementById('select1');
                    let element2 = document.getElementById('select2');
                    let element3 = document.getElementById('select3');
                    let element4 = document.getElementById('select4');

                    element1.style.display = "initial";
                    element2.style.display = "none";
                    element3.style.display = "none";
                    element4.style.display = "none";

                    $('#select1').append('<option value="Selectionnez un pays">@lang('Select a country')</option>');
                    $.each(data, function(index, countriesObj){
                        $('#select1').append('<option value="'+ countriesObj.id +'">'+ countriesObj.name +'</option>');
                    })
                });

            }
            if(sortoption == 2)
            {
                $.get('/operationsites/'+{{$operation->id}},function(data) {
                    $('#select2').empty();
                    let element1 = document.getElementById('select1');
                    let element2 = document.getElementById('select2');
                    let element3 = document.getElementById('select3');
                    let element4 = document.getElementById('select4');
                    element1.style.display = "none";
                    element2.style.display = "initial";
                    element3.style.display = "none";
                    element4.style.display = "none";
                  ;
                    $('#select2').append('<option value="Selectionnez un site">@lang('Select a site')</option>');
                    $.each(data, function(index, sitesObj){
                        $('#select2').append('<option value="'+ sitesObj.id +'">'+ sitesObj.nom +'</option>');
                    })
                });
            }
            if(sortoption == 3)
            {
                $.get('/operationvilles/'+{{$operation->id}},function(data) {

                    $('#select3').empty();
                    let element1 = document.getElementById('select1');
                    let element2 = document.getElementById('select2');
                    let element3 = document.getElementById('select3');
                    let element4 = document.getElementById('select4');
                    element1.style.display = "none";
                    element2.style.display = "none";
                    element3.style.display = "initial";
                    element4.style.display = "none";
                    $('#select3').append('<option value="Selectionnez une ville">@lang('Select a city')</option>');
                    $.each(data, function(index, sitesObj){
                        $('#select3').append('<option value="'+ sitesObj.id +'">'+ sitesObj.name +'</option>');
                    })
                });
            }

            if(sortoption == 4)
            {
                $.get('/tryoperateurs/'+{{$operation->id}},function(data) {

                    $('#select4').empty();
                    let element1 = document.getElementById('select1');
                    let element2 = document.getElementById('select2');
                    let element3 = document.getElementById('select3');
                    let element4 = document.getElementById('select4');
                    element1.style.display = "none";
                    element2.style.display = "none";
                    element3.style.display = "none";
                    element4.style.display = "initial";

                    $('#select4').append('<option value="Selectionnez une ville">@lang('Select an operator')</option>');
                    $.each(data, function(index, sitesObj){
                        $('#select4').append('<option value="'+ sitesObj.id +'">'+ sitesObj.first_name + ' ' + sitesObj.last_name +' </option>');
                    })
                });
            }

        });

        $('#select1').on('change', function(e){
            let pays_id = e.target.value;
            {
                $.get('/operation/'+'{{$operation->id}}'+'/'+ pays_id,function(response) {

                    let button1 = document.getElementById('download_pdf');
                    let button2 = document.getElementById('download_country_pdf');
                    let button3 = document.getElementById('download_site_pdf');
                    let button4 = document.getElementById('download_ville_pdf');
                    let button5 = document.getElementById('download_user_pdf');

                    let button6 = document.getElementById('download_exel');
                    let button7 = document.getElementById('download_country_exel');
                    let button8 = document.getElementById('download_site_exel');
                    let button9 = document.getElementById('download_ville_exel');
                    let button10 = document.getElementById('download_user_exel');

                    button1.style.display = "none";
                    button2.style.display = "initial";
                    button3.style.display = "none";
                    button4.style.display = "none";
                    button5.style.display = "none";

                    button6.style.display = "none";
                    button7.style.display = "initial";
                    button8.style.display = "none";
                    button9.style.display = "none";
                    button10.style.display = "none";

                    $('#responses').empty()
                        .append(response.response_view);

                    data_for_chart = JSON.parse(response.data_for_chart);

                    drawCharts(data_for_chart);

                    $('#responsesprint').empty()
                        .append(response.response_view2);


                    // data_for_chart2 = JSON.parse(response.data_for_chart2);
                    //
                    // drawCharts(data_for_chart2);

                    $(function () {
                        // Resize chart on sidebar width change and window resize
                        $(window).on('resize', function () {
                            drawCharts(data_for_chart);
                        });
                    });

                    document.getElementById('download_country_pdf').onclick = function () {
                        let impresion =  document.getElementById('print');
                        impresion.style.display = 'initial';
                        impresion.style.visibility = 'hidden';
                        data_for_chart2 = JSON.parse(response.data_for_chart2);
                        drawCharts(data_for_chart2);
                        printpdf();
                        setInterval(reload, 3000);
                    };
                    document.getElementById('download_country_exel').onclick = function () {
                        window.location.href='/forms/'+'{{$form->code}}'+'/responses/download/'+pays_id;
                    };
                });
            }
        });

        $('#select2').on('change', function(e){
            let site_id = e.target.value;
            {
                $.get('/siteoperation/'+'{{$operation->id}}'+'/'+ site_id,function(response) {


                    let button1 = document.getElementById('download_pdf');
                    let button2 = document.getElementById('download_country_pdf');
                    let button3 = document.getElementById('download_site_pdf');
                    let button4 = document.getElementById('download_ville_pdf');
                    let button5 = document.getElementById('download_user_pdf');

                    let button6 = document.getElementById('download_exel');
                    let button7 = document.getElementById('download_country_exel');
                    let button8 = document.getElementById('download_site_exel');
                    let button9 = document.getElementById('download_ville_exel');
                    let button10 = document.getElementById('download_user_exel');

                    button1.style.display = "none";
                    button2.style.display = "none";
                    button3.style.display = "initial";
                    button4.style.display = "none";
                    button5.style.display = "none";

                    button6.style.display = "none";
                    button7.style.display = "none";
                    button8.style.display = "initial";
                    button9.style.display = "none";
                    button10.style.display = "none";


                    $('#responses').empty()
                        .append(response.response_view);

                    data_for_chart = JSON.parse(response.data_for_chart);

                    drawCharts(data_for_chart);

                    $('#responsesprint').empty()
                        .append(response.response_view2);

                    $(function () {
                        // Resize chart on sidebar width change and window resize
                        $(window).on('resize', function () {
                            drawCharts(data_for_chart);
                        });
                    });

                    document.getElementById('download_site_pdf').onclick = function () {
                        let impresion =  document.getElementById('print');
                        impresion.style.display = 'initial';
                        impresion.style.visibility = 'hidden';
                        data_for_chart2 = JSON.parse(response.data_for_chart2);
                        drawCharts(data_for_chart2);
                        printpdf();
                        setInterval(reload, 3000);
                    };
                    document.getElementById('download_site_exel').onclick = function () {
                        window.location.href='/forms/'+'{{$form->code}}'+'/responses/downloadsite/'+site_id;
                    };
                });
            }
        });

        $('#select3').on('change', function(e){
            let ville = e.target.value;
            {
                $.get('/villeoperation/'+'{{$operation->id}}'+'/'+ ville,function(response) {

                    let button1 = document.getElementById('download_pdf');
                    let button2 = document.getElementById('download_country_pdf');
                    let button3 = document.getElementById('download_site_pdf');
                    let button4 = document.getElementById('download_ville_pdf');
                    let button5 = document.getElementById('download_user_pdf');

                    let button6 = document.getElementById('download_exel');
                    let button7 = document.getElementById('download_country_exel');
                    let button8 = document.getElementById('download_site_exel');
                    let button9 = document.getElementById('download_ville_exel');
                    let button10 = document.getElementById('download_user_exel');

                    button1.style.display = "none";
                    button2.style.display = "none";
                    button3.style.display = "none";
                    button4.style.display = "initial";
                    button5.style.display = "none";

                    button6.style.display = "none";
                    button7.style.display = "none";
                    button8.style.display = "none";
                    button9.style.display = "initial";
                    button10.style.display = "none";

                    $('#responses').empty()
                        .append(response.response_view);

                    data_for_chart = JSON.parse(response.data_for_chart);

                    drawCharts(data_for_chart);

                    $('#responsesprint').empty()
                        .append(response.response_view2);

                    $(function () {
                        // Resize chart on sidebar width change and window resize
                        $(window).on('resize', function () {
                            drawCharts(data_for_chart);
                        });
                    });

                    document.getElementById('download_ville_pdf').onclick = function () {
                        let impresion =  document.getElementById('print');
                        impresion.style.display = 'initial';
                        impresion.style.visibility = 'hidden';
                        data_for_chart2 = JSON.parse(response.data_for_chart2);
                        drawCharts(data_for_chart2);
                        printpdf();
                        setInterval(reload, 3000);
                    };
                    document.getElementById('download_ville_exel').onclick = function () {
                        window.location.href='/forms/'+'{{$form->code}}'+'/responses/downloadville/'+ville;
                    };
                });
            }
        });

        $('#select4').on('change', function(e){
            let userid = e.target.value;
            {
                $.get('/useroperation/'+'{{$operation->id}}'+'/'+ userid,function(response) {

                    let button1 = document.getElementById('download_pdf');
                    let button2 = document.getElementById('download_country_pdf');
                    let button3 = document.getElementById('download_site_pdf');
                    let button4 = document.getElementById('download_ville_pdf');
                    let button5 = document.getElementById('download_user_pdf');

                    let button6 = document.getElementById('download_exel');
                    let button7 = document.getElementById('download_country_exel');
                    let button8 = document.getElementById('download_site_exel');
                    let button9 = document.getElementById('download_ville_exel');
                    let button10 = document.getElementById('download_user_exel');

                    button1.style.display = "none";
                    button2.style.display = "none";
                    button3.style.display = "none";
                    button4.style.display = "none";
                    button5.style.display = "initial";

                    button6.style.display = "none";
                    button7.style.display = "none";
                    button8.style.display = "none";
                    button9.style.display = "none";
                    button10.style.display = "initial";

                    $('#responses').empty()
                        .append(response.response_view);

                    data_for_chart = JSON.parse(response.data_for_chart);

                    drawCharts(data_for_chart);

                    $('#responsesprint').empty()
                        .append(response.response_view2);

                    $(function () {
                        // Resize chart on sidebar width change and window resize
                        $(window).on('resize', function () {
                            drawCharts(data_for_chart);
                        });
                    });

                    document.getElementById('download_ville_pdf').onclick = function () {
                        let impresion =  document.getElementById('print');
                        impresion.style.display = 'initial';
                        impresion.style.visibility = 'hidden';
                        data_for_chart2 = JSON.parse(response.data_for_chart2);
                        drawCharts(data_for_chart2);
                        printpdf();
                        setInterval(reload, 3000);
                    };
                    document.getElementById('download_user_exel').onclick = function () {
                        window.location.href='/forms/'+'{{$form->code}}'+'/responses/downloaduser/'+userid;
                    };
                });
            }
        });
    </script>
@endsection

@section('plugin-scripts')
    <script src="{{ asset('assets/js/plugins/bootbox.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/select2.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/datatables/extension-responsive.min.js') }}"></script>
@endsection
