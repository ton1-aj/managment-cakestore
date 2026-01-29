<!DOCTYPE html>
<html>
<head>
    <title>CRUD Kue</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">

    <h3 class="mb-3">Data Kue</h3>

    {{-- FORM TAMBAH KUE --}}
    <div class="card mb-4">
        <div class="card-header">Tambah Kue</div>
        <div class="card-body">
            <form action="{{ route('kue.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row">
                    <div class="col-md-4 mb-2">
                        <label>Kategori</label>
                            <select name="id_kategori_kue" class="form-control">
                                <option value="">-- Pilih Kategori --</option>
                                @forelse ($kategori as $k)
                                    <option value="{{ $k->id_kategori_kue }}">
                                        {{ $k->nama_kategori_kue }}
                                    </option>
                                @empty
                                    <option disabled>Data kategori belum ada</option>
                                @endforelse
                            </select>
                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul class="mb-0">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                    </div>

                    <div class="col-md-4 mb-2">
                        <label>Nama Kue</label>
                        <input type="text" name="nama_kue" class="form-control">
                    </div>

                    <div class="col-md-4 mb-2">
                        <label>Harga</label>
                        <input type="number" name="harga_kue" class="form-control">
                    </div>
                </div>

                <div class="mb-2">
                    <label>Komposisi</label>
                    <textarea name="komposisi_kue" class="form-control"></textarea>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-2">
                        <label>Stok</label>
                        <input type="number" name="stok_kue" class="form-control">
                    </div>
                    <div class="col-md-6 mb-2">
                        <label>Foto</label>
                        <input type="file" name="foto_kue" class="form-control">
                    </div>
                </div>

                <button class="btn btn-success mt-2">Simpan</button>

            </form>
        </div>
    </div>

    {{-- TABEL DATA KUE --}}
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Kategori</th>
                <th>Harga</th>
                <th>Stok</th>
                <th>Gambar</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($kue as $item)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $item->nama_kue }}</td>
                <td>{{ $item->kategoriKue->nama_kategori_kue }}</td>
                <td>Rp {{ number_format($item->harga_kue) }}</td>
                <td>{{ $item->stok_kue }}</td>
                <td>
                    @if ($item->foto_kue)
                        <img src="{{ asset('storage/' . $item->foto_kue) }}"
                            width="80" class="img-thumbnail">
                    @else
                        <span class="text-muted">Tidak ada foto</span>
                    @endif
                </td>

                <td>
                {{-- FORM EDIT --}}
                <button
                class="btn btn-warning btn-sm"
                data-bs-toggle="modal"
                data-bs-target="#editModal"
                data-id="{{ $item->id_kue }}"
                data-nama="{{ $item->nama_kue }}"
                data-harga="{{ $item->harga_kue }}"
                data-stok="{{ $item->stok_kue }}"
                data-komposisi="{{ $item->komposisi_kue }}"
            >
                Edit
            </button>

            <div class="modal fade" id="editModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <form method="POST" enctype="multipart/form-data" id="editForm">
                @csrf
                @method('PUT')

                <div class="modal-header">
                    <h5 class="modal-title">Edit Kue</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

                    <div class="mb-2">
                        <label>Nama Kue</label>
                        <input type="text" name="nama_kue" id="edit_nama" class="form-control">
                    </div>

                    <div class="mb-2">
                        <label>Harga</label>
                        <input type="number" name="harga_kue" id="edit_harga" class="form-control">
                    </div>

                    <div class="mb-2">
                        <label>Stok</label>
                        <input type="number" name="stok_kue" id="edit_stok" class="form-control">
                    </div>

                    <div class="mb-2">
                        <label>Komposisi</label>
                        <textarea name="komposisi_kue" id="edit_komposisi" class="form-control"></textarea>
                    </div>

                    <div class="mb-2">
                        <label>Foto (opsional)</label>
                        <input type="file" name="foto_kue" class="form-control">
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

                {{-- FORM HAPUS --}}
                <form action="{{ route('kue.destroy', $item->id_kue) }}"
                    method="POST"
                    class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger btn-sm"
                        onclick="return confirm('Yakin ingin menghapus data ini?')">
                        Hapus
                    </button>
                </form>

            </tr>
            @endforeach
        </tbody>
    </table>
</div>
</body>
</html>




<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
const editModal = document.getElementById('editModal');

editModal.addEventListener('show.bs.modal', function (event) {
    const button = event.relatedTarget;

    const id = button.getAttribute('data-id');
    const nama = button.getAttribute('data-nama');
    const harga = button.getAttribute('data-harga');
    const stok = button.getAttribute('data-stok');
    const komposisi = button.getAttribute('data-komposisi');

    document.getElementById('edit_nama').value = nama;
    document.getElementById('edit_harga').value = harga;
    document.getElementById('edit_stok').value = stok;
    document.getElementById('edit_komposisi').value = komposisi;

    document.getElementById('editForm').action = `/kue/${id}`;
});
</script>

