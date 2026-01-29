<!DOCTYPE html>
<html>
<head>
    <title>Data Pegawai</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .img-thumbnail {
            max-height: 60px;
        }
    </style>
</head>
<body>

<div class="container mt-4">

    {{-- HEADER DAN TOMBOL BACK --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Data Pegawai</h3>
        <a href="{{ route('admin_dashboard') }}" class="btn btn-secondary">&larr; Kembali ke Dashboard</a>
    </div>

    {{-- ALERT SUCCESS --}}
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- FORM TAMBAH PEGAWAI --}}
    <div class="card mb-4 shadow-sm">
        <div class="card-header bg-primary text-white">Tambah Pegawai</div>
        <div class="card-body">
            <form action="{{ route('data_pegawai.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row mb-2">
                    <div class="col-md-6">
                        <label>Nama Pegawai</label>
                        <input type="text" name="nama_pegawai" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label>Posisi</label>
                        <select name="posisi_pegawai" class="form-control" required>
                            <option value="">-- Pilih Posisi --</option>
                            <option>Baker</option>
                            <option>Asisten Baker</option>
                            <option>Kasir</option>
                            <option>Admin</option>
                        </select>
                    </div>
                </div>

                <div class="mb-2">
                    <label>Alamat</label>
                    <textarea name="alamat_pegawai" class="form-control" required></textarea>
                </div>

                <div class="row mb-2">
                    <div class="col-md-3">
                        <label>Jam Masuk</label>
                        <input type="time" name="jam_masuk" class="form-control" required>
                    </div>
                    <div class="col-md-3">
                        <label>Jam Pulang</label>
                        <input type="time" name="jam_pulang" class="form-control" required>
                    </div>
                    <div class="col-md-3">
                        <label>Gaji</label>
                        <input type="number" name="gaji_pegawai" class="form-control" required>
                    </div>
                    <div class="col-md-3">
                        <label>Foto</label>
                        <input type="file" name="foto_pegawai" class="form-control">
                    </div>
                </div>

                <button class="btn btn-success mt-2">Simpan</button>
            </form>
        </div>
    </div>

    {{-- TABEL DATA PEGAWAI --}}
    <div class="card shadow-sm">
        <div class="card-header bg-secondary text-white">Daftar Pegawai</div>
        <div class="card-body p-0">
            <table class="table table-striped table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Posisi</th>
                        <th>Jam Kerja</th>
                        <th>Gaji</th>
                        <th>Foto</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($pegawai as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->nama_pegawai }}</td>
                            <td>{{ $item->posisi_pegawai }}</td>
                            <td>{{ $item->jam_masuk }} - {{ $item->jam_pulang }}</td>
                            <td>Rp {{ number_format($item->gaji_pegawai,0,',','.') }}</td>
                            <td>
                                @if($item->foto_pegawai)
                                    <img src="{{ asset('storage/' . $item->foto_pegawai) }}" class="img-thumbnail">
                                @else
                                    <span class="text-muted">Tidak ada foto</span>
                                @endif
                            </td>
                            <td>
                                <button class="btn btn-warning btn-sm"
                                        data-bs-toggle="modal"
                                        data-bs-target="#editModal"
                                        data-id="{{ $item->id_data_pegawai }}"
                                        data-nama="{{ $item->nama_pegawai }}"
                                        data-posisi="{{ $item->posisi_pegawai }}"
                                        data-alamat="{{ $item->alamat_pegawai }}"
                                        data-masuk="{{ $item->jam_masuk }}"
                                        data-pulang="{{ $item->jam_pulang }}"
                                        data-gaji="{{ $item->gaji_pegawai }}">Edit</button>

                                <button class="btn btn-danger btn-sm"
                                        data-bs-toggle="modal"
                                        data-bs-target="#hapusModal"
                                        data-id="{{ $item->id_data_pegawai }}"
                                        data-nama="{{ $item->nama_pegawai }}">Hapus</button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">Data pegawai belum ada</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

{{-- MODAL EDIT --}}
<div class="modal fade" id="editModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form method="POST" enctype="multipart/form-data" id="editForm">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title">Edit Pegawai</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-2">
                        <div class="col-md-6">
                            <label>Nama Pegawai</label>
                            <input type="text" name="nama_pegawai" id="edit_nama" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label>Posisi</label>
                            <select name="posisi_pegawai" id="edit_posisi" class="form-control" required>
                                <option value="">-- Pilih Posisi --</option>
                                <option>Baker</option>
                                <option>Asisten Baker</option>
                                <option>Kasir</option>
                                <option>Admin</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-2">
                        <label>Alamat</label>
                        <textarea name="alamat_pegawai" id="edit_alamat" class="form-control" required></textarea>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-3">
                            <label>Jam Masuk</label>
                            <input type="time" name="jam_masuk" id="edit_masuk" class="form-control" required>
                        </div>
                        <div class="col-md-3">
                            <label>Jam Pulang</label>
                            <input type="time" name="jam_pulang" id="edit_pulang" class="form-control" required>
                        </div>
                        <div class="col-md-3">
                            <label>Gaji</label>
                            <input type="number" name="gaji_pegawai" id="edit_gaji" class="form-control" required>
                        </div>
                        <div class="col-md-3">
                            <label>Foto (Opsional)</label>
                            <input type="file" name="foto_pegawai" class="form-control">
                        </div>
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
                    <h5 class="modal-title text-danger">Hapus Pegawai</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    Yakin ingin menghapus pegawai <strong id="namaPegawai"></strong>?
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

    document.getElementById('edit_nama').value = button.getAttribute('data-nama');
    document.getElementById('edit_posisi').value = button.getAttribute('data-posisi');
    document.getElementById('edit_gaji').value = button.getAttribute('data-gaji');
    document.getElementById('edit_alamat').value = button.getAttribute('data-alamat');
    document.getElementById('edit_masuk').value = button.getAttribute('data-masuk');
    document.getElementById('edit_pulang').value = button.getAttribute('data-pulang');
    document.getElementById('editForm').action = `/data_pegawai/${id}`;
});

// Modal Hapus
const hapusModal = document.getElementById('hapusModal');
hapusModal.addEventListener('show.bs.modal', function(event){
    const button = event.relatedTarget;
    const id = button.getAttribute('data-id');
    const nama = button.getAttribute('data-nama');
    document.getElementById('namaPegawai').innerText = nama;
    document.getElementById('hapusForm').action = `/data_pegawai/${id}`;
});
</script>

</body>
</html>
