# Template Import User - Panduan Penggunaan

## Deskripsi

Template ini digunakan untuk mengimpor data user (guru dan siswa) ke dalam sistem E-Voting secara massal menggunakan file Excel.

## Format File

-   **Ekstensi yang didukung**: .xlsx, .xls, .csv
-   **Ukuran maksimal**: 5MB
-   **Encoding**: UTF-8

## Struktur Template

### Sheet 1: Data User

Template memiliki struktur kolom sebagai berikut:

| Kolom | Nama Field | Tipe Data | Keterangan                            | Contoh                      |
| ----- | ---------- | --------- | ------------------------------------- | --------------------------- |
| A     | Nama       | Text      | Nama lengkap user                     | John Doe                    |
| B     | Email      | Email     | Email unik untuk login                | john.doe@example.com        |
| C     | Kelas      | Text      | Kelas untuk siswa, jabatan untuk guru | XII IPA 1 / Guru Matematika |
| D     | Role       | Number    | Kode role (lihat sheet Role)          | 1 atau 2                    |

### Sheet 2: Role

Daftar kode role yang bisa digunakan:

| Kode | Nama Role  | Keterangan                 |
| ---- | ---------- | -------------------------- |
| 1    | Guru/Admin | User dengan akses penuh    |
| 2    | Siswa      | User dengan akses terbatas |

## Petunjuk Penggunaan

### 1. Download Template

-   Klik tombol "Download Template Excel" di halaman Data User
-   Template akan terdownload dengan nama `template-import-user.xlsx`

### 2. Isi Data

-   Buka file template yang sudah didownload
-   **HAPUS** baris contoh data (baris 3-4) sebelum mengisi data real
-   Mulai mengisi data dari **baris ke-3**
-   Pastikan email yang dimasukkan unik (tidak ada yang sama)
-   Isi kolom Role dengan kode yang sesuai (1 untuk Guru, 2 untuk Siswa)

### 3. Validasi Data

Sebelum upload, pastikan:

-   ✅ Header pada baris ke-2 tidak diubah
-   ✅ Email tidak ada yang duplikat
-   ✅ Kolom Role hanya berisi angka 1 atau 2
-   ✅ Tidak ada kolom yang kosong
-   ✅ Format email valid (@domain.com)

### 4. Upload File

-   Simpan file dalam format Excel (.xlsx)
-   Kembali ke halaman Data User
-   Klik "Pilih File Excel" dan pilih file yang sudah diisi
-   Klik tombol "Import"

## Contoh Data Valid

```
| Nama          | Email                 | Kelas      | Role |
|---------------|-----------------------|------------|------|
| Ahmad Suharto | ahmad.suharto@smk.sch.id | Guru MTK   | 1    |
| Siti Aminah   | siti.aminah@smk.sch.id   | XII IPA 1  | 2    |
| Budi Santoso  | budi.santoso@smk.sch.id  | XI IPS 2   | 2    |
```

## Error yang Sering Terjadi

### 1. "Format file tidak sesuai"

-   **Penyebab**: Header pada baris ke-2 diubah atau dihapus
-   **Solusi**: Download template baru dan jangan ubah header

### 2. "Email sudah terdaftar"

-   **Penyebab**: Email yang dimasukkan sudah ada di database
-   **Solusi**: Gunakan email yang berbeda

### 3. "Role tidak valid"

-   **Penyebab**: Kolom Role berisi selain angka 1 atau 2
-   **Solusi**: Pastikan kolom Role hanya berisi 1 atau 2

### 4. "File terlalu besar"

-   **Penyebab**: Ukuran file melebihi 5MB
-   **Solusi**: Kurangi jumlah data atau kompres file

## Tips Penggunaan

1. **Backup Data**: Selalu backup data sebelum import
2. **Test Kecil**: Coba import dengan sedikit data dulu
3. **Email Konsisten**: Gunakan format email yang konsisten (@domain yang sama)
4. **Validasi Manual**: Periksa data hasil import setelah proses selesai

## Support

Jika mengalami kesulitan, hubungi administrator sistem.

---

_Template ini dibuat untuk sistem E-Voting_
_Terakhir diupdate: 29 Agustus 2025_
