# 🎓 FRONTEND - SISTEM INFORMASI PENGELOLAAN NILAI MAHASISWA
Website ini merupakan sistem informasi pengelolaan nilai mahasiswa yang dirancang untuk memudahkan dosen dan admin akademik dalam mengelola data mahasiswa, mata kuliah, serta input dan rekapitulasi nilai. Sistem ini menyediakan fitur pencatatan nilai secara terstruktur, pencarian data, serta laporan nilai akhir mahasiswa. Cocok digunakan untuk skala perguruan tinggi.

Proyek ini merupakan implementasi frontend Laravel dengan Tailwind CSS yang berkomunikasi dengan backend REST API (dari CodeIgniter).

🔗 [SI-KHS Backend (GitHub)](https://github.com/Arfilal/backend_sinilai)

🔗 [SI-KHS Database (GitHub)](https://github.com/HanaKurnia/database_pbf)

## 🧱 Teknologi yang Digunakan
- Laravel 10
- Tailwind CSS
- Laravel HTTP Client (untuk konsumsi API)
- REST API Backend (misal: CodeIgniter 4)
- Vite (build frontend asset Laravel)
- Postman (untuk cek EndPoint BE)

## DATABASE
<h3>import database</h3>

🔗 [SI-KHS Database (GitHub)](https://github.com/HanaKurnia/database_pbf.git)

## 📦 BACKEND
<h3>1. Clone Repository BE</h3>

```bash
git clone https://github.com/Arfilal/backend_sinilai.git
cd backend_sinilai
```

<h3>2. Install Dependency CodeIgniter</h3>

```bash
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

<h3>5. Cek EndPoint menggunakan Postman, untuk Endpoint berada di GitHub BE</h3>

🔗 [SI-KHS Backend (GitHub)](https://github.com/Arfilal/backend_sinilai)

## 🎨 FRONTEND
<h3>1. Clone Repository FE</h3>
Jika ingin langsung menggukan folder ini

```bash
git clone https://github.com/GalihFitria/FrontEnd-SiNilai.git
cd FrontEnd-SiNilai
```

<h3>2. Install Laravel </h3>
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

<h3>3. Install Dependency Laravel</h3>

```bash
composer install
```

<h3>4. Copy File Environment</h3>

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

## 📁 Routing 
Di routes/web.php :

```bash
<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\LoginDosenController;
use App\Http\Controllers\LoginMahasiswaController;
use App\Http\Controllers\DashboardDosenController;
use App\Http\Controllers\DatadosenController;
use App\Http\Controllers\DatakelasController;
use App\Http\Controllers\DatamahasiswaController;
use App\Http\Controllers\DataprodiController;
use App\Http\Controllers\MatakuliahController;
use App\Http\Controllers\PenilaianController;
use App\Http\Controllers\TambahdosenController;
use App\Http\Controllers\TambahdataController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CetakKHSController;
use Illuminate\Support\Facades\Session;
use App\Models\penilaian;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('login');
})->name('login.dashboard');


Route::get('/login/dosen', [AuthController::class, 'showDosenLoginForm'])->name('login.dosen.form');
Route::get('/login/mahasiswa', [AuthController::class, 'showMahasiswaLoginForm'])->name('login.mahasiswa.form');

Route::post('/login', [AuthController::class, 'login'])->name('login.process');
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login.form');

Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/dashboard/dosen', function () {
    if (Session::get('role') !== 'dosen') {
        return redirect()->route('login.form')->with('error', 'Akses ditolak.');
    }
    return view('dashboard_dosen');
})->name('dashboard.dosen');


Route::get('/dashboard/mahasiswa', function () {
    if (Session::get('role') !== 'mahasiswa') {
        return redirect()->route('login.form')->with('error', 'Akses ditolak.');
    }
    return view('dashboard_mahasiswa');
})->name('dashboard.mahasiswa');

