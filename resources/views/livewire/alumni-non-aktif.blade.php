<div>
    @include('livewire.alumni-non-aktif.detil')
    @include('livewire.alumni-non-aktif.setujui')
    <table class="table table-bordered mt-2 mb-2">
        <thead>
            <tr>
                <th>Nama Lengkap</th>
                <th>Email</th>
                <th>No. HP</th>
                <th>Tahun Masuk</th>
                <th>Tahun Lulus</th>
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
                <td>{{ $value->nomor_handphone }}</td>
                <td>{{ $value->tahun_masuk }}</td>
                <td>{{ $value->tahun_lulus }}</td>
                <td>{{ ($value->dpw) ? $value->dpw->nama : '-' }}</td>
                <td>
                    <button data-bs-toggle="modal" data-bs-target="#viewModal" wire:click="detil({{ $value->id }})" class="btn btn-primary btn-sm">Detil</button>
                    @if($value->doesntHave('roles'))
                    <button type="button" wire:click="deleteId({{ $value->id }})" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal">Setujui</button>
                    @endif
                </td>
            </tr>
            @endforeach
            @else
            <tr>
                <td colspan="7" class="text-center">Tidak ada data untuk ditampilkan</td>
            </tr>
            @endif
        </tbody>
    </table>
    {{ $results->links() }}
</div>