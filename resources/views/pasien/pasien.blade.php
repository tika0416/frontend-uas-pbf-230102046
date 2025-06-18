<!DOCTYPE html>
<html>
<head>
    <title>Daftar Pasien</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">
    <div class="container">
        <h2 class="mb-4">Daftar Pasien</h2>

        <table class="table table-bordered">
            <thead class="table-light">
                <tr>
                    <th>Nama</th>
                    <th>Alamat</th>
                    <th>Tanggal Lahir</th>
                    <th>Jenis Kelamin</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($pasien as $p)
                    <tr>
                        <td>{{ $p['id'] }}</td>
                        <td>{{ $p['nama'] }}</td>
                        <td>{{ $p['alamat'] }}</td>
                        <td>{{ $p['telepon'] ?? '-' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center">Tidak ada data pasien.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</body>
</html>
