@extends('layouts.app')
@section('title', 'Edit Mahasiswa')
@section('content')
<div class="card shadow-sm">
    <div class="card-header">Edit Mahasiswa</div>
    <div class="card-body">
        <form method="POST" action="{{ route('mahasiswa.update', $mahasiswa) }}">
            @csrf
            @method('PUT')
            @include('mahasiswa._form', ['mahasiswa' => $mahasiswa])
            <button class="btn btn-primary">Perbarui</button>
            <a href="{{ route('mahasiswa.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>
@endsection
