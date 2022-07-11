<div>
    <div class="card">
        <div class="card-body">
        @if (session()->has('message'))
            <div class="alert alert-success p-1" role="alert">
                {{ session('message') }}
            </div>
        @endif
            <form wire:submit.prevent="save">
                <div class="row mb-2">
                    <label for="semester_id" class="col-sm-2 col-form-label">Semester Aktif</label>
                    <div class="col-sm-10">
                        <select id="semester_id" class="form-select" wire:model="semester_id" aria-describedby="sekolah_idHelpInline">
                            <option selected>Pilih Semester</option>
                            @foreach($data_semester as $semester)
                            <option value="{{ $semester->semester_id }}" {{($semester->periode_aktif) ? 'selected' : ''}}>{{ $semester->nama }}</option>
                            @endforeach
                        </select>
                        @error('semester_id')
                        <span id="semester_idHelpInline">
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
                        <input type="text" id="jarak" class="form-control" wire:model="jarak">
                        <span class="input-group-text" wire:ignore>meter</span>
                        </div>
                        @error('jarak')
                        <span id="jarakHelpInline">
                            <span class="text-danger">{{ $message }}</span>
                        </span>
                        @enderror
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </form>
        </div>
    </div>
</div>
