@extends("layouts.admin4")

@section('ariane')
    @csrf


@stop

@section('content')
    <br/>
    <div class="row">
        <div class="col-md-12">
            <a href="{{route('user.create')}}" class="btn bg-bloo float-right">
                <i class="fas fa-plus-circle mr-1"></i> Ajouter
            </a>
            <h3>Administrateurs</h3>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <table id="user" class="user datatable table table-sm table-hover mt-3">
                <thead>
                <tr>
                    <th></th>
                    <th>Noms</th>
                    <th class="text-center">Email</th>
                    <th class="text-center">Role</th>
                    <th class="text-center">Statut</th>
                    <th class="text-center">Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach($admins as $user)
                    <tr>
                        <td></td>
                        <td>{{$user->name}}</td>
                        <td class="text-center">{{ $user->email }}</td>
                        <td class="text-center">
                            @foreach($user->roles as $role)
                                <span class="badge badge-primary">{{$role->name}}</span>
                            @endforeach
                        </td>
                        <td class="text-center">
                            @if($user->activated === 1)
                                <span class="badge badge-primary">Actif</span>
                            @else
                                <span class="badge badge-danger">Inactif</span>
                            @endif
                        </td>
                        <td class="text-center">
                            @if($user->activated === 1)
                                <i title="Descactivate" id="{{$user->id}}"
                                   class="fas fa-times-circle mr-1 text-danger desactivated"></i>
                            @else
                                <i title="Activate" id="{{$user->id}}"
                                   class="fa fa-check-square mr-1 bloo-color  actived"></i>
                            @endif
                            <a href="{{route('user.edit',$user->id)}}"><i class="fas fa-edit mr-1 bloo-color"></i></a>
                            <i data-userid="{{ $user->id }}" class="delete-btn fa fa-trash text-danger"
                               title="Supprimer l'utilisateur"></i>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <hr/>
    <div class="row mt-4">
        <div class="col-md-12">
            <h3>Clients</h3>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <table id="user" class="user datatable table table-sm table-hover mt-3">
                <thead>
                <tr>
                    <th></th>
                    <th>Noms</th>
                    <th class="text-center">Email</th>
                    <th class="text-center">Pays</th>
                    <th class="text-center">Entreprise</th>
                    <th class="text-center">Role</th>
                    <th class="text-center">Statut</th>
                    <th class="text-center">Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach($clients as $user)
                    <tr>
                        <td></td>
                        <td>{{$user->name}}</td>
                        <td class="text-center">{{ $user->email }}</td>
                        <td class="text-center">
                            @isset($user->country)
                                <span>{{ $user->country->name_fr }}</span>
                            @endisset
                        </td>
                        <td class="text-center">
                            @isset($user->company)
                                <span>{{ $user->company->name }}</span>
                            @endisset
                        </td>
                        <td class="text-center">
                            @foreach($user->roles as $role)
                                <span class="badge badge-primary">{{$role->name}}</span>
                            @endforeach
                        </td>
                        <td class="text-center">
                            @if($user->activated === 1)
                                <span class="badge badge-primary">Actif</span>
                            @else
                                <span class="badge badge-danger">Inactif</span>
                            @endif
                        </td>
                        <td class="text-center">
                            @if($user->activated === 1)
                                <i title="Descactivate" id="{{$user->id}}"
                                   class="fas fa-times-circle mr-1 text-danger desactivated"></i>
                            @else
                                <i title="Activate" id="{{$user->id}}"
                                   class="fa fa-check-square mr-1 bloo-color  actived"></i>
                            @endif
                            <a href="{{route('user.edit',$user->id)}}"><i class="fas fa-edit mr-1 bloo-color"></i></a>
                            <i data-userid="{{ $user->id }}" class="delete-btn fa fa-trash text-danger"
                               title="Supprimer l'utilisateur"></i>

                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <hr/>

    <div class="row mt-4">
        <div class="col-md-12">
            <h3>Opérateurs</h3>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <table id="user" class="user datatable table table-sm table-hover mt-3">
                <thead>
                <tr>
                    <th></th>
                    <th>Noms</th>
                    <th class="text-center">Email</th>
                    <th class="text-center">Pays</th>
                    <th class="text-center">Entreprise</th>
                    <th class="text-center">Role</th>
                    <th class="text-center">Statut</th>
                    <th class="text-center">Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach($operateurs as $user)
                    <tr>
                        <td></td>
                        <td>{{$user->name}}</td>
                        <td class="text-center">{{ $user->email }}</td>
                        <td class="text-center">
                            @isset($user->country)
                                <span>{{ $user->country->name_fr }}</span>
                            @endisset
                        </td>
                        <td class="text-center">
                            @isset($user->company)
                                <span>{{ $user->company->name }}</span>
                            @endisset
                        </td>
                        <td class="text-center">
                            @foreach($user->roles as $role)
                                <span class="badge badge-primary">{{$role->name}}</span>
                            @endforeach
                        </td>
                        <td class="text-center">
                            @if($user->activated === 1)
                                <span class="badge badge-primary">Actif</span>
                            @else
                                <span class="badge badge-danger">Inactif</span>
                            @endif
                        </td>
                        <td class="text-center">
                            @if($user->activated === 1)
                                <i title="Descactivate" id="{{$user->id}}"
                                   class="fas fa-times-circle mr-1 text-danger desactivated"></i>
                            @else
                                <i title="Activate" id="{{$user->id}}"
                                   class="fa fa-check-square mr-1 bloo-color  actived"></i>
                            @endif
                            <a href="{{route('user.edit',$user->id)}}"><i class="fas fa-edit mr-1 bloo-color"></i></a>
                            <i data-userid="{{ $user->id }}" class="delete-btn fa fa-trash text-danger"
                               title="Supprimer l'utilisateur"></i>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <hr/>

    <div class="row mt-4">
        <div class="col-md-12">
            <h3>Lecteurs</h3>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <table id="user" class="user table datatable table-sm table-hover mt-3">
                <thead>
                <tr>
                    <th></th>
                    <th>Noms</th>
                    <th class="text-center">Email</th>
                    <th class="text-center">Pays</th>
                    <th class="text-center">Entreprise</th>
                    <th class="text-center">Role</th>
                    <th class="text-center">Statut</th>
                    <th class="text-center">Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach($lecteurs as $user)
                    <tr>
                        <td></td>
                        <td>{{$user->name}}</td>
                        <td class="text-center">{{ $user->email }}</td>
                        <td class="text-center">
                            @isset($user->country)
                                <span>{{ $user->country->name_fr }}</span>
                            @endisset
                        </td>
                        <td class="text-center">
                            @isset($user->company)
                                <span>{{ $user->company->name }}</span>
                            @endisset
                        </td>
                        <td class="text-center">
                            @foreach($user->roles as $role)
                                <span class="badge badge-primary">{{$role->name}}</span>
                            @endforeach
                        </td>
                        <td class="text-center">
                            @if($user->activated === 1)
                                <span class="badge badge-primary">Actif</span>
                            @else
                                <span class="badge badge-danger">Inactif</span>
                            @endif
                        </td>
                        <td class="text-center">
                            @if($user->activated === 1)
                                <i id="{{$user->id}}" class="fas fa-times-circle mr-1 text-danger desactivated"></i>
                            @else
                                <i id="{{$user->id}}" class="fa fa-check-square mr-1 bloo-color  actived"></i>
                            @endif
                            <a href="{{route('user.edit',$user->id)}}"><i class="fas fa-edit mr-1 bloo-color"></i></a>
                            <i data-userid="{{ $user->id }}" class="delete-btn fa fa-trash text-danger"
                               title="Supprimer l'utilisateur"></i>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@stop


