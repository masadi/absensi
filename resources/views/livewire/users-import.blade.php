<div>
    <div wire:ignore.self class="modal fade" id="createModal" tabindex="-1" aria-labelledby="addNewAddressTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-transparent">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body pb-5 px-sm-4 mx-50">
                    <h1 class="address-title text-center mb-1" id="addNewAddressTitle">Import Data Alumni</h1>
                    <h2 class="address-title text-center mb-1"></h2>
                    <form>
                        <div class="mb-1" x-data="{photoName: null, photoPreview: null}">
                            <!-- Profile Photo File Input -->
                            <input type="file" hidden wire:model="excel" x-ref="excel" />
                            <div class="row">
                                <div class="col-6 d-grid gap-2">
                                    <x-jet-secondary-button class="mt-2 me-2" type="button" x-on:click.prevent="$refs.excel.click()">
                                        {{ __('Pilih file excel') }}
                                    </x-jet-secondary-button>
                                </div>
                                <div class="col-6 d-grid gap-2">
                                    <a href="/downloads/template-alumni.xlsx" class="btn btn-warning text-uppercase mt-2 me-2">Download File Excel</a>
                                </div>
                            </div>
                            <x-jet-input-error for="gambar" class="mt-2" />
                        </div>
                        <div class="col-12 text-center">
                            <button class="btn btn-primary me-1 mt-2" wire:click.prevent="store()">Simpan</button>
                            <button type="reset" class="btn btn-outline-secondary mt-2" data-bs-dismiss="modal" aria-label="Close">
                            Batal
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
