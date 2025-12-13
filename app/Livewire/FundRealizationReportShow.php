<?php

namespace App\Livewire;

use Livewire\Component;
<<<<<<< HEAD
use App\Models\Budget;
use Illuminate\Support\Facades\Auth;
=======
use App\Models\Budgets;
>>>>>>> e68c7900a429ca0a02a86e7a4345c04cba74b760

class FundRealizationReportShow extends Component
{
    public $budget;

    public function mount($id)
    {
<<<<<<< HEAD
        $userId = Auth::id();

        $this->budget = Budget::with('proposal')
            ->whereHas('proposal.teamMembers', function($q) use ($userId) {
                $q->where('user_id', $userId);
            })
            ->findOrFail($id);
=======
        // Eager load proposal untuk efisiensi
        $this->budget = Budgets::with('proposal')->findOrFail($id);
>>>>>>> e68c7900a429ca0a02a86e7a4345c04cba74b760
    }

    public function render()
    {
        return view('livewire.fund-realization-report-show');
    }
<<<<<<< HEAD


=======
>>>>>>> e68c7900a429ca0a02a86e7a4345c04cba74b760
}