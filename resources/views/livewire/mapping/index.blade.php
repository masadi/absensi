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
                        <th class="text-center">Nama</th>
                        <th class="text-center">Lembaga</th>
                        <th class="text-center">Libur</th>
                        <th class="text-center">Tanggal Mulai</th>
                        <th class="text-center">Tanggal Berakhir</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @if($data_kategori->count())
                        @foreach($data_kategori as $kategori)
                        <tr>
                            <td>{{$kategori->nama}}</td>
                            <td>{{($kategori->sekolah_id) ? $kategori->sekolah->nama : 'UMUM'}}</td>
                            <td class="text-center">{{($kategori->is_libur) ? 'Ya' : 'Tidak'}}</td>
                            <td class="text-center">{{($kategori->tanggal_mulai) ?? '-'}}</td>
                            <td class="text-center">{{($kategori->tanggal_akhir) ?? '-'}}</td>
                            <td class="text-center">
                                <div class="btn-group btn-group-sm" role="group">
                                    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#detilModal" wire:click="getID({{$kategori->id}})">Detil</button>
                                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#editModal" wire:click="getID({{$kategori->id}})">Edit</button>
                                    <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#deleteModal" wire:click="getID({{$kategori->id}})">Hapus</button>
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
                    <p>Showing {{ $data_kategori->firstItem() }} to {{ $data_kategori->firstItem() + $data_kategori->count() - 1 }} of {{ $data_kategori->total() }} items</p>
                </div>
                <div class="col-4">
                    {{ $data_kategori->links('components.custom-pagination-links-view') }}
                </div>
            </div>
        </div>
    </div>
    @include('livewire.mapping.create')
    @include('livewire.mapping.read')
    @include('livewire.mapping.update')
    @include('livewire.mapping.delete')
</div>
