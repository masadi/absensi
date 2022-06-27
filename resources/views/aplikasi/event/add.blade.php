<!-- add new address modal -->
<div wire:ignore.self class="modal fade" id="tambahDonasi" tabindex="-1" aria-labelledby="addNewAddressTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header bg-transparent">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body pb-5 px-sm-4 mx-50">
        <h1 class="address-title text-center mb-1" id="addNewAddressTitle">Tambah Data Donasi</h1>
        @livewire('tambah-donasi')
      </div>
    </div>
  </div>
</div>
<div wire:ignore.self class="modal fade" id="editData" tabindex="-1" aria-labelledby="addNewAddressTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header bg-transparent">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body pb-5 px-sm-4 mx-50" id="dynamic">
        
      </div>
    </div>
  </div>
</div>
=<!-- / add new address modal -->
