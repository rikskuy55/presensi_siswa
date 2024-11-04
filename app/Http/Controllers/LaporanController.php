<?php

namespace App\Http\Controllers;

use App\Models\Presensi;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use Illuminate\Http\Request;
use PDF;

class LaporanController extends Controller
{
    // Menampilkan laporan presensi harian
    // public function laporanHarian()
    // {
    //     $presensiHarian = Presensi::where('jenis_presensi', 'harian')->get();
    //     return view('admin.laporan.laporan-harian.index', compact('presensiHarian'));
    // }

    // Menampilkan laporan presensi mata pelajaran
    // public function laporanMapel()
    // {
    //     $presensiMapel = Presensi::where('jenis_presensi', 'pelajaran')->get();
    //     return view('admin.laporan.laporan-mapel.index', compact('presensiMapel'));
    // }

    // Cetak laporan harian ke PDF
    // public function cetakLaporanHarian()
    // {
    //     $presensiHarian = Presensi::where('jenis_presensi', 'harian')->get();
        
    //     $pdf = FacadePdf::loadView('admin.laporan.laporan-harian.pdf', compact('presensiHarian'));

    //     $pdf->setPaper('A4', 'landscape');

    //     return $pdf->stream('laporan-harian.pdf');
    // }

    // Cetak laporan mapel ke PDF
    // public function cetakLaporanMapel()
    // {
    //     $presensiMapel = Presensi::where('jenis_presensi', 'pelajaran')->get();
    //     $pdf = FacadePdf::loadView('admin.laporan.laporan-mapel.pdf', compact('presensiMapel'));
    //     return $pdf->stream('laporan-mapel.pdf');
    // }
}
