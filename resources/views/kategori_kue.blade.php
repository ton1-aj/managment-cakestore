<!DOCTYPE html>
<html>
<head>
    <title>Data Kategori Kue</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* BODY & BACKGROUND */
        body {
            background: linear-gradient(135deg, #f0f4f8, #d9e2ec);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        /* HEADER */
        h3 {
            font-weight: 600;
            color: #333;
        }

        /* BUTTON BACK */
        .btn-secondary {
            box-shadow: 0 3px 8px rgba(0,0,0,0.1);
            transition: transform 0.2s;
        }
        .btn-secondary:hover {
            transform: translateY(-2px);
        }

        /* CARDS */
        .card {
            border-radius: 12px;
            box-shadow: 0 6px 15px rgba(0,0,0,0.05);
        }

        .card-header {
            font-weight: 600;
            letter-spacing: 0.5px;
            border-bottom: none;
        }

        .card-header.bg-primary {
            background: linear-gradient(135deg, #6a11cb, #2575fc);
            color: #fff;
        }

        .card-header.bg-secondary {
            background: linear-gradient(135deg, #757f9a, #d7dde8);
            color: #fff;
        }

        /* FORM INPUTS */
        input.form-control, textarea.form-control {
            border-radius: 8px;
            box-shadow: inset 0 2px 5px rgba(0,0,0,0.05);
            transition: all 0.2s;
        }
        input.form-control:focus, textarea.form-control:focus {
            border-color: #6a11cb;
            box-shadow: 0 0 8px rgba(106,17,203,0.2);
        }

        /* TABLE */
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

        /* MODAL */
        .modal-content {
            border-radius: 12px;
            box-shadow: 0 6px 25px rgba(0,0,0,0.1);
        }

        .modal-header {
            border-bottom: none;
        }

        .modal-footer button {
            border-radius: 8px;
        }

    </style>
</head>
<body>

<div class="container mt-4">

    {{-- HEADER DAN BACK --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Data Kategori Kue</h3>
        <a href="{{ route('admin_dashboard') }}" class="btn btn-secondary">&larr; Kembali ke Dashboard</a>
    </div>

    {{-- ALERT SUCCESS --}}
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- FORM TAMBAH KATEGORI --}}
    <div class="card mb-4 shadow-sm">
        <div class="card-header bg-primary">Tambah Kategori Kue</div>
        <div class="card-body">
            <form action="{{ route('kategori_kue.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label>Nama Kategori</label>
                    <input type="text" name="nama_kategori_kue" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Gambar Kategori</label>
                    <input type="file" name="gambar_kategori_kue" class="form-control">
                </div>
                <button class="btn btn-success">Simpan</button>
            </form>
        </div>
    </div>

    {{-- TABEL KATEGORI --}}
    <div class="card shadow-sm">
        <div class="card-header bg-secondary">Daftar Kategori</div>
        <div class="card-body p-0">
            <table class="table table-striped table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Nama Kategori</th>
                        <th>Gambar</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($kategori as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->nama_kategori_kue }}</td>
                            <td>
                                @if ($item->gambar_kategori_kue)
                                    <img src="{{ asset('storage/' . $item->gambar_kategori_kue) }}" class="img-thumbnail">
                                @else
                                    <span class="text-muted">Tidak ada gambar</span>
                                @endif
                            </td>
                            <td>
                                <button class="btn btn-warning btn-sm"
                                        data-bs-toggle="modal"
                                        data-bs-target="#editModal"
                                        data-id="{{ $item->id_kategori_kue }}"
                                        data-nama="{{ $item->nama_kategori_kue }}">Edit</button>

                                <button class="btn btn-danger btn-sm"
                                        data-bs-toggle="modal"
                                        data-bs-target="#hapusModal"
                                        data-id="{{ $item->id_kategori_kue }}"
                                        data-nama="{{ $item->nama_kategori_kue }}">Hapus</button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center">Data kategori belum ada</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

{{-- MODAL EDIT --}}
<div class="modal fade" id="editModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" enctype="multipart/form-data" id="editForm">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title">Edit Kategori</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label>Nama Kategori</label>
                        <input type="text" name="nama_kategori_kue" id="edit_nama" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label>Gambar (opsional)</label>
                        <input type="file" name="gambar_kategori_kue" class="form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary">Update</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- MODAL HAPUS --}}
<div class="modal fade" id="hapusModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" id="hapusForm">
                @csrf
                @method('DELETE')
                <div class="modal-header">
                    <h5 class="modal-title text-danger">Hapus Kategori</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Yakin ingin menghapus kategori <strong id="namaKategori"></strong> ?</p>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-danger">Ya, Hapus</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
// Modal Edit
const editModal = document.getElementById('editModal');
editModal.addEventListener('show.bs.modal', function(event){
    const button = event.relatedTarget;
    const id = button.getAttribute('data-id');
    const nama = button.getAttribute('data-nama');

    document.getElementById('edit_nama').value = nama;
    document.getElementById('editForm').action = `/kategori_kue/${id}`;
});

// Modal Hapus
const hapusModal = document.getElementById('hapusModal');
hapusModal.addEventListener('show.bs.modal', function(event){
    const button = event.relatedTarget;
    const id = button.getAttribute('data-id');
    const nama = button.getAttribute('data-nama');

    document.getElementById('namaKategori').innerText = nama;
    document.getElementById('hapusForm').action = `/kategori_kue/${id}`;
});
</script>

</body>
</html>
