<div>
    <div wire:ignore.self class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="addNewAddressTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-transparent">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body pb-5 px-sm-4 mx-50">
                    <h1 class="address-title text-center mb-1" id="addNewAddressTitle">Perbaharui Data Kegiatan</h1>
                    <form>
                        <div class="mb-1">
                            <x-jet-input id="dpw_id" type="hidden" wire:model.defer="dpw_id" autocomplete="dpw_id" />
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
                        <div class="mb-1">
                            @livewire('select2-dropdown', ['data' => [
                                'id' => 'update_ketua_id',
                                'model' => 'ketua_id',
                                'title' => 'Ketua DPW',
                                'placeholder' => $nama_ketua,
                                'url' => '/api/cari-alumni',
                                'modalId' => 'updateModal',
                                'value' => $ketua_id,
                            ]])
                        </div>
                        <div class="mb-1">
                            @livewire('select2-dropdown', ['data' => [
                                'id' => 'update_sekretaris_id',
                                'model' => 'sekretaris_id',
                                'title' => 'Sekretaris DPW',
                                'placeholder' => $nama_sekretaris,
                                'url' => '/api/cari-alumni',
                                'modalId' => 'updateModal',
                                'value' => $sekretaris_id,
                            ]])
                        </div>
                        <div class="mb-1">
                            @livewire('select2-dropdown', ['data' => [
                                'id' => 'update_bendahara_id',
                                'model' => 'bendahara_id',
                                'title' => 'Bendahara DPW',
                                'placeholder' => $nama_bendahara,
                                'url' => '/api/cari-alumni',
                                'modalId' => 'updateModal',
                                'value' => $bendahara_id,
                            ]])
                        </div>
                        --}}
                        <div class="col-12 text-center">
                            <button class="btn btn-primary me-1 mt-2" wire:click.prevent="update()">Perbaharui</button>
                            <button type="reset" class="btn btn-outline-secondary mt-2" data-bs-dismiss="modal" aria-label="Close" wire:click.prevent="cancel()">Batal</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>