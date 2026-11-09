@extends('layouts.app')
@section('title', 'Data Mahasiswa')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="mb-0">Data Mahasiswa</h4>
    <a href="{{ route('mahasiswa.create') }}" class="btn btn-primary">+ Tambah</a>
</div>

<form method="GET" class="mb-3">
    <div class="input-group">
        <input type="text" name="q" value="{{ $q }}" class="form-control" placeholder="Cari nama / NIM">
        <button class="btn btn-outline-secondary">Cari</button>
    </div>
</form>

<div class="table-responsive">
<table class="table table-bordered table-striped bg-white align-middle">
    <thead class="table-light">
        <tr>
            <th>#</th><th>NIM</th><th>Nama</th><th>Email</th><th>Jurusan</th>
            <th>Angkatan</th><th>No HP</th><th>Alamat (didekripsi)</th><th style="width:210px">Aksi</th>
        </tr>
    </thead>
    <tbody>
    @forelse($data as $i => $m)
        <tr>
            <td>{{ $data->firstItem() + $i }}</td>
            <td>{{ $m->nim }}</td>
            <td>{{ $m->nama }}</td>
            <td>{{ $m->email }}</td>
            <td>{{ $m->jurusan }}</td>
            <td>{{ $m->angkatan }}</td>
            <td>{{ $m->no_hp }}</td>
            <td>{{ $m->alamatDekripsi() }}</td>
            <td>
                <a href="{{ route('mahasiswa.show', $m) }}" class="btn btn-sm btn-info">Lihat</a>
                <a href="{{ route('mahasiswa.edit', $m) }}" class="btn btn-sm btn-warning">Edit</a>
                @can('delete-mahasiswa')
                <form action="{{ route('mahasiswa.destroy', $m) }}" method="POST" class="d-inline"
                      onsubmit="return confirm('Hapus data ini?')">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-sm btn-danger">Hapus</button>
                </form>
                @endcan
            </td>
        </tr>
    @empty
        <tr><td colspan="9" class="text-center">Belum ada data.</td></tr>
    @endforelse
    </tbody>
</table>
</div>
{{ $data->links('pagination::bootstrap-5') }}
@endsection
