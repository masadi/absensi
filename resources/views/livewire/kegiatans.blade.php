<div>
    @include('livewire.kegiatan.create')
    @include('livewire.kegiatan.update')
    @include('livewire.kegiatan.delete')
    @include('livewire.kegiatan.hadir')
    @include('livewire.kegiatan.batal')
    <table class="table table-bordered mt-2 mb-2">
        <thead>
            <tr>
                <th>Nama Kegiatan</th>
                <th>Waktu Kegiatan</th>
                <th>Tempat Kegiatan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($results as $value)
            <tr>
                <td>{{ $value->nama }}</td>
                <td>{{ $value->waktu }}</td>
                <td>{{ $value->tempat }}</td>
                <td>
                    @hasanyrole('dpw|admin')
                    <button data-bs-toggle="modal" data-bs-target="#updateModal" wire:click="edit({{ $value->id }})" class="btn btn-primary btn-sm">Edit</button>
                    <button type="button" wire:click="deleteId({{ $value->id }})" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal">Hapus</button>
                    <button type="button" wire:click="hadirId({{ $value->id }})" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal">Hadir</button>
                    @else
                    <?php
                    $kehadiran = $value->kehadiran()->where('user_id', $user->id)->first();
                    ?>
                    @if($kehadiran)
                    <span class="badge bg-info">Akan Hadir</span>
                    <button type="button" wire:click="hadirId({{ $value->id }})" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#batalModal">Batal Hadir</button>
                    @else
                    <button type="button" wire:click="hadirId({{ $value->id }})" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#hadirModal">Hadir</button>
                    @endif
                    @endhasanyrole
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{ $results->links() }}
</div>