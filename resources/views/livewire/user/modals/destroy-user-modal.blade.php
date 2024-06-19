<div>
    @if ($modalDestroy)
        <div class="modald">
            <div class="modald-contenido">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">

                        <div class="card-header">
                            <div class="d-flex align-items-center text-center justify-content-center">
                                <h5>¿Estás seguro de eliminar el usuario?</h5>
                            </div>
                        </div>

                        <div class="modal-body">
                            <div align="center">
                                <button type="button" class="btn btn-secondary btn-sm my-2 mx-2"
                                    wire:click="cancelar()">Cancelar</button>
                                <button wire:click="destroy()"
                                    class="btn btn-danger btn-sm my-2 mx-2">Eliminar</button>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
