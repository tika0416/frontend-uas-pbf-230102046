<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Daftar Pasien</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">
    <div class="container">
        <h2 class="mb-4">Daftar Pasien</h2>

        <a href="#" class="btn btn-primary mb-3">+ Tambah Pasien</a>

        <table class="table table-bordered table-striped">
            <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>Nama</th>
                    <th>Alamat</th>
                    <th>Telepon</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($pasien as $p)
                    <tr>
                        <td>{{ $p['id'] }}</td>
                        <td>{{ $p['nama'] }}</td>
                        <td>{{ $p['alamat'] }}</td>
                        <td>{{ $p['telepon'] ?? '-' }}</td>
                        <td>
                            <a href="#" class="btn btn-sm btn-warning">Edit</a>
                            <a href="#" class="btn btn-sm btn-danger">Hapus</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center">Data pasien tidak tersedia.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</body>
</html>
