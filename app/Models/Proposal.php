<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proposal extends Model
{
    use HasFactory;

<<<<<<< HEAD
    // Mengizinkan mass assignment untuk semua kolom selain ID
    // Ini penting agar 'user_id', 'title', dll bisa diisi via create()
    protected $guarded = ['id'];

    // ==========================================================
    // RELASI USER
    // ==========================================================

    /**
     * Relasi ke Pemilik Proposal (User yang membuat).
     * Berdasarkan kolom 'user_id' di tabel proposals.
     */
    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Relasi ke Tim Peneliti (Ketua & Anggota).
     * Menggunakan tabel pivot 'proposal_teams'.
     */
    public function teamMembers()
    {
        return $this->belongsToMany(User::class, 'proposal_teams', 'proposal_id', 'user_id')
                    ->withPivot('role')
                    ->withTimestamps();
    }

    /**
     * ALIAS: Agar kode lama yang menggunakan ->members tetap jalan.
     * Merujuk ke fungsi teamMembers() di atas.
     */
    public function members()
    {
        return $this->teamMembers();
    }

    // ==========================================================
    // RELASI DATA PENDUKUNG
    // ==========================================================

    public function budget()
    {
        return $this->hasOne(Budget::class);
    }

    public function outputIndicators()
    {
        return $this->hasMany(OutputIndicator::class);
    }

    // ==========================================================
    // RELASI LAPORAN
    // ==========================================================

    public function progressReport()
    {
        return $this->hasOne(ProgressReport::class);
    }

=======
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
>>>>>>> e68c7900a429ca0a02a86e7a4345c04cba74b760
    public function finalReport()
    {
        return $this->hasOne(FinalReport::class);
    }

    /**
<<<<<<< HEAD
     * Relasi Realisasi Dana.
     * Sebenarnya datanya ada di tabel 'budgets' juga, 
     * tapi dipisahkan method-nya agar lebih semantik di controller.
     */
    public function fundRealization()
    {
        return $this->hasOne(Budget::class); 
    }
}
=======
     * Get the latest progress report.
     */
    public function latestProgressReport()
    {
        return $this->progressReports()->latest()->first();
    }
}
>>>>>>> e68c7900a429ca0a02a86e7a4345c04cba74b760
