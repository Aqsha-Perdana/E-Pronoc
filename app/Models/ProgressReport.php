<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProgressReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'proposal_id',
        'report_date',
        'progress_description',
        'percentage_complete',
        'status',
        'notes',
        'focus_area',
        'focus',
        'introduction',
        'project_method',
        'results',
        'bibliography',
    ];

    protected $casts = [
        'report_date' => 'date',
    ];

    /**
     * Get the project this report belongs to.
     */
    public function proposal()
    {
        return $this->belongsTo(Proposal::class);
    }
}
