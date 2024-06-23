<div>
    @if ($modalExtender)
        <div class="modald">
            <div class="modald-contenido">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header d-flex justify-content-center">
                            <h4 class="modal-title" id="exampleModalLabel">Extender {{ $mesa->nombre }}</h4>
                        </div>
                        <div class="modal-body">

                            @php
                                $pedidoModal = $mesa->Pedido();
                            @endphp

                            <div class="col-12 my-2">
                                <label for="">Fecha Inicio:</label>
                                <input type="text" value="{{ $pedidoModal->fecha_inicio }}" readonly="true"
                                    class="form-control">
                            </div>
                            <div class="col-12 my-2">
                                <label for="">Fecha Fin:</label>
                                <input type="text" value="{{ $pedidoModal->fecha_fin }}" readonly="true"
                                    class="form-control">
                            </div>

                            <div class="col-12 my-2">
                                <label for="">Cant. Horas:</label>
                                <input type="text" value="{{ $pedidoModal->cantidad_horas }}" readonly="true"
                                    class="form-control">
                            </div>

                            <hr>
                            <label for="">Extender Tiempo: </label>
                            <input class="" type="datetime-local" wire:model="pedido.fecha_fin">
                            <div class="row">
                                @error('pedido.fecha_fin')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <p class="text-center">Nueva fecha de finalizacion: {{ $pedido['fecha_fin'] }}</p>

                            @if ($error)
                                <small class="text-danger">{{ $error }}</small>
                            @endif

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" wire:click="cancelar()">Cancelar</button>
                            <button type="button" class="btn btn-primary" wire:click="extender()"
                                wire:loading.attr='disabled'>Empezar
                                <div wire:loading class="spinner-border spinner-border-sm" role="status"
                                    wire:target='extender'>
                                    <span class="sr-only">Loading...</span>
                                </div>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
