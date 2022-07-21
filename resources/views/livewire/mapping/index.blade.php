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
                    @if($collection->count())
                        @foreach($collection as $item)
                        <tr>
                            <td>{{$item->nama}}</td>
                            <td>{{($item->sekolah_id) ? $item->sekolah->nama : 'UMUM'}}</td>
                            <td class="text-center">{{($item->is_libur) ? 'Ya' : 'Tidak'}}</td>
                            <td class="text-center">{{($item->tanggal_mulai) ?? '-'}}</td>
                            <td class="text-center">{{($item->tanggal_akhir) ?? '-'}}</td>
                            <td class="text-center">
                                <div class="btn-group btn-group-sm" role="group">
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#copyModal" wire:click="getID({{$item->id}})">Copy</button>
                                    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#detilModal" wire:click="getID({{$item->id}})">Detil</button>
                                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#editModal" wire:click="getID({{$item->id}})">Edit</button>
                                    <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#deleteModal" wire:click="getID({{$item->id}})">Hapus</button>
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
                <div class="col-6">
                    @if($collection->count())
                    <p>Menampilkan {{ $collection->firstItem() }} sampai {{ $collection->firstItem() + $collection->count() - 1 }} dari {{ $collection->total() }} data</p>
                    @endif
                </div>
                <div class="col-6">
                    {{ $collection->onEachSide(1)->links('components.custom-pagination-links-view') }}
                </div>
            </div>
        </div>
    </div>
    @include('livewire.mapping.create')
    @include('livewire.mapping.read')
    @include('livewire.mapping.update')
    @include('livewire.mapping.delete')
    @include('livewire.mapping.copy')
</div>
