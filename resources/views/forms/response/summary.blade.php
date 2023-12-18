@php
    $data_for_chart = [];
    $fields = $form->fields;
    $template_alias_no_options = get_form_templates()->where('attribute_type', 'string')->pluck('alias')->all();
@endphp

<div class="panel panel-body"  id="print_r">
    @foreach ($fields as $field)
        @php
            $responses = $field->responses;
            $responses_count = $responses->where('answer', '!==', null)->count();
        @endphp
        <div class="row" >
            <div class="col-md-12">
                <label class="label-xlg">{{ $field->question }}
                    @if ($field->required) <span class="text-danger">*</span> @endif
                </label>
                <p>{{ $responses_count }} {{ Str::plural(trans('response'), $responses_count) }}</p>

                @if (in_array($field->template, $template_alias_no_options))
                    <div class="table-responsive">
                        <table class="table table-striped-info table-xxs table-framed-info">
                            @foreach ($responses as $response)
                                @if($loop->index === 10)

                                  @break
                                @endif
                                <tr>
                                    @php $answer = $response->getAnswerForTemplate($field->template); @endphp
                                    <td>{!! $answer !!}</td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                @else
                    @php $response_for_chart = $field->getResponseSummaryDataForChart(); @endphp
                    @if (!empty($response_for_chart))
                        @php $data_for_chart[] = $response_for_chart; @endphp

                        <div class="chart-container{{ ($response_for_chart['chart'] == 'pie_chart') ? ' text-center' : '' }}">
                            <div class="{{ ($response_for_chart['chart'] == 'pie_chart') ? 'display-inline-block' : 'chart' }}" id="{{ $response_for_chart['name'] }}"></div>
                        </div>
                    @endif
                @endif
            </div>
        </div>
        @if (!$loop->last)
            <hr>
            <div class="html2pdf__page-break"></div>
            <p style="font-size:0.25mm" >test</p>
        @endif
    @endforeach
</div>




@push('script')
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
        $(function () {
            // Resize chart on sidebar width change and window resize
            $(window).on('resize', function () {
                drawCharts(data_for_chart);
            });
        });
    </script>
    <script>
        function reload(){
            window.location.reload();
        }
        //setInterval(reload, 45000)
    </script>

    <script type="text/javascript">

        setInterval(function(){
            google.charts.load('current', {'packages':['corechart']});

            let data_for_chart = {!! json_encode($data_for_chart) !!};

            if (typeof data_for_chart === 'object' && data_for_chart instanceof Array && data_for_chart.length) {
                google.charts.setOnLoadCallback(function () {
                    drawCharts(data_for_chart);
                });
            }
            $(function () {
                // Resize chart on sidebar width change and window resize
                $(window).on('resize', function () {
                    drawCharts(data_for_chart);
                });
            });
        }, 3000);



        let printpdf = () => {
            let now = new Date();
            let annee   = now.getFullYear();
            let mois    = now.getMonth() + 1;
            let jour    = now.getDate();
            let heure   = now.getHours();
            let minute  = now.getMinutes();
            let seconde = now.getSeconds();
            let imgData = 'data:image/png;base64,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'
            let element = document.getElementById('print_r');
            let name =  "{!!$form->title !!}.pdf";
            console.log(name);
            let opt = {
                margin:      [5, 5, 5, 5] ,
                enableLinks: true,
                filename:     "{!!$form->title !!}.pdf",
                image: { type: 'we', quality: 1 },
                html2canvas: {
                    dpi: 192,
                    scale: 2,
                    letterRendering: true,
                    useCORS: true
                },
                jsPDF: { unit: 'mm', format: 'a4', orientation: 'landscape' }
            };

            html2pdf().from(element).set(opt).toPdf().get('pdf').then(function (pdf) {
                let totalPages = pdf.internal.getNumberOfPages();

                for (i = 1; i <= totalPages; i++) {
                    pdf.setPage(i);
                    pdf.setFontSize(10);
                    pdf.setTextColor(150);
                    pdf.setPage(i);
                    pdf.setFont("helvetica");
                    pdf.text('Page ' + i + ' / ' + totalPages, (pdf.internal.pageSize.getWidth()/2.25), (pdf.internal.pageSize.getHeight()-8));
                }
            }).save();
        }


        document.getElementById('download_pdf').onclick = function () {
            // let impresion =  document.getElementById('print');
            // impresion.style.display = 'initial';
             printpdf();
            //impresion.style.visibility = 'hidden';
            // setInterval(reload, 5000);
        };

    </script>

@endpush
