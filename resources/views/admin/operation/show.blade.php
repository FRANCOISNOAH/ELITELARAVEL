@extends("layouts.admin4")

@section('title','Dashbord')

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
            $('html,body').animate({scrollTop: tag.offset().top}, 'slow', function () {
                window.location.hash = hash
            });
        }

        function initMap() {
            let lat = "";
            let lng = "";
            let first_name = "";
            let last_name = "";

            let map = new google.maps.Map(document.getElementById("map_lecteurs"), {
                center: {lat: 4.050000, lng: 9.700000},
                zoom: 15
            });

            $('.m_operateur').click(function () {
                if ($(this).hasClass('op_active')) {
                    lat = "";
                    lng = "";
                    first_name = "";
                    last_name = "";

                    $(this).removeClass('op_active');
                    $('.m_btn_op').addClass('disabled');
                } else {
                    lat = $(this).attr("data_lat");
                    lng = $(this).attr("data_lng");
                    first_name = $(this).find(".op_first_name").html();
                    last_name = $(this).find(".op_last_name").html();
                    $(this).addClass('op_active');
                    $('.m_btn_op').removeClass('disabled');
                }
            });

            $('.m_btn_location').click(function (e) {
                if ($(e.target).hasClass('disabled'))
                    return

                let tagId = e.target.id;
                scrollToAnchor('#' + tagId);

                let position = {lat: parseFloat(lat), lng: parseFloat(lng)};

                map.setCenter(position);
                let marker = new google.maps.Marker({
                    position: position,
                    map,
                    animation: google.maps.Animation.DROP
                });
                let contentString = "" +
                    "<div class=\"infowindow-content\">\n" +
                    "    <span class=\"place-name title\">" + first_name + "</span><br>" +
                    "    <span class=\"place-address\">" + last_name + "</span>\n" +
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

        $('.removelecteur').on('click', function (e) {
            let operation_id = e.target.lang;
            let user_id = e.target.title;
            $.get('/removelecteurs/' + user_id + '/' + operation_id, function (data) {
                if (data && $.parseJSON('true') == true) {
                    $(e.target).parents('tr').remove();
                }
            });
        });

        $('.removeoperateur').on('click', function (e) {
            let user_id = e.target.dataset.userid;
            $.get('/removeOperateurs/' + user_id + '/' + {{$operation->id}}, function (data) {
                if (data && $.parseJSON('true') === true) {
                    $(e.target).parents('tr').remove();
                }
            });
        });

        $('#getoperateur').on('click', function (e) {
            $.get('/getOperateursList/' + {{$operation->id}}, function (data) {
                $('#content').empty().append(data);
            });
        })

        $('#getlecteur').on('click', function (e) {
            $.get('/getLecteursList/' + {{$operation->id}}, function (data) {
                $('#contentlecteur').empty().append(data);
            });
        });
    </script>

    <script type="text/javascript">
        let printpdf = () => {

            let now = new Date();
            let annee = now.getFullYear();
            let mois = now.getMonth() + 1;
            let jour = now.getDate();
            let imgData = 'data:image/png;base64,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'
            let element = document.getElementById('responsesprint');
            let opt = {
                margin: [20, 20, 20, 20],
                pagebreak: {mode: ['avoid-all', 'css', 'legacy']},
                enableLinks: true,
                filename: '{{$operation->nom}}.pdf',
                image: {type: 'jpeg', quality: .95},
                html2canvas: {scale: 1},
                jsPDF: {unit: 'mm', format: 'letter', orientation: 'landscape'}
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
                    pdf.text('Page ' + i + '/' + totalPages, 260, 210);
                    pdf.text('Imprimé le : ' + jour + "/" + mois + "/" + annee, 05, 275);
                    @endif

                    @if( app()->getLocale() === "en")
                    pdf.text('Page ' + i + '/' + totalPages, 260, 210);
                    pdf.text('Printed on : ' + jour + "/" + mois + "/" + annee, 05, 210);
                    @endif

                    @if( app()->getLocale() === "pt")
                    pdf.text('Página ' + i + '/' + totalPages, 260, 210);
                    pdf.text('Imprima : ' + jour + "/" + mois + "/" + annee, 05, 210);
                    @endif

                    pdf.addImage(imgData, "PNG", 258, 05);
                    pdf.text('{{$operation->nom}}', 05, 12);
                }
            }).save();
        };

        function reload() {
            window.location.reload();
        }

        document.getElementById('download_pdf').onclick = function () {
            // Simple Slide

            let impresion = document.getElementById('print');
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
        $(function () {

            $('.datatable').DataTable(
                {
                    "bLengthChange": false, //thought this line could hide the LengthMenu
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
        google.charts.load('current', {'packages': ['corechart']});

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
        {{--Pusher.logToConsole = true;--}}

        {{--let pusher = new Pusher('1702f90c00112df631a4', {--}}
        {{--    cluster: 'ap2'--}}
        {{--});--}}
        {{--let channel = pusher.subscribe('responce-channel');--}}
        {{--channel.bind('my-event', function (data) {--}}
        {{--    // alert(JSON.stringify(data));--}}
        {{--    // location.reload(true);--}}
        {{--    $.get('/operation/{!! $operation->id !!}', function (response) {--}}
        {{--        $('#responses').empty()--}}
        {{--            .append(response.response_view);--}}

        {{--        $('#responsesprint').empty()--}}
        {{--            .append(response.response_view2)--}}

        {{--        $('#operateurs').empty()--}}
        {{--            .append(response.response_operateurs);--}}

        {{--        $(function () {--}}
        {{--            $('#datatable2').DataTable(--}}
        {{--                {--}}
        {{--                    "bLengthChange": false, //thought this line could hide the LengthMenu--}}
        {{--                    "searching": false,--}}
        {{--                    "language": {--}}
        {{--                        @if( app()->getLocale() === "fr" )--}}
        {{--                        "url": "//cdn.datatables.net/plug-ins/1.10.21/i18n/French.json"--}}
        {{--                        @endif--}}
        {{--                            @if( app()->getLocale() === "en")--}}
        {{--                        "url": "//cdn.datatables.net/plug-ins/1.10.21/i18n/English.json"--}}
        {{--                        @endif--}}
        {{--                            @if( app()->getLocale() === "es")--}}
        {{--                        "url": "//cdn.datatables.net/plug-ins/1.10.21/i18n/Spanish.json"--}}
        {{--                        @endif--}}
        {{--                            @if( app()->getLocale() === "pt")--}}
        {{--                        "url": "//cdn.datatables.net/plug-ins/1.10.21/i18n/Portuguese.json"--}}
        {{--                        @endif--}}
        {{--                    }--}}

        {{--                })--}}
        {{--        });--}}


        {{--        data_for_chart = JSON.parse(response.data_for_chart);--}}
        {{--        drawCharts(data_for_chart);--}}

        {{--        // data_for_chart2 = JSON.parse(response.data_for_chart2);--}}
        {{--        // drawCharts(data_for_chart2);--}}

        {{--        $(function () {--}}
        {{--            // Resize chart on sidebar width change and window resize--}}
        {{--            $(window).on('resize', function () {--}}
        {{--                drawCharts(data_for_chart);--}}
        {{--                // drawCharts(data_for_chart2);--}}
        {{--            });--}}
        {{--        });--}}
        {{--    });--}}

        {{--});--}}
    </script>

    <script>
        $('#countries').on('change', function (e) {

            let sortoption = e.target.value;

            if (sortoption == 0) {
                $.get('/operation/' + '{{$operation->id}}', function (response) {

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
                        let impresion = document.getElementById('print');
                        impresion.style.display = 'initial';
                        impresion.style.visibility = 'hidden';
                        data_for_chart2 = JSON.parse(response.data_for_chart2);
                        drawCharts(data_for_chart2);
                        printpdf();
                        setInterval(reload, 3000);
                    };

                });

            }
            if (sortoption == 1) {
                $.get('/jsonmapcountries2', function (data) {
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
                    $.each(data, function (index, countriesObj) {
                        $('#select1').append('<option value="' + countriesObj.id + '">' + countriesObj.name + '</option>');
                    })
                });

            }
            if (sortoption == 2) {
                $.get('/operationsites/' + {{$operation->id}}, function (data) {
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
                    $.each(data, function (index, sitesObj) {
                        $('#select2').append('<option value="' + sitesObj.id + '">' + sitesObj.nom + '</option>');
                    })
                });
            }
            if (sortoption == 3) {
                $.get('/operationvilles/' + {{$operation->id}}, function (data) {

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
                    $.each(data, function (index, sitesObj) {
                        $('#select3').append('<option value="' + sitesObj.id + '">' + sitesObj.name + '</option>');
                    })
                });
            }

            if (sortoption == 4) {
                $.get('/tryoperateurs/' + {{$operation->id}}, function (data) {

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
                    $.each(data, function (index, sitesObj) {
                        $('#select4').append('<option value="' + sitesObj.id + '">' + sitesObj.first_name + ' ' + sitesObj.last_name + ' </option>');
                    })
                });
            }

        });

        $('#select1').on('change', function (e) {
            let pays_id = e.target.value;
            {
                $.get('/operation/' + '{{$operation->id}}' + '/' + pays_id, function (response) {

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
                        let impresion = document.getElementById('print');
                        impresion.style.display = 'initial';
                        impresion.style.visibility = 'hidden';
                        data_for_chart2 = JSON.parse(response.data_for_chart2);
                        drawCharts(data_for_chart2);
                        printpdf();
                        setInterval(reload, 3000);
                    };
                    document.getElementById('download_country_exel').onclick = function () {
                        window.location.href = '/forms/' + '{{$form->code}}' + '/responses/download/' + pays_id;
                    };
                });
            }
        });

        $('#select2').on('change', function (e) {
            let site_id = e.target.value;
            {
                $.get('/siteoperation/' + '{{$operation->id}}' + '/' + site_id, function (response) {


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
                        let impresion = document.getElementById('print');
                        impresion.style.display = 'initial';
                        impresion.style.visibility = 'hidden';
                        data_for_chart2 = JSON.parse(response.data_for_chart2);
                        drawCharts(data_for_chart2);
                        printpdf();
                        setInterval(reload, 3000);
                    };
                    document.getElementById('download_site_exel').onclick = function () {
                        window.location.href = '/forms/' + '{{$form->code}}' + '/responses/downloadsite/' + site_id;
                    };
                });
            }
        });

        $('#select3').on('change', function (e) {
            let ville = e.target.value;
            {
                $.get('/villeoperation/' + '{{$operation->id}}' + '/' + ville, function (response) {

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
                        let impresion = document.getElementById('print');
                        impresion.style.display = 'initial';
                        impresion.style.visibility = 'hidden';
                        data_for_chart2 = JSON.parse(response.data_for_chart2);
                        drawCharts(data_for_chart2);
                        printpdf();
                        setInterval(reload, 3000);
                    };
                    document.getElementById('download_ville_exel').onclick = function () {
                        window.location.href = '/forms/' + '{{$form->code}}' + '/responses/downloadville/' + ville;
                    };
                });
            }
        });

        $('#select4').on('change', function (e) {
            let userid = e.target.value;
            {
                $.get('/useroperation/' + '{{$operation->id}}' + '/' + userid, function (response) {

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
                        let impresion = document.getElementById('print');
                        impresion.style.display = 'initial';
                        impresion.style.visibility = 'hidden';
                        data_for_chart2 = JSON.parse(response.data_for_chart2);
                        drawCharts(data_for_chart2);
                        printpdf();
                        setInterval(reload, 3000);
                    };
                    document.getElementById('download_user_exel').onclick = function () {
                        window.location.href = '/forms/' + '{{$form->code}}' + '/responses/downloaduser/' + userid;
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


@section('content')
    <br/>
    <div class="row">
        <div class="col-lg-9 col-xs-12">
            <div class="card">
                <div class="card-body row">
                    <h4 class="col-sm-6 col-lg-12 card-title">Informations générales</h4>
                    <br/>
                    <div class="col-sm-6 col-lg-3">
                        <p class="label"> Début : {{$operation->form->start}} </p>
                    </div>
                    <div class="col-sm-6 col-lg-3">
                        <p class="label">Fin : {{$operation->form->end}} </p>
                    </div>

                    <div class="col-sm-6 col-lg-2">
                        <p class="label">Villes : {{$Villes->count()}}</p>
                    </div>

                    <div class="col-sm-6 col-lg-2">
                        <p class="label">Sites : {{$sites->count()}}</p>
                    </div>

                    <div class="col-sm-6 col-lg-2">
                        <p class="label">Opérateurs : {{$operateurs->count()}}</p>
                    </div>
                </div>
                <!-- /.box-body -->
            </div>
            <span class="row">
                          {!! $view !!}
            </span>
        </div>

        <div class="col-lg-3 col-xs-12">
            <div class="row">
                <div class="col-lg-12 col-xs-6">
                    <div class="small-box bg-white">
                        <a href="{{route("forms.show",$form->code)}}"
                           class="btn form-control" target="_blank">Afficher le questionnaire</a>
                    </div>
                </div>
                <div class="col-lg-12 col-xs-6">
                    <div class="small-box bg-white">
                        <a href="https://blooapp.live/theadministration" class="btn form-control">Sélectionner
                            une opération</a>
                    </div>
                </div>

                <div class="col-lg-12 col-xs-6">
                    <div class="small-box bg-white">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="col-sm-6 col-lg-12 card-title">Lecteurs
                                    <i class="fa fa-plus-circle float-right"
                                       aria-hidden="true"
                                       id="getlecteur"
                                       title="ajouter un lecteur"
                                       role="button"
                                       data-toggle="modal"
                                       data-target="#datalecteurs"
                                    ></i>
                                </h4>

                                <table class="datatable table stripe">
                                    <thead>
                                    <tr>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($lecteurs as $user)
                                        <tr>
                                            <td>
                                                <span>{{$user->name}} </span>
                                            </td>
                                            <td>
                                                <i class="fa fa-minus-circle text-danger removeoperateur"
                                                   id="removeoperateur_{{$user->id}}"
                                                   title="retirer operateur"
                                                   role="button"
                                                   data-userid="{{$user->id}}"
                                                   aria-hidden="true">
                                                </i>

                                            </td>
                                            <td>
                                                <li class="text-success">Online</li>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.box-body -->
                        </div>
                    </div>
                </div>

                <div class="col-lg-12 col-xs-6">
                    <div class="small-box bg-white">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="col-sm-6 col-lg-12 card-title">Opérateurs
                                    <i class="fa fa-plus-circle float-right"
                                       aria-hidden="true"
                                       id="getoperateur"
                                       title="ajouter un operateur"
                                       role="button"
                                       data-toggle="modal"
                                       data-target="#dataoperateurs"
                                    ></i>
                                </h4>

                                <table class="datatable table stripe">
                                    <thead>
                                    <tr>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($operateurs as $user)
                                        <tr>
                                            <td>
                                                <span>{{$user->name}} </span>
                                            </td>
                                            <td>
                                                <i class="fa fa-minus-circle text-danger removeoperateur"
                                                   id="removeoperateur_{{$user->id}}"
                                                   title="retirer operateur"
                                                   role="button"
                                                   data-userid="{{$user->id}}"
                                                   aria-hidden="true">
                                                </i>

                                            </td>
                                            <td>
                                                <li class="text-success">Online</li>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.box-body -->
                        </div>
                    </div>
                </div>

                <div class="col-lg-12 col-xs-6">
                    <div class="small-box bg-white">
                        <div class="card">
                            <div class="card-body" id="map_lecteurs">
                            </div>
                            <!-- /.box-body -->
                        </div>
                    </div>
                </div>

            </div>
            <!-- /.box-body -->
        </div>

        <!-- Modal -->
        <div class="modal fade bd-example-modal-lg" id="dataoperateurs" tabindex="-1" role="dialog"
             aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" >Ajout des operateurs</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <span id="content">

                    </span>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade bd-example-modal-lg" id="datalecteurs" tabindex="-1" role="dialog"
             aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Ajout des lecteurs</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <span id="contentlecteur">

                    </span>
                </div>
            </div>
        </div>

    </div>
@endsection
