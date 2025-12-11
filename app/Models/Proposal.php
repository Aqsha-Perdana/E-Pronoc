<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proposal extends Model
{
    use HasFactory;

    protected $table = 'proposals';

    protected $fillable = [
        'user_id',
        'registration_code',
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
    public function teams()
    {
        return $this->hasMany(ProposalTeam::class, 'proposal_id');
    }
    public function budgets()
    {
        return $this->hasMany(Budgets::class);
    }
    public function user()
{
    return $this->belongsTo(User::class);
}
    public function progressReports()
    {
        return $this->hasMany(ProgressReport::class);
    }

    /**
     * Get the final report for this project.
     */
    public function finalReport()
    {
        return $this->hasOne(FinalReport::class);
    }

    /**
     * Get the latest progress report.
     */
    public function latestProgressReport()
    {
        return $this->progressReports()->latest()->first();
    }
}
