<x-jet-form-section submit="updateProfileInformation">
  <x-slot name="title">
    {{ __('Biodata Lengkap') }}
  </x-slot>

  <x-slot name="description">
    {{ __('Lengkapi biodata Anda dibawah ini.') }}
  </x-slot>

  <x-slot name="form">

    <x-jet-action-message on="saved">
      {{ __('Tersimpan.') }}
    </x-jet-action-message>

    
    <!-- Name -->
    <div class="mb-1">
      <x-jet-label class="form-label" for="name" value="{{ __('Nama Lengkap') }}" />
      <x-jet-input id="name" type="text" class="{{ $errors->has('name') ? 'is-invalid' : '' }}"
        wire:model.defer="state.name" autocomplete="name" />
      <x-jet-input-error for="name" />
    </div>
    <!-- Tempat Lahir -->
    <div class="mb-1">
      <x-jet-label class="form-label" for="tempat_lahir" value="{{ __('Tempat Lahir') }}" />
      <x-jet-input id="tempat_lahir" type="text" class="{{ $errors->has('tempat_lahir') ? 'is-invalid' : '' }}"
        wire:model.defer="state.tempat_lahir" autocomplete="tempat_lahir" />
      <x-jet-input-error for="tempat_lahir" />
    </div>
    <!-- Tanggal Lahir -->
    <div class="mb-1">
      <x-jet-label class="form-label" for="tanggal_lahir" value="{{ __('Tanggal Lahir') }}" />
      <!--x-jet-input id="tanggal_lahir" type="text" class="{{ $errors->has('tanggal_lahir') ? 'is-invalid' : '' }}"
        wire:model.defer="state.tanggal_lahir" autocomplete="tanggal_lahir" /-->
        <!--input id="datepicker"
        x-data
        x-ref="input"
        x-init="new Pikaday({ field: $refs.input, format: 'DD-MM-YYYY',})"
        type="text"
        class="form-control {{ $errors->has('tanggal_lahir') ? 'is-invalid' : '' }}"
        wire:model.defer="state.tanggal_lahir"
      /-->
      <x-date-picker wire:model.defer="state.tanggal_lahir" id="datepicker" autocomplete="off" />
      <!--x-jet-input type="text" id="tanggal_lahir" wire:model.defer="state.tanggal_lahir" class="datepicker {{ $errors->has('tanggal_lahir') ? 'is-invalid' : '' }}" /-->
      <x-jet-input-error for="tanggal_lahir" />
    </div>
    <!-- Alamat Rumah -->
    <div class="mb-1">
      <x-jet-label class="form-label" for="alamat_rumah" value="{{ __('Alamat Rumah') }}" />
      <x-jet-input id="alamat_rumah" type="alamat_rumah" class="{{ $errors->has('alamat_rumah') ? 'is-invalid' : '' }}"
        wire:model.defer="state.alamat_rumah" />
      <x-jet-input-error for="alamat_rumah" />
    </div>
    <!-- Alamat domisili -->
    <!-- Nomor Handphone/Whatsapp -->
    <!-- Email -->
    <div class="mb-1">
      <x-jet-label class="form-label" for="email" value="{{ __('Email') }}" />
      <x-jet-input id="email" type="email" class="{{ $errors->has('email') ? 'is-invalid' : '' }}"
        wire:model.defer="state.email" />
      <x-jet-input-error for="email" />
    </div>
    <!-- Pekerjaan [Ketik manual] -->
    <!-- NIK/No. Paspor -->
    <!-- Tahun Masuk DUBA -->
    <!-- Tahun Lulus DUBA -->
    <!-- Keanggotaan tergabung di Peradaban DPW mana [pilihan data kabupaten se Indonesia] -->
    <div class="mb-1">
      <livewire:dpw />
    </div>
    <!-- Profile Photo -->
    @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
    <div class="mb-1" x-data="{photoName: null, photoPreview: null}">
      <!-- Profile Photo File Input -->
      <input type="file" hidden wire:model="photo" x-ref="photo"
        x-on:change=" photoName = $refs.photo.files[0].name; const reader = new FileReader(); reader.onload = (e) => { photoPreview = e.target.result;}; reader.readAsDataURL($refs.photo.files[0]);" />

      <!-- Current Profile Photo -->
      <div class="mt-2" x-show="! photoPreview">
        <img src="{{ $this->user->profile_photo_url }}" class="rounded-circle" height="80px" width="80px">
      </div>

      <!-- New Profile Photo Preview -->
      <div class="mt-2" x-show="photoPreview">
        <img x-bind:src="photoPreview" class="rounded-circle" width="80px" height="80px">
      </div>

      <x-jet-secondary-button class="mt-2 me-2" type="button" x-on:click.prevent="$refs.photo.click()">
        {{ __('Pilih foto profil') }}
      </x-jet-secondary-button>

      @if ($this->user->profile_photo_path)
        <button type="button" class="btn btn-danger text-uppercase mt-2" wire:click="deleteProfilePhoto">
          {{ __('Hapus Foto') }}
        </button>
      @endif

      <x-jet-input-error for="photo" class="mt-2" />
    </div>
    @endif
  </x-slot>
  <x-slot name="actions">
    <div class="d-flex align-items-baseline">
      <x-jet-button>
        {{ __('Simpan') }}
      </x-jet-button>
    </div>
  </x-slot>
</x-jet-form-section>
