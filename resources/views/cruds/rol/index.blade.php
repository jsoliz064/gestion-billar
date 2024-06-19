@extends('adminlte::page')

@section('title', 'Roles')

@section('content_header')
    <div class="row d-flex justify-content-between">
        <div class="ml-3">
            <h1>ROLES</h1>
        </div>
        <div class="mr-3 row breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('users.index') }}"> Usuarios </a>
            </li>
            <li class="breadcrumb-item active">
                Roles
            </li>
        </div>
    </div>
@stop

@section('content')
    @livewire('user.rol-lw')
@stop

@section('css')
    @livewireStyles
@stop

@section('js')
    @livewireScripts
@stop
