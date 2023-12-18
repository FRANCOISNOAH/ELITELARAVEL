@php
    $response = $responses->first();
    $response_data = $response->getQuestionAnswerMap();
@endphp

<div class="panel panel-white">
    <div class="panel-heading">
        <h6 class="panel-title">{{ trans('submitted') }}: <small>{{ $response->created_at->format('jS F, Y g:i a') }} ({{ $response->created_at->diffForHumans() }})</small></h6>
        <div class="heading-elements">
            {{ $responses->appends(['type' => 'individual'])->onEachSide(2)->links('vendor.pagination.panel-header', ['pagination_class' => 'pagination-flat pagination-sm position-left']) }}

        </div>
    </div>

    <div class="panel-body">
        @foreach ($response_data as $data)
			<div class="row">
				<div class="col-md-12">
					<label class="label-xlg">{{ $data['question'] }}
						@if ($data['required']) <span class="text-danger">*</span> @endif
                    </label>
                    @php
						$value = '';
						if ($data['answer']) {
                            if ($data['template'] === 'linear-scale') {
                                $options = $data['options'];
                                $min_label = !empty($options['min']['label']) ? ": {$options['min']['label']}" : '';
                                $max_label = !empty($options['max']['label']) ? ": {$options['max']['label']}" : '';

                                $range = "(" . trans('between') . " {$options['min']['value']}{$min_label} " . trans('and') . " {$options['max']['value']}{$max_label})";
                                $value = trans('rating_of') . " {$data['answer']} {$range}";
                            } else {
                                $value = $data['answer'];
                            }
						} else {
							$value = 'NIL';
						}
                    @endphp
                    <div class="form-control-static form-underline pb-5">{!! $value !!}</div>
                </div>
			</div>
        @endforeach
    </div>
</div>
