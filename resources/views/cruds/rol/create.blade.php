@extends('adminlte::page')

@section('title', 'Roles')

@section('content_header')
<div class="row d-flex justify-content-between">
    <div class="ml-3">
        <h1>REGISTRAR ROL</h1>
    </div>
    <div class="mr-3 row breadcrumb">
        <li class="breadcrumb-item">
            <a href="{{route('users.index')}}" title="Volver a la pagina usuarios"> Usuarios </a>
        </li>
        <li class="breadcrumb-item">
            <a href="{{route('roles.index')}}" title="Volver a la pagina roles"> Roles </a>
        </li>
        <li class="breadcrumb-item active">
             Registrar
        </li>
    </div>
</div>
@stop

@section('content')
    <div>
        @livewire('user.rol-modals.create-rol')
    </div>
@stop

@section('css')
    @livewireStyles
@stop

@section('js')
    @livewireScripts
@stop
