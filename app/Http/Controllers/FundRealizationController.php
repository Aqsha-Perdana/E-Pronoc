<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
<<<<<<< HEAD
use App\Models\Budget;
=======
use App\Models\Budgets;
>>>>>>> e68c7900a429ca0a02a86e7a4345c04cba74b760
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Str; // Tambahkan ini jika mau pakai Str::slug, tapi cara di bawah pakai str_replace native

class FundRealizationController extends Controller
{
    public function downloadPdf($id)
    {
        // 1. Ambil data berdasarkan ID
<<<<<<< HEAD
        $budget = Budget::with('proposal')->findOrFail($id);

        // 2. Load View khusus PDF
        $pdf = Pdf::loadView('pdf.fund-realization-document', [
            'budget' => $budget
=======
        $budget = Budgets::with('proposal')->findOrFail($id);

        // 2. Load View khusus PDF
        $pdf = Pdf::loadView('pdf.fund-realization-document', [
            'budgets' => $budget
>>>>>>> e68c7900a429ca0a02a86e7a4345c04cba74b760
        ]);

        // 3. Set ukuran kertas dan orientasi
        $pdf->setPaper('A4', 'portrait');

        // 4. SANITASI NAMA FILE
        // Ambil kode, default ke 'DOC' jika null
<<<<<<< HEAD
        $rawCode = $budget->proposal->registration_code ?? 'DOC';
=======
        $rawCode = $budget->proposals->registration_code ?? 'DOC';
>>>>>>> e68c7900a429ca0a02a86e7a4345c04cba74b760
        
        // Ganti karakter '/' dan '\' menjadi '-' agar valid sebagai nama file
        // Contoh: "RCMS/RES/2025" menjadi "RCMS-RES-2025"
        $safeCode = str_replace(['/', '\\'], '-', $rawCode);

        // Buat nama file akhir
        $filename = 'Realization-' . $safeCode . '.pdf';
        
        return $pdf->download($filename);
    }
}