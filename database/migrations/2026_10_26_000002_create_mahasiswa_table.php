<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mahasiswa', function (Blueprint $table) {
            $table->id();
            $table->string('nim', 12)->unique();
            $table->string('nama', 100);
            $table->string('email', 150)->unique();
            $table->string('jurusan', 100);
            $table->unsignedSmallInteger('angkatan');
            $table->string('no_hp', 20);
            $table->text('alamat'); // tersimpan terenkripsi (Crypt)
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mahasiswa');
    }
};
