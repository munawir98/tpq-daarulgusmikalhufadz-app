<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class KelasWebController extends Controller
{
    /**
     * Show kelas list
     */
    public function index()
    {
        return view('kelas.index');
    }

    /**
     * Show kelas detail
     */
    public function show($id)
    {
        return view('kelas.show', ['kelasId' => $id]);
    }

    /**
     * Show kelas presensi recap
     */
    public function rekapPresensi($id)
    {
        return view('kelas.presensi', ['kelasId' => $id]);
    }
}
