<div>
    @if ($modalEdit)
        <div class="modald">
            <div class="modald-contenido">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="exampleModalLabel">Cerrar: {{ $mesa->nombre }}</h4>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-12 my-2">
                                    <label for="">Fecha Inicio:</label>
                                    <input type="text" value="{{ $pedido->fecha_inicio }}" readonly="true"
                                        class="form-control">
                                </div>

                                @if ($pedido->fecha_fin)
                                    <div class="col-12 my-2">
                                        <label for="">Fecha Fin:</label>
                                        <input type="text" value="{{ $pedido->fecha_fin }}" readonly="true"
                                            class="form-control">
                                    </div>

                                    <div class="col-12 my-2">
                                        <label for="">Cant. Horas</label>
                                        <input type="text" value="{{ $pedido->cantidad_horas }}" readonly="true"
                                            class="form-control">
                                    </div>
                                @else
                                    <div class="col-12 my-2">
                                        <label for="">Fecha Fin:</label>
                                        <input type="text" value="{{ $pedidoUpdate['fecha_fin'] }}"
                                            class="form-control">
                                        @error('pedidoUpdate.fecha_fin')
                                            <small class="text-danger">campo requerido</small>
                                        @enderror
                                    </div>

                                    <div class="col-12 my-2">
                                        <label for="">Cant. Horas</label>
                                        <input type="text" value="{{ $pedidoUpdate['cantidad_horas'] }}"
                                            class="form-control">
                                        @error('pedidoUpdate.cantidad_horas')
                                            <small class="text-danger">campo requerido</small>
                                        @enderror
                                    </div>
                                @endif


                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" wire:click="cancelar()">Cancelar</button>
                            <button type="button" class="btn btn-primary"
                                wire:click="terminarPedido()">Terminar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
