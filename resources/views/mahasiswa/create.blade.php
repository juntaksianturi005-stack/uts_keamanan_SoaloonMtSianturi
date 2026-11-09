@extends('layouts.app')
@section('title', 'Tambah Mahasiswa')
@section('content')
<div class="card shadow-sm">
    <div class="card-header">Tambah Mahasiswa</div>
    <div class="card-body">
        <form method="POST" action="{{ route('mahasiswa.store') }}">
            @csrf
            @include('mahasiswa._form')
            <button class="btn btn-primary">Simpan</button>
            <a href="{{ route('mahasiswa.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>
@endsection
