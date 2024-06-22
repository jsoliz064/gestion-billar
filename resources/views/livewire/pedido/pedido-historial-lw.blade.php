<div class="p-2">

    <head>
        <link rel="stylesheet" href="{{ asset('css/modal.css') }}">
    </head>
    <div>
        @livewire('pedido.modals.edit-pedido-modal')
    </div>
    <div class="card">
        <div class="card-body">
            @livewire('pedido.pedido-datatable')
        </div>
    </div>
</div>
