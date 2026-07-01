# 6. Alur Sistem End-to-End

1. Pasien datang → Resepsionis input data di **Front-Office** → sistem generate no. antrian.
2. Dokter login → melihat antrian poli miliknya → memanggil pasien → mengisi form **RME**.
3. Dari form RME, dokter langsung membuat **e-resep** (komponen Livewire nested) → resep
   otomatis masuk ke antrian **Farmasi**.
4. Farmasi menyiapkan obat sesuai resep → stok berkurang otomatis → status resep jadi
   `diserahkan`.
5. **Kasir** melihat pasien yang RME & resepnya sudah selesai → sistem menghitung total
   (biaya tindakan + obat) → kasir menerima pembayaran → invoice terbit.

```
Pasien Daftar
     │
     ▼
Front-Office (antrian)
     │
     ▼
RME (dokter periksa + buat resep)
     │
     ▼
Farmasi (siapkan obat, potong stok)
     │
     ▼
Kasir (hitung total, terima bayar, invoice)
```

Seluruh transisi status (antrian, resep, invoice) diperbarui secara **reaktif dengan
Livewire tanpa reload halaman**, sesuai ketentuan soal UAS.

## Catatan Implementasi

- Gunakan Livewire events (`$this->dispatch()`) untuk memberi tahu komponen lain saat
  status berubah, misalnya saat resep selesai diproses farmasi → komponen kasir ter-refresh.
- Pertimbangkan `wire:poll` pada papan antrian agar update tanpa perlu event manual.
- Pastikan validasi di tiap tahap (misal: kasir tidak bisa menagih sebelum resep selesai)
  untuk menghindari bug alur logis — ini bobot penilaian terbesar (40%).
