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
                        <h5>Nombre:</h5>
                            <input type="text" wire:model="user.name" class="form-control">
                            @error('user.name')
                                <small class="text-danger">Campo Requerido</small>
                            @enderror

                            <h5>Correo:</h5>
                            <input type="email" wire:model="email" class="form-control">
                            @error('email')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror

                            <h5>Cambiar contraseña:</h5>
                            <input type="password" wire:model="user.password" class="form-control" autocomplete="new-password">
                            @error('user.password')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror

                            <h5>Confirmar contraseña:</h5>
                            <input type="password" wire:model="user.cpassword" class="form-control" autocomplete="off">

                            <h5>Rol:</h5>
                            <select wire:model="user.rol_id" class="form-control" >
                                <option value="">Seleccione un rol</option>
                                @foreach ($rols as $rol)
                                    <option value="{{$rol->id}}">{{$rol->name}}</option>
                                @endforeach
                            </select>
                            @error('user.rol_id')
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
