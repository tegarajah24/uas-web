# 3. Modul & Fitur

## 3.1 Front-Office (Pendaftaran & Antrian)

- Registrasi pasien baru (data diri, NIK, kontak, riwayat alergi singkat).
- Pencarian pasien lama berdasarkan No. RM / NIK.
- Pemilihan poli/dokter tujuan.
- Generate nomor antrian otomatis per poli, ditampilkan reaktif di papan antrian
  (Livewire polling atau broadcast).
- Status antrian: `waiting` → `called` → `done`.

## 3.2 Rekam Medis Elektronik (RME)

- Dashboard antrian pasien milik dokter yang login.
- Form pemeriksaan: keluhan, anamnesis, diagnosis (opsional pakai kode ICD-10 sederhana), tindakan.
- Riwayat rekam medis pasien (kunjungan sebelumnya) dapat dilihat dokter.
- Setelah pemeriksaan, dokter dapat langsung membuat e-resep tanpa pindah halaman
  (komponen Livewire nested).

## 3.3 Farmasi (E-Resep)

- Menerima resep elektronik dari dokter secara real-time.
- Master data obat: nama, satuan, harga, stok.
- Validasi stok saat resep diproses; stok berkurang otomatis saat obat diserahkan.
- Status resep: `menunggu` → `disiapkan` → `diserahkan`.

## 3.4 Kasir (Billing System)

- Menampilkan pasien yang sudah selesai tahap RME & Farmasi, siap dibayar.
- Rincian tagihan otomatis: biaya konsultasi/tindakan + biaya obat dari farmasi.
- Input pembayaran (tunai/lainnya) dan cetak/tampilkan invoice.
- Riwayat transaksi kasir per hari.

---

Gunakan daftar ini juga sebagai acuan isi **Slide 2 (Modul)** dan **Slide 3 (Fitur)**
pada PPT pengumpulan — lihat [08-ppt-submission.md](08-ppt-submission.md).
