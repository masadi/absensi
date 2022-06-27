<div>
    {{-- Because she competes with no one, no one can compete with her. --}}
    <form wire:submit.prevent="save">
        <div class="mb-1">
            <x-jet-label class="form-label" for="nama" value="{{ __('Nama Donasi') }}" />
            <x-jet-input id="nama" type="text" class="{{ $errors->has('nama') ? 'is-invalid' : '' }}"
              wire:model.defer="nama" autocomplete="nama" />
            <x-jet-input-error for="nama" />
        </div>
        <div class="mb-1">
            <x-jet-label class="form-label" for="deskripsi" value="{{ __('Deskripsi') }}" />
            <x-jet-input id="deskripsi" type="text" class="{{ $errors->has('deskripsi') ? 'is-invalid' : '' }}"
              wire:model.defer="deskripsi" autocomplete="deskripsi" />
            <x-jet-input-error for="deskripsi" />
        </div>
        <div class="mb-1">
            <x-jet-label class="form-label" for="nomor_rekening" value="{{ __('Nomor Rekening') }}" />
            <x-jet-input id="nomor_rekening" type="text" class="{{ $errors->has('nomor_rekening') ? 'is-invalid' : '' }}"
              wire:model.defer="nomor_rekening" autocomplete="nomor_rekening" />
            <x-jet-input-error for="nomor_rekening" />
        </div>
        <div class="mb-1">
            <x-jet-label class="form-label" for="nama_rekening" value="{{ __('Nama Rekening') }}" />
            <x-jet-input id="nama_rekening" type="text" class="{{ $errors->has('nama_rekening') ? 'is-invalid' : '' }}"
              wire:model.defer="nama_rekening" autocomplete="nama_rekening" />
            <x-jet-input-error for="nama_rekening" />
        </div>
        <div class="mb-1" x-data="{photoName: null, photoPreview: null}">
            <!-- Profile Photo File Input -->
            <input type="file" hidden wire:model="gambar" x-ref="gambar"
              x-on:change=" photoName = $refs.gambar.files[0].name; const reader = new FileReader(); reader.onload = (e) => { photoPreview = e.target.result; return false;}; reader.readAsDataURL($refs.gambar.files[0]);" />
      
            <!-- New Profile Photo Preview -->
            <div class="mt-2" x-show="photoPreview">
              <img x-bind:src="photoPreview" class="rounded-circle" width="80px" height="80px">
            </div>
      
            <x-jet-secondary-button class="mt-2 me-2" type="button" x-on:click.prevent="$refs.gambar.click()">
              {{ __('Pilih gambar') }}
            </x-jet-secondary-button>
      
            <x-jet-input-error for="gambar" class="mt-2" />
          </div>
        <div class="col-12 text-center">
            <button class="btn btn-primary me-1 mt-2">Simpan</button>
            <button type="reset" class="btn btn-outline-secondary mt-2" data-bs-dismiss="modal" aria-label="Close">
              Batal
            </button>
          </div>
    </form>
</div>
