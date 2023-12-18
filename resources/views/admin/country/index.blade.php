@extends("layouts.admin4")

@section('content')
    <div class="row mt-3">
        <div class="col-md-12">
            <h3>PAYS</h3>
            <a href="{{route('countries.create')}}" class="btn bg-bloo float-right"><i
                    class="fas fa-plus-circle mr-1"></i> Ajouter</a>
        </div>
    </div>


    <div class="row">
        <div class="col-md-12">
            <table id="operation" class="table datatable table-sm table-hover mt-3">
                <thead>
                <tr>
                    <th></th>
                    <th>Nom en français</th>
                    <th>Nom en français</th>
                    <th>Ville enregistrée</th>
                    <th class="text-center">Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach($countries as $country)
                    <tr>
                        <td></td>
                        <td>{{$country->name_fr}}</td>
                        <td>{{$country->name_fr}}</td>
                        <td>{{$country->cities->count()}}</td>
                        <td class="text-center">
                            <div class="dropdown dropleft">
                                <a class="dropdown-toggle" href="#" role="button" id="ddMenu" data-toggle="dropdown"
                                   aria-haspopup="true" aria-expanded="false">
                                    ...
                                </a>

                                <div class="dropdown-menu" aria-labelledby="ddMenu">
                                    <a class="dropdown-item" href="{{route('countries.show',$country->id)}}">
                                        Voir les villes
                                    </a>
                                    <a class="dropdown-item" href="{{route('countries.edit',$country->id)}}">
                                        Editer le pays
                                    </a>
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
@stop
