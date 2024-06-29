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
                            <p>Defina el tiempo que se encendera esta mesa, ya sea en horas, por un tiempo especifico o
                                sin tiempo (ningun valor)</p>
                            <label for="">Horas (opcional): </label>
                            <input class="" type="number" step="1" wire:model="pedido.cantidad_horas">
                            <div class="row">
                                @error('pedido.cantidad_horas')
                                    <small class="text-danger">solo horas enteras. 1, 2 ,3 ...</small>
                                @enderror
                            </div>

                            <label for="">Tiempo (opcional): </label>
                            <input class="" type="datetime-local" wire:model="pedido.fecha_fin">
                            <div class="row">
                                @error('pedido.fecha_fin')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            @if ($error)
                                <small class="text-danger">{{ $error }}</small>
                            @endif

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" wire:click="cancelar()">Cancelar</button>
                            <button type="button" class="btn btn-primary" wire:click="store()"
                                wire:loading.attr='disabled'>Empezar
                                <div wire:loading class="spinner-border spinner-border-sm" role="status"
                                    wire:target='store'>
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
