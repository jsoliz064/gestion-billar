@extends('adminlte::page')

@section('title', 'Pedidos')

@section('content_header')
    <div class="row d-flex justify-content-between">
        <div class="ml-3">
            <h1>Pedidos</h1>
        </div>
    </div>
@stop

@section('content')
    @livewire('pedido.pedido-lw')
@stop

@section('css')
    @livewireStyles
@stop

@section('js')
    @livewireScripts
@stop
