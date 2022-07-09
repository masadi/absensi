<div>
    <div class="card">
        <div class="card-header">
        Rekapitulasi Absensi per {{$periode}}
        </div>
        <div class="card-body">
            <div class="input-group mb-2">
                <input type="text" class="form-control" placeholder="Filter Tanggal" aria-label="start" id="start" wire:model="start">
                <span class="input-group-text">s/d</span>
                <input type="text" class="form-control" placeholder="Filter Tanggal" aria-label="end" id="end" wire:model="end">
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
        </div>
    </div>
</div>
