<div>
    <!-- Modal -->
    <div wire:ignore.self class="modal fade" id="donasiModal" tabindex="-1" aria-labelledby="addNewAddressTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-transparent">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body pb-5 px-sm-4 mx-50">
                    <h1 class="address-title text-center mb-1" id="addNewAddressTitle">Proses Donasi</h1>
                    @if($data)
                    <table class="table">
                        <tr>
                            <td>Nama Donasi</td>
                            <td>: {{$data->judul}}</td>
                        </tr>
                        <tr>
                            <td>Deskripsi</td>
                            <td>: {{$data->deskripsi}}</td>
                        </tr>
                        <tr>
                            <td>Nomor Rekening</td>
                            <td>: {{$data->nomor_rekening}}</td>
                        </tr>
                        <tr>
                            <td>Nama Rekening</td>
                            <td>: {{$data->nama_rekening}}</td>
                        </tr>
                        <tr>
                            <td>Gambar</td>
                            <td><img src="/storage/gambar/{{$data->gambar}}" alt="" class="img-fluid"></td>
                        </tr>
                    </table>
                    @endif
                    <form>
                        <input type="hidden" wire:model="penyumbang_id">
                        <input type="hidden" wire:model="donasi_id">
                        <div class="mb-1">
                            <x-jet-label class="form-label" for="nominal" value="{{ __('Nominal Transfer') }}" />
                            <x-jet-input id="nominal" type="text" class="{{ $errors->has('nominal') ? 'is-invalid' : '' }}"
                            wire:model.defer="nominal" autocomplete="nominal" />
                            <x-jet-input-error for="nominal" />
                        </div>
                        <div class="mb-1">
                            <x-jet-label class="form-label" for="nama_bank" value="{{ __('Nama Bank') }}" />
                            <x-jet-input id="nama_bank" type="text" class="{{ $errors->has('nama_bank') ? 'is-invalid' : '' }}"
                            wire:model.defer="nama_bank" autocomplete="nama_bank" />
                            <x-jet-input-error for="nama_bank" />
                        </div>
                        <div class="mb-1">
                            <x-jet-label class="form-label" for="nomor_pengirim" value="{{ __('Nomor Rekening') }}" />
                            <x-jet-input id="nomor_pengirim" type="text" class="{{ $errors->has('nomor_pengirim') ? 'is-invalid' : '' }}"
                            wire:model.defer="nomor_pengirim" autocomplete="nomor_pengirim" />
                            <x-jet-input-error for="nomor_pengirim" />
                        </div>
                        <div class="mb-1">
                            <x-jet-label class="form-label" for="nama_pengirim" value="{{ __('Nama Rekening') }}" />
                            <x-jet-input id="nama_pengirim" type="text" class="{{ $errors->has('nama_pengirim') ? 'is-invalid' : '' }}"
                            wire:model.defer="nama_pengirim" autocomplete="nama_pengirim" />
                            <x-jet-input-error for="nama_pengirim" />
                        </div>
                        <div class="mb-1" x-data="{photoName: null, photoPreview: null}">
                            <!-- Profile Photo File Input -->
                            <input type="file" hidden wire:model="bukti" x-ref="bukti"
                            x-on:change=" photoName = $refs.bukti.files[0].name; const reader = new FileReader(); reader.onload = (e) => { photoPreview = e.target.result; return false;}; reader.readAsDataURL($refs.bukti.files[0]);" class="{{ $errors->has('bukti') ? 'is-invalid' : '' }}" />
                    
                            <!-- New Profile Photo Preview -->
                            @if($bukti)
                            <div class="mt-2" x-show="photoPreview">
                            <img x-bind:src="photoPreview" class="rounded-circle" width="80px" height="80px">
                            </div>
                            @endif
                            <x-jet-secondary-button class="mt-2 me-2" type="button" x-on:click.prevent="$refs.bukti.click()">
                            {{ __('Upload Bukti Transfer') }}
                            </x-jet-secondary-button>
                    
                            <x-jet-input-error for="bukti" class="mt-2" />
                        </div>
                        <div class="col-12 text-center">
                            <!--button class="btn btn-primary me-1 mt-2" wire:click.prevent="store()">Simpan</button>
                            <button type="reset" class="btn btn-outline-secondary mt-2" data-bs-dismiss="modal" aria-label="Close">
                            Batal
                            </button-->
                            <button type="button" wire:click.prevent="proses()" class="btn btn-primary me-1 mt-2" data-dismiss="modal">Proses Donasi</button>
                            <button type="reset" class="btn btn-outline-secondary mt-2" data-bs-dismiss="modal" aria-label="Close">Batal</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>