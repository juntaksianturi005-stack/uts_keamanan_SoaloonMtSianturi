<?php

namespace Database\Seeders;

use App\Models\Mahasiswa;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Soaloon Mt Sianturi', 'email' => 'admin@uts.test',
            'password' => Hash::make('Admin12345'), 'role' => 'admin',
        ]);
        User::create([
            'name' => 'User Biasa', 'email' => 'user@uts.test',
            'password' => Hash::make('User12345'), 'role' => 'user',
        ]);

        $contoh = [
            ['20230001', 'Andi Pratama', 'andi@mail.test', 'Manajemen Informatika', 2023, '081234567890', 'Jl. Sudirman No. 1, Padang'],
            ['20230002', 'Budi Santoso', 'budi@mail.test', 'Manajemen Informatika', 2023, '081234567891', 'Jl. Khatib Sulaiman No. 5, Padang'],
            ['20230003', 'Citra Lestari', 'citra@mail.test', 'Manajemen Informatika', 2023, '081234567892', 'Jl. Proklamasi No. 9, Padang'],
            ['20240001', 'Dewi Anggraini', 'dewi@mail.test', 'Teknik Komputer', 2024, '081234567893', 'Jl. Veteran No. 3, Padang'],
            ['20240002', 'Eko Wijaya', 'eko@mail.test', 'Teknik Komputer', 2024, '081234567894', 'Jl. Hamka No. 12, Padang'],
        ];
        foreach ($contoh as [$nim, $nama, $email, $jur, $ang, $hp, $alamat]) {
            Mahasiswa::create([
                'nim' => $nim, 'nama' => $nama, 'email' => $email, 'jurusan' => $jur,
                'angkatan' => $ang, 'no_hp' => $hp, 'alamat' => Crypt::encryptString($alamat),
            ]);
        }
    }
}
