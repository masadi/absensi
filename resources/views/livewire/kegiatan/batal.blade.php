<div>
    <div wire:ignore.self class="modal fade" id="batalModal" tabindex="-1" role="dialog" aria-labelledby="batalModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="batalModalLabel">Apakah Anda akan batal?</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
               <div class="modal-body">
                    <p>Klik Ya jika Anda ingin membatalkan kehadiran di kegiatan ini!</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary close-btn" data-bs-dismiss="modal">Tutup</button>
                    <button type="button" wire:click.prevent="batal()" class="btn btn-danger close-modal" data-dismiss="modal">Ya, Batalkan!</button>
                </div>
            </div>
        </div>
    </div>
</div>