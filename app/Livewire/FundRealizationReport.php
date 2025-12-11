<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Budgets;

class FundRealizationReport extends Component
{
    use WithPagination;

    public $perPage = 10;
    public $search = '';

    // Reset pagination saat search berubah
    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
{
    $budgets = Budgets::with('proposal')
        ->whereHas('proposal', function($query) {
            $query->where('title', 'like', '%' . $this->search . '%');
        })
        // PENTING: Filter logika gabungan
        ->where(function($query) {
            // Tampilkan jika Budget statusnya sudah 'Done'
            $query->where('status', 'Done')
                  // ATAU jika Proposal statusnya 'Approved' (ini yang akan jadi Active)
                  ->orWhereHas('proposal', function($q) {
                      $q->where('status', 'Approved'); 
                  });
        })
        ->orderBy('id', 'desc')
        ->paginate($this->perPage);

    return view('livewire.fund-realization-report', [
        'budgets' => $budgets
    ]);
}
}


