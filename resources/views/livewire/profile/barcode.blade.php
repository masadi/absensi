<div>
    <div class="card">
        <div class="card-body">
            <p>Silahkan unduh QRCode ini agar bisa melakukan absensi!</p>
            <p><img src="{{asset('storage/qrcodes/'.$user->pd->peserta_didik_id.'.svg')}}" alt="qrcodes" wire:click="downloadQrCode"></p>
        </div>
    </div>
</div>
