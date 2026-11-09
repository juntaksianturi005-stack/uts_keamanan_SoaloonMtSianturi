<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;

class Mahasiswa extends Model
{
    protected $table = 'mahasiswa';

    protected $fillable = ['nim', 'nama', 'email', 'jurusan', 'angkatan', 'no_hp', 'alamat'];

    /**
     * D.2 - Tampilkan alamat dengan dekripsi: Crypt::decryptString($mahasiswa->alamat)
     */
    public function alamatDekripsi(): string
    {
        try {
            return Crypt::decryptString($this->alamat);
        } catch (DecryptException $e) {
            return '[alamat tidak dapat didekripsi]';
        }
    }
}
