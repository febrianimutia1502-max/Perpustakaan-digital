@extends('layouts.dashboard')

@section('title', 'Peminjaman Saya')

@section('content')
<div class="card p-4 shadow-sm border-0">
    <h5 class="fw-bold mb-4">Daftar Peminjaman</h5>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Judul Buku</th>
                    <th>Tanggal Pinjam</th>
                    <th>Tanggal Kembali</th>
                    <th>Status</th>
                    <th>Ulasan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>

            @forelse($peminjaman as $item)
            @php
                $ulasanUser = $item->buku->ulasanbuku->where('user_id', auth()->id())->first();
            @endphp
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $item->buku->judul }}</td>
                <td>{{ $item->tanggal_peminjaman ? \Carbon\Carbon::parse($item->tanggal_peminjaman)->format('d/m/Y') : '-' }}</td>
                <td>{{ $item->tanggal_pengembalian ? \Carbon\Carbon::parse($item->tanggal_pengembalian)->format('d/m/Y') : '-' }}</td>

                <td>
                    @if($item->status_peminjaman == 'pending')
                        <span class="badge bg-warning text-dark">Menunggu Konfirmasi</span>

                    @elseif($item->status_peminjaman == 'dipinjam')
                        <span class="badge bg-primary">Sedang Dipinjam</span>

                    @elseif($item->status_peminjaman == 'dikembalikan')
                        <span class="badge bg-info text-white">Sudah Dikembalikan (Menunggu Konfirmasi)</span>

                    @elseif($item->status_peminjaman == 'ditolak')
                        <span class="badge bg-danger">Ditolak</span>

                    @else
                        <span class="badge bg-success">Selesai</span>
                    @endif
                </td>

                {{-- Kolom Ulasan --}}
                <td>
                    @if($item->status_peminjaman == 'selesai')
                        @if($ulasanUser)
                            <div>
                                <div class="text-warning" style="font-size:13px;">
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="bi {{ $i <= $ulasanUser->rating ? 'bi-star-fill' : 'bi-star' }}"></i>
                                    @endfor
                                </div>
                                <span class="text-muted" style="font-size:12px;">{{ \Str::limit($ulasanUser->ulasan, 40) }}</span>
                            </div>
                        @else
                            <span class="text-muted" style="font-size:12px;">Belum ada ulasan</span>
                        @endif
                    @else
                        <span class="text-muted" style="font-size:12px;">-</span>
                    @endif
                </td>

                <td>

                {{-- Jika status pending --}}
                @if($item->status_peminjaman == 'pending')
                    <div class="d-flex gap-2">
                        <a href="{{ route('user.peminjaman.cetak', $item->id) }}"
                           class="btn btn-sm btn-info text-white"
                           target="_blank">
                            <i class="bi bi-printer"></i> Cetak Struk
                        </a>
                    </div>

                {{-- Jika status dipinjam: TIDAK ada tombol ulasan --}}
                @elseif($item->status_peminjaman == 'dipinjam')
                    <div class="d-flex gap-2">

                        <form action="{{ route('user.peminjaman.return', $item->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-outline-primary">
                                Kembalikan
                            </button>
                        </form>

                        <a href="{{ route('user.peminjaman.cetak', $item->id) }}"
                           class="btn btn-sm btn-info text-white"
                           target="_blank">
                            <i class="bi bi-printer"></i> Cetak Struk
                        </a>

                    </div>

                {{-- Jika status dikembalikan (menunggu konfirmasi admin) --}}
                @elseif($item->status_peminjaman == 'dikembalikan')
                    <div class="d-flex gap-2">
                        <a href="{{ route('user.peminjaman.cetak', $item->id) }}"
                           class="btn btn-sm btn-info text-white"
                           target="_blank">
                            <i class="bi bi-printer"></i> Cetak Struk
                        </a>
                    </div>

                {{-- Jika selesai: tombol ulasan muncul --}}
                @elseif($item->status_peminjaman == 'selesai')

                    <div class="d-flex gap-2 flex-wrap">

                        @if($ulasanUser)
                            {{-- Edit ulasan --}}
                            <button class="btn btn-sm btn-outline-warning"
                                data-bs-toggle="modal"
                                data-bs-target="#editUlasanModal{{ $item->id }}">
                                <i class="bi bi-pencil"></i> Edit Ulasan
                            </button>
                        @else
                            {{-- Tulis ulasan baru --}}
                            <button class="btn btn-sm btn-outline-success"
                                data-bs-toggle="modal"
                                data-bs-target="#ulasanModal{{ $item->id }}">
                                <i class="bi bi-chat-square-text"></i> Tulis Ulasan
                            </button>
                        @endif

                        <a href="{{ route('user.peminjaman.cetak', $item->id) }}"
                           class="btn btn-sm btn-info text-white"
                           target="_blank">
                            <i class="bi bi-printer"></i> Cetak Struk
                        </a>

                    </div>

                @endif

                {{-- Modal Tulis Ulasan Baru --}}
                @if($item->status_peminjaman == 'selesai' && !$ulasanUser)
                <div class="modal fade" id="ulasanModal{{ $item->id }}" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form action="{{ route('user.ulasan.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="buku_id" value="{{ $item->buku_id }}">

                                <div class="modal-header">
                                    <h5 class="modal-title">
                                        Tulis Ulasan: {{ $item->buku->judul }}
                                    </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>

                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">Rating</label>
                                        <div class="d-flex gap-1" id="starRating{{ $item->id }}">
                                            @for($s = 1; $s <= 5; $s++)
                                                <i class="bi bi-star fs-4 text-warning star-btn"
                                                   data-value="{{ $s }}"
                                                   data-target="rating_{{ $item->id }}"
                                                   style="cursor:pointer;"></i>
                                            @endfor
                                        </div>
                                        <input type="hidden" name="rating" id="rating_{{ $item->id }}" value="" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">Ulasan</label>
                                        <textarea
                                            name="ulasan"
                                            class="form-control"
                                            rows="4"
                                            placeholder="Tulis ulasan kamu tentang buku ini..."
                                            required></textarea>
                                    </div>
                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">
                                        Batal
                                    </button>
                                    <button type="submit" class="btn btn-primary">
                                        Kirim Ulasan
                                    </button>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
                @endif

                {{-- Modal Edit Ulasan --}}
                @if($item->status_peminjaman == 'selesai' && $ulasanUser)
                <div class="modal fade" id="editUlasanModal{{ $item->id }}" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form action="{{ route('user.ulasan.update', $ulasanUser->id) }}" method="POST">
                                @csrf
                                @method('PUT')

                                <div class="modal-header">
                                    <h5 class="modal-title">
                                        Edit Ulasan: {{ $item->buku->judul }}
                                    </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>

                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">Rating</label>
                                        <div class="d-flex gap-1" id="editStarRating{{ $item->id }}">
                                            @for($s = 1; $s <= 5; $s++)
                                                <i class="bi {{ $s <= $ulasanUser->rating ? 'bi-star-fill' : 'bi-star' }} fs-4 text-warning star-btn"
                                                   data-value="{{ $s }}"
                                                   data-target="edit_rating_{{ $item->id }}"
                                                   style="cursor:pointer;"></i>
                                            @endfor
                                        </div>
                                        <input type="hidden" name="rating" id="edit_rating_{{ $item->id }}" value="{{ $ulasanUser->rating }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">Ulasan</label>
                                        <textarea
                                            name="ulasan"
                                            class="form-control"
                                            rows="4"
                                            required>{{ $ulasanUser->ulasan }}</textarea>
                                    </div>
                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">
                                        Batal
                                    </button>
                                    <button type="submit" class="btn btn-warning">
                                        Simpan Perubahan
                                    </button>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
                @endif

                </td>
            </tr>

            @empty
            <tr>
                <td colspan="7" class="text-center py-4">
                    Belum ada data peminjaman.
                </td>
            </tr>
            @endforelse

            </tbody>
        </table>
    </div>
</div>
@endsection

@section('scripts')
<script>
// Star rating interaktif
document.querySelectorAll('.star-btn').forEach(function(star) {
    star.addEventListener('click', function() {
        const value = this.getAttribute('data-value');
        const targetId = this.getAttribute('data-target');
        document.getElementById(targetId).value = value;

        // Update tampilan bintang
        const container = this.closest('.d-flex');
        container.querySelectorAll('.star-btn').forEach(function(s, idx) {
            if (idx < value) {
                s.classList.remove('bi-star');
                s.classList.add('bi-star-fill');
            } else {
                s.classList.remove('bi-star-fill');
                s.classList.add('bi-star');
            }
        });
    });

    star.addEventListener('mouseover', function() {
        const value = this.getAttribute('data-value');
        const container = this.closest('.d-flex');
        container.querySelectorAll('.star-btn').forEach(function(s, idx) {
            if (idx < value) {
                s.classList.remove('bi-star');
                s.classList.add('bi-star-fill');
            } else {
                s.classList.remove('bi-star-fill');
                s.classList.add('bi-star');
            }
        });
    });

    star.addEventListener('mouseout', function() {
        const targetId = this.getAttribute('data-target');
        const currentVal = document.getElementById(targetId).value || 0;
        const container = this.closest('.d-flex');
        container.querySelectorAll('.star-btn').forEach(function(s, idx) {
            if (idx < currentVal) {
                s.classList.remove('bi-star');
                s.classList.add('bi-star-fill');
            } else {
                s.classList.remove('bi-star-fill');
                s.classList.add('bi-star');
            }
        });
    });
});
</script>
@endsection