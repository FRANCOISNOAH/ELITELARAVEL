<form method="POST" action="{{route('operateur.add')}}" name="operateur" id="operateur">
    @csrf
    <div class="modal-body">
        <input type="hidden" name="operation" value="{{ $operation->id }}"/>
        <table class="table table-sm table-hover mt-3" id='table26'>
            <thead>
            <tr>
                <th></th>
                <th>Nom</th>
                <th>Pays</th>
                <th>Ville</th>
            </tr>
            </thead>
            <tbody>
            @foreach($operateurs as $item)
                <tr>
                    <td><input type="hidden" name="operation" value="{{ $operation->id }}"/></td>
                    <td id='{{$item->id}}'><input type='checkbox' name='operateurs[]'
                                                  value='{{$item->id}}' {{$item->status}}>
                        {{$item->name }}
                    </td>
                    <td>
                        @isset($item->country)
                            {{ $item->country->name_fr }}
                        @endisset
                    </td>
                    <td>
                        @isset($item->city)
                            {{ $item->city->name }}
                        @endisset
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
        <button type="submit" class="btn btn-primary">Sauvegarder</button>
    </div>
</form>

<script>
    $(document).ready(function (){
        let table =  $('#table26').DataTable({
            "language": {
                @if( app()->getLocale() === "fr" )
                "url": "//cdn.datatables.net/plug-ins/1.10.21/i18n/French.json"
                @endif
                    @if( app()->getLocale() === "en")
                "url": "//cdn.datatables.net/plug-ins/1.10.21/i18n/English.json"
                @endif
                    @if( app()->getLocale() === "pt")
                "url": "//cdn.datatables.net/plug-ins/1.10.21/i18n/Portuguese.json"
                @endif
            },
            columnDefs: [
                {
                    className: 'control',
                    orderable: false,
                    targets:   0
                },
                {
                    orderable: false,
                    targets: [-1]
                },
                { responsivePriority: 1, targets: 0 },
            ],
        });



        $('#operateur').on('submit', function(e){
            // Prevent actual form submission
            e.preventDefault();

            // Serialize form data
            let data = table.$('input').serialize();
            console.log(data);

            // Submit form data via Ajax
            $.ajax({
                url: '/addOperateurs',
                data: data,
                success: function(data){
                    location.reload(true);
                }
            });

            // FOR DEMONSTRATION ONLY
            // The code below is not needed in production

            // Output form data to a console
            $('#example-console-form').text(data);
        });
    });
</script>
