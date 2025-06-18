# FRONTEND - SISTEM RUMAH SAKIT
Sistem Rumah Sakit membantu pengelolaan data pasien dan obat secara terintegrasi untuk menunjang pelayanan kesehatan yang lebih baik. Data pasien mencakup identitas, riwayat kunjungan, diagnosa, serta rekam medis yang dapat diakses oleh tenaga medis untuk memberikan penanganan yang tepat. Sementara itu, sistem juga mengelola data obat mulai dari stok, resep dokter, distribusi, hingga penggunaan obat oleh pasien. Dengan sistem ini, proses pemberian obat menjadi lebih terkontrol dan tercatat dengan baik, serta meminimalkan kesalahan dalam penanganan pasien.


🔗 BackEnd  :https://github.com/tika0416/Backend_rumahsakit.git



🔗 Database : https://drive.google.com/drive/folders/1i4C-KC2sQjWilzbQ47SKOpCbkF88o0Wi

## Teknologi yang Digunakan
- Laravel 12
- REST API Backend (misal: CodeIgniter 4)
- Postman (untuk cek EndPoint BE)


## 📦 BACKEND

<h3>1. Install CodeIgniter</h3>

```bash
composer create-project codeigniter4/appstarter backend_rumahsakit
composer install
```
<h3>3. Copy File Environment</h3>

```bash
cp .env.example .env
```

<h3>4. Menjalankan CodeIgniter</h3>

```bash
php spark serve
```

<h3>5. Cek EndPoint menggunakan Postman

LINK POSTMAN : https://drive.google.com/drive/folders/1jy76yYynuSth7kelwv8vvqCEaPKYYmHQ?usp=drive_link

##  FRONTEND
<h3>1. Install Laravel </h3>
<h3>Pastikan Prasyarat Terpenuhi</h3>
Sebelum menginstal Laravel menggunakan Laragon, pastikan sistem memiliki:

