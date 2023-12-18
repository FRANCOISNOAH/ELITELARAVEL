@if(auth()->user()->hasRole('Free'))
<button style="background-color: #0065a1;" class="btn btn-xs btn-success">Menu</button>

<button  style="background-color: #0065a1;" class="btn btn-xs btn-success dropdown-toggle" data-toggle="dropdown"><span class="caret"></span></button>
<ul class="dropdown-menu dropdown-menu-right">

    <li class="dropdown-header highlight"><i class="icon-menu7"></i> <i class="icon-share3 pull-right"></i>{{trans('menu_form_1')}}</li>

    @if ($form->status === $form::STATUS_OPEN)
        <li><a data-toggle="modal" data-target="#share-form" data-backdrop="static" data-keyboard="false">{{trans('menu_form_2')}}</a></li>
    @endif

{{--    @if (in_array($form->status, [$form::STATUS_OPEN, $form::STATUS_CLOSED]))--}}
{{--        <li class="dropdown-header highlight"><i class="icon-menu7"></i> <i class="icon-menu6 pull-right"></i>{{trans('menu_form_4')}}</li>--}}
{{--        @if (Route::currentRouteName() !== 'forms.responses.index')--}}
{{--            <li><a href="{{ route('forms.responses.index', $form->code) }}">{{trans('menu_form_5')}}</a></li>--}}
{{--        @endif--}}
{{--        @if ($form->responses()->has('fieldResponses')->exists())--}}
{{--            <li><a id="delete-button" data-href="{{ route('forms.responses.destroy.all', $form->code) }}" data-message="Are your sure you want to delete all the responses for this form?">{{trans('menu_form_6')}}</a></li>--}}
{{--            <li><a href="{{ route('forms.response.export', $form->code) }}">{{trans('menu_form_7')}}</a></li>--}}
{{--        @endif--}}
{{--    @endif--}}



    <li class="dropdown-header highlight"><i class="icon-menu7"></i> <i class="icon-gear pull-right"></i>{{trans('menu_form_8')}}</li>
    @if(!auth()->user()->hasRole('Free'))
    <li><a data-toggle="modal" data-target="#form-availability" data-backdrop="static" data-keyboard="false">{{trans('menu_form_9')}}</a></li>
    @endif
    @if (Route::currentRouteName() !== 'forms.show')
        <li><a href="{{ route('forms.show', $form->code) }}">{{trans('menu_form_10')}}</a></li>
    @endif

    @if (in_array($form->status, [$form::STATUS_PENDING, $form::STATUS_CLOSED]))
        <li><a href="{{ route('forms.open', $form->code) }}" data-method="post">{{trans('menu_form_11')}}</a></li>
    @endif

    @if ($form->status === $form::STATUS_OPEN)
        <li><a href="{{ route('forms.close', $form->code) }}" data-method="post">{{trans('menu_form_12')}}</a></li>
    @endif

    <li class="divider"></li>

    {{-- @if ($form->user_id === $current_user->id)
        <li><a href="#">Form Settings</a></li>
    @endif --}}

    @if(!auth()->user()->hasRole('Free'))
    <li><a href="{{ route('forms.edit', $form->code) }}">{{trans('menu_form_13')}}</a></li>
    @endif

    @if(auth()->user()->hasRole('Free'))
    <li>
        <form method="post" action="{{route("logout")}}" id="logout">
            @csrf
        </form>
        <a href="#" class="dropdown-item" onclick="document.getElementById('logout').submit();">
            <i class="fas fa-sign-out-alt mr-2"></i>Fermer le formulaire
            <span class="float-right text-muted text-sm"></span>
        </a>
    </li>
    @endif

{{-- --}}
{{--    @if(!auth555()->user()->hasRole('Free'))--}}
{{--    <li><a href="{{ route('forms.index') }}">{{trans('menu_form_15')}}</a></li>--}}
{{--    @endif--}}
</ul>
@endif
