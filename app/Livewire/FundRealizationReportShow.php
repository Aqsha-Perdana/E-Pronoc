<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Budgets;

class FundRealizationReportShow extends Component
{
    public $budget;

    public function mount($id)
    {
        // Eager load proposal untuk efisiensi
        $this->budget = Budgets::with('proposal')->findOrFail($id);
    }

    public function render()
    {
        return view('livewire.fund-realization-report-show');
    }
}