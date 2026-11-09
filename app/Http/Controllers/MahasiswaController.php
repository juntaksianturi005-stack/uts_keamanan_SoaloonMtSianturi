<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class MahasiswaController extends Controller
{
    public function index(Request $request)
    {
        $q = trim(strip_tags($request->query('q', '')));
        $data = Mahasiswa::when($q, fn($query) => $query->where('nama', 'like', "%{$q}%")
                    ->orWhere('nim', 'like', "%{$q}%"))
                ->latest()->paginate(10)->withQueryString();

        return view('mahasiswa.index', compact('data', 'q'));
    }

    public function create()
    {
        return view('mahasiswa.create');
    }

    public function store(Request $request)
    {
        $this->sanitize($request);
        $data = $request->validate($this->rules());

        // D.1 - Enkripsi kolom alamat
        $data['alamat'] = Crypt::encryptString($data['alamat']);

        Mahasiswa::create($data);

        return redirect()->route('mahasiswa.index')->with('success', 'Data mahasiswa berhasil ditambahkan.');
    }

    public function show(Mahasiswa $mahasiswa)
    {
        return view('mahasiswa.show', compact('mahasiswa'));
    }

    public function edit(Mahasiswa $mahasiswa)
    {
        return view('mahasiswa.edit', compact('mahasiswa'));
    }

    public function update(Request $request, Mahasiswa $mahasiswa)
    {
        $this->sanitize($request);
        $data = $request->validate($this->rules($mahasiswa->id));

        $data['alamat'] = Crypt::encryptString($data['alamat']);

        $mahasiswa->update($data);

        return redirect()->route('mahasiswa.index')->with('success', 'Data mahasiswa berhasil diperbarui.');
    }

    public function destroy(Mahasiswa $mahasiswa)
    {
        // E.3 - Gate: hanya admin
        Gate::authorize('delete-mahasiswa');

        $mahasiswa->delete();

        return redirect()->route('mahasiswa.index')->with('success', 'Data mahasiswa berhasil dihapus.');
    }

    /** C.2 - Sanitasi input: buang tag HTML & spasi berlebih sebelum divalidasi/disimpan */
    private function sanitize(Request $request): void
    {
        $clean = [];
        foreach (['nim', 'nama', 'email', 'jurusan', 'angkatan', 'no_hp', 'alamat'] as $f) {
            $clean[$f] = trim(strip_tags((string) $request->input($f, '')));
        }
        $request->merge($clean);
    }

    /** B.3 - Validasi input */
    private function rules(?int $id = null): array
    {
        return [
            'nim'      => ['required', 'digits_between:8,12', Rule::unique('mahasiswa', 'nim')->ignore($id)],
            'nama'     => ['required', 'string', 'max:100'],
            'email'    => ['required', 'email', 'max:150', Rule::unique('mahasiswa', 'email')->ignore($id)],
            'jurusan'  => ['required', 'string', 'max:100'],
            'angkatan' => ['required', 'integer', 'between:2000,' . date('Y')],
            'no_hp'    => ['required', 'regex:/^[0-9+\-\s]{8,15}$/'],
            'alamat'   => ['required', 'string', 'max:255'],
        ];
    }
}
