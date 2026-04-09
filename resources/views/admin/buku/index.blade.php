@extends('layouts.dashboard')

@section('title', 'Kelola Buku')

@section('content')
<div class="card shadow-sm border-0">
    <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <h5 class="fw-bold mb-0"><i class="bi bi-journal-richtext me-2"></i>Daftar Buku</h5>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">
            <i class="bi bi-plus-lg"></i> Tambah Buku
        </button>
    </div>
    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('success') }}
                <button class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th width="50">No</th>
                        <th width="90">Cover</th>
                        <th>Judul</th>
                        <th>Penulis</th>
                        <th>Penerbit</th>
                        <th width="100">Tahun</th>
                        <th width="80">Stok</th>
                        <th>Deskripsi</th>
                        <th width="180">Kategori</th>
                        <th width="120">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($buku as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                @if($item->cover)
                                    <img src="{{ asset('storage/' . $item->cover) }}" style="width:60px;height:80px;object-fit:cover;border-radius:6px">
                                @else
                                    <div class="text-muted small">No Cover</div>
                                @endif
                            </td>
                            <td class="fw-semibold">{{ $item->judul }}</td>
                            <td>{{ $item->penulis }}</td>
                            <td>{{ $item->penerbit }}</td>
                            <td>{{ $item->tahun_terbit }}</td>
                            <td>{{ $item->stok == 0 ? 'kosong' : $item->stok }}</td>
                            <td class="text-muted small">{{ $item->deskripsi ? \Illuminate\Support\Str::limit($item->deskripsi, 60) : '-' }}</td>
                            <td>
                                @php
                                    $colors = ['bg-primary', 'bg-success', 'bg-warning', 'bg-info', 'bg-danger', 'bg-dark'];
                                @endphp
                                @foreach($item->kategoribuku as $kat)
                                    <span class="badge {{ $colors[$loop->index % count($colors)] }} mb-1">{{ $kat->nama_kategori }}</span>
                                @endforeach
                            </td>
                            <td>
                                <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editModal{{ $item->id }}">
                                    <i class="bi bi-pencil"></i>
                                </button>
                                <form action="{{ route('admin.buku.destroy', $item->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm" onclick="return confirm('Hapus buku ini?')">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>

                        <!-- EDIT MODAL -->
                        <div class="modal fade" id="editModal{{ $item->id }}">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <form action="{{ route('admin.buku.update', $item->id) }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-header">
                                            <h5 class="modal-title">Edit Buku</h5>
                                            <button class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <label class="form-label">Cover Saat Ini</label>
                                                    @if($item->cover)
                                                        <img src="{{ asset('storage/' . $item->cover) }}" class="img-fluid rounded mb-2" id="previewEdit{{ $item->id }}">
                                                    @else
                                                        <img id="previewEdit{{ $item->id }}" class="img-fluid mt-2 rounded"/>
                                                    @endif
                                                    <input type="file" name="cover" class="form-control mt-2" onchange="previewEdit(event, {{ $item->id }})">
                                                </div>
                                                <div class="col-md-8">
                                                    <div class="mb-3">
                                                        <label>Judul</label>
                                                        <input type="text" name="judul" class="form-control" value="{{ $item->judul }}" required>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6 mb-3">
                                                            <label>Penulis</label>
                                                            <input type="text" name="penulis" class="form-control" value="{{ $item->penulis }}" required>
                                                        </div>
                                                        <div class="col-md-6 mb-3">
                                                            <label>Penerbit</label>
                                                            <input type="text" name="penerbit" class="form-control" value="{{ $item->penerbit }}" required>
                                                        </div>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label>Tahun Terbit</label>
                                                        <input type="number" name="tahun_terbit" class="form-control" value="{{ $item->tahun_terbit }}" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label>Stok</label>
                                                        <input type="number" name="stok" class="form-control" value="{{ $item->stok }}" min="0" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label>Kategori</label>
                                                        <select name="kategori_id[]" class="form-select" multiple required>
                                                            @foreach($kategori as $kat)
                                                                <option value="{{ $kat->id }}" {{ $item->kategoribuku->contains($kat->id) ? 'selected' : '' }}>{{ $kat->nama_kategori }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label>Deskripsi</label>
                                                        <textarea name="deskripsi" class="form-control" rows="3">{{ $item->deskripsi }}</textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                            <button class="btn btn-primary">Simpan</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- MODAL TAMBAH -->
<div class="modal fade" id="addModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="{{ route('admin.buku.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Buku</h5>
                    <button class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="mb-3">
                                <label>Judul</label>
                                <input type="text" name="judul" class="form-control" required>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label>Penulis</label>
                                    <input type="text" name="penulis" class="form-control" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label>Penerbit</label>
                                    <input type="text" name="penerbit" class="form-control" required>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label>Tahun Terbit</label>
                                <input type="number" name="tahun_terbit" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label>Stok</label>
                                <input type="number" name="stok" class="form-control" min="0" required>
                            </div>
                            <div class="mb-3">
                                <label>Kategori</label>
                                <select name="kategori_id[]" class="form-select" multiple required>
                                    @foreach($kategori as $kat)
                                        <option value="{{ $kat->id }}">{{ $kat->nama_kategori }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label>Deskripsi</label>
                                <textarea name="deskripsi" class="form-control" rows="3"></textarea>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label>Cover Buku</label>
                            <input type="file" name="cover" class="form-control" onchange="previewAdd(event)">
                            <img id="previewAdd" class="img-fluid mt-2 rounded"/>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function previewAdd(event) {
        let reader = new FileReader();
        reader.onload = function() {
            let output = document.getElementById('previewAdd');
            output.src = reader.result;
        }
        reader.readAsDataURL(event.target.files[0]);
    }

    function previewEdit(event, id) {
        let reader = new FileReader();
        reader.onload = function() {
            let output = document.getElementById('previewEdit' + id);
            output.src = reader.result;
        }
        reader.readAsDataURL(event.target.files[0]);
    }
</script>
@endsection
