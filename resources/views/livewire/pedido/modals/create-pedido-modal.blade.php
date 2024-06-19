<div>
    @if ($modalCrear)
        <div class="modald">
            <div class="modald-contenido">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="exampleModalLabel">Habilitar {{ $mesa->nombre }}</h4>
                        </div>
                        <div class="modal-body">
                            <label for="">Horas (opcional): </label>
                            {{-- <input class="" type="datetime-local" wire:model="pedido.fecha_fin"> --}}
                            <input class="" type="number" wire:model="pedido.horas">
                            <div class="row">
                                @error('pedido.horas')
                                    <small class="text-danger">Debe ingresar una cantidad > 0</small>
                                @enderror
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" wire:click="cancelar()">Cancelar</button>
                            <button type="button" class="btn btn-primary" wire:click="store()">Empezar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
