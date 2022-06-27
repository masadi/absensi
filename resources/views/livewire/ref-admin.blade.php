<div>
    @include('livewire.referensi.admin.create')
    @include('livewire.referensi.admin.update')
    @include('livewire.referensi.admin.delete')
    <table class="table table-bordered mt-2 mb-2">
        <thead>
            <tr>
                <th>Nama Lengkap</th>
                <th>Email</th>
                <th>DPW</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @if($results->count())
            @foreach($results as $value)
            <tr>
                <td>{{ $value->name }}</td>
                <td>{{ $value->email }}</td>
                <td>{{ ($value->dpw) ? $value->dpw->nama : '-' }}</td>
                <td>
                    <button data-bs-toggle="modal" data-bs-target="#updateModal" wire:click="edit({{ $value->id }})" class="btn btn-primary btn-sm">Edit</button>
                    <button type="button" wire:click="deleteId({{ $value->id }})" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal">Hapus</button>
                </td>
            </tr>
            @endforeach
            @else
            <tr>
                <td colspan="4" class="text-center">Tidak ada data untuk ditampilkan</td>
            </tr>
            @endif
        </tbody>
    </table>
    {{ $results->links() }}
</div>