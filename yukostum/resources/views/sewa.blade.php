@extends('layouts.app')

@section('content')
    <div class="row justify-content-center mt-4">
        <div class="col-md-6">

            <a href="/katalog" class="btn btn-light mb-3 shadow-sm fw-bold text-muted">
                ⬅️ Batal & Kembali
            </a>

            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-header bg-primary text-white fw-bold py-3 fs-5 rounded-top-4">
                    📅 Tentukan Tanggal Sewa
                </div>
                <div class="card-body p-4">

                    <div class="d-flex align-items-center mb-4 pb-3 border-bottom">
                        <div class="ms-2">
                            <span class="badge bg-secondary mb-1">{{ $costume->type }}</span>
                            <h5 class="fw-bold mb-1">{{ $costume->name }}</h5>
                            <span class="text-primary fw-bold fs-5">Rp
                                {{ number_format($costume->price, 0, ',', '.') }}</span> <span class="text-muted">/
                                hari</span>
                        </div>
                    </div>

                    <form action="/sewa/{{ $costume->id }}" method="POST">
                        @csrf

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Tanggal Pinjam</label>
                                <input type="date" name="borrow_date" id="borrow_date"
                                    class="form-control form-control-lg" required min="{{ date('Y-m-d') }}">
                            </div>

                            <div class="col-md-6 mb-4">
                                <label class="form-label fw-bold">Tanggal Kembali</label>
                                <input type="date" name="return_date" id="return_date"
                                    class="form-control form-control-lg" required min="{{ date('Y-m-d') }}">
                            </div>
                        </div>

                        <div id="summary_box" class="alert alert-info d-none shadow-sm border-0 mb-4">
                        </div>

                        <input type="hidden" id="harga_kostum" value="{{ $costume->price }}">

                        <button type="submit" id="btn_submit" class="btn btn-primary btn-lg w-100 fw-bold shadow-sm">
                            🚀 Konfirmasi & Ajukan Sewa
                        </button>
                    </form>

                </div>
            </div>
        </div>
    </div>

    <script>
        // 1. Ambil elemen-elemen dari form HTML
        const borrowDateInput = document.getElementById('borrow_date');
        const returnDateInput = document.getElementById('return_date');
        const hargaKostum = parseInt(document.getElementById('harga_kostum').value);
        const summaryBox = document.getElementById('summary_box');
        const btnSubmit = document.getElementById('btn_submit');

        // 2. Buat fungsi untuk menghitung
        function hitungTotal() {
            const borrowDate = new Date(borrowDateInput.value);
            const returnDate = new Date(returnDateInput.value);

            // Pastikan kedua kotak tanggal sudah diisi oleh pelanggan
            if (borrowDateInput.value && returnDateInput.value) {

                // Hitung selisih waktu (dalam milidetik)
                const diffTime = returnDate.getTime() - borrowDate.getTime();

                // Konversi milidetik menjadi Hari (1000 ms * 60 dtk * 60 mnt * 24 jam)
                let diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));

                // LOGIKA ERROR: Jika tanggal kembali lebih mundur dari tanggal pinjam
                if (diffDays < 0) {
                    summaryBox.classList.remove('d-none');
                    summaryBox.classList.replace('alert-info', 'alert-danger'); // Ubah warna jadi merah
                    summaryBox.innerHTML =
                        '<strong>⚠️ Kesalahan:</strong> Tanggal kembali tidak boleh lebih awal dari tanggal pinjam.';
                    btnSubmit.disabled = true; // Kunci tombol submit!
                    return; // Hentikan perhitungan
                }

                // LOGIKA NORMAL: Jika pinjam dan kembali di hari yang sama, hitung 1 hari
                if (diffDays === 0) {
                    diffDays = 1;
                }

                // Hitung total harga
                const totalHarga = diffDays * hargaKostum;

                // Alat pembuat titik format mata uang (100000 jadi 100.000)
                const formatRupiah = (angka) => new Intl.NumberFormat('id-ID').format(angka);

                // Munculkan kotak biru dan masukkan struktur rincian HTML-nya
                summaryBox.classList.remove('d-none');
                summaryBox.classList.replace('alert-danger', 'alert-info');
                summaryBox.innerHTML = `
                <h6 class="fw-bold text-dark mb-3">🧾 Rincian Tagihan</h6>
                <div class="d-flex justify-content-between mb-1 text-dark">
                    <span>Durasi Sewa:</span>
                    <span class="fw-bold">${diffDays} Hari</span>
                </div>
                <div class="d-flex justify-content-between mb-2 text-dark">
                    <span>Perhitungan:</span>
                    <span class="text-muted small">${diffDays} hari x Rp ${formatRupiah(hargaKostum)}</span>
                </div>
                <hr class="border-secondary my-2">
                <div class="d-flex justify-content-between align-items-center mt-2">
                    <span class="fw-bold text-dark">Total Bayar:</span>
                    <span class="fw-bold text-primary fs-4">Rp ${formatRupiah(totalHarga)}</span>
                </div>
            `;

                // Buka kunci tombol submit
                btnSubmit.disabled = false;
            }
        }

        // 3. Pasang "Telinga" agar JavaScript langsung menghitung setiap kali tanggal diklik/diubah
        borrowDateInput.addEventListener('change', hitungTotal);
        returnDateInput.addEventListener('change', hitungTotal);
    </script>
@endsection
