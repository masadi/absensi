<div>
    <div class="card">
        <div class="card-header">
        Rekapitulasi Absensi per {{$periode}}
        </div>
        <div class="card-body">
            @role('administrator', session('semester_id'))
            <div class="row mb-2">
                <div class="col-4">
                    <select class="form-select" wire:model="sekolah_id" wire:change="filterSekolah">
                        <option selected>== Filter Sekolah ==</option>
                        @foreach($data_sekolah as $sekolah)
                        <option value="{{ $sekolah->sekolah_id }}">{{ $sekolah->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-8">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Filter Tanggal" aria-label="start" id="start" wire:model="start">
                        <span class="input-group-text">s/d</span>
                        <input type="text" class="form-control" placeholder="Filter Tanggal" aria-label="end" id="end" wire:model="end">
                    </div>
                </div>
            </div>
            @else
            <div class="input-group mb-2">
                <input type="text" class="form-control" placeholder="Filter Tanggal" aria-label="start" id="start" wire:model="start">
                <span class="input-group-text">s/d</span>
                <input type="text" class="form-control" placeholder="Filter Tanggal" aria-label="end" id="end" wire:model="end">
            </div>
            @endrole
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
                        @role('administrator', session('semester_id'))
                        <th class="text-center">PTK</th>
                        @endrole
                        <th class="text-center">Tanggal</th>
                        <th class="text-center">Masuk</th>
                        <th class="text-center">Pulang</th>
                    </tr>
                </thead>
                <tbody>
                    @if($data_absen->count())
                    @foreach($data_absen as $absen)
                    <tr>
                        @role('administrator', session('semester_id'))
                        <td>{{$absen->ptk->nama}}</td>
                        @endrole
                        <td class="text-center">{{$absen->created_at->format('d/m/Y')}}</td>
                        <td class="text-center">{{($absen->absen_masuk) ? $absen->absen_masuk->created_at->format('H:i:s') : '-'}}</td>
                        <td class="text-center">{{($absen->absen_pulang) ? $absen->absen_pulang->created_at->format('H:i:s') : '-'}}</td>
                    </tr>
                    @endforeach
                    @else
                    <tr>
                        @role('administrator', session('semester_id'))
                        <td class="text-center" colspan="4">Tidak ada data untuk ditampilkan</td>
                        @else
                        <td class="text-center" colspan="3">Tidak ada data untuk ditampilkan</td>
                        @endrole
                    </tr>
                    @endif
                </tbody>
            </table>
            <div class="row justify-content-between mt-2">
                <div class="col-4">
                    <p>Showing {{ $data_absen->firstItem() }} to {{ ($data_absen->firstItem()) ? $data_absen->firstItem() + $data_absen->count() - 1 : 0 }} of {{ $data_absen->total() }} items</p>
                </div>
                <div class="col-4">
                    {{ $data_absen->links('components.custom-pagination-links-view') }}
                </div>
            </div>
        </div>
    </div>
</div>
