<div class="p-2">

    <head>
        <link rel="stylesheet" href="{{ asset('css/modal.css') }}">
    </head>
    <div>
        @livewire('mesa.modals.create-mesa-modal')
        @livewire('mesa.modals.edit-mesa-modal')
        @livewire('mesa.modals.destroy-mesa-modal')
    </div>
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between">
                @can('mesas.create')
                    <button class="btn btn-primary my-3" wire:click='openCreateMesaModal'>Registrar Mesa</button>
                @endcan
            </div>
            @can('mesas.index')
                @livewire('mesa.mesa-datatable')
            @endcan
        </div>
    </div>
</div>
