<div class="member d-flex align-items-start" data-aos="zoom-in" data-aos-delay="100">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th class="text-center">No.</th>
                <th class="text-center">Nama Sekolah</th>
                <th class="text-center">NPSN</th>
                @foreach ($all_jalur as $jalur)
                <th class="text-center">{{$jalur->nama}}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach ($data_sekolah as $sekolah)
            <tr>
                <td class="text-center">{{$loop->iteration}}</td>
                <td>{{$sekolah->nama}}</td>
                <td class="text-center">{{$sekolah->npsn}}</td>
                @foreach ($all_jalur as $jalur)
                <td class="text-center"><a href="{{route('cetak.hasil_ppdb', ['sekolah_id' => $sekolah->sekolah_id, 'jalur_id' => $jalur->id])}}#hasil" class="btn btn-primary btn-sm" target="_blank">Lihat Hasil</a></td>
                @endforeach
            </tr>
            @endforeach
        </tbody>
    </table>
</div>