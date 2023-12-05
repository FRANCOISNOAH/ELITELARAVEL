@extends('admin.layouts.admin')

@section('ariane')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0">Tous les utilisateurs</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{route('user.index')}}">Tous les utilisateurs</a></li>
                <li class="breadcrumb-item active">Utilisateurs</li>
            </ol>
        </div>
    </div>
    <hr/>
@stop

@section('content')
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
            <table id="user" class="user table table-sm table-hover mt-3">
                <thead>
                <tr>
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
                        <td>{{$user->name}}</td>
                        <td class="text-center">{{ $user->email }}</td>
                        <td class="text-center">
                            @foreach($user->roles as $role)
                                <span class="badge badge-primary">{{$role->name}}</span>
                            @endforeach
                        </td>
                        <td class="text-center">
                            @if($user->activated === 1)
                                <span  class="badge badge-primary">Actif</span>
                            @else
                                <span class="badge badge-danger">Inactif</span>
                            @endif
                        </td>
                        <td class="text-center">
                            @if($user->activated === 1)
                                <i OnClick="activate(user.id)" class="fas fa-times-circle mr-1 text-danger"></i>
                            @else
                                <i OnClick="desactivate(user.id)" class="fa fa-check-square mr-1 bloo-color" aria-hidden="true"></i>
                            @endif
                            <a href="{{route('user.edit',$user->id)}}"><i class="fas fa-edit mr-1 bloo-color"></i></a>
                            <i OnClick="deleted({{$user->id}})" class="fa fa-trash text-danger" aria-hidden="true"></i>
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
            <table id="user" class="user table table-sm table-hover mt-3">
                <thead>
                <tr>
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
                                <span  class="badge badge-primary">Actif</span>
                            @else
                                <span class="badge badge-danger">Inactif</span>
                            @endif
                        </td>
                        <td class="text-center">
                            @if($user->activated === 1)
                                <i OnClick="activate(user.id)" class="fas fa-times-circle mr-1 text-danger"></i>
                            @else
                                <i OnClick="desactivate(user.id)" class="fa fa-check-square mr-1 bloo-color" aria-hidden="true"></i>
                            @endif
                            <a href="{{route('user.edit',$user->id)}}"><i class="fas fa-edit mr-1 bloo-color"></i></a>
                            <i OnClick="deleted({{$user->id}})" class="fa fa-trash text-danger" aria-hidden="true"></i>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <hr />

    <div class="row mt-4">
        <div class="col-md-12">
            <h3>Opérateurs</h3>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <table id="user" class="user table table-sm table-hover mt-3">
                <thead>
                <tr>
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
                                <span  class="badge badge-primary">Actif</span>
                            @else
                                <span class="badge badge-danger">Inactif</span>
                            @endif
                        </td>
                        <td class="text-center">
                            @if($user->activated === 1)
                                <i OnClick="activate(user.id)" class="fas fa-times-circle mr-1 text-danger"></i>
                            @else
                                <i OnClick="desactivate(user.id)" class="fa fa-check-square mr-1 bloo-color" aria-hidden="true"></i>
                            @endif
                            <a href="{{route('user.edit',$user->id)}}"><i class="fas fa-edit mr-1 bloo-color"></i></a>
                            <i OnClick="deleted({{$user->id}})" class="fa fa-trash text-danger" aria-hidden="true"></i>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <hr />

    <div class="row mt-4">
        <div class="col-md-12">
            <h3>Lecteurs</h3>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <table id="user" class="user table table-sm table-hover mt-3">
                <thead>
                <tr>
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
                                <span  class="badge badge-primary">Actif</span>
                            @else
                                <span class="badge badge-danger">Inactif</span>
                            @endif
                        </td>
                        <td class="text-center">
                            @if($user->activated === 1)
                                <i OnClick="activate(user.id)" class="fas fa-times-circle mr-1 text-danger"></i>
                            @else
                                <i OnClick="desactivate(user.id)" class="fa fa-check-square mr-1 bloo-color" aria-hidden="true"></i>
                            @endif
                            <a href="{{route('user.edit',$user->id)}}"><i class="fas fa-edit mr-1 bloo-color"></i></a>
                            <i OnClick="deleted({{$user->id}})" class="fa fa-trash text-danger" aria-hidden="true"></i>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@stop
