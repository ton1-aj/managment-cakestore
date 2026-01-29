<!DOCTYPE html>
<html>
<head>
    <title>Dashboard Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* BODY & BACKGROUND */
        body {
            background: linear-gradient(135deg, #f0f4f8, #d9e2ec);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        /* NAVBAR */
        .navbar {
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }

        /* CARD SUMMARY */
        .card-summary {
            border-radius: 15px;
            padding: 30px 20px;
            transition: all 0.3s ease-in-out;
            box-shadow: 0 6px 15px rgba(0,0,0,0.1);
            color: #fff;
        }

        .card-summary.bg-primary {
            background: linear-gradient(45deg, #6a11cb, #2575fc);
        }

        .card-summary.bg-warning {
            background: linear-gradient(45deg, #f6d365, #fda085);
            color: #333;
        }

        .card-summary.bg-success {
            background: linear-gradient(45deg, #43e97b, #38f9d7);
        }

        .card-summary.bg-info {
            background: linear-gradient(45deg, #36d1dc, #5b86e5);
        }

        .card-summary:hover {
            transform: translateY(-8px) scale(1.05);
            box-shadow: 0 12px 25px rgba(0,0,0,0.2);
        }

        .card-summary h3 {
            font-weight: 700;
        }

        .card-summary h5 {
            font-weight: 600;
            letter-spacing: 0.5px;
        }

        /* TABLE STYLING */
        table.table {
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 6px 15px rgba(0,0,0,0.05);
        }

        table.table th, table.table td {
            vertical-align: middle;
        }

        table.table tbody tr:hover {
            background-color: rgba(0,123,255,0.05);
            transition: background-color 0.2s;
        }

        table.table img {
            border-radius: 10px;
            box-shadow: 0 3px 8px rgba(0,0,0,0.15);
            max-height: 50px;
        }

        /* CARD HEADER */
        .card-header {
            font-weight: 600;
            letter-spacing: 0.5px;
            background: linear-gradient(135deg, #6a11cb, #2575fc);
            color: #fff;
            border-bottom: none;
        }

        /* CARD HEADER VARIANTS */
        .card-header.bg-warning {
            background: linear-gradient(135deg, #f6d365, #fda085);
            color: #333;
        }

        .card-header.bg-info {
            background: linear-gradient(135deg, #36d1dc, #5b86e5);
            color: #fff;
        }

        /* CARD BODY */
        .card-body.p-0 {
            padding: 0 !important;
        }

        /* HEADING */
        h3.mb-4 {
            color: #333;
            font-weight: 600;
        }

    </style>
</head>
<body>

{{-- NAVBAR --}}
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container">
        <a class="navbar-brand fw-bold" href="{{ route('admin_dashboard') }}">Admin Dashboard</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('kue') }}">Kue</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('kategori_kue') }}">Kategori Kue</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('data_pegawai') }}">Pegawai</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="container mt-4">

    <h3 class="mb-4">Dashboard Admin</h3>

    {{-- CARD SUMMARY --}}
    <div class="row mb-4">
        <div class="col-md-4 mb-3">
            <div class="card card-summary bg-success text-white text-center">
                <div class="card-body">
                    <h5 class="card-title">Jumlah Kue</h5>
                    <h3 class="card-text">{{ $kue->count() }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card card-summary bg-warning text-dark text-center">
                <div class="card-body">
                    <h5 class="card-title">Jumlah Kategori</h5>
                    <h3 class="card-text">{{ $kategori_kue->count() }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card card-summary bg-info text-white text-center">
                <div class="card-body">
                    <h5 class="card-title">Jumlah Pegawai</h5>
                    <h3 class="card-text">{{ $data_pegawai->count() }}</h3>
                </div>
            </div>
        </div>
    </div>

    {{-- TABEL DATA KUE --}}
    <div class="card mb-4 shadow-sm">
        <div class="card-header bg-primary text-white">Data Kue</div>
        <div class="card-body p-0">
            <table class="table table-striped table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Nama Kue</th>
                        <th>Kategori</th>
                        <th>Harga</th>
                        <th>Stok</th>
                        <th>Foto</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($kue as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->nama_kue }}</td>
                        <td>{{ $item->kategoriKue->nama_kategori_kue ?? '-' }}</td>
                        <td>Rp {{ number_format($item->harga_kue, 0, ',', '.') }}</td>
                        <td>{{ $item->stok_kue }}</td>
                        <td>
                            @if($item->foto_kue)
                                <img src="{{ asset('storage/' . $item->foto_kue) }}" class="img-thumbnail">
                            @else
                                -
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center">Belum ada data kue</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- TABEL KATEGORI --}}
    <div class="card mb-4 shadow-sm">
        <div class="card-header bg-warning text-dark">Data Kategori Kue</div>
        <div class="card-body p-0">
            <table class="table table-striped table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Nama Kategori</th>
                        <th>Gambar</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($kategori_kue as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->nama_kategori_kue }}</td>
                        <td>
                            @if($item->gambar_kategori_kue)
                                <img src="{{ asset('storage/' . $item->gambar_kategori_kue) }}" class="img-thumbnail">
                            @else
                                -
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="text-center">Belum ada data kategori</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- TABEL PEGAWAI --}}
    <div class="card mb-4 shadow-sm">
        <div class="card-header bg-info text-white">Data Pegawai</div>
        <div class="card-body p-0">
            <table class="table table-striped table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Nama Pegawai</th>
                        <th>Posisi</th>
                        <th>Alamat</th>
                        <th>Jam Kerja</th>
                        <th>Gaji</th>
                        <th>Foto</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($data_pegawai as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->nama_pegawai }}</td>
                        <td>{{ $item->posisi_pegawai }}</td>
                        <td>{{ $item->alamat_pegawai }}</td>
                        <td>{{ $item->jam_masuk }} - {{ $item->jam_pulang }}</td>
                        <td>Rp {{ number_format($item->gaji_pegawai, 0, ',', '.') }}</td>
                        <td>
                            @if($item->foto_pegawai)
                                <img src="{{ asset('storage/' . $item->foto_pegawai) }}" class="img-thumbnail">
                            @else
                                -
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center">Belum ada data pegawai</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
