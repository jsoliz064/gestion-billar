<div>
    @if ($modalEdit)
    <div class="modald">
        <div class="modald-contenido">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="exampleModalLabel">Editar Rol</h4>
                    </div>
                    <div class="modal-body">
                        <h5>Nombre del rol:</h5>
                        <input type="text" wire:model="rol.name" class="form-control">
                        @error('rol.name')
                            <small class="text-danger">Campo Requerido</small>
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
