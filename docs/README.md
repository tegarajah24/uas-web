# Dokumentasi Proyek — SIMRS

Sistem Informasi Manajemen Rumah Sakit berbasis Laravel + Livewire.
Dokumen ini merupakan acuan teknis untuk pengembangan project (UAS Pemrograman Berbasis Web).

## Daftar Isi

1. [Overview](01-overview.md) — latar belakang, tujuan, ruang lingkup
2. [Arsitektur & Tech Stack](02-architecture.md) — teknologi, struktur folder Livewire
3. [Modul & Fitur](03-modules-features.md) — detail fitur tiap modul
4. [Skema Database](04-database-schema.md) — tabel, field, relasi
5. [Hak Akses (Roles)](05-roles-permissions.md) — matriks role & permission
6. [Alur Sistem](06-system-flow.md) — alur end-to-end pasien
7. [Checklist Pengerjaan](07-checklist.md) — checklist sesuai bobot penilaian UAS
8. [Struktur PPT Pengumpulan](08-ppt-submission.md) — format laporan akhir

## Cara Pakai

Simpan folder `docs/` ini di root project Laravel kamu:

```
simrs/
├── app/
├── database/
├── docs/          <-- taruh di sini
│   ├── README.md
│   ├── 01-overview.md
│   ├── 02-architecture.md
│   ├── ...
├── routes/
└── ...
```

Update isi tiap file seiring progres development (checklist di `07-checklist.md` bisa dicentang manual).
