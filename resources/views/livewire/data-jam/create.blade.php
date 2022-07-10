<form wire:submit.prevent="save">
        <div wire:ignore.self class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addModalLabel">Tambah Data Jam</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row mb-2">
                            <label for="sekolah_id" class="col-sm-3 col-form-label">Sekolah</label>
                            <div class="col-sm-9">
                                <select id="sekolah_id" class="form-select" wire:model="sekolah_id" wire:change="getKategori" aria-describedby="sekolah_idHelpInline">
                                    <option selected>Pilih Sekolah</option>
                                    <option value="">UMUM</option>
                                    @foreach($data_sekolah as $sekolah)
                                    <option value="{{ $sekolah->sekolah_id }}">{{ $sekolah->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <label for="kategori_id" class="col-sm-3 col-form-label">Kategori</label>
                            <div class="col-sm-9">
                                <select id="kategori_id" class="form-select" wire:model="kategori_id" aria-describedby="kategori_idHelpInline">
                                    <option selected>Pilih Kategori</option>
                                    @foreach($data_kategori as $kategori)
                                    <option value="{{ $kategori->id }}">{{ $kategori->nama }}</option>
                                    @endforeach
                                </select>
                                @error('kategori_id') <span class="error">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="row mb-2">
                            <label for="scan_masuk_start_jam" class="col-sm-3 col-form-label">Mulai Scan Masuk</label>
                            <div class="col-sm-9">
                                <div class="input-group">
                                    <span class="input-group-text" wire:ignore><i data-feather="clock"></i></span>
                                    <select class="form-select" id="scan_masuk_start_jam" aria-label="Pilih Jam" wire:model="scan_masuk_start_jam" aria-describedby="scan_masuk_start_jamHelpInline">
                                        <option selected>Pilih Jam</option>
                                        @for ($i = 0; $i < 24; $i++)
                                            <option value="{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}">{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}</option>
                                        @endfor
                                    </select>
                                    <span class="input-group-text" wire:ignore>:</span>
                                    <select class="form-select" id="scan_masuk_start_menit" aria-label="Pilih Jam" wire:model="scan_masuk_start_menit" aria-describedby="scan_masuk_start_menitHelpInline">
                                        <option selected>Pilih Menit</option>
                                        @for ($i = 0; $i < 60; $i++)
                                            <option value="{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}">{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}</option>
                                        @endfor
                                    </select>
                                </div>
                                @error('scan_masuk_start_jam')
                                <span id="scan_masuk_start_jamHelpInline">
                                <span class="text-danger">{{ $message }}</span>
                                </span>
                                @enderror
                                @error('scan_masuk_start_menit')
                                <span id="scan_masuk_start_menitHelpInline">
                                <span class="text-danger">{{ $message }}</span>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-2">
                            <label for="scan_masuk_end_jam" class="col-sm-3 col-form-label">Akhir Scan Masuk</label>
                            <div class="col-sm-9">
                                <div class="input-group">
                                    <span class="input-group-text" wire:ignore><i data-feather="clock"></i></span>
                                    <select class="form-select" id="scan_masuk_end_jam" aria-label="Pilih Jam" wire:model="scan_masuk_end_jam" aria-describedby="scan_masuk_end_jamHelpInline">
                                        <option selected>Pilih Jam</option>
                                        @for ($i = 0; $i < 24; $i++)
                                            <option value="{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}">{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}</option>
                                        @endfor
                                    </select>
                                    <span class="input-group-text" wire:ignore>:</span>
                                    <select class="form-select" id="scan_masuk_end_menit" aria-label="Pilih Jam" wire:model="scan_masuk_end_menit" aria-describedby="scan_masuk_end_menitHelpInline">
                                        <option selected>Pilih Menit</option>
                                        @for ($i = 0; $i < 60; $i++)
                                            <option value="{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}">{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}</option>
                                        @endfor
                                    </select>
                                </div>
                                @error('scan_masuk_end_jam')
                                <span id="scan_masuk_end_jamHelpInline">
                                <span class="text-danger">{{ $message }}</span>
                                </span>
                                @enderror
                                @error('scan_masuk_end_menit')
                                <span id="scan_masuk_end_menitHelpInline">
                                <span class="text-danger">{{ $message }}</span>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-2">
                            <label for="waktu_akhir_masuk_jam" class="col-sm-3 col-form-label">Waktu Akhir Masuk</label>
                            <div class="col-sm-9">
                                <div class="input-group">
                                    <span class="input-group-text" wire:ignore><i data-feather="clock"></i></span>
                                    <select class="form-select" id="waktu_akhir_masuk_jam" aria-label="Pilih Jam" wire:model="waktu_akhir_masuk_jam" aria-describedby="waktu_akhir_masuk_jamHelpInline">
                                        <option selected>Pilih Jam</option>
                                        @for ($i = 0; $i < 24; $i++)
                                            <option value="{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}">{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}</option>
                                        @endfor
                                    </select>
                                    <span class="input-group-text" wire:ignore>:</span>
                                    <select class="form-select" id="waktu_akhir_masuk_menit" aria-label="Pilih Jam" wire:model="waktu_akhir_masuk_menit" aria-describedby="waktu_akhir_masuk_menitHelpInline">
                                        <option selected>Pilih Menit</option>
                                        @for ($i = 0; $i < 60; $i++)
                                            <option value="{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}">{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}</option>
                                        @endfor
                                    </select>
                                </div>
                                @error('waktu_akhir_masuk_jam')
                                <span id="waktu_akhir_masuk_jamHelpInline">
                                <span class="text-danger">{{ $message }}</span>
                                </span>
                                @enderror
                                @error('waktu_akhir_masuk_menit')
                                <span id="waktu_akhir_masuk_menitHelpInline">
                                <span class="text-danger">{{ $message }}</span>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-2">
                            <label for="scan_pulang_start_jam" class="col-sm-3 col-form-label">Mulai Scan Pulang</label>
                            <div class="col-sm-9">
                                <div class="input-group">
                                    <span class="input-group-text" wire:ignore><i data-feather="clock"></i></span>
                                    <select class="form-select" id="scan_pulang_start_jam" aria-label="Pilih Jam" wire:model="scan_pulang_start_jam" aria-describedby="scan_pulang_start_jamHelpInline">
                                        <option selected>Pilih Jam</option>
                                        @for ($i = 0; $i < 24; $i++)
                                            <option value="{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}">{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}</option>
                                        @endfor
                                    </select>
                                    <span class="input-group-text" wire:ignore>:</span>
                                    <select class="form-select" id="scan_pulang_start_menit" aria-label="Pilih Jam" wire:model="scan_pulang_start_menit" aria-describedby="scan_pulang_start_menitHelpInline">
                                        <option selected>Pilih Menit</option>
                                        @for ($i = 0; $i < 60; $i++)
                                            <option value="{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}">{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}</option>
                                        @endfor
                                    </select>
                                </div>
                                @error('scan_pulang_start_jam')
                                <span id="scan_pulang_start_jamHelpInline">
                                <span class="text-danger">{{ $message }}</span>
                                </span>
                                @enderror
                                @error('scan_pulang_start_menit')
                                <span id="scan_pulang_start_menitHelpInline">
                                <span class="text-danger">{{ $message }}</span>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-2">
                            <label for="scan_pulang_end_jam" class="col-sm-3 col-form-label">Akhir Scan Pulang</label>
                            <div class="col-sm-9">
                                <div class="input-group">
                                    <span class="input-group-text" wire:ignore><i data-feather="clock"></i></span>
                                    <select class="form-select" id="scan_pulang_end_jam" aria-label="Pilih Jam" wire:model="scan_pulang_end_jam" aria-describedby="scan_pulang_end_jamHelpInline">
                                        <option selected>Pilih Jam</option>
                                        @for ($i = 0; $i < 24; $i++)
                                            <option value="{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}">{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}</option>
                                        @endfor
                                    </select>
                                    <span class="input-group-text" wire:ignore>:</span>
                                    <select class="form-select" id="scan_pulang_end_menit" aria-label="Pilih Jam" wire:model="scan_pulang_end_menit" aria-describedby="scan_pulang_end_menitHelpInline">
                                        <option selected>Pilih Menit</option>
                                        @for ($i = 0; $i < 60; $i++)
                                            <option value="{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}">{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}</option>
                                        @endfor
                                    </select>
                                </div>
                                @error('scan_pulang_end_jam')
                                <span id="scan_pulang_end_jamHelpInline">
                                <span class="text-danger">{{ $message }}</span>
                                </span>
                                @enderror
                                @error('scan_pulang_end_menit')
                                <span id="scan_pulang_end_menitHelpInline">
                                <span class="text-danger">{{ $message }}</span>
                                </span>
                                @enderror
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