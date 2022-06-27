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
                            <x-jet-input id="user_id" type="text" wire:model.defer="user_id" autocomplete="user_id" />
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
                                'id' => 'update_dpw_id',
                                'model' => 'dpw_id',
                                'title' => 'Nama DPW',
                                'placeholder' => 'Cari nama DPW',
                                'url' => '/api/cari-dpw',
                                'modalId' => 'updateModal',
                                'value' => $dpw_id,
                            ]])
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