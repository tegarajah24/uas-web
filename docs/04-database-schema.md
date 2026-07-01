# 4. Skema Database (Rancangan)

Nama tabel mengikuti konvensi Eloquent (snake_case, jamak).

## 4.1 `users`

| Field | Tipe | Keterangan |
|---|---|---|
| id | bigint, PK | Auto increment |
| name | varchar | Nama pengguna |
| email | varchar, unique | Untuk login |
| password | varchar | Hashed |
| role | enum | `admin_resepsionis` \| `dokter` \| `farmasi` \| `kasir` |

## 4.2 `patients`

| Field | Tipe | Keterangan |
|---|---|---|
| id | bigint, PK | Auto increment |
| no_rm | varchar, unique | Nomor rekam medis |
| nik | varchar | NIK pasien |
| name | varchar | Nama pasien |
| birth_date | date | Tanggal lahir |
| gender | enum | `L` / `P` |
| phone | varchar | Kontak |
| address | text | Alamat |

## 4.3 `queues`

| Field | Tipe | Keterangan |
|---|---|---|
| id | bigint, PK | Auto increment |
| patient_id | FK → patients | Pasien terkait |
| poli | varchar | Poli tujuan |
| doctor_id | FK → users | Dokter tujuan |
| queue_number | int | Nomor antrian harian |
| status | enum | `waiting` \| `called` \| `done` |
| created_at | timestamp | Waktu daftar |

## 4.4 `medical_records`

| Field | Tipe | Keterangan |
|---|---|---|
| id | bigint, PK | Auto increment |
| patient_id | FK → patients | Pasien terkait |
| doctor_id | FK → users | Dokter pemeriksa |
| queue_id | FK → queues | Antrian terkait |
| complaint | text | Keluhan |
| diagnosis | text | Diagnosis |
| action_cost | decimal | Biaya tindakan/konsultasi |

## 4.5 `prescriptions`, `prescription_items`, `medicines`

| Tabel | Field Kunci | Keterangan |
|---|---|---|
| prescriptions | id, medical_record_id, status | Header resep (`menunggu`/`disiapkan`/`diserahkan`) |
| prescription_items | id, prescription_id, medicine_id, qty, price | Detail obat per resep |
| medicines | id, name, unit, price, stock | Master data obat farmasi |

## 4.6 `invoices`, `invoice_items`

| Tabel | Field Kunci | Keterangan |
|---|---|---|
| invoices | id, patient_id, total, status, paid_at | Tagihan akhir per kunjungan |
| invoice_items | id, invoice_id, description, amount | Rincian: konsultasi, obat, dll |

## 4.7 Relasi Antar Tabel (Ringkas)

```
patients (1—N) queues
patients (1—N) medical_records
queues   (1—1) medical_records
medical_records (1—N) prescriptions
prescriptions   (1—N) prescription_items
prescription_items (N—1) medicines

medical_records + prescriptions → invoices (1—N) invoice_items
```

## 4.8 Contoh Migration (Laravel)

```php
Schema::create('patients', function (Blueprint $table) {
    $table->id();
    $table->string('no_rm')->unique();
    $table->string('nik');
    $table->string('name');
    $table->date('birth_date');
    $table->enum('gender', ['L', 'P']);
    $table->string('phone')->nullable();
    $table->text('address')->nullable();
    $table->timestamps();
});
```
