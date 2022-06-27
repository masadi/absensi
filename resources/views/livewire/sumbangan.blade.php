<div>
    @include('livewire.donasi.create')
    @include('livewire.donasi.update')
    @include('livewire.donasi.delete')
    @include('livewire.donasi.donasi')
    @include('livewire.donasi.riwayat')
    <table class="table table-bordered mt-2 mb-2">
        <thead>
            <tr>
                <th>Nama Donasi</th>
                <th>Dana Terkumpul</th>
                <th>Deskripsi</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($donasi as $value)
            <tr>
                <td>{{ $value->judul }}</td>
                <td>{{ number_format($value->dana->sum('nominal'),0,'','.') }}</td>
                <td>{{ $value->deskripsi }}</td>
                <td>
                    @hasanyrole('dpw|admin')
                    <button data-bs-toggle="modal" data-bs-target="#updateModal" wire:click="edit({{ $value->id }})" class="btn btn-primary btn-sm">Edit</button>
                    <button type="button" wire:click="deleteId({{ $value->id }})" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal">Hapus</button>
                    @else
                    <button data-bs-toggle="modal" data-bs-target="#donasiModal" wire:click="donasi({{ $value->id }})" class="btn btn-primary btn-sm">Donasi</button>
                    <button data-bs-toggle="modal" data-bs-target="#riwayatModal" wire:click="riwayat({{ $value->id }}, {{ $user->id }})" class="btn btn-warning btn-sm">Riwayat</button>
                    @endhasanyrole
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{ $donasi->links() }}
</div>