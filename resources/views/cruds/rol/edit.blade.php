@extends('adminlte::page')

@section('title', 'Roles')

@section('content')
    <div style="margin-bottom: 10px">
        <a class="btn btn-dark btb-sm" href="{{ route('roles.index') }}">Volver</a>
    </div>
    <div> 
        @livewire('user.rol-modals.edit-rol',['id'=>$id])
    </div>
@stop

@section('css')
    @livewireStyles
@stop

@section('js')
    @livewireScripts
@stop
