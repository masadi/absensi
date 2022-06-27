<div>
    <table class="table table-bordered mt-2 mb-2">
        <thead>
            <tr>
                <th>Nama Kegiatan</th>
                <th>Waktu Kegiatan</th>
                <th>Tempat Kegiatan</th>
            </tr>
        </thead>
        <tbody>
            @if($results->count())
            @foreach($results as $value)
            <tr>
                <td>{{ $value->nama }}</td>
                <td>{{ $value->waktu }}</td>
                <td>{{ $value->tempat }}</td>
            </tr>
            @endforeach
            @else
            <tr>
                <td colspan="3" class="text-center">Tidak ada data untuk ditampilkan</td>
            </tr>
            @endif
        </tbody>
    </table>
    {{ $results->links() }}
</div>
