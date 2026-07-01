# 1. Overview

## Latar Belakang

Rumah sakit membutuhkan sistem terintegrasi yang menghubungkan proses pendaftaran pasien,
pemeriksaan medis, peresepan obat, hingga pembayaran — tanpa duplikasi data dan tanpa proses
manual yang lambat. SIMRS dibangun sebagai aplikasi web reaktif (SPA-like) menggunakan Livewire,
sehingga operasi CRUD terjadi tanpa reload halaman penuh.

## Tujuan

- Mendigitalkan alur layanan rumah sakit dari pendaftaran hingga pembayaran.
- Menyediakan Rekam Medis Elektronik (RME) yang terpusat dan mudah diakses dokter.
- Mengelola resep obat (e-resep) dan stok farmasi secara real-time.
- Menghasilkan tagihan (billing) otomatis berdasarkan tindakan medis dan obat yang diberikan.
- Memberikan hak akses berbeda untuk tiap peran pengguna (multi-user authentication).

## Ruang Lingkup Modul

Sistem terdiri dari 4 modul utama yang saling terintegrasi:

1. **Front-Office** — Pendaftaran pasien & Antrian
2. **Rekam Medis Elektronik (RME)**
3. **Farmasi** — E-Resep
4. **Kasir** — Billing System

## Tech Stack Ringkas

| Komponen | Teknologi |
|---|---|
| Backend | Laravel (versi terbaru) |
| Frontend reaktif | Livewire |
| Styling | Tailwind CSS |
| Database | MySQL / MariaDB |
| Autentikasi | Laravel Breeze/Fortify + Livewire, role-based |

Detail lengkap ada di [02-architecture.md](02-architecture.md).
