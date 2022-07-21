<div>
    <div class="container mt-3">
        <div class="card">
            <div class="card-body">
                <div class="visible-print text-center">
                    {!! QrCode::size(100)->format('svg')->generate(Request::url(), public_path('images/qrcode.svg')); !!}
                    <p>Scan me to return to the original page.</p>
                </div>
                <div x-data x-init="$refs.peserta_didik_id.focus()"> <!-- this component needs to swap out -->
                    <input class="form-control form-control-lg" wire:model="peserta_didik_id" x-ref="peserta_didik_id" type="text" placeholder="ID Peserta Didik">
                </div>
                <div class="text-center mt-2 {{($welcome) ? '' : 'd-none'}}">
                    <img class="img-fluid" src="{{asset('images/welcome.gif')}}" alt="">
                </div>
                <div class="text-center {{($bye) ? '' : 'd-none'}}">
                    <img class="img-fluid" src="{{asset('images/good-bye.gif')}}" alt="">
                </div>
                <div class="row justify-content-between mt-2">
                    <div class="col-4 text-center">
                        <h1>SISWA HADIR PALING AWAL</h1>
                        <img class="img-fluid" src="{{asset('images/no-pict.jpg')}}" alt="">
                    </div>
                    <div class="col-4 text-center">
                        <h1>SISWA HADIR PALING AKHIR</h1>
                        <img class="img-fluid" src="{{asset('images/no-pict.jpg')}}" alt="">
                    </div>
                    <div class="col-4 text-center">
                        <h1>HITUNG KEHADIRAN</h1>
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
