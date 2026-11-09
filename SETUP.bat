@echo off
REM Jalankan dari Laragon Terminal, di folder project ini (C:\laragon\www\uts_keamanan_SoaloonMtSianturi)
cd /d %~dp0

echo [1/3] Install dependency (vendor) ...
call composer install
if errorlevel 1 (
  echo GAGAL composer install. Cek internet / versi PHP (butuh PHP 8.2 ke atas).
  pause
  exit /b 1
)

echo [2/3] Membuat database uts_keamanan ...
mysql -u root -e "CREATE DATABASE IF NOT EXISTS uts_keamanan CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"

echo [3/3] Migrasi + seeder ...
call php artisan migrate:fresh --seed

echo.
echo SELESAI. Buka: http://uts_keamanan_SoaloonMtSianturi.test  (Laragon auto virtual host)
echo atau jalankan: php artisan serve  lalu buka http://127.0.0.1:8000
echo Admin : admin@uts.test / Admin12345
echo User  : user@uts.test  / User12345
pause
