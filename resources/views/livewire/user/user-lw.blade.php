<div class="p-2">

    <head>
        <link rel="stylesheet" href="{{ asset('css/modal.css') }}">
    </head>
    <div>
        @livewire('user.modals.create-user-modal')
        @livewire('user.modals.edit-user-modal')
        @livewire('user.modals.destroy-user-modal')
    </div>
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between">
                @can('users.create')
                    <button class="btn btn-primary my-3" wire:click='openCreateUserModal'>Registrar Usuario</button>
                @endcan
                @can('roles.index')
                    <a class="btn btn-success btb-sm my-3" href="{{ route('roles.index') }}">Ver Roles</a>
                @endcan
            </div>
            @can('users.index')
                @livewire('user.user-datatable')
            @endcan
        </div>
    </div>
</div>
