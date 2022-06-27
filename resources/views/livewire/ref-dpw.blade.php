<div>
    @include('livewire.referensi.dpw.create')
    @include('livewire.referensi.dpw.update')
    @include('livewire.referensi.dpw.delete')
    <table class="table table-bordered mt-2 mb-2">
        <thead>
            <tr>
                <th>Nama DPW</th>
                <th>Alamat Kantor</th>
                <th>Ketua</th>
                <th>Sekretaris</th>
                <th>Bendahara</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @if($results->count())
            @foreach($results as $value)
            <tr>
                <td>{{ $value->nama }}</td>
                <td>{{ $value->alamat }}</td>
                <td>{{ $value->nama_ketua }}</td>
                <td>{{ $value->nama_sekretaris }}</td>
                <td>{{ $value->nama_bendahara }}</td>
                <td>
                    <button data-bs-toggle="modal" data-bs-target="#updateModal" wire:click="edit({{ $value->id }})" class="btn btn-primary btn-sm">Edit</button>
                    <button type="button" wire:click="deleteId({{ $value->id }})" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal">Hapus</button>
                </td>
            </tr>
            @endforeach
            @else
            <tr>
                <td colspan="6" class="text-center">Tidak ada data untuk ditampilkan</td>
            </tr>
            @endif
        </tbody>
    </table>
    {{ $results->links() }}
</div>