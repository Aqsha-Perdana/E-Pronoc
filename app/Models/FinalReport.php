<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FinalReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'proposal_id',
        'title',
        'date',
        'focus_area',
        'focus',
        'abstract',
        'introduction',
        'project_method',
        'bibliography',
        'statement_letter',
        'status',
    ];

    protected $casts = [
        'report_date' => 'datetime', // Pastikan baris ini ada
        'summary' => 'array', // Ini juga penting agar json_decode di view tidak error
    ];

    /**
     * Get the project this report belongs to.
     */
    public function proposal()
    {
        return $this->belongsTo(Proposal::class);
    }
}
