@extends("layouts.admin4")

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3">
                <div class="card card-primary">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-12">
                                <p class="card-title">
                                    {{ trans('Topics') }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        @foreach($topics as $topic)
                            <div class="row">
                                <div class="col-lg-12 col-xs-6">
                                    <div class="card bg-white">
                                        <a href="#" class="btn btn-outline-dark btn-block topic"
                                           id="{{ $topic->id }}">
                                            <i class="fas fa-layer-group"></i>
                                            {{ $topic->name }}
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="col-md-9">
                <div class="card card-success">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-12">
                                <p class="card-title">
                                    {{ trans('Templates') }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="row" id="templates">
                            <!-- Votre contenu pour les templates ici -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

