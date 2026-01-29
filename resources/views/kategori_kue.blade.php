<!DOCTYPE html>
<html>
<head>
    <title>Data Kategori Kue</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-4">

    <h3 class="mb-3">Data Kategori Kue</h3>

    {{-- ALERT SUCCESS --}}
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    {{-- FORM TAMBAH KATEGORI --}}
    <div class="card mb-4">
        <div class="card-header">Tambah Kategori Kue</div>
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
    <table class="table table-bordered">
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
                            <img src="{{ asset('storage/' . $item->gambar_kategori_kue) }}"
                                width="80">
                        @else
                            -
                        @endif
                    </td>
                    <td>
                        <button
                        class="btn btn-warning btn-sm"
                        data-bs-toggle="modal"
                        data-bs-target="#editModal"
                        data-id="{{ $item->id_kategori_kue }}"
                        data-nama="{{ $item->nama_kategori_kue }}">Edit
                        </button><div class="modal fade" id="editModal" tabindex="-1">
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
                                                <input type="text" name="nama_kategori_kue"
                                                    id="edit_nama" class="form-control">
                                            </div>

                                            <div class="mb-3">
                                                <label>Gambar (opsional)</label>
                                                <input type="file" name="gambar_kategori_kue"
                                                    class="form-control">
                                            </div>
                                        </div>

                                        <div class="modal-footer">
                                            <button class="btn btn-primary">Update</button>
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Batal</button>
                                        </div>
                                    </form>

                                </div>
                            </div>
                        </div>

                        <button
                            class="btn btn-danger btn-sm"
                            data-bs-toggle="modal"
                            data-bs-target="#hapusModal"
                            data-id="{{ $item->id_kategori_kue }}"
                            data-nama="{{ $item->nama_kategori_kue }}">Hapus
                        </button>

                        <!-- MODAL HAPUS -->
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
                                            <p>
                                                Yakin ingin menghapus kategori
                                                <strong id="namaKategori"></strong> ?
                                            </p>
                                        </div>

                                        <div class="modal-footer">
                                            <button class="btn btn-danger">Ya, Hapus</button>
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                Batal
                                            </button>
                                        </div>

                                    </form>

                                </div>
                            </div>
                        </div>


                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center">
                        Data kategori belum ada
                    </td>
                </tr>
            @endforelse
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

    document.getElementById('edit_nama').value = nama;
    document.getElementById('editForm').action = `/kategori-kue/${id}`;
});
</script>

<script>
const hapusModal = document.getElementById('hapusModal');

hapusModal.addEventListener('show.bs.modal', function (event) {
    const button = event.relatedTarget;

    const id = button.getAttribute('data-id');
    const nama = button.getAttribute('data-nama');

    document.getElementById('namaKategori').innerText = nama;
    document.getElementById('hapusForm').action = `/kategori-kue/${id}`;
});
</script>

