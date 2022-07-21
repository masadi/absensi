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
@push('scripts')
<script>
    window.addEventListener('toastr', event => {
        toastr[event.detail.type](event.detail.message, event.detail.title, {
            "closeButton": false,
            "debug": false,
            "newestOnTop": false,
            "progressBar": false,
            "positionClass": "toast-top-right",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "3000",
            "hideDuration": "10000",
            "timeOut": "50000",
            "extendedTimeOut": "10000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        });
    })
</script>
@endpush
