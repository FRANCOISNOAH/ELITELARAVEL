<table id="datatable2" class="datatable table stripe">
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
    <a href="{{route("messages_index")}}"><button class="btn btn-xs-bloo disabled m_btn_op m_btn_message"><i class="icon ions ion-chatboxes"></i> {{ trans('Message') }}</button></a>
    <button class="btn btn-xs-bloo disabled m_btn_op m_btn_location"><i class="icon ions ion-location"></i> {{ trans('Localisation') }}</button>
</div>
