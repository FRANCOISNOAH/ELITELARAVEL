<button class="btn btn-xs btn-bloo-c3 dropdown-toggle" data-toggle="dropdown" style="margin-left: 10px;">{{ trans('actions') }} <span class="caret"></span></button>
<ul class="dropdown-menu dropdown-menu-right" style="padding: 10px;">
    <li>
        <a href="{{ route('operation.show', [$operation->id]) }}" class="btn btn-bloo-action mb-5">{{ trans('view_form') }}</a>
    </li>
    @if (auth()->user()->hasRole('Superadmin|Client|Admin'))
        <li><a href="{{ route('startoperation', [$operation->id]) }}" class="btn btn-bloo-action mb-5 @php if(($operation->status === "EN COUR")||($operation->status === "TERMINER")){  echo "disabled"  ; } @endphp">{{ trans('commencer_op') }}</a></li>
    <li><a href="{{route('operation.edit', [$operation->id]) }}" class="btn btn-bloo-action mb-5 @php if($operation->status === "TERMINER"){  echo "disabled"  ; } @endphp "  >{{ trans('edit_op') }} </a></li>
    @isset($operation->form)
        <li><a href="{{route('forms.show', [$operation->form->code]) }}" class="btn btn-bloo-action mb-5  @php if($operation->status === "TERMINER"){  echo "disabled"  ; } @endphp" >{{ trans('edit_form') }}</a></li>
    @endisset
        <li><a href="{{route('lockoperation',$operation->id)}}" class="btn  btn-bloo-action mb-5 @php if($operation->status === "TERMINER"){  echo "disabled"  ; } @endphp"  >{{ trans('end operation') }}</a></li>
    <li><a href="{{route('operation.destroy', $operation->id) }}" class="btn btn-bloo-action @php if($operation->status === "TERMINER"){  echo "disabled"  ; } @endphp" data-id="{{ $operation->id }}" data-method="delete" data-item="form" data-ajax="true"  >{{ trans('delete_op') }}</a></li>
    @endif
</ul>
