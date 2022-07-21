<div>
    <div class="card">
        <div class="card-body">
            <div class="row justify-content-between mb-2">
                <div class="col-4">
                    <div class="d-inline">
                        <select class="form-select" wire:model="per_page" wire:change="loadPerPage">
                            <option value="10">10</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                        </select>
                    </div>
                </div>
                <div class="col-4">
                    <input type="text" class="form-control" placeholder="Cari data..." wire:model="search">
                </div>
            </div>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th class="text-center">Nama</th>
                        <th class="text-center">NPSN</th>
                        <th class="text-center">Alamat</th>
                        <th class="text-center">Jml PTK</th>
                        <th class="text-center">Jml PD</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($collection as $sekolah)
                    <tr>
                        <td>{{$sekolah->nama}}</td>
                        <td class="text-center">{{$sekolah->npsn}}</td>
                        <td>{{$sekolah->alamat}}</td>
                        <td class="text-center">{{$sekolah->ptk_count}}</td>
                        <td class="text-center">{{$sekolah->pd_count}}</td>
                        <td>
                            <button class="btn btn-primary btn-sm" type="button" disabled wire:loading wire:target="syncPtk('{{$sekolah->sekolah_id}}')">
                                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                <span class="visually-hidden">Loading...</span>
                            </button>
                            <button wire:loading.remove type="button" class="btn btn-primary btn-sm" wire:click="syncPtk('{{$sekolah->sekolah_id}}')">Sync PTK</button>
                            <button class="btn btn-success btn-sm" type="button" disabled wire:loading wire:target="syncPd('{{$sekolah->sekolah_id}}')">
                                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                <span class="visually-hidden">Loading...</span>
                            </button>
                            <button wire:loading.remove type="button" class="btn btn-success btn-sm" wire:click="syncPd('{{$sekolah->sekolah_id}}')">Sync PD</button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="row justify-content-between mt-2">
                <div class="col-6">
                    @if($collection->count())
                    <p>Menampilkan {{ $collection->firstItem() }} sampai {{ $collection->firstItem() + $collection->count() - 1 }} dari {{ $collection->total() }} data</p>
                    @endif
                </div>
                <div class="col-6">
                    {{ $collection->onEachSide(1)->links('components.custom-pagination-links-view') }}
                </div>
            </div>
        </div>
    </div>
    <div wire:ignore.self class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addModalLabel">Tambah Data Sekolah</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-2">
                        <label for="npsn" class="col-sm-3 col-form-label">NPSN</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" wire:model="npsn" placeholder="Masukkan NPSN disini....">
                            @error('npsn')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary" wire:click.prevent="store()" wire:loading.remove>Simpan</button>
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
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        });
    })
</script>
@endpush
