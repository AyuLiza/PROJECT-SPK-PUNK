# SPK CV Ruarasa Lombok
>
> Sistem Pendukung Keputusan — Penentuan 3 Package Unggulan Menggunakan Metode SMART

---

📄 PPT : [Lihat Dokumentasi (PDF)](SPKSMARTPUNK_PPT.pdf)

## Tentang Proyek

Aplikasi web berbasis PHP untuk membantu manajemen **CV Ruarasa Lombok** menentukan 3 package event unggulan yang paling layak diprioritaskan dalam kegiatan penjualan dan promosi, menggunakan metode **SMART (Simple Multi-Attribute Rating Technique)**.

CV Ruarasa adalah perusahaan hiburan edukatif berbasis teknologi immersive yang mengintegrasikan budaya lokal Lombok & NTB dengan video mapping, AI, dan IoT.

---

## Alternatif Package

| Kode | Package |
|------|---------|
| A1 | Wedding Package |
| A2 | Birthday Party Package |
| A3 | Gathering & Arisan Package |
| A4 | Outing Class / Study Tour Package |
| A5 | Corporate Event / Team Building Package |
| A6 | Photo & Creative Content Package |

## Kriteria Penilaian

| Kode | Kriteria | Bobot |
|------|----------|-------|
| C1 | Potensi Pendapatan | 30% |
| C2 | Frekuensi Permintaan Pasar | 25% |
| C3 | Keunggulan Diferensiasi Produk | 20% |
| C4 | Kemudahan Operasional | 15% |
| C5 | Kesesuaian dengan Target Pasar Utama | 10% |

---

## Teknologi

- **Backend**: PHP (Native)
- **Database**: MySQL
- **Frontend**: Bootstrap 5 + Custom CSS
- **Server**: Apache (XAMPP)

---

## Fitur

- Login terpisah untuk Admin dan User
- Manajemen data Alternatif, Kriteria, Sub Kriteria
- Input nilai/bobot per alternatif
- Perhitungan otomatis metode SMART
- Hasil ranking 3 package terbaik

---

## Instalasi

### Prasyarat

- XAMPP (PHP 8.x + MySQL)
- Browser modern

### Langkah

1. Clone atau download repositori ini ke folder `htdocs`:

   ```
   C:\xampp\htdocs\PROJECT-SPK-PUNK\
   ```

2. Import database:
   - Buka `phpMyAdmin` → buat database baru: `db_smart`
   - Import file `db_smart.sql` dari folder `/database`

3. Sesuaikan koneksi di `tools/connection.php`:

   ```php
   $conn = new mysqli('localhost', 'root', '', 'db_smart');
   ```

4. Akses aplikasi di browser:

   ```
   http://localhost/SPK-Metode-SMART/
   ```

---

## Akun Default

| Role | Username | Password |
|------|----------|----------|
| Admin | `admin` | `admin123` |
| User | `user` | `user123` |

> **Catatan:** Ganti password setelah pertama kali login.

---

## Struktur Folder

```
PROJECT-SPK-PUNK/
├── admin/          # Halaman admin (dashboard, kelola user)
├── alternatif/     # CRUD alternatif package
├── kriteria/       # CRUD kriteria
├── subKriteria/    # CRUD sub kriteria
├── faktor/         # Input faktor/bobot
├── ranking/        # Hasil perhitungan & ranking SMART
├── home/           # Dashboard user
├── login/          # Login admin & user
├── blade/          # Komponen UI (header, nav, footer, icon)
├── tools/          # Koneksi DB, Bootstrap, CSS
└── database/       # File SQL
```

---

## Mata Kuliah

Tugas Besar — Mata Kuliah Sistem Pendukung Keputusan

---

## Kredit

Proyek ini dikembangkan berdasarkan repositori:

> **SPK-Metode-SMART** oleh [PratamaHarits](https://github.com/PratamaHarits/SPK-Metode-SMART)

Modifikasi yang dilakukan:

- Penyesuaian data alternatif & kriteria untuk CV Ruarasa Lombok
- Redesign UI (header, navigasi, login admin & user, footer)
- Penambahan dashboard admin dengan ringkasan statistik

---

## Lisensi

Proyek ini dibuat untuk keperluan akademik.
