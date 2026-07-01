# 5. Hak Akses (Roles & Permissions)

| Role | Akses Modul | Aksi Utama |
|---|---|---|
| Admin / Resepsionis | Front-Office | Registrasi pasien, kelola antrian |
| Dokter | RME | Isi pemeriksaan, diagnosis, buat e-resep |
| Farmasi | Farmasi | Proses resep, kelola stok obat |
| Kasir | Kasir | Buat invoice, catat pembayaran |

## Implementasi

- Kolom `role` pada tabel `users` (lihat [04-database-schema.md](04-database-schema.md)).
- Middleware route, contoh:

```php
Route::middleware(['auth', 'role:dokter'])->group(function () {
    Route::get('/rme', RmeDashboard::class);
});
```

- Custom middleware sederhana:

```php
class EnsureRole
{
    public function handle($request, Closure $next, string $role)
    {
        abort_unless($request->user()?->role === $role, 403);
        return $next($request);
    }
}
```

- Di dalam komponen Livewire / Blade, sembunyikan menu yang tidak relevan:

```blade
@if(auth()->user()->role === 'dokter')
    <a href="/rme">Rekam Medis</a>
@endif
```

- Setiap role hanya melihat sidebar/menu sesuai wewenangnya — jangan andalkan
  hide-via-CSS saja, tetap validasi di server side (route + Livewire mount/authorize).
