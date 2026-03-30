@echo off
echo ==============================================
echo 🚀 MEMULAI DEPLOYMENT KE RAILWAY...
echo ==============================================
echo.

echo [1/3] Menambahkan file yang diubah...
git add .
if %errorlevel% neq 0 (
    echo ❌ Gagal menambahkan file! Pastikan git sudah terinstall.
    pause
    exit /b
)

echo [2/3] Membuat 'commit'...
git commit -m "Fix map tile rendering on Ustadz dashboard"
if %errorlevel% neq 0 (
    echo ⚠️ Tidak ada perubahan baru atau gagal commit. Melanjutkan push...
)

echo [3/3] Mengirimkan (push) ke GitHub...
git push origin main
if %errorlevel% neq 0 (
    echo ❌ Gagal mengirim ke GitHub (pastikan koneksi internet stabil).
    pause
    exit /b
)

echo.
echo ==============================================
echo ✅ BERHASIL! 
echo Railway akan melakukan deploy beberapa saat lagi.
echo Silakan cek dashboard Railway untuk melihat prosesnya.
echo ==============================================
pause
