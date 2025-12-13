<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProgressReport extends Model
{
    use HasFactory;

    protected $fillable = [
<<<<<<< HEAD
        'proposal_id', 'report_date', 'percentage_complete', 'status', 
        'activities', 'results', 'obstacles', 'next_steps', 'attachments', 'notes'
    ];

=======
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
>>>>>>> e68c7900a429ca0a02a86e7a4345c04cba74b760
    public function proposal()
    {
        return $this->belongsTo(Proposal::class);
    }
<<<<<<< HEAD
    
    // Relasi ke Final Report (Jika ingin mengecek dari sisi Progress)
    public function finalReport()
    {
        return $this->hasOne(FinalReport::class, 'proposal_id', 'proposal_id');
    }
}
=======
}
>>>>>>> e68c7900a429ca0a02a86e7a4345c04cba74b760
