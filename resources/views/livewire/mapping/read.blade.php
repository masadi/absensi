<div wire:ignore.self class="modal fade" id="detilModal" tabindex="-1" aria-labelledby="detilModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="detilModalLabel">Detil Data Jam</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered">
                        <tr>
                            <td>Nama</td>
                            <td colspan="2">{{$nama}}</td>
                        </tr>
                        <tr>
                            <td rowspan="2">Masuk</td>
                            <td>Scan Awal</td>
                            <td>{{$scan_masuk_start}}</td>
                        </tr>
                        <tr>
                            <td>Scan Akhir</td>
                            <td>{{$scan_masuk_end}}</td>
                        </tr>
                        <tr>
                            <td colspan="2">Waktu Akhir Masuk</td>
                            <td>{{$waktu_akhir_masuk}}</td>
                        </tr>
                        <tr>
                            <td rowspan="2">Pulang</td>
                            <td>Scan Awal</td>
                            <td>{{$scan_pulang_start}}</td>
                        </tr>
                        <tr>
                            <td>Scan Akhir</td>
                            <td>{{$scan_pulang_end}}</td>
                        </tr>
                        <tr>
                            <td>PTK</td>
                            <td colspan="2">
                                @if($jam_ptk)
                                <ul class="ps-1">
                                    @foreach($jam_ptk as $ptk)
                                    <li>{{$ptk}}</li>
                                    @endforeach
                                </ul>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td>Hari</td>
                            <td>
                                @if($jam_hari)
                                <ul class="ps-1">
                                    @foreach($jam_hari as $hari)
                                    <li>{{$hari}}</li>
                                    @endforeach
                                </ul>
                                @endif
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>