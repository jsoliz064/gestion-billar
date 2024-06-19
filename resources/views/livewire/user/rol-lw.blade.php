<div class="p-2">

    <head>
        <link rel="stylesheet" href="{{ asset('css/modal.css') }}">
    </head>
    <div>
        @livewire('user.rol-modals.destroy-rol-modal')
    </div>
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between">
                @can('roles.create')
                    <a class="btn btn-primary my-3" href="{{ route('roles.create') }}">Registrar Rol</a>
                @endcan
                @can('permissions.index')
                    <a class="btn btn-secondary my-3" href="{{ route('permisos.index') }}">Ver Permisos</a>
                @endcan
            </div>
            <div>
                @can('roles.index')
                    @livewire('user.rol-datatable')
                @endcan
            </div>
        </div>
    </div>
</div>
