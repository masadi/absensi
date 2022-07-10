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
                        <th class="text-center align-middle" rowspan="2">Kategori</th>
                        <th class="text-center" colspan="2">Masuk</th>
                        <th class="text-center align-middle" rowspan="2">Waktu Akhir Masuk</th>
                        <th class="text-center" colspan="2">Pulang</th>
                        <th class="text-center align-middle" rowspan="2">Aksi</th>
                    </tr>
                    <tr>
                        <th class="text-center">Scan Awal</th>
                        <th class="text-center">Scan Akhir</th>
                        <th class="text-center">Scan Awal</th>
                        <th class="text-center">Scan Akhir</th>
                    </tr>
                </thead>
                <tbody>
                    @if($data_jam->count())
                        @foreach($data_jam as $jam)
                        <tr>
                            <td>{{$jam->kategori->nama}}</td>
                            <td class="text-center">{{$jam->scan_masuk_start}}</td>
                            <td class="text-center">{{$jam->scan_masuk_end}}</td>
                            <td class="text-center">{{$jam->waktu_akhir_masuk}}</td>
                            <td class="text-center">{{$jam->scan_pulang_start}}</td>
                            <td class="text-center">{{$jam->scan_pulang_end}}</td>
                            <td class="text-center">
                                <div class="btn-group btn-group-sm" role="group">
                                    <button id="btnGroupDrop1" type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                    Aksi
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                                        <li><a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#detilModal" wire:click="getID({{$jam->id}})"><i data-feather="eye"></i> Detil</a></li>
                                        <li><a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#editModal" wire:click="getID({{$jam->id}})"><i data-feather="edit"></i> Edit</a></li>
                                        <li><a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#deleteModal" wire:click="getID({{$jam->id}})"><i data-feather="trash-2"></i> Hapus</a></li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    @else
                        <tr>
                            <td class="text-center" colspan="7">Tidak ada data untuk ditampilkan</td>
                        </tr>
                    @endif
                </tbody>
            </table>
            <div class="row justify-content-between mt-2">
                <div class="col-4">
                    <p>Showing {{ $data_jam->firstItem() }} to {{ $data_jam->firstItem() + $data_jam->count() - 1 }} of {{ $data_jam->total() }} items</p>
                </div>
                <div class="col-4">
                    {{ $data_jam->links('components.custom-pagination-links-view') }}
                </div>
            </div>
        </div>
    </div>
    @include('livewire.data-jam.create')
    @include('livewire.data-jam.read')
    @include('livewire.data-jam.update')
    @include('livewire.data-jam.delete')
</div>
