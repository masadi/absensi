<div>
    <div wire:ignore.self class="modal fade" id="createModal" tabindex="-1" aria-labelledby="addNewAddressTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-transparent">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body pb-5 px-sm-4 mx-50">
                    <h1 class="address-title text-center mb-1" id="addNewAddressTitle">Tambah Data DPW</h1>
                    <form>
                        <div class="mb-1">
                            <x-jet-label class="form-label" for="nama" value="{{ __('Nama DPW') }}" />
                            <x-jet-input id="nama" type="text" class="{{ $errors->has('nama') ? 'is-invalid' : '' }}" wire:model.defer="nama" autocomplete="nama" />
                            <x-jet-input-error for="nama" />
                        </div>
                        <div class="mb-1">
                            <x-jet-label class="form-label" for="alamat" value="{{ __('Alamat Kantor') }}" />
                            <x-jet-input id="alamat" type="text" class="{{ $errors->has('alamat') ? 'is-invalid' : '' }}" wire:model.defer="alamat" autocomplete="alamat" />
                            <x-jet-input-error for="alamat" />
                        </div>
                        <div class="mb-1">
                            <x-jet-label class="form-label" for="nama_ketua" value="{{ __('Ketua DPW') }}" />
                            <x-jet-input id="nama_ketua" type="text" class="{{ $errors->has('nama_ketua') ? 'is-invalid' : '' }}" wire:model.defer="nama_ketua" autocomplete="nama_ketua" />
                            <x-jet-input-error for="nama_ketua" />
                        </div>
                        <div class="mb-1">
                            <x-jet-label class="form-label" for="nama_sekretaris" value="{{ __('Sekretaris DPW') }}" />
                            <x-jet-input id="nama_sekretaris" type="text" class="{{ $errors->has('nama_sekretaris') ? 'is-invalid' : '' }}" wire:model.defer="nama_sekretaris" autocomplete="nama_sekretaris" />
                            <x-jet-input-error for="nama_sekretaris" />
                        </div>
                        <div class="mb-1">
                            <x-jet-label class="form-label" for="nama_bendahara" value="{{ __('Bendahara DPW') }}" />
                            <x-jet-input id="nama_bendahara" type="text" class="{{ $errors->has('nama_bendahara') ? 'is-invalid' : '' }}" wire:model.defer="nama_bendahara" autocomplete="nama_bendahara" />
                            <x-jet-input-error for="nama_bendahara" />
                        </div>
                        {{--
                        <div>
                            <x-jet-label class="form-label" for="ketua_id" value="Ketua DPW" />
                            <select class="form-control select2 {{ $errors->has('ketua_id') ? 'is-invalid' : '' }}" id="ketua_id" wire:model.defer="ketua_id">
                                <option value="">Cari nama alumni</option>
                            </select>
                            <x-jet-input-error for="ketua_id" />
                        </div>
                        <div>
                            <x-jet-label class="form-label" for="sekretaris_id" value="Sekretaris DPW" />
                            <select class="form-control select2 {{ $errors->has('sekretaris_id') ? 'is-invalid' : '' }}" id="sekretaris_id" wire:model.defer="sekretaris_id">
                                <option value="">Cari nama alumni</option>
                            </select>
                            <x-jet-input-error for="sekretaris_id" />
                        </div>
                        <div>
                            <x-jet-label class="form-label" for="bendahara_id" value="Bendahara DPW" />
                            <select class="form-control select2 {{ $errors->has('bendahara_id') ? 'is-invalid' : '' }}" id="bendahara_id" wire:model.defer="bendahara_id">
                                <option value="">Cari nama alumni</option>
                            </select>
                            <x-jet-input-error for="bendahara_id" />
                        </div>
                        <div class="mb-1">
                            @livewire('select2-dropdown', ['data' => [
                                'id' => 'ketua_id',
                                'model' => 'ketua_id',
                                'title' => 'Ketua DPW',
                                'placeholder' => 'Cari nama alumni',
                                'url' => '/api/cari-alumni',
                                'modalId' => 'createModal',
                                'value' => '',
                            ]])
                        </div>
                        <div class="mb-1">
                            @livewire('select2-dropdown', ['data' => [
                                'id' => 'sekretaris_id',
                                'model' => 'sekretaris_id',
                                'title' => 'Sekretaris DPW',
                                'placeholder' => 'Cari nama alumni',
                                'url' => '/api/cari-alumni',
                                'modalId' => 'createModal',
                                'value' => '',
                            ]])
                        </div>
                        <div class="mb-1">
                            @livewire('select2-dropdown', ['data' => [
                                'id' => 'bendahara_id',
                                'model' => 'bendahara_id',
                                'title' => 'Bendahara DPW',
                                'placeholder' => 'Cari nama alumni',
                                'url' => '/api/cari-alumni',
                                'modalId' => 'createModal',
                                'value' => '',
                            ]])
                        </div>
                        --}}
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