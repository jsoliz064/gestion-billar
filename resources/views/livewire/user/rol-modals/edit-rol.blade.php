<div>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header" style="background-color:#0E86D4">
                    <h4 style="color: white">EDITAR ROL:</h4>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="name">Nombre del rol:</label>
                        <input type="text" id="name" wire:model="rol.name" class="form-control">
                        @error('rol.name')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div>
                        <label for="permissions">Permisos del rol:</label>
                        <div class="form-group row">
                            @php
                                $columnCount = 4;
                                $permissionsCount = $permissions->count();
                                $columnSize = ceil($permissionsCount / $columnCount);
                                $permissionsChunks = $permissions->chunk($columnSize);
                            @endphp
                            @foreach ($permissionsChunks as $permissionsChunk)
                                <div class="col-md-3">
                                    @foreach ($permissionsChunk as $permission)
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="permissions[]"
                                                id="{{ $permission['id'] }}" value="{{ $permission['id'] }}"
                                                wire:model="selectedPermissions"
                                                @if (in_array($permission['id'], $selectedPermissions)) checked @endif>
                                            <label class="form-check-label" for="{{ $permission['id'] }}">
                                                {{ $permission['name'] }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <button type="button" class="btn btn-primary" wire:click="update()">Actualizar</button>
                    <div style="margin-top: 10px">
                        @if (session()->has('message'))
                            <div class="alert alert-success" role="alert">
                                {{ session('message') }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
