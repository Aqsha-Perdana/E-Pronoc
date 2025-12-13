<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProgressReport;
use App\Models\FinalReport;
use App\Models\Proposal;
use App\Models\Budget;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    // ... (Keep existing index, progress, editProgress methods) ...
    // Note: I will include them briefly for context, but the main fix is in updateProgress

    public function index()
    {
        $userId = Auth::id(); 
        $user = Auth::user();
        $showProfileAlert = false;

        if (!$user->member) {
            $showProfileAlert = true;
        } elseif (empty($user->member->nip) || empty($user->member->phone_number)) {
            $showProfileAlert = true;
        }

        $totalProposals = Proposal::whereHas('teamMembers', function($q) use ($userId) {
            $q->where('user_id', $userId);
        })->count(); 

        $activeProposals = Proposal::whereHas('teamMembers', function($q) use ($userId) {
            $q->where('user_id', $userId);
        })->whereIn('status', ['SUBMITTED', 'APPROVED'])->count();

        $danaCair = Proposal::where('status', 'APPROVED')
            ->whereHas('teamMembers', function($q) use ($userId) {
                $q->where('user_id', $userId);
            })
            ->with('budget')
            ->get()
            ->sum(function($proposal) {
                if (!$proposal->budget) return 0;
                return ($proposal->budget->direct_personnel_cost_proposal ?? 0) +
                       ($proposal->budget->non_personnel_cost_proposal ?? 0) +
                       ($proposal->budget->indirect_cost_proposal ?? 0);
            });

        $totalRealization = Proposal::where('status', 'APPROVED')
            ->whereHas('teamMembers', function($q) use ($userId) {
                $q->where('user_id', $userId);
            })
            ->with('budget')
            ->get()
            ->sum(function($proposal) {
                if (!$proposal->budget) return 0;
                return ($proposal->budget->direct_personnel_cost_fundrealization ?? 0) +
                       ($proposal->budget->non_personnel_cost_fundrealization ?? 0) +
                       ($proposal->budget->indirect_cost_fundrealization ?? 0);
            });

        $totalGrant = 1000000000; 
        $hasApprovedProposal = Proposal::where('status', 'APPROVED')
            ->whereHas('teamMembers', function($q) use ($userId) {
                $q->where('user_id', $userId);
            })->exists();

        $sisaDana = $hasApprovedProposal ? ($danaCair - $totalRealization) : 0;
        // Wait, logic correction based on previous prompt:
        // Sisa Pagu = (Total Allocation) - (Total Spent). 
        // If Dana Cair is allocation, then Sisa = Dana Cair - Total Realization.
        // If Total Grant is the global ceiling, then Sisa = Total Grant - Dana Cair (Allocated).
        // Let's stick to the prompt's specific logic: 
        // Sisa Pagu = Total Realization - Total Proposal Cost (which is negative if under budget?)
        // Actually, usually: Remaining = Budget - Realization.
        $sisaDana = $danaCair - $totalRealization; 


        $monthlyProposals = Proposal::select(
                DB::raw('COUNT(id) as count'), 
                DB::raw('MONTH(date) as month')
            )
            ->whereHas('teamMembers', function($q) use ($userId) {
                $q->where('user_id', $userId);
            })
            ->whereYear('date', date('Y'))
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('count', 'month')
            ->toArray();

        $chartData = [];
        for ($i = 1; $i <= 12; $i++) {
            $chartData[] = $monthlyProposals[$i] ?? 0;
        }
        $months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

        $recentProposals = Proposal::whereHas('teamMembers', function($q) use ($userId) {
                $q->where('user_id', $userId);
            })
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard.dashboard', compact(
            'totalProposals', 
            'activeProposals', 
            'danaCair', 
            'sisaDana', 
            'chartData', 
            'months',
            'recentProposals',
            'showProfileAlert'
        ));
    }

    public function progress()
    {
        $userId = Auth::id();
        $approvedProposals = Proposal::where('status', 'APPROVED')
            ->whereHas('teamMembers', function($q) use ($userId) {
                $q->where('user_id', $userId);
            })
            ->with('progressReport')
            ->orderBy('updated_at', 'desc')
            ->get();

        return view('progressreport.progress', compact('approvedProposals'));
    }

    public function editProgress($id)
    {
        $proposal = Proposal::findOrFail($id);
        $report = $proposal->progressReport ?? new ProgressReport();
        return view('progressreport.progress-create', compact('proposal', 'report'));
    }

    // --- FIX: updateProgress Method ---
    public function updateProgress(Request $request, $id)
    {
        // 1. Basic Input Validation
        $request->validate([
            'percentage' => 'required|integer|min:0|max:100',
            'status'     => 'required|string',
        ]);

        $status = $request->input('status');
        
        // 2. Define Conditional Validation Rules
        $rules = [
            'notes'       => 'nullable|string',
            'activities'  => 'nullable|string',
            'results'     => 'nullable|string',
            'obstacles'   => 'nullable|string',
            'next_steps'  => 'nullable|string',
            'attachments' => 'nullable|string', 
        ];

        // If Status is 'Complete' OR Percentage is 100, make fields REQUIRED
        // Note: Ensure the value "Complete" matches exactly what is sent from the form/select option
        if ($status === 'Complete' || $request->input('percentage') == 100) {
            $rules['activities']  = 'required|string|min:10';
            $rules['results']     = 'required|string|min:10';
            $rules['obstacles']   = 'required|string';
            $rules['next_steps']  = 'required|string';
            $rules['attachments'] = 'required|string'; 
        }

        $data = $request->validate($rules);

        $proposal = Proposal::findOrFail($id);

        // 3. Save to Database
        // Columns here MUST match the database table 'progress_reports' shown in your image
        ProgressReport::updateOrCreate(
            ['proposal_id' => $proposal->id],
            [
                'report_date'         => now()->toDateString(),
                'percentage_complete' => $request->input('percentage'),
                'status'              => $status,
                // Optional fields mapped from validated data
                'notes'               => $data['notes'] ?? null,
                'activities'          => $data['activities'] ?? null,
                'results'             => $data['results'] ?? null,
                'obstacles'           => $data['obstacles'] ?? null,
                'next_steps'          => $data['next_steps'] ?? null,
                'attachments'         => $data['attachments'] ?? null,
            ]
        );

        return redirect()->route('progress.index')->with('success', 'Progress updated successfully!');
    }

    // ... (Keep existing methods: showPdf, downloadPdf, destroy, final, editFinal, storeFinal, etc.) ...
    
    public function showPdf($id)
    {
        $report = ProgressReport::with('proposal')->findOrFail($id);
        $pdf = Pdf::loadView('reports.progress-report-pdf', compact('report'));
        $pdfBase64 = base64_encode($pdf->output());
        return view('progressreport.progress-success', compact('report', 'pdfBase64'));
    }
    
    public function downloadPdf($id)
    {
        $report = ProgressReport::with('proposal')->findOrFail($id);
        $pdf = Pdf::loadView('reports.progress-report-pdf', compact('report'));
        return $pdf->download('Progress_Report_' . $report->proposal->title . '.pdf');
    }

    public function indexAdmin()
{
    $user = auth()->user();

    $skills = $user->skills()->get(); // pastikan relasi user->skills ada di model User

    return view('dashboard-admin', compact('user', 'skills'));
}

}
