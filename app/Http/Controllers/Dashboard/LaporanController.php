<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\BukuModel;
use Barryvdh\DomPDF\Facade\Pdf;
use Dompdf\Dompdf;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index()
    {
        try {
            $buku = BukuModel::with('Kategori')->get();
            $pdf = Pdf::loadView('dashboard.laporan.pdf', compact('buku'));
            return $pdf->stream('laporan-buku.pdf');
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
