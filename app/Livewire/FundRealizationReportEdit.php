<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
<<<<<<< HEAD
use App\Models\Budget;
=======
use App\Models\Budgets;
>>>>>>> e68c7900a429ca0a02a86e7a4345c04cba74b760

class FundRealizationReportEdit extends Component
{
    use WithFileUploads;

    public $budget;
    
<<<<<<< HEAD
    // Form Inputs (Mapped to component properties)
    public $direct_cost_realization;
    public $non_personnel_cost_realization;
    public $indirect_cost_realization;
    public $document_rab_realization; // Temporary file upload

    public function mount($id)
    {
        // 1. Ambil data budget & proposal
        $this->budget = Budget::with('proposal')->findOrFail($id);

        // 2. Isi form dengan data database (agar tidak kosong saat edit)
=======
    // Form Inputs (Realization)
    public $direct_cost_realization;
    public $non_personnel_cost_realization;
    public $indirect_cost_realization;
    public $document_rab_realization; // File upload

    public function mount($id)
    {
        // Ambil data budget berdasarkan ID
        $this->budget = Budgets::with('proposal')->findOrFail($id);

        // Isi form dengan data yang sudah ada (jika mau edit ulang)
>>>>>>> e68c7900a429ca0a02a86e7a4345c04cba74b760
        $this->direct_cost_realization = $this->budget->direct_personnel_cost_fundrealization;
        $this->non_personnel_cost_realization = $this->budget->non_personnel_cost_fundrealization;
        $this->indirect_cost_realization = $this->budget->indirect_cost_fundrealization;
    }

<<<<<<< HEAD
    // Hitung Total Realisasi (Otomatis update di view)
=======
    // Property Hitung Total Realisasi (Real-time update)
>>>>>>> e68c7900a429ca0a02a86e7a4345c04cba74b760
    public function getTotalRealizationProperty()
    {
        return (float)$this->direct_cost_realization + 
               (float)$this->non_personnel_cost_realization + 
               (float)$this->indirect_cost_realization;
    }

<<<<<<< HEAD
    // Hitung Sisa Dana
    public function getRemainingFundProperty()
    {
        // Ambil Total Plan dari kolom proposal di tabel budgets
        // Pastikan kolom ini terisi di database saat proposal dibuat
        $totalPlan = ($this->budget->direct_personnel_cost_proposal ?? 0) + 
                     ($this->budget->non_personnel_cost_proposal ?? 0) + 
                     ($this->budget->indirect_cost_proposal ?? 0);
                     
=======
    // Property Hitung Sisa Dana (Plan - Realization)
    public function getRemainingFundProperty()
    {
        // Total Plan diambil dari database (tetap)
        $totalPlan = $this->budget->total_plan; 
>>>>>>> e68c7900a429ca0a02a86e7a4345c04cba74b760
        return $totalPlan - $this->totalRealization;
    }

    public function save()
    {
<<<<<<< HEAD
        // --- VALIDASI KETAT ---
        
        // Cek apakah file sudah ada di database sebelumnya?
        // Jika SUDAH ada, upload baru opsional ('nullable').
        // Jika BELUM ada, upload baru wajib ('required').
        $fileRule = $this->budget->document_rab_fundrealization ? 'nullable' : 'required';

        $this->validate([
            'direct_cost_realization'        => 'required|numeric|min:0',
            'non_personnel_cost_realization' => 'required|numeric|min:0',
            'indirect_cost_realization'      => 'required|numeric|min:0',
            'document_rab_realization'       => [$fileRule, 'file', 'mimes:xlsx,xls,pdf', 'max:10240'], // Max 10MB
        ], [
            // Pesan Error Bahasa Indonesia yang Jelas
            'direct_cost_realization.required'        => 'Biaya Personil wajib diisi (masukkan 0 jika tidak ada).',
            'non_personnel_cost_realization.required' => 'Biaya Non-Personil wajib diisi (masukkan 0 jika tidak ada).',
            'indirect_cost_realization.required'      => 'Biaya Tidak Langsung wajib diisi (masukkan 0 jika tidak ada).',
            
            'document_rab_realization.required'       => 'Dokumen Pendukung (RAB Realisasi) wajib diunggah!',
            'document_rab_realization.mimes'          => 'Format file harus Excel (.xlsx, .xls) atau PDF.',
            'document_rab_realization.max'            => 'Ukuran file terlalu besar (Maksimal 10MB).',
        ]);

        // --- PROSES SIMPAN ---

        // 1. Tentukan path file (Gunakan yang lama jika tidak ada upload baru)
        $filePath = $this->budget->document_rab_fundrealization;
        
        if ($this->document_rab_realization) {
            // Simpan file baru ke storage
            $filePath = $this->document_rab_realization->store('realization_docs', 'public');
        }

        // 2. Update Database
        $this->budget->update([
            'direct_personnel_cost_fundrealization' => $this->direct_cost_realization,
            'non_personnel_cost_fundrealization'    => $this->non_personnel_cost_realization,
            'indirect_cost_fundrealization'         => $this->indirect_cost_realization,
            'document_rab_fundrealization'          => $filePath, // Path file (baru atau lama)
            'status'                                => 'Done'
        ]);

        // 3. Feedback & Redirect
        session()->flash('message', 'Laporan Realisasi Dana berhasil disimpan.');
=======
        $this->validate([
            'direct_cost_realization' => 'required|numeric|min:0',
            'non_personnel_cost_realization' => 'required|numeric|min:0',
            'indirect_cost_realization' => 'required|numeric|min:0',
            'document_rab_realization' => 'nullable|file|mimes:xlsx,xls|max:10240',
        ]);

        // Upload file jika ada yang baru
        $filePath = $this->budget->document_rab_fundrealization;
        if ($this->document_rab_realization) {
            $filePath = $this->document_rab_realization->store('realization_docs', 'public');
        }

        // Update Database
        $this->budget->update([
            'direct_personnel_cost_fundrealization' => $this->direct_cost_realization,
            'non_personnel_cost_fundrealization' => $this->non_personnel_cost_realization,
            'indirect_cost_fundrealization' => $this->indirect_cost_realization,
            'document_rab_fundrealization' => $filePath,
            'status' => 'Done' // Atau status lain sesuai logika bisnis
        ]);

        session()->flash('message', 'Fund realization updated successfully!');
>>>>>>> e68c7900a429ca0a02a86e7a4345c04cba74b760
        return redirect()->route('report.fund');
    }

    public function render()
    {
        return view('livewire.fund-realization-report-edit');
    }
}