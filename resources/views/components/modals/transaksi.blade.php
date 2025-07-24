<!-- resources/views/components/modals/transaksi-actions.blade.php -->
@props(['item'])

<!-- Tombol Trigger -->
<div class="d-flex gap-2">
    <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#konfirmasiModal{{ $item->id }}">
        <i class="fas fa-check-circle me-1"></i> Konfirmasi
    </button>
    <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#tolakModal{{ $item->id }}">
        <i class="fas fa-times-circle me-1"></i> Tolak
    </button>
</div>

<!-- Modal Konfirmasi -->
<div class="modal fade" id="konfirmasiModal{{ $item->id }}" tabindex="-1" aria-labelledby="konfirmasiModalLabel{{ $item->id }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="{{ route('admin.transaksis.konfirmasi', $item->id) }}" method="POST">
                @csrf
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title" id="konfirmasiModalLabel{{ $item->id }}">
                        <i class="fas fa-check-circle me-1"></i> Konfirmasi Transaksi
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body">
                    <p>Anda yakin ingin <strong>menyetujui</strong> transaksi ini?</p>
                    <ul class="list-unstyled">
                        <li><strong>Nama Berkas:</strong> {{ $item->arsip->nama ?? '-' }}</li>
                        <li><strong>Letak Fisik:</strong> {{ $item->arsip->lokasi ?? '-' }}</li>
                    </ul>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success">Konfirmasi</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Tolak -->
<div class="modal fade" id="tolakModal{{ $item->id }}" tabindex="-1" aria-labelledby="tolakModalLabel{{ $item->id }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="{{ route('admin.transaksis.tolak', $item->id) }}" method="POST">
                @csrf
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="tolakModalLabel{{ $item->id }}">
                        <i class="fas fa-times-circle me-1"></i> Tolak Permintaan
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="alasan_penolakan{{ $item->id }}" class="form-label">Alasan Penolakan</label>
                        <textarea name="alasan_penolakan" id="alasan_penolakan{{ $item->id }}" class="form-control" rows="3" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">Tolak Permintaan</button>
                </div>
            </form>
        </div>
    </div>
</div>