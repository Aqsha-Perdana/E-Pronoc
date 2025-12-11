<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Budgets;

class FundRealizationReportEdit extends Component
{
    use WithFileUploads;

    public $budget;
    
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
        $this->direct_cost_realization = $this->budget->direct_personnel_cost_fundrealization;
        $this->non_personnel_cost_realization = $this->budget->non_personnel_cost_fundrealization;
        $this->indirect_cost_realization = $this->budget->indirect_cost_fundrealization;
    }

    // Property Hitung Total Realisasi (Real-time update)
    public function getTotalRealizationProperty()
    {
        return (float)$this->direct_cost_realization + 
               (float)$this->non_personnel_cost_realization + 
               (float)$this->indirect_cost_realization;
    }

    // Property Hitung Sisa Dana (Plan - Realization)
    public function getRemainingFundProperty()
    {
        // Total Plan diambil dari database (tetap)
        $totalPlan = $this->budget->total_plan; 
        return $totalPlan - $this->totalRealization;
    }

    public function save()
    {
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
        return redirect()->route('report.fund');
    }

    public function render()
    {
        return view('livewire.fund-realization-report-edit');
    }
}