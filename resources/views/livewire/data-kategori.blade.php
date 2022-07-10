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
    <form wire:submit.prevent="save">
        <div wire:ignore.self class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addModalLabel">Tambah Data Kategori</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row mb-2">
                            <label for="sekolah_id" class="col-sm-2 col-form-label">Sekolah</label>
                            <div class="col-sm-10">
                                <select id="sekolah_id" class="form-select" wire:model="sekolah_id" aria-describedby="sekolah_idHelpInline">
                                    <option selected>Pilih Sekolah</option>
                                    <option value="">UMUM</option>
                                    @foreach($data_sekolah as $sekolah)
                                    <option value="{{ $sekolah->sekolah_id }}">{{ $sekolah->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <label for="is_libur" class="col-sm-2 col-form-label">Waktu Libur</label>
                            <div class="col-sm-10">
                                <select id="is_libur" class="form-select" wire:model="is_libur" aria-describedby="is_liburHelpInline">
                                    <option value="0">TIDAK</option>
                                    <option value="1">YA</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <label for="nama" class="col-sm-2 col-form-label">Nama Kategori</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" wire:model="nama">
                                @error('nama') <span class="error">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="row mb-2">
                            <label for="tanggal_mulai" class="col-sm-2 col-form-label">Periode Libur</label>
                            <div class="col-sm-10">
                                <div class="input-group">
                                    <input type="text" class="form-control" wire:change="getStart($event.target.value)" placeholder="Tanggal Mulai" aria-label="tanggal_mulai" id="tanggal_mulai" wire:model="tanggal_mulai">
                                    <span class="input-group-text">s/d</span>
                                    <input type="text" class="form-control" wire:change="getEnd($event.target.value)" placeholder="Tanggal Berakhir" aria-label="tanggal_akhir" id="tanggal_akhir" wire:model="tanggal_akhir">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <form wire:submit.prevent="update">
        <div wire:ignore.self class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel">Perbaharui Data Kategori</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row mb-2">
                            <input type="hidden" wire:model="kategori_id">
                            <label for="sekolah_id" class="col-sm-2 col-form-label">Sekolah</label>
                            <div class="col-sm-10">
                                <select id="sekolah_id" class="form-select" wire:model="sekolah_id" aria-describedby="sekolah_idHelpInline">
                                    <option selected>Pilih Sekolah</option>
                                    <option value="">UMUM</option>
                                    @foreach($data_sekolah as $sekolah)
                                    <option value="{{ $sekolah->sekolah_id }}">{{ $sekolah->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <label for="is_libur" class="col-sm-2 col-form-label">Waktu Libur</label>
                            <div class="col-sm-10">
                                <select id="is_libur" class="form-select" wire:model="is_libur" aria-describedby="is_liburHelpInline">
                                    <option value="0">TIDAK</option>
                                    <option value="1">YA</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <label for="nama" class="col-sm-2 col-form-label">Nama Kategori</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" wire:model="nama">
                            </div>
                        </div>
                        <div class="row mb-2">
                            <label for="tanggal_mulai" class="col-sm-2 col-form-label">Periode Libur</label>
                            <div class="col-sm-10">
                                <div class="input-group">
                                    <input type="text" class="form-control" wire:change="getStart($event.target.value)" placeholder="Tanggal Mulai" aria-label="tanggal_mulai" id="tanggal_mulai" wire:model="tanggal_mulai">
                                    <span class="input-group-text">s/d</span>
                                    <input type="text" class="form-control" wire:change="getEnd($event.target.value)" placeholder="Tanggal Berakhir" aria-label="tanggal_akhir" id="tanggal_akhir" wire:model="tanggal_akhir">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Perbaharui</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <form wire:submit.prevent="delete">
        <div wire:ignore.self class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteModalLabel">Hapus Data Kategori</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" wire:model="kategori_id">
                        <p>Menghapus kategori akan menghapus seluruh jam yang terhubung.</p>
                        <p>Apakah Anda yakin ingin menghapus?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Hapus</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <div wire:ignore.self class="modal fade" id="detilModal" tabindex="-1" aria-labelledby="detilModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="detilModalLabel">Detil Data Kategori</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered">
                        <tr>
                            <td>Nama</td>
                            <td>{{$this->nama}}</td>    
                        </tr>
                        <tr>
                            <td>Lembaga</td>
                            <td>{{($this->sekolah) ? $this->sekolah->nama : 'UMUM'}}</td>
                        </tr>
                        <tr>
                            <td>Libur</td>
                            <td>{{($this->is_libur) ? 'Ya' : 'Tidak'}}</td>
                        </tr>
                        <tr>
                            <td>Tanggal Mulai</td>
                            <td>{{($this->tanggal_mulai) ? $this->tanggal_mulai : '-'}}</td>
                        </tr>
                        <tr>
                            <td>Tanggal Berakhir</td>
                            <td>{{($this->tanggal_akhir) ? $this->tanggal_akhir : '-'}}</td>
                        </tr>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
</div>
