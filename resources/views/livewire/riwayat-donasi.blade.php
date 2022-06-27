<div>
    <table class="table table-bordered mt-2 mb-2">
        <thead>
            <tr>
                <th>No.</th>
                <th>Judul Donasi</th>
                <th>Nominal</th>
                <th>Nama Pengirim</th>
                <th>Nomor Pengirim</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @if($riwayat->count())
            @foreach ($riwayat as $item)
            <tr>
                <td>{{$loop->iteration}}</td>
                <td>{{$item->donasi->judul}}</td>
                <td>{{$item->nominal}}</td>
                <td>{{$item->nominal}}</td>
                <td>{{$item->nominal}}</td>
                <td>{!!($item->approved) ? '<span class="badge badge-glow bg-success">Telah diverifikasi</span>' : '<span class="badge badge-glow bg-danger">Belum diverifikasi</span>'!!}</td>
            </tr>
            @endforeach
            @else
            <tr>
                <td colspan="6" class="text-center">Anda belum pernah melakukan donasi</td>
            </tr>
            @endif
        </tbody>
    </table>
    {{ $riwayat->links() }}
</div>
