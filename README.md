# UTS Keamanan Sistem Informasi — Soaloon Mt Sianturi
Project Laravel 12: `uts_keamanan_SoaloonMtSianturi` | Database: `uts_keamanan`

Struktur project lengkap (app, bootstrap, config, database, public, resources, routes, storage, tests,
artisan, composer.json, .env, dll). Satu-satunya yang belum ada adalah folder `vendor` — dibuat oleh
`composer install` (butuh internet, PHP 8.2+).

## Pasang di Laragon
1. Taruh folder ini di `C:\laragon\www\`, start Apache + MySQL di Laragon.
2. Buka Terminal Laragon di folder project, jalankan: `SETUP.bat`
   (atau manual: `composer install` → buat DB `uts_keamanan` → `php artisan migrate:fresh --seed`)
3. Buka `http://uts_keamanan_SoaloonMtSianturi.test` atau `php artisan serve`.
4. Buka folder ini di VS Code untuk mengedit.

`APP_KEY` sudah terisi di `.env`, jadi tidak perlu `key:generate`.

## Akun
| Role  | Email          | Password   |
|-------|----------------|------------|
| admin | admin@uts.test | Admin12345 |
| user  | user@uts.test  | User12345  |

## Pemetaan ke soal
| Soal | Lokasi |
|---|---|
| A.1 login/register | `app/Http/Controllers/AuthController.php`, `resources/views/auth/*` |
| A.2 role admin/user | kolom `users.role` (`database/migrations/2026_10_26_000001_...`) |
| A.3 middleware role | `app/Http/Middleware/RoleMiddleware.php`, alias di `bootstrap/app.php`, `routes/web.php` |
| B CRUD + validasi (7 kolom) | `app/Models/Mahasiswa.php`, `MahasiswaController.php`, `resources/views/mahasiswa/*` |
| C.1 @csrf | semua `<form>` di `resources/views` |
| C.2 sanitasi | `strip_tags()` + `trim()` di controller (`sanitize()`), output di-escape `{{ }}` |
| C.3 uji tanpa CSRF | lihat di bawah |
| D.1/D.2 enkripsi alamat | `Crypt::encryptString` di controller, `Mahasiswa::alamatDekripsi()` |
| D.3 hashing | `Hash::make()` di `AuthController`, `ProfileController`, seeder |
| E.1 rate limit | `throttle:5,1` pada `POST /login` (`routes/web.php`) |
| E.2 HTTPS | `URL::forceScheme('https')` di `AppServiceProvider` (aktif jika `FORCE_HTTPS=true`) |
| E.3 Gate | `Gate::define('delete-mahasiswa', ...)` di `AppServiceProvider` + `Gate::authorize` + `@can` |

## Uji
- Otomatis: `php artisan test` (role, enkripsi alamat, sanitasi, validasi, hashing, rate limit, hapus data).
- CSRF (C.3): `curl -i -X POST http://127.0.0.1:8000/login -d "email=a@a.com&password=x"` → `419 Page Expired`.
- Rate limit: salah login 6x dalam 1 menit → `429`.
- Enkripsi: lihat tabel `mahasiswa` di HeidiSQL → kolom `alamat` berupa teks acak.
- Role: login sebagai `user`, buka `/mahasiswa` → `403`.
- HTTPS: `FORCE_HTTPS=true` di `.env`, lalu `php artisan config:clear` (butuh SSL Laragon).
