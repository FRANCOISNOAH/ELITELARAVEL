<div class="row">
    @foreach($templates as $item)
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center template create-form" id="{{ $item->form->code }}">
                        <i class="fas fa-file-alt mr-3"></i>
                        {{ $item->form->title }}
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>



