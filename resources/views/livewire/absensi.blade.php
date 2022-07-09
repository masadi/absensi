<div>
    <div class="card">
        <div class="card-body">
            @if($status)
                <div class="alert alert-danger p-1 mt-2 text-center" role="alert">
                    {{$status}}
                </div>
            @endif
            <p>Jarak Pengguna: {{$jarak_pengguna}}</p>
            <p>Jarak Pengaturan: {{$jarak_pengaturan}}</p>
            <div class="row">
                <div class="col-6">
                    <div class="d-grid gap-2">
                        <button class="btn btn-success" {{$disabled_masuk}} type="button" wire:click="absen('masuk')">Absen Masuk</button>
                    </div>
                </div>
                <div class="col-6">
                    <div class="d-grid gap-2">
                        <button class="btn btn-primary" {{$disabled_pulang}} type="button" wire:click="absen('pulang')">Absen Pulang</button>
                    </div>
                </div>
                <div class="col-12 mt-2">
                    <h1>Status Absensi Hari Ini</h1>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th class="text-center">Masuk</th>
                                <th class="text-center">Pulang</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="text-center">{{$aktifitas_masuk}}</td>
                                <td class="text-center">{{$aktifitas_pulang}}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
