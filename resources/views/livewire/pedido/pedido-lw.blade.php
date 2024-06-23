<div class="py-4">

    <head>
        <link rel="stylesheet" href="{{ asset('css/modal.css') }}">
    </head>
    <div>
        @livewire('pedido.modals.create-pedido-modal')
        @livewire('pedido.modals.edit-pedido-modal')
        @livewire('pedido.modals.extender-pedido-modal')
    </div>
    <div class="row">
        @foreach ($mesas as $mesa)
            @php
                $pedido = $mesa->Pedido();
            @endphp
            <div class="col-md-4">
                <div class="card"
                    style="@if ($pedido) border: solid 1px red; @else border: solid 1px green; @endif">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-12 d-flex justify-content-center">
                                <h5 style="font-weight: bold;">{{ $mesa->nombre }}</h5>
                            </div>
                            <div class="col-12 d-flex justify-content-center">
                                <p>{{ $mesa->device_id }} -
                                    {{ $mesa->host }}:{{ $mesa->port }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="row d-flex justify-content-center p-4">
                        <img style="width: 15rem;" class="card-img-top" src="{{ asset('img/mesaBillar.jpeg') }}"
                            alt="Card image cap">
                    </div>

                    <div class="card-body" style="height: 15rem; overflow-y: auto">
                        <p style="font-weight: bold;" class="card-text">Precio/H: {{ $mesa->precio }} $</p>
                        <hr>
                        @if ($pedido)
                            <p>Inicio: {{ $pedido->fecha_inicio }}</p>
                            <p>Fin: {{ $pedido->fecha_fin }}</p>
                            <p>Horas: {{ $pedido->cantidad_horas }}</p>
                        @endif


                    </div>
                    <div class="card-footer">
                        @if ($pedido == null)
                            <div class="row justify-content-around">
                                <button wire:click="createPedido('{{ $mesa->id }}')"
                                    class="btn btn-primary">Encender</button>
                            </div>
                        @endif

                        @if ($pedido)
                            <div class="row justify-content-around">
                                <button wire:click="closePedido('{{ $mesa->id }}')" class="btn btn-secondary">
                                    @if ($pedido->fecha_fin == null)
                                        Apagar
                                    @else
                                        Cancelar
                                    @endif
                                </button>
                                <button wire:click="extenderPedido('{{ $mesa->id }}')" class="btn btn-success">
                                    Extender
                                </button>
                            </div>
                        @endif

                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
