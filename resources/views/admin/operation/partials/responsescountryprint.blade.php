@php
    $data_for_chart = [];
    $fields = $form->fields;
    $template_alias_no_options = get_form_templates()->where('attribute_type', 'string')->pluck('alias')->all();
@endphp
<p><center><h1> @lang('try_pays') {{trans($pays->name)}} </h1></center></p>
@foreach ($fields as $field)
    @php
        $responses = $field->responses->where('country_id',$paysid);

        $responses_count = $responses->where('answer', '!==', null)->count();
    @endphp
    <div class="col-md-12">
        <h4>Question : {{ $field->question }}
            @if ($field->required) <span class="text-danger">*</span> @endif
        </h4>
        <p>{{ $responses_count }} {{ Str::plural(trans('response'), $responses_count) }}</p>

        @if (in_array($field->template, $template_alias_no_options))
            <div class="table-responsive">
                <table class="table table-striped-info table-xxs table-framed-info">
                    @foreach ($responses as $response)

                        <tr>
                            @php $answer = $response->getAnswerForTemplate($field->template); @endphp
                            <td>{!! $answer !!}</td>
                        </tr>
                    @endforeach
                </table>
            </div>
        @else
            @php $response_for_chart = $field->getResponseSummaryDataForChartPays2($paysid); @endphp
            @if (!empty($response_for_chart))
                @php $data_for_chart[] = $response_for_chart; @endphp
                <div class="col-6 chart-container{{ ($response_for_chart['chart'] == 'pie_chart') ? ' text-center' : '' }}">
                    <div class="{{ ($response_for_chart['chart'] == 'pie_chart') ? 'display-inline-block' : 'chart' }}" id="{{ $response_for_chart['name'] }}"></div>
                </div>
            @endif
        @endif
    </div>
    @if (!$loop->last)
        <div class="html2pdf__page-break"></div>
        <p style="font-size:0.25mm" >{{ trans('test') }}</p>
    @endif
@endforeach
