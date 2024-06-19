<div>
    @if ($modalCrear)
    <div class="modald">
        <div class="modald-contenido">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="exampleModalLabel">Crear Usuario</h4>
                    </div>
                    <div class="modal-body">
                        <h5>Nombre:</h5>
                        <input type="text" wire:model="user.name" class="form-control">
                        @error('user.name')
                        <small class="text-danger">Debe ingresar un nombre</small>
                        @enderror

                        <h5>Correo:</h5>
                        <input type="email" wire:model="email" class="form-control">
                        @error('email')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror

                        <h5>Contraseña:</h5>
                        <input type="password" wire:model="user.password" class="form-control"
                            autocomplete="new-password">
                        @error('user.password')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror

                        <h5>Confirmar contraseña:</h5>
                        <input type="password" wire:model="user.cpassword" class="form-control">

                        <h5>Rol:</h5>
                        <select wire:model="user.rol_id" class="form-control">
                            <option value="">Seleccione un rol</option>
                            @foreach ($rols as $rol)
                            <option value="{{$rol->id}}">{{$rol->name}}</option>
                            @endforeach
                        </select>
                        @error('user.rol_id')
                        <small class="text-danger">El usuario debe tener un rol</small>
                        @enderror


                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" wire:click="cancelar()">Cancelar</button>
                        <button type="button" class="btn btn-primary" wire:click="store()">Guardar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>