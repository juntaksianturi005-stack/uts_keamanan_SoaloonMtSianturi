<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $jam = now()->hour;

        $data = [
            'sapaan'    => $jam < 11 ? 'Selamat pagi' : ($jam < 15 ? 'Selamat siang' : ($jam < 18 ? 'Selamat sore' : 'Selamat malam')),
            'namaDepan' => Str::before($user->name, ' '),
            'tanggal'   => now()->locale('id')->isoFormat('dddd, D MMMM Y'),
        ];

        if ($user->isAdmin()) {
            $byJurusan = Mahasiswa::select('jurusan', DB::raw('count(*) as jml'))
                ->groupBy('jurusan')->orderByDesc('jml')->pluck('jml', 'jurusan');

            $data += [
                'total'      => Mahasiswa::count(),
                'totalUsers' => User::count(),
                'byAngkatan' => Mahasiswa::select('angkatan', DB::raw('count(*) as jml'))
                    ->groupBy('angkatan')->orderByDesc('angkatan')->pluck('jml', 'angkatan'),
                'byJurusan'  => $byJurusan,
                'terbaru'    => Mahasiswa::latest()->take(5)->get(),
            ];
        }

        return view('dashboard', $data);
    }
}