- Laragon (https://laragon.org/download/)
- PHP ≥ 8.1 (termasuk dalam Laragon)
- Composer (termasuk dalam Laragon)
- MySQL (dapat menggunakan database bawaan Laragon)

<h3>Melalui Terminal/CMD</h3>

```
composer create-priject laravel/laravel (nama-projek)
```
<h3>Laragon</h3>

- Buka Laragon
- Klik kanan Quick app
- Laravel

<h3>2. Install Dependency Laravel</h3>

```bash
composer install
```

<h3>3. Copy File Environment</h3>

```bash
cp .env.example .env
```
<h3>5. Set .env untuk Non-Database App</h3>

```bash
APP_NAME=Laravel
APP_URL=http://localhost:8000
SESSION_DRIVER=file
```

> Tidak perlu konfigurasi DB karena semua data berasal dari API CodeIgniter.

<h3>6. Menjalankan Laravel</h3>

```bash
php artisan serve
```

##  Routing 
Di routes/web.php :

```bash
<?php

<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PasienController;


Route::get('/dashboard', function () {
    return view('dashboard');
});
Route::get('/pasien', [PasienController::class, 'index']);
Route::get('/', function () {
    return view('welcome');
});


## 🧑‍💻 Controller
<h3>Generate Controller</h3>

```bash
php artisan make:controller nama_fileController / php artisan make:model PasienController -mcr
```
file berada di `app/Http/Controllers/PasienController.php`
jika ingin melihat file controllers yang lain bisa lihat di `app/Http/Controllers`

<h3>Contoh PasienController.php</h3>

```bash
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PasienController extends Controller
{
    public function index()
    {
        $response = Http::get('http://localhost:8080/pasien');

        if ($response->successful()) {
            $mahasiswa = collect($response->json())->sortBy('id')->values();
            return view('Pasien.index', compact('pasien'));
        } else {
            return back()->with('error', 'Gagal ambil data');
        }
    }

    public function create()
    {
        return view('Pasien.create');
    }

    public function store(Request $request)
    {
        $response = Http::post('http://localhost:8080/pasien', [
            'npm_mhs' => $request->npm_mhs,
            'nama_mhs' => $request->nama_mhs,
            'prodi' => $request->prodi,
            'alamat' => $request->alamat,
            'no_telp' => $request->no_telp,
            'email' => $request->email,
        ]);

        if ($response->successful()) {
            return redirect()->route('Pasien.index')->with('success', 'Pasien berhasil ditambahkan');
        } else {
            return back()->with('error', 'Gagal menambahkan data');
        }
    }

    public function show($id)
    {
        $response = Http::get("http://localhost:8080/mahasiswa/$id");

        if ($response->successful()) {
            $mahasiswa = $response->json();
            return view('Pasien.show', compact('Pasien'));
        } else {
            return back()->with('error', 'Data tidak ditemukan');
        }
    }

    public function edit($id)
    {
        $response = Http::get("http://localhost:8080/pasien/$id");

        if ($response->successful()) {
            $mahasiswa = $response->json();
            return view('Pasien.edit', compact('pasien'));
        } else {
            return back()->with('error', 'Data tidak ditemukan');
        }
    }

    public function update(Request $request, $npm)
    {
        $response = Http::put("http://localhost:8080/mahasiswa/$npm", [
            'nama_mhs' => $request->nama_mhs,
            'prodi' => $request->prodi,
            'alamat' => $request->alamat,
            'no_telp' => $request->no_telp,
            'email' => $request->email,
        ]);

        if ($response->successful()) {
            return redirect()->route('Mahasiswa.index')->with('success', 'Data berhasil diupdate');
        } else {
            return back()->with('error', 'Gagal mengupdate data');
        }
    }

    public function destroy($npm)
    {
        $response = Http::delete("http://localhost:8080/mahasiswa/$npm");

        if ($response->successful()) {
            return redirect()->route('Mahasiswa.index')->with('success', 'Data berhasil dihapus');
        } else {
            return back()->with('error', 'Gagal menghapus data');
        }
    }
}

## 🧾 View (Blade)
<h3>Generate View</h3>

```bash
php artisan make:view nama_file
```
file berada di `resources/views/Pasien.blade.php`
jika ingin melihat file view yang lain bisa lihat di `resources/views`

<h3>1. Contoh Pasien.blade.php</h3>

```bash
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


## Export PDF
- `composer require barryvdh/laravel-dompdf `
-  buat view cetak pada `resources/views/pdf/cetak.blade.php`

```bash
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kartu Hasil Studi</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .header {
            text-align: center;
            padding: 20px 0;
            border-bottom: 2px solid #000;
        }

        .header img {
            max-width: 100px;
            margin-bottom: 10px;
        }

        .header h3 {
            margin: 0;
            font-size: 18px;
        }

        .header p {
            margin: 5px 0;
            font-size: 12px;
            color: #333;
        }

        .content {
            margin: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }

        .footer {
            text-align: center;
            margin-top: 40px;
            font-size: 10px;
            color: #666;
        }
    </style>
</head>

<body>
    <!-- Header -->
    <div class="header">
        <!-- <img src="https://pnc.ac.id/wp-content/uploads/2023/01/logo-pnc.png" alt="Logo PNC" onerror="this.src='https://via.placeholder.com/100x100?text=PNC+Logo';"> -->
        <h3>KEMENTERIAN PENDIDIKAN, TINGGI, SAINS, DAN TEKNOLOGI</h3>
        <h3>POLITEKNIK NEGERI CILACAP</h3>
        <p>Jalan Dr. Soetomo No. 1, Sidakaya - Cilacap 53212 Jawa Tengah</p>
        <p>Telepon: (0282) 533329, Fax: (0282) 537992</p>
        <p>www.pnc.ac.id, Email: sekretariat@pnc.ac.id</p>
    </div>

    <!-- Konten Utama -->
    <div class="content">
        <h2 style="text-align: center;">Kartu Hasil Studi</h2>
        <p>Nama : Andika Wijaya</p>
        <p>NPM : 22000</P>
        <p>Program Studi : D3-Teknik Informatika</p>
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kode Matkul</th>
                    <th>Nama Matkul</th>
                    <th>SKS</th>
                    <th>Nilai</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($khs as $index => $k)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $k['Kode Mata Kuliah'] }}</td>
                    <td>{{ $k['Nama Mata Kuliah'] }}</td>
                    <td>{{ $k['Jumlah SKS'] }}</td>
                    <td>{{ $k['Nilai'] }}</td>
                    <td>{{ $k['Status Kelulusan'] }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <p>Indeks Prestasi : ....</p>
        <p>Indeks Prestasi Kumulatif : ....</p>
        <p>Status Kelulusan : Lulus</p>
        <p style="text-align: right;">Cilacap, ...................</p>
    </div>

    <!-- Footer (opsional) -->

</body>

</html>
```





  




