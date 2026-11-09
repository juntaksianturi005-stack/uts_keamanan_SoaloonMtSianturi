@php $m = $mahasiswa ?? null; @endphp
<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label">NIM</label>
        <input type="text" name="nim" value="{{ old('nim', $m->nim ?? '') }}" class="form-control" required>
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label">Nama</label>
        <input type="text" name="nama" value="{{ old('nama', $m->nama ?? '') }}" class="form-control" required>
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label">Email</label>
        <input type="email" name="email" value="{{ old('email', $m->email ?? '') }}" class="form-control" required>
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label">Jurusan</label>
        <input type="text" name="jurusan" value="{{ old('jurusan', $m->jurusan ?? '') }}" class="form-control" required>
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label">Angkatan</label>
        <input type="number" name="angkatan" value="{{ old('angkatan', $m->angkatan ?? '') }}" class="form-control" required>
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label">No HP</label>
        <input type="text" name="no_hp" value="{{ old('no_hp', $m->no_hp ?? '') }}" class="form-control" required>
    </div>
    <div class="col-12 mb-3">
        <label class="form-label">Alamat <span class="text-muted small">(disimpan terenkripsi)</span></label>
        <textarea name="alamat" rows="3" class="form-control" required>{{ old('alamat', $m ? $m->alamatDekripsi() : '') }}</textarea>
    </div>
</div>