Route::get('/export-pdf', [CetakKHSController::class, 'exportPdf'])->name('export.pdf');
Route::resource('nilai', PenilaianController::class);
Route::resource('cetakKHS', CetakKHSController::class);
Route::resource('dosen', DatadosenController::class);
Route::resource('mahasiswa', DatamahasiswaController::class);
Route::resource('matakuliah', MatakuliahController::class);
Route::resource('prodi', DataprodiController::class);
Route::resource('kelas', DatakelasController::class);
```

## 🧑‍💻 Controller
<h3>Generate Controller</h3>

```bash
php artisan make:controller nama_fileController / php artisan make:model nama-file -mcr
```
file berada di `app/Http/Controllers/DatadosenController.php`
jika ingin melihat file controllers yang lain bisa lihat di `app/Http/Controllers`

<h3>Contoh DatadosenController.php</h3>

```bash
<?php

namespace App\Http\Controllers;

use App\Models\datadosen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class DatadosenController extends Controller
{
    /*controller di Laravel bertujuan menangani semua proses CRUD (Create, Read, Update, Delete) data dosen. 
    Semua data diambil dan dikirim melalui API eksternal (
    *
     * menampilkan daftar semua data dosen
     * mengambil data dari API eksternal dan menampilkannya pada view datadosen
     */
    public function index()
    {
        
        $response = Http::get('http://localhost:8080/dosen');

        if ($response->successful()) { 
        // mengurutkan data dosen berdasarkan NIDN
            $dosen = collect($response->json())->sortBy('nidn')->values();
            return view('datadosen', compact('dosen'));
        } else {
            //jika gagal mengambil data, kembali ke halaman sebelumnya dengan pesan error
            return back()->with('error', 'Gagal mengambil data dosen');
        }
    }


    /**
     * Menampilkan halaman form untuk menambahkan data dosen baru.
     */
    public function create()
    {
        return view('tambahdosen');
    }

    /**
     * menyimpan data dosen baru ke database melalui API.
     */
    public function store(Request $request)
    {
        try {
            $validate = $request->validate([
                'nidn' => 'required|unique:dosen,nidn',
                'nama_dosen' => 'required'
            ]);

            Http::post('http://localhost:8080/dosen', $validate);

            response()->json([
                'success' => true,
                'message' => 'Dosen berhasil ditambahkan!',
                'data' => $request
            ], 201);

            return redirect()->route('dosen.index');
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }


    /**
     * menampilkan halaman edit data dosen berdasarkan nidn.
     */
    public function edit($datadosen)
    {

        $respon_dosen = Http::get("http://localhost:8080/dosen/$datadosen/edit");
        $dosen = $respon_dosen->json();
        return view('editdosen', [
            'dosen' => $dosen
        ]);
    }

    /**
     * memperbarui data dosen melalui API berdasarkan nidn.
     */
    public function update(Request $request, $datadosen)
    {

        try {
            $validate = $request->validate([
                'nidn' => 'required',
                'nama_dosen' => 'required'
            ]);

            Http::put("http://localhost:8080/dosen/$datadosen", $validate);

            response()->json([
                'success' => true,
                'message' => 'Dosen berhasil diperbarui',
                'data' => $request
            ], 200);
            //redirect ke halaman index dosen
            return redirect()->route('dosen.index');
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Menghapus data dosen berdasarkan nidn melalui API.
     */
    public function destroy($datadosen)
    {
        //
        Http::delete("http://localhost:8080/dosen/$datadosen");
        return redirect()->route('dosen.index');
    }
}
```

## 🧾 View (Blade)
<h3>Generate View</h3>

```bash
php artisan make:view nama_file
```
file berada di `resources/views/Datadosen.blade.php`
jika ingin melihat file view yang lain bisa lihat di `resources/views`

<h3>1. Contoh datadosen.blade.php</h3>

```bash
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Dosen</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100" data-page="dosen">
    <div class="flex">

        <aside class="w-64 bg-blue-700 min-h-screen text-white p-4">
            <link href="https://fonts.googleapis.com/css2?family=Lobster&display=swap" rel="stylesheet">
            <h1 class="text-center text-4xl font-bold mb-6" style="font-family: 'Lobster', cursive;">Si Nilai</h1>
            <nav>
                <ul>
                    <li class="mb-4">
                        <a href="{{ route('dashboard.dosen') }}" class="flex items-center space-x-2 text-white font-semibold hover:bg-blue-800 p-2 rounded">
                            🏠 Dashboard
                        </a>
                    </li>
                    <li class="mb-4 relative">
                        <button id="dropdown-btn" class="w-full flex items-center justify-between text-white font-semibold hover:bg-blue-800 p-2 rounded">
                            📊 Pengolahan Data
                            <span id="arrow">▼</span>
                        </button>
                        <ul id="dropdown-menu" class="hidden bg-blue-600 mt-2 rounded-lg">
                            <li><a href="{{route('dosen.index')}}" class="block px-4 py-2 hover:bg-blue-700 active-link">Data Dosen</a></li>
                            <li><a href="{{route('mahasiswa.index')}}" class="block px-4 py-2 hover:bg-blue-700">Data Mahasiswa</a></li>
                            <li><a href="{{route('matakuliah.index')}}" class="block px-4 py-2 hover:bg-blue-700">Data Mata Kuliah</a></li>
                            <li><a href="{{route('prodi.index')}}" class="block px-4 py-2 hover:bg-blue-700">Data Prodi</a></li>
                            <li><a href="{{route('kelas.index')}}" class="block px-4 py-2 hover:bg-blue-700">Data Kelas</a></li>
                            <li><a href="{{route('nilai.index')}}" class="block px-4 py-2 hover:bg-blue-700">Penilaian</a></li>
                        </ul>
                    </li>
                </ul>
            </nav>
        </aside>


        <main class="flex-1 p-6">
            <h2 class="text-center text-4xl font-bold">.::Data Dosen::.</h2>
            <div class="bg-white shadow-md p-4 rounded-lg mt-4">
                <div class="flex justify-between mb-4">
                    <a href="{{route('dosen.create')}}" class="bg-blue-500 text-white px-4 py-2 rounded">+ Tambah Data</a>
                    <input type="text" id="searchInput" placeholder="Cari Dosen..." class="border p-2 rounded w-1/3">
                </div>
                <table class="w-full mt-4 border-collapse border border-gray-300">
                    <thead>
                        <tr class="bg-gray-200">
                            <th class="border p-2">No.</th>
                            <th class="border p-2">NIDN</th>
                            <th class="border p-2">Nama Dosen</th>
                            <th class="border p-2">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="dosenTable">
                        <!--menampilkan data dosen dari BE-->
                        @foreach($dosen as $index => $d)
                        <tr>
                            <td class="border p-2 text-center">{{ $index + 1 }}</td> <!-- Nomor otomatis -->
                            <td class="border p-2">{{ $d['nidn'] }}</td>
                            <td class="border p-2">{{ $d['nama_dosen'] }}</td>

                            <td class="border p-2 text-center flex gap-2 justify-center">

                                <a href="{{ route('dosen.edit', $d['nidn']) }}" class="bg-green-500 text-white px-3 py-1 rounded hover:bg-green-600">Edit</a>

                                <form action="{{ route('dosen.destroy', $d['nidn']) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600">Hapus</button>
                                </form>
                            </td>


                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <!-- Navigasi halaman (pagination) -->
                <div class="flex justify-between items-center mt-4">
                    <button id="prevPage" class="bg-gray-400 text-white px-3 py-1 rounded hover:bg-gray-500">Previous</button>
                    <span id="pageInfo" class="text-gray-700">Page 1</span>
                    <button id="nextPage" class="bg-gray-400 text-white px-3 py-1 rounded hover:bg-gray-500">Next</button>
                </div>
            </div>
        </main>
    </div>


    <div id="deleteModal" class="hidden fixed inset-0 bg-gray-800 bg-opacity-50 flex justify-center items-center">
        <div class="bg-white p-6 rounded-lg shadow-lg w-96 text-center">
            <h2 class="text-lg font-bold mb-4">Konfirmasi Hapus</h2>
            <p>Apakah Anda yakin ingin menghapus data ini?</p>
            <div class="mt-4 flex justify-center space-x-4">
                <button onclick="deleteData()" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">Ya, Hapus</button>
                <button onclick="closeDeleteModal()" class="bg-gray-400 text-white px-4 py-2 rounded hover:bg-gray-500">Batal</button>
            </div>
        </div>
    </div>

    <script>
        // Fungsi pagination
        let currentPage = 1;
        const rowsPerPage = 10;
        const table = document.getElementById("dosenTable");
        const rows = table.getElementsByTagName("tr");
        const totalPages = Math.ceil(rows.length / rowsPerPage);

        function showPage(page) {
            for (let i = 0; i < rows.length; i++) {
                rows[i].style.display = "none";
            }
            let start = (page - 1) * rowsPerPage;
            let end = start + rowsPerPage;
            for (let i = start; i < end && i < rows.length; i++) {
                rows[i].style.display = "";
            }
            document.getElementById("pageInfo").textContent = `Page ${page} of ${totalPages}`;
        }

        // Navigasi halaman sebelumnya dan selanjutnya
        document.getElementById("prevPage").addEventListener("click", function() {
            if (currentPage > 1) {
                currentPage--;
                showPage(currentPage);
            }
        });

        document.getElementById("nextPage").addEventListener("click", function() {
            if (currentPage < totalPages) {
                currentPage++;
                showPage(currentPage);
            }
        });

        showPage(currentPage);

        // Fungsi dropdown menu otomatis terbuka jika halaman cocok
        document.addEventListener("DOMContentLoaded", function() {
            let currentPage = document.body.getAttribute("data-page");
            let dropdownMenu = document.getElementById("dropdown-menu");
            let dropdownBtn = document.getElementById("dropdown-btn");
            let arrow = document.getElementById("arrow");
            let activeLink = document.querySelector(`a[href='${currentPage}']`);

            let pages = ["penilaian", "dosen", "mahasiswa", "matakuliah", "prodi", "kelas"];

            if (pages.includes(currentPage)) {
                dropdownMenu.classList.remove("hidden");
                arrow.innerHTML = "▲";
            }

            if (activeLink) {
                activeLink.classList.add("bg-blue-800", "text-white");
            }

            dropdownBtn.addEventListener("click", function() {
                if (dropdownMenu.classList.contains("hidden")) {
                    dropdownMenu.classList.remove("hidden");
                    arrow.innerHTML = "▲";
                } else {
                    dropdownMenu.classList.add("hidden");
                    arrow.innerHTML = "▼";
                }
            });
        });

        let deleteElement = null;

        function openDeleteModal(event, element) {
            event.preventDefault();
            deleteElement = element.closest("tr");
            document.getElementById("deleteModal").classList.remove("hidden");
        }

        function closeDeleteModal() {
            document.getElementById("deleteModal").classList.add("hidden");
            deleteElement = null;
        }

        function deleteData() {
            if (deleteElement) {
                deleteElement.remove();
                deleteElement = null;
            }
            closeDeleteModal();
        }

        // Fungsi pencarian dosen
        document.getElementById("searchInput").addEventListener("keyup", function() {
            let filter = this.value.toLowerCase();
            let rows = document.querySelectorAll("#dosenTable tr");

            rows.forEach(row => {
                let namaDosen = row.cells[2].textContent.toLowerCase();
                if (namaDosen.includes(filter)) {
                    row.style.display = "";
                } else {
                    row.style.display = "none";
                }
            });
        });
    </script>
</body>

</html>
```

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

- penambahan function di CetakKHSController

```bash
public function exportPdf()
    {
        $response = Http::get('http://localhost:8080/nilaiview');
        if ($response->successful()) {
            $khs = collect($response->json());
            $pdf = Pdf::loadView('pdf.cetak', compact('khs')); // Ubah 'cetak.pdf' menjadi 'pdf.cetak'
            return $pdf->download('khs.pdf');
        } else {
            return back()->with('error', 'Gagal mengambil data untuk PDF');
        }
    }
```
> karena tombol submit berada pada cetakKHS.blade.php maka penambahan function exportPDFnya ditaruh CetakKHSController.php

<h2 align="center">SEMANGAT NGODING gaes 💻🔥</h2>



  




