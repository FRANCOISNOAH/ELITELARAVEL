@php
    $data_for_chart2 = [];
    $fields = $form->fields;
    $template_alias_no_options = get_form_templates()->where('attribute_type', 'string')->pluck('alias')->all();
@endphp
@foreach ($fields as $field)
    @php
        $responses = $field->responses;
        $responses_count = $responses->where('answer', '!==', null)->count();
    @endphp

    <div class="col-md-12" >
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
            @php $response_for_chart = $field->getResponseSummaryDataForChart2(); @endphp
            @if (!empty($response_for_chart))
                @php $data_for_chart2[] = $response_for_chart; @endphp
                <div class="col-12 chart-container{{ ($response_for_chart['chart'] == 'pie_chart') ? ' text-center' : '' }}">
                    <div class="{{ ($response_for_chart['chart'] == 'pie_chart') ? 'display-inline-block' : 'chart' }}" id="{{ $response_for_chart['name'] }}"></div>
                </div>
            @endif
        @endif
    </div>
    @if (!$loop->last)
    <div class="html2pdf__page-break" style="font-size: 0.015mm">{{ trans('test') }}</div>
@endif
@endforeach
