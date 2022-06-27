<div>
    <div wire:ignore.self class="modal fade" id="createModal" tabindex="-1" aria-labelledby="addNewAddressTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-transparent">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body pb-5 px-sm-4 mx-50">
                    <h1 class="address-title text-center mb-1" id="addNewAddressTitle">Tambah Data Kegiatan</h1>
                    <form>
                        <div class="mb-1">
                            <x-jet-input id="user_id" type="hidden" wire:model.defer="user_id" autocomplete="user_id" />
                            <x-jet-input id="regency_id" type="hidden" wire:model.defer="regency_id" autocomplete="regency_id" />
                            <x-jet-label class="form-label" for="nama" value="{{ __('Nama Kegiatan') }}" />
                            <x-jet-input id="nama" type="text" class="{{ $errors->has('nama') ? 'is-invalid' : '' }}" wire:model.defer="nama" autocomplete="nama" />
                            <x-jet-input-error for="nama" />
                        </div>
                        <div class="mb-1">
                            <x-jet-label class="form-label" for="waktu" value="{{ __('Waktu Kegiatan') }}" />
                            <x-jet-input type="text" id="waktu" wire:model="waktu" class="datepicker {{ $errors->has('waktu') ? 'is-invalid' : '' }}" />
                            <x-jet-input-error for="waktu" />
                        </div>
                        <div class="mb-1">
                            <x-jet-label class="form-label" for="tempat" value="{{ __('Tempat Kegiatan') }}" />
                            <x-jet-input id="tempat" type="text" class="{{ $errors->has('tempat') ? 'is-invalid' : '' }}" wire:model.defer="tempat" autocomplete="tempat" />
                            <x-jet-input-error for="tempat" />
                        </div>
                        <div class="col-12 text-center">
                            <button class="btn btn-primary me-1 mt-2" wire:click.prevent="store()">Simpan</button>
                            <button type="reset" class="btn btn-outline-secondary mt-2" data-bs-dismiss="modal" aria-label="Close" wire:click.prevent="cancel()">Batal</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>