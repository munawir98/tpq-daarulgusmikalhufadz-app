# Panduan Deploy ke Railway (Gratis Trial)

Ikuti langkah demi langkah ini, jangan ada yang terlewat ya kak.

## Tahap 1: Persiapan di Laptop Kakak (Sekarang)
1. Saya sudah membuatkan file `Procfile` otomatis.
2. Kakak perlu `commit` dan `push` semua perubahan ini ke GitHub dulu.
   - Buka Terminal di VS Code.
   - Ketik: `git add .`
   - Ketik: `git commit -m "Persiapan deploy railway"`
   - Ketik: `git push origin main` (atau nama branch kakak).

## Tahap 2: Setup di Website Railway
1. Buka [Railway.app](https://railway.app/).
2. Login pakai akun **GitHub** kakak.
3. Klik tombol **+ New Project** -> Pilih **Deploy from GitHub repo** -> Pilih repo **tpq-daarulgusmikalhufadz-app**.
4. Klik **Deploy Now**.
5. Tunggu sebentar sampai muncul kotak projectnya.

## Tahap 3: Konfigurasi Database (PENTING)
1. Di dashboard project Railway kakak, klik tombol **+ Create** (biasanya di pojok kanan atas atau klik kanan di area kosong).
2. Pilih **Database** -> Pilih **MySQL**.
3. Tunggu sampai kotak MySQL muncul dan statusnya aktif (hijau).

## Tahap 4: Sambungkan Laravel ke Database
1. Klik kotak project Laravel kakak (bukan yang MySQL).
2. Pergi ke tab **Variables**.
3. Klik **New Variable**, masukkan data ini (Sesuai data dari kotak MySQL kakak):
   - `APP_KEY`: (Copy dari file `.env` di laptop kakak -> `php artisan key:generate --show`)
   - `APP_URL`: (Nanti diisi setelah webnya online, sementara kosongi atau isi `https://railway.app`)
   - `APP_DEBUG`: `true` (biar ketahuan kalau error)
   - `DB_CONNECTION`: `mysql`
   - `DB_HOST`: `${{MySQL.MYSQLHOST}}` (Ketik persis begini, nanti otomatis ambil dari MySQL Railway)
   - `DB_PORT`: `${{MySQL.MYSQLPORT}}`
   - `DB_DATABASE`: `${{MySQL.MYSQLDATABASE}}`
   - `DB_USERNAME`: `${{MySQL.MYSQLUSER}}`
   - `DB_PASSWORD`: `${{MySQL.MYSQLPASSWORD}}`

4. Railway akan otomatis Re-deploy. Tunggu sampai selesai.
5. **PENTING**: Setelah deploy berhasil (Status Active), buka tab **Console** (Terminal) di Railway, lalu ketik:
   `php artisan migrate --force`
   (Ini untuk membuat tabel database. Kita hapus dari start command biar deploy lebih cepat & tidak timeout).

## Tahap 5: Akses Website
1. Di kotak project Laravel, klik tab **Settings**.
2. Cari bagian **Networking** (Public Domain).
3. Klik **Generate Domain**.
4. Klik link domain yang muncul (contoh: `xxxxx.up.railway.app`).

---

## 🛑 Catatan Troubleshooting (Riwayat Debugging)
*Bagian ini penting jika nanti deploy ulang atau buat project baru.*

### 1. Deployment Gagal / Timeout (503)
**Penyebab:** Perintah `php artisan migrate --force` ada di `startCommand`.
**Solusi:** Hapus perintah migrasi dari `railway.json` dan `Procfile`. Migrasi harus dijalankan **MANUAL** via Console setelah deploy sukses.

### 2. Error Database `caching_sha2_password` (Connection Failed)
**Penyebab:** PHP 8.4 (image default Railway terbaru) belum terlalu stabil driver MySQL-nya dengan MySQL 8+ Railway.
**Solusi:**
- Downgrade `composer.json` ke `"php": "^8.2"`.
- Jika masih error, reset user database MySQL ke mode kompatibel (Native Password).

### 3. Error Seeding `Field 'password' doesn't have a default value`
**Penyebab:** Tabel `santri` butuh password tapi seeder lupa memberikannya.
**Solusi:** Pastikan `SantriSeeder` memberikan nilai default password (misal `Hash::make('...')`).

**Selesai!** 🎉
Aplikasi kakak sudah online dan terhubung database.
