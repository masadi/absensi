<div>
    <div wire:ignore.self class="modal fade" id="hadirModal" tabindex="-1" role="dialog" aria-labelledby="hadirModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="hadirModalLabel">Apakah Anda akan Hadir?</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
               <div class="modal-body">
                    <p>Klik Ya jika Anda ingin menghadiri kegiatan ini!</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary close-btn" data-bs-dismiss="modal">Batal</button>
                    <button type="button" wire:click.prevent="hadir()" class="btn btn-danger close-modal" data-dismiss="modal">Ya, Hadir!</button>
                </div>
            </div>
        </div>
    </div>
</div>