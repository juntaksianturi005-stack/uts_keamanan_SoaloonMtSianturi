@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')
<div class="card shadow-sm">
    <div class="card-body">
        <h4>Selamat datang, {{ auth()->user()->name }}</h4>
        <p class="text-muted">Role Anda: <strong>{{ auth()->user()->role }}</strong></p>

        @if(auth()->user()->isAdmin())
            <p>Total data mahasiswa: <strong>{{ $total }}</strong></p>
            <a href="{{ route('mahasiswa.index') }}" class="btn btn-primary">Kelola Data Mahasiswa</a>
        @else
            <p>Sebagai <em>user</em>, Anda hanya dapat melihat dan mengubah profil Anda sendiri.</p>
            <a href="{{ route('profil.edit') }}" class="btn btn-primary">Lihat / Ubah Profil</a>
        @endif
    </div>
</div>
@endsection
