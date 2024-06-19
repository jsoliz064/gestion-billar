<div>
    @if ($modalEdit)
        <div class="modald">
            <div class="modald-contenido">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="exampleModalLabel">Editar Mesa</h4>
                        </div>
                        <div class="modal-body">
                            <label>Nombre:</label>
                            <input type="text" wire:model="mesa.nombre" class="form-control">
                            @error('mesa.nombre')
                                <small class="text-danger">Debe ingresar un nombre</small>
                            @enderror

                            <label>Device ID: (opcional)</label>
                            <input type="text" wire:model="mesa.device_id" class="form-control">
                            @error('mesa.device_id')
                                <small class="text-danger">campo requerido</small>
                            @enderror

                            <label>Host: (opcional)</label>
                            <input type="text" wire:model="mesa.host" class="form-control">
                            @error('mesa.host')
                                <small class="text-danger">campo requerido</small>
                            @enderror

                            <label>Port: (opcional)</label>
                            <input type="text" wire:model="mesa.port" class="form-control">
                            @error('mesa.port')
                                <small class="text-danger">campo requerido</small>
                            @enderror

                            <label>Precio:</label>
                            <input type="number" wire:model="mesa.precio" class="form-control">
                            @error('mesa.precio')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror

                            <div class="form-check my-2">
                                <input class="form-check-input" type="checkbox" wire:model="mesa.habilitado"
                                    id="defaultCheck1">
                                <label for="defaultCheck1">
                                    Habilitado
                                </label>
                            </div>
                            @error('mesa.habilitado')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" wire:click="cancelar()">Cancelar</button>
                            <button type="button" class="btn btn-primary" wire:click="update()">Actualizar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
