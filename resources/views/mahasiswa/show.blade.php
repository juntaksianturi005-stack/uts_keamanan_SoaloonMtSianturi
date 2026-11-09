@extends('layouts.app')
@section('title', 'Detail Mahasiswa')
@section('content')
<div class="card shadow-sm">
    <div class="card-header">Detail Mahasiswa</div>
    <div class="card-body">
        <table class="table table-borderless mb-3">
            <tr><th style="width:200px">NIM</th><td>{{ $mahasiswa->nim }}</td></tr>
            <tr><th>Nama</th><td>{{ $mahasiswa->nama }}</td></tr>
            <tr><th>Email</th><td>{{ $mahasiswa->email }}</td></tr>
            <tr><th>Jurusan</th><td>{{ $mahasiswa->jurusan }}</td></tr>
            <tr><th>Angkatan</th><td>{{ $mahasiswa->angkatan }}</td></tr>
            <tr><th>No HP</th><td>{{ $mahasiswa->no_hp }}</td></tr>
            <tr><th>Alamat (didekripsi)</th><td>{{ $mahasiswa->alamatDekripsi() }}</td></tr>
            <tr><th>Alamat di database</th><td><code class="small text-break">{{ $mahasiswa->alamat }}</code></td></tr>
        </table>
        <a href="{{ route('mahasiswa.index') }}" class="btn btn-secondary">Kembali</a>
    </div>
</div>
@endsection
