<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Proposal;
use App\Models\ProgressReport;
use App\Models\FinalReport;
use Barryvdh\DomPDF\Facade\Pdf;


class DashboardController extends Controller
{
    public function index()
{
    $user = auth()->user();

    $skills = $user->skills()->get(); // pastikan relasi user->skills ada di model User

    return view('dashboard-admin', compact('user', 'skills'));
}

public function dashboardpeneliti()
    {
        return view('dashboard-peneliti');
    }
public function progress()
    {
        $progressReports = ProgressReport::with('proposals')
            ->orderBy('report_date', 'desc')
            ->get();

        return view('progressreport.progress', compact('progressReports'));
    }

    public function createProgress()
    {
        return view('progressreport.progress-create');
    }

    public function storeProgress(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'percentage' => 'nullable|integer|min:0|max:100',
            'status' => 'nullable|string|max:50',
            'notes' => 'nullable|string',
            'date' => 'nullable|date',
            'focus_area' => 'nullable|string|max:255',
            'focus' => 'nullable|string|max:255',
            'abstract' => 'nullable|string',
            'introduction' => 'nullable|string',
            'project_method' => 'nullable|string',
            'results' => 'nullable|string',
            'bibliography' => 'nullable|string',
            'statement_letter' => 'nullable|string',
        ]);

        // Create or update project with provided fields
        $projectData = [
            'title' => $data['title'],
            'status' => $data['status'] ?? 'In Progress',
        ];

        // set project date to provided date or default to today when submitting
        $projectData['date'] = $data['date'] ?? now()->toDateString();
        if (!empty($data['focus_area'])) $projectData['focus_area'] = $data['focus_area'];
        if (!empty($data['focus'])) $projectData['focus'] = $data['focus'];
        if (!empty($data['abstract'])) $projectData['abstract'] = $data['abstract'];
        if (!empty($data['introduction'])) $projectData['introduction'] = $data['introduction'];
        if (!empty($data['project_method'])) $projectData['project_method'] = $data['project_method'];
        if (!empty($data['bibliography'])) $projectData['bibliography'] = $data['bibliography'];
        if (!empty($data['statement_letter'])) $projectData['statement_letter'] = $data['statement_letter'];

        $project = Proposal::updateOrCreate(
            ['title' => $data['title']],
            $projectData
        );

        $progressReport = ProgressReport::create([
            'proposal_id' => $project->id,
            'report_date' => now()->toDateString(),
            'progress_description' => $data['abstract'] ?? null,
            'percentage_complete' => $data['percentage'] ?? 0,
            'status' => $data['status'] ?? 'In Progress',
            'notes' => $data['notes'] ?? null,
            'focus_area' => $data['focus_area'] ?? null,
            'focus' => $data['focus'] ?? null,
            'introduction' => $data['introduction'] ?? null,
            'project_method' => $data['project_method'] ?? null,
            'results' => $data['results'] ?? null,
            'bibliography' => $data['bibliography'] ?? null,
        ]);

        // Generate PDF
        $report = $progressReport->load('proposals');
        $pdf = Pdf::loadView('reports.progress-report-pdf', compact('report'));
        
        // Convert PDF to base64 for embedding in iframe
        $pdfBase64 = base64_encode($pdf->output());

        // Show success page with embedded PDF
        return view('progressreport.progress-success', compact('report', 'pdfBase64'));
    }

    public function downloadPdf($id)
    {
        $report = ProgressReport::with('proposals')->findOrFail($id);
        $pdf = Pdf::loadView('reports.progress-report-pdf', compact('report'));
        
        return $pdf->download('Progress_Report_' . $report->proposals->title . '.pdf');
    }

    /**
     * Remove the specified progress report from storage.
     */
    public function destroy($id)
    {
        $report = ProgressReport::findOrFail($id);
        $report->delete();

        return redirect('/progress')->with('success', 'Progress report deleted.');
    }

    /**
     * Show the generated PDF for an existing report (embedded) with actions.
     */
    public function showPdf($id)
    {
        $report = ProgressReport::with('proposals')->findOrFail($id);
        $pdf = Pdf::loadView('reports.progress-report-pdf', compact('report'));
        $pdfBase64 = base64_encode($pdf->output());

        return view('progressreport.progress-success', compact('report', 'pdfBase64'));
    }

    public function final()
    {
        $finalReports = \App\Models\FinalReport::with('proposals')
            ->orderBy('date', 'desc')
            ->get();

        return view('finalreport.final-report', compact('finalReports'));
    }

    /**
     * Show existing final report PDF embedded (for list PDF button).
     */
    public function showFinal($id)
    {
        $final = FinalReport::with('proposals')->findOrFail($id);
        $pdf = Pdf::loadView('reports.final-report-pdf', compact('final'));
        $pdfBase64 = base64_encode($pdf->output());

        return view('finalreport.final-success', compact('final', 'pdfBase64'));
    }

    /**
     * Remove the specified final report from storage.
     */
    public function destroyFinal($id)
    {
        $final = FinalReport::findOrFail($id);
        $final->delete();

        return redirect('/final')->with('success', 'Final report deleted.');
    }

    /**
     * Show the form to create a new final report.
     */
    public function createFinal()
    {
        return view('finalreport.final-create');
    }

    /**
     * Store a newly created final report.
     */
    public function storeFinal(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'note' => 'nullable|string',
            'abstract' => 'nullable|string',
            'introduction' => 'nullable|string',
            'method' => 'nullable|string',
            'results' => 'nullable|string',
            'bibliography' => 'nullable|string',
            'focus_area' => 'nullable|string|max:255',
            'focus' => 'nullable|string|max:255',
            'statement_letter' => 'nullable|string',
        ]);

        $project = Proposal::firstOrCreate([
            'title' => $data['title']
        ], [
            'status' => 'In Progress'
        ]);

        // store the various rich sections as a JSON blob in `summary`
        $summaryPayload = [
            'note' => $data['note'] ?? null,
            'abstract' => $data['abstract'] ?? null,
            'introduction' => $data['introduction'] ?? null,
            'method' => $data['method'] ?? null,
            'results' => $data['results'] ?? null,
            'bibliography' => $data['bibliography'] ?? null,
        ];

        $final = FinalReport::create([
            'proposal_id' => $project->id,
            'date' => now()->toDateString(),
            'title' => $data['title'],
            'focus_area' => $data['focus_area'] ?? null,
            'focus' => $data['focus'] ?? null,
            'abstract' => $data['abstract'] ?? null,
            'introduction' => $data['introduction'] ?? null,
            'project_method' => $data['method'] ?? null,
            'bibliography' => $data['bibliography'] ?? null,
            'statement_letter' => $data['statement_letter'] ?? null,
            'note' => $data['note'] ?? null,
            'results' => $data['results'] ?? null,
        ]);

        // generate PDF and show embedded viewer with download/back options
        $final = $final->fresh()->load('proposals');
        $pdf = Pdf::loadView('reports.final-report-pdf', compact('final'));
        $pdfBase64 = base64_encode($pdf->output());

        return view('finalreport.final-success', compact('final', 'pdfBase64'));
    }

    /**
     * Download the generated PDF for a final report.
     */
    public function downloadFinal($id)
    {
        $final = FinalReport::with('proposals')->findOrFail($id);
        $pdf = Pdf::loadView('reports.final-report-pdf', compact('final'));

        return $pdf->download('Final_Report_' . ($final->proposals->title ?? $final->id) . '.pdf');
    }

}
