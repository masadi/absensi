<div>
<!-- Modal -->
    <div wire:ignore.self class="modal fade" id="riwayatModal" tabindex="-1" aria-labelledby="addNewAddressTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-transparent">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body pb-5 px-sm-4 mx-50">
                    <h1 class="address-title text-center mb-1" id="addNewAddressTitle">Riwayat Donasi</h1>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Nominal</th>
                                <th>Nama Pengirim</th>
                                <th>Nomor Pengirim</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($riwayat)
                            @foreach ($riwayat as $item)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$item->nominal}}</td>
                                <td>{{$item->nominal}}</td>
                                <td>{{$item->nominal}}</td>
                                <td>{!!($item->approved) ? '<span class="badge badge-glow bg-success">Telah diverifikasi</span>' : '<span class="badge badge-glow bg-danger">Belum diverifikasi</span>'!!}</td>
                            </tr>
                            @endforeach
                            @else
                            <tr>
                                <td colspan="5" class="text-center">Anda belum pernah melakukan donasi</td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>