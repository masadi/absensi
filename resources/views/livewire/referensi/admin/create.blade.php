<div>
    <div wire:ignore.self class="modal fade" id="createModal" tabindex="-1" aria-labelledby="addNewAddressTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-transparent">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body pb-5 px-sm-4 mx-50">
                    <h1 class="address-title text-center mb-1" id="addNewAddressTitle">Tambah Data Admin DPW</h1>
                    <form>
                        <div class="mb-1">
                            <x-jet-label class="form-label" for="name" value="{{ __('Nama Lengkap') }}" />
                            <x-jet-input id="name" type="text" class="{{ $errors->has('name') ? 'is-invalid' : '' }}" wire:model.defer="name" autocomplete="name" />
                            <x-jet-input-error for="name" />
                        </div>
                        <div class="mb-1">
                            <x-jet-label class="form-label" for="email" value="{{ __('Email') }}" />
                            <x-jet-input id="email" type="email" class="{{ $errors->has('email') ? 'is-invalid' : '' }}" wire:model.defer="email" autocomplete="email" />
                            <x-jet-input-error for="email" />
                        </div>
                        <div class="mb-1">
                            @livewire('select2-dropdown', ['data' => [
                                'id' => 'dpw_id',
                                'model' => 'dpw_id',
                                'title' => 'Nama DPW',
                                'placeholder' => 'Cari nama DPW',
                                'url' => '/api/cari-dpw',
                                'modalId' => 'createModal',
                                'value' => '',
                            ]])
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