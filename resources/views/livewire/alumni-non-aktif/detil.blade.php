<div>
<!-- Modal -->
    <div wire:ignore.self class="modal fade" id="viewModal" tabindex="-1" aria-labelledby="addNewAddressTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-transparent">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body pb-5 px-sm-4 mx-50">
                    <h1 class="address-title text-center mb-1" id="addNewAddressTitle">Detil Data Alumni</h1>
                    @if($data)
                    <div class="text-center mb-2">
                        <img src="{{$data->profile_photo_url}}" alt="{{$data->name}}" class="uploadedAvatar rounded me-50" width="250">
                    </div>
                    <table class="table">
                        <tr>
                            <td>Nama Lengkap</td>
                            <td>: {{$data->name}}</td>
                        </tr>
                        <tr>
                            <td>Tempat, Tanggal Lahir</td>
                            <td>: {{$data->tempat_lahir}}, {{$data->tanggal_lahir}}</td>
                        </tr>
                        <tr>
                            <td>Alamat Rumah</td>
                            <td>: {{$data->alamat_rumah}}</td>
                        </tr>
                        <tr>
                            <td>Alamat domisili</td>
                            <td>: {{$data->alamat_domisili}}</td>
                        </tr>
                        <tr>
                            <td>Nomor Telepon/HP</td>
                            <td>: {{$data->nomor_handphone}}</td>
                        </tr>
                        <tr>
                            <td>Email</td>
                            <td>: {{$data->email}}</td>
                        </tr>
                        <tr>
                            <td>Pekerjaan</td>
                            <td>: {{$data->pekerjaan}}</td>
                        </tr>
                        <tr>
                            <td>Tahun Masuk DUBA</td>
                            <td>: {{$data->tahun_masuk}}</td>
                        </tr>
                        <tr>
                            <td>Tahun Lulus DUBA</td>
                            <td>: {{$data->tahun_lulus}}</td>
                        </tr>
                        <tr>
                            <td>DPW</td>
                            <td>: {{($data->dpw) ? $data->dpw->name : '-'}}</td>
                        </tr>
                    </table>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>