@extends("layouts.admin4")

@section('content')
    <div class="row mt-3">
        <div class="col-md-12">
            <a href="{{route('operation.create')}}" class="btn bg-bloo float-right"><i
                    class="fas fa-plus-circle mr-1"></i> Ajouter</a>
            <h3>Opérations</h3>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <table id="operation" class="table datatable table-sm table-hover mt-3">
                <thead>
                <tr>
                    <th></th>
                    <th>Nom de l'opération</th>
                    <th class="text-center">Date de début</th>
                    <th class="text-center">Date de fin</th>
                    <th class="text-center">Sites</th>
                    <th class="text-center">Opérateurs</th>
                    <th class="text-center">Lecteurs</th>
                    <th class="text-center">Statut</th>
                    <th class="text-center"></th>
                </tr>
                </thead>
                <tbody>
                @foreach($operations as $operation)
                    <tr>
                        <td></td>
                        <td>{{$operation->form->title}}</td>
                        <td class="text-center">{{$operation->form->start}}</td>
                        <td class="text-center">{{$operation->form->end}}</td>
                        <td class="text-center">{{$operation->sites->count()}}</td>
                        <td class="text-center">{{$operation->usersWithRole('Operateur')->count()}}</td>
                        <td class="text-center">{{$operation->usersWithRole('Lecteur')->count()}}</td>
                        @switch($operation->form->status)
                            @case('Brouillon')
                                <td><span class="statut-point bg-danger"></span> {{$operation->form->status}}</td>
                                @break
                            @case('Prêt à ouvrir')
                                <td><span class="statut-point bg-success"></span> {{$operation->form->status}}</td>
                                @break
                            @case('Ouvert')
                                <td><span class="statut-point bg-primary"></span> {{$operation->form->status}}</td>
                                @break
                            @case('Fermé')
                                <td><span class="statut-point bg-danger"></span> {{$operation->form->status}}</td>
                                @break
                        @endswitch
                        <td class="text-center">
                            <div class="dropdown dropleft">
                                <a class="dropdown-toggle" href="#" role="button" id="ddMenu" data-toggle="dropdown"
                                   aria-haspopup="true" aria-expanded="false">
                                    ...
                                </a>

                                <div class="dropdown-menu" aria-labelledby="ddMenu">
                                    <a class="dropdown-item" href="{{route('operation.show',$operation->id)}}">
                                        Voir l'operation
                                    </a>

                                    @if($operation->form->status === 'Prêt à ouvrir')
                                        <a onclick="start({{$operation->form_id}})" class="dropdown-item" href="#">
                                            Commencer l'operation
                                        </a>
                                    @endif

                                    <a class="dropdown-item" href="{{route('operation.edit',$operation->id)}}">
                                        Editer l'operation
                                    </a>

                                    @if($operation->form->status === 'Ouvert')
                                        <a Onclick="end({{$operation->form_id}})" class="dropdown-item" href="#">Cloturer
                                            l'operation</a>
                                    @endif

                                    @if($operation->form->status === 'Fermé')
                                        <a Onclick="deleted(operation.id)" class="dropdown-item" href="#">Supprimer
                                            l'operation</a>
                                    @endif
                                </div>
                            </div>
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
    <script>
        function start(id) {
            $.ajax({
                url: '/operation_start/' + id,
                type: 'GET',
                success: function (response) {
                    setTimeout(function () {
                        location.reload();
                    }, 1000);
                },
                error: function (error) {
                    console.log(error);
                }
            });
        }

        function end(id) {
            $.ajax({
                url: '/operation_end/' + id,
                type: 'GET',
                success: function (response) {
                    setTimeout(function () {
                        location.reload();
                    }, 1000);
                },
                error: function (error) {
                    console.log(error);
                }
            });
        }
    </script>
@stop
