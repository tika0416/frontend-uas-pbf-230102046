<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Rumah Sakit</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary mb-4">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Dashboard RS</a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="/pasien">Pasien</a></li>
                    <li class="nav-item"><a class="nav-link" href="/obat">Obat</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        <h1 class="mb-4">Selamat Datang di Dashboard Rumah Sakit</h1>

        <div class="row">
            <div class="col-md-6 mb-4">
                <div class="card text-white bg-info">
                    <div class="card-body">
                        <h5 class="card-title">Data Pasien</h5>
                        <p class="card-text">Lihat dan kelola daftar pasien.</p>
                        <a href="/pasien" class="btn btn-light">Lihat Pasien</a>
                    </div>
                </div>
            </div>

            <div class="col-md-6 mb-4">
                <div class="card text-white bg-success">
                    <div class="card-body">
                        <h5 class="card-title">Data Obat</h5>
                        <p class="card-text">Lihat dan kelola daftar obat.</p>
                        <a href="/obat" class="btn btn-light">Lihat Obat</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
