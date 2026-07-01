# 2. Arsitektur & Tech Stack

## 2.1 Stack Teknologi

| Komponen | Teknologi | Keterangan |
|---|---|---|
| Backend Framework | Laravel (versi terbaru) | Routing, Eloquent ORM, migrations, validation |
| Frontend Reaktif | Livewire | Komponen CRUD tanpa reload halaman penuh (SPA-like) |
| Styling | Tailwind CSS | Tema visual medis (biru/putih/hijau), responsif |
| Database | MySQL / MariaDB | Relasi antar modul (pasien, RME, farmasi, kasir) |
| Autentikasi | Laravel Breeze/Fortify + Livewire | Login multi-role, middleware hak akses |
| Realtime UI kecil | Alpine.js (bundled) | Modal, dropdown, interaksi client-side ringan |

## 2.2 Arsitektur Alur Data

Pipeline utama, tiap tahap wajib tervalidasi sebelum lanjut ke tahap berikutnya:

1. **Pendaftaran (Front-Office)** — pasien baru/lama didaftarkan, masuk ke antrian poli.
2. **Pemeriksaan (RME)** — dokter memanggil antrian, mencatat diagnosis & tindakan.
3. **Peresepan (Farmasi)** — dokter menerbitkan e-resep, farmasi menyiapkan & mengurangi stok obat.
4. **Pembayaran (Kasir)** — kasir menghitung total biaya (tindakan + obat) dan menerbitkan invoice.

## 2.3 Struktur Direktori Livewire (Disarankan)

```
app/Livewire/
├── Auth/
│   └── LoginForm.php
├── FrontOffice/
│   ├── PatientRegistration.php
│   └── QueueBoard.php
├── Rme/
│   ├── MedicalRecordForm.php
│   └── PatientHistory.php
├── Farmasi/
│   ├── PrescriptionQueue.php
│   └── MedicineStock.php
└── Kasir/
    ├── BillingForm.php
    └── InvoiceList.php
```

## 2.4 Middleware & Otorisasi

- Gunakan Laravel Middleware untuk membatasi route per role (`role:dokter`, `role:kasir`, dst).
- Gunakan Laravel Policy/Gate atau pengecekan `@can` di dalam komponen Livewire agar tiap role
  hanya melihat menu dan data sesuai wewenangnya (lihat [05-roles-permissions.md](05-roles-permissions.md)).
