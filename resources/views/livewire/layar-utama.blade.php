<div>
    <div class="row match-height justify-content-between mb-2">
        <div class="col-6">
            <div class="card">
                <div class="card-body">
                    <h3>Daftar Peserta Didik berhasil Scan</h3>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>NO</th>
                                <th>NISN</th>
                                <th>NAMA</th>
                                <th>KELAS</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($collection as $item)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$item['peserta_didik']['nisn']}}</td>
                                    <td>{{$item['peserta_didik']['nama']}}</td>
                                    <td>{{$item['peserta_didik']['kelas']['nama']}}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="text-center" colspan="4">Tidak ada data untuk ditampilkan</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-6">
            <div class="card">
                <div class="card-body">
                    <h3>Data Kehadiran Peserta Didik per Kelas</h3>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>NO</th>
                                <th>KELAS</th>
                                <th>HADIR</th>
                                <th>BELUM/TIDAK HADIR</th>
                                <th>JUMLAH</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($data_kelas as $kelas)
                            <tr>
                                <td class="text-center">{{$loop->iteration}}</td>
                                <td>{{$kelas->nama}}</td>
                                <td>{{$kelas->hadir}}</td>
                                <td>{{$kelas->belum}}</td>
                                <td>{{$kelas->hadir + $kelas->belum}}</td>
                            </tr>
                            @empty
                            <tr>
                                <td class="text-center" colspan="5">Tidak ada data untuk ditampilkan</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
