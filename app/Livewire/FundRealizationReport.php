<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
<<<<<<< HEAD
use App\Models\Budget;
use Illuminate\Support\Facades\Auth; // Don't forget to import Auth!
=======
use App\Models\Budgets;
>>>>>>> e68c7900a429ca0a02a86e7a4345c04cba74b760

class FundRealizationReport extends Component
{
    use WithPagination;

    public $perPage = 10;
    public $search = '';

<<<<<<< HEAD
    // Reset pagination when search changes
=======
    // Reset pagination saat search berubah
>>>>>>> e68c7900a429ca0a02a86e7a4345c04cba74b760
    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
<<<<<<< HEAD
    {
        $userId = Auth::id(); // Get current user ID

        $budgets = Budget::with('proposal')
            // 1. FILTER BY USER (OWNERSHIP)
            ->whereHas('proposal.teamMembers', function($q) use ($userId) {
                $q->where('user_id', $userId);
            })
            // 2. SEARCH FILTER
            ->whereHas('proposal', function($query) {
                $query->where('title', 'like', '%' . $this->search . '%');
            })
            // 3. STATUS LOGIC
            ->where(function($query) {
                // Show if Budget status is 'Done' OR Proposal is 'Approved'
                $query->where('status', 'Done')
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
=======
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


>>>>>>> e68c7900a429ca0a02a86e7a4345c04cba74b760
