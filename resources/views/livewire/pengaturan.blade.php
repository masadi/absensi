<div>
    <div class="card">
        <div class="card-body">
            <form wire:submit.prevent="save">
                <div class="row mb-2">
                    <label for="sekolah_id" class="col-sm-2 col-form-label">Sekolah</label>
                    <div class="col-sm-10">
                        <select id="sekolah_id" class="form-select" wire:model="sekolah_id" wire:change="change" aria-describedby="sekolah_idHelpInline">
                            <option selected>Pilih Sekolah</option>
                            @foreach($data_sekolah as $sekolah)
                            <option value="{{ $sekolah->sekolah_id }}">{{ $sekolah->nama }}</option>
                            @endforeach
                        </select>
                        @error('sekolah_id')
                        <span id="sekolah_idHelpInline">
                            <span class="text-danger">{{ $message }}</span>
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="{{($showForm) ? '' : 'd-none'}}">
                    <div class="row mb-2">
                        <label for="scan_masuk_start" class="col-sm-2 col-form-label">Jam Absen Masuk Awal</label>
                        <div class="col-sm-10">
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
                        <label for="scan_masuk_end_jam" class="col-sm-2 col-form-label">Jam Absen Masuk Akhir</label>
                        <div class="col-sm-10">
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
                        <label for="waktu_akhir_masuk_jam" class="col-sm-2 col-form-label">Waktu Akhir Masuk</label>
                        <div class="col-sm-10">
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
                        <label for="scan_pulang_start_jam" class="col-sm-2 col-form-label">Jam Absen Pulang Awal</label>
                        <div class="col-sm-10">
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
                        <label for="scan_pulang_end_jam" class="col-sm-2 col-form-label">Jam Absen Pulang Akhir</label>
                        <div class="col-sm-10">
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
                    <div class="row mb-2">
                        <label for="jarak" class="col-sm-2 col-form-label">Jarak Maksimum</label>
                        <div class="col-sm-10">
                            <div class="input-group">
                            <span class="input-group-text" wire:ignore><i data-feather="map-pin"></i></span>
                            <input type="text" class="form-control" wire:model="jarak">
                            <span class="input-group-text" wire:ignore>meter</span>
                            </div>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </form>
        </div>
    </div>
</div>