@section('js-script')
    <script>
        $(document).ready(function () {
            function deleted(id) {
                $("#form_" + id).submit(function (e) {
                    e.preventDefault();
                    let csrfToken = $('meta[name="csrf-token"]').attr('content');
                    // Get form data
                    let formData = $(this).serialize();
                    // Perform an AJAX request
                    $.ajax({
                        type: "POST",
                        url: "/user/" + id,
                        data: formData,
                        headers: {
                            'X-CSRF-TOKEN': csrfToken
                        },
                        success: function (response) {
                            console.log(response);
                        },
                        error: function (error) {
                            console.log(error);
                        }
                    });
                });
            }

            $(".actived").click(function () {
                let id = $(this).attr('id');
                let csrfToken = $('meta[name="csrf-token"]').attr('content');
                $.ajax({
                    type: "GET",
                    url: "/user/activate/" + id,
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    success: function (response) {
                        location.reload();
                    },
                    error: function (error) {
                        console.log(error);
                    }
                });

            });

            $(".desactivated").click(function () {
                let id = $(this).attr('id');
                let csrfToken = $('meta[name="csrf-token"]').attr('content');
                $.ajax({
                    type: "GET",
                    url: "/user/deactivate/" + id,
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    success: function (response) {
                        location.reload();
                    },
                    error: function (error) {
                        console.log(error);
                    }
                });
            });

            $('.delete-btn').on('click', function () {
                let userId = $(this).data('userid');
                // Confirmation de la suppression (vous pouvez personnaliser cela)
                if (confirm('Voulez-vous vraiment supprimer ce site ?')) {
                    // Envoyer la requête Ajax pour la suppression
                    $.ajax({
                        url: '/user/' + userId,
                        type: 'DELETE',
                        data: {
                            "_token": "{{ csrf_token() }}"
                        },
                        success: function (response) {
                            // Gérer la réponse de la requête (par exemple, actualiser la page)
                            console.log(response);
                            location.reload(); // Vous pouvez remplacer cela par le traitement souhaité
                        },
                        error: function (error) {
                            // Gérer les erreurs
                            console.error(error);
                        }
                    });
                }
            });

        });
    </script>

    <script>
        $(function () {
            $('.datatable').DataTable({

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
                },

                responsive: {
                    details: {
                        type: 'column',
                        target: 'tr'
                    }
                },
                columnDefs: [
                    {
                        className: 'control',
                        orderable: false,
                        targets: 0
                    },
                    {
                        orderable: false,
                        targets: [-1]
                    },
                    {responsivePriority: 1, targets: 0},
                ],
            });
        });
    </script>
@stop
