@extends('admin.layouts.admin')

@section('content')

<div class="row mt-3">
    <div class="col-md-12">
        <a href="#" class="btn bg-bloo float-right"><i class="fas fa-plus-circle mr-1"></i> Ajouter</a>
        <h3>Opérations</h3>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <table id="operation" class="table table-sm table-hover mt-3">
            <thead>
            <tr>
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
                <td>{{$operation->form->title}}</td>
                <td class="text-center">{{$operation->form->start}}</td>
                <td class="text-center">{{$operation->form->end}}</td>
                <td class="text-center">{{$operation->sites->length}}</td>
                <td class="text-center">6</td>
                <td class="text-center">10</td>
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
                        <a class="dropdown-toggle" href="#" role="button" id="ddMenu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            ...
                        </a>

                        <div class="dropdown-menu" aria-labelledby="ddMenu">
                            <a Onclick="operationShow(operation.id)" class="dropdown-item" href="#">Voir l'operation</a>
                            <a Onclick="start(operation.id)" v-if="operation.form.status === 'Prêt à ouvrir'"
                               class="dropdown-item" href="#">Commencer l'operation</a>
                            <a class="dropdown-item" href="{{route('operation.edit',$operation->id)}}">Editer
                                l'operation</a>
                            @if($operation->form->status === 'Ouvert')
                                <a Onclick="end(operation.id)" class="dropdown-item" href="#">Cloturer l'operation</a>
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
