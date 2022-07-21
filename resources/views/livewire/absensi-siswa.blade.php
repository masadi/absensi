<div>
    <div class="container mt-3">
        <div class="card">
            <div class="card-body">
                <div x-data x-init="$refs.peserta_didik_id.focus()"> <!-- this component needs to swap out -->
                    <input class="form-control form-control-lg" wire:model="peserta_didik_id" x-ref="peserta_didik_id" type="text" placeholder="ID Peserta Didik">
                </div>
            </div>
        </div>
    </div>
</div>
