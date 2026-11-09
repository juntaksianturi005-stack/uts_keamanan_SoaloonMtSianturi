<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;

class DashboardController extends Controller
{
    public function index()
    {
        $total = auth()->user()->isAdmin() ? Mahasiswa::count() : null;
        return view('dashboard', compact('total'));
    }
}
