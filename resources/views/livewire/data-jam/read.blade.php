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
                            <td>Kategori</td>
                            <td colspan="2">{{($this->kategori) ? $this->kategori->nama : ''}}</td>
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
                            <td>Waktu Akhir Masuk</td>
                            <td colspan="2">{{$waktu_akhir_masuk}}</td>
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
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>