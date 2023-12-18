@extends("layouts.admin4")

@section('content')
    <div class="row mt-3">
        <div class="col-md-12">
            <h3>{{ $country->name_fr }} / {{$country->name_en}}</h3>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <table id="city" class="table datatable table-sm table-hover mt-3">
                <thead>
                <tr>
                    <th></th>
                    <th>Nom</th>
                </tr>
                </thead>
                <tbody>
                @foreach($country->cities as $city)
                    <tr>
                        <td></td>
                        <td>{{$city->name}}</td>
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
