<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Progress Report - {{ $report->project->title }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            color: #333;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 3px solid #c8102e;
            padding-bottom: 15px;
        }
        .header h1 {
            margin: 0;
            color: #c8102e;
            font-size: 24px;
        }
        .header p {
            margin: 5px 0;
            font-size: 12px;
            color: #666;
        }
        .section {
            margin-bottom: 20px;
        }
        .section h2 {
            background-color: #f3f4f6;
            padding: 10px;
            border-left: 4px solid #c8102e;
            font-size: 14px;
            margin: 0 0 10px 0;
        }
        .section p {
            margin: 0 0 10px 0;
            line-height: 1.6;
            font-size: 11px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
            font-size: 11px;
        }
        table td {
            padding: 8px;
            border-bottom: 1px solid #ddd;
        }
        table tr:nth-child(even) {
            background-color: #f9fafb;
        }
        .label {
            font-weight: bold;
            width: 30%;
            color: #555;
        }
        .footer {
            margin-top: 40px;
            border-top: 1px solid #ddd;
            padding-top: 15px;
            text-align: center;
            font-size: 10px;
            color: #999;
        }
        .status-badge {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 4px;
            font-weight: bold;
            font-size: 11px;
        }
        .status-inprogress { background-color: #dbeafe; color: #1e40af; }
        .status-blocked { background-color: #fee2e2; color: #991b1b; }
        .status-complete { background-color: #dcfce7; color: #166534; }
        .status-onhold { background-color: #fef3c7; color: #92400e; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Progress Report</h1>
        <p>E-PRONOC System</p>
        <p>Generated on {{ now()->format('d F Y H:i') }}</p>
    </div>

    <div class="section">
        <h2>Project Information</h2>
        <table>
            <tr>
                <td class="label">Project Title:</td>
                <td>{{ $report->project->title }}</td>
            </tr>
            <tr>
                <td class="label">Report Date:</td>
                <td>{{ \Carbon\Carbon::parse($report->report_date)->format('d F Y') }}</td>
            </tr>
            <tr>
                <td class="label">Status:</td>
                <td>
                    <span class="status-badge status-{{ strtolower(str_replace(' ', '', $report->status)) }}">
                        {{ $report->status }}
                    </span>
                </td>
            </tr>
            <tr>
                <td class="label">Progress:</td>
                <td>{{ $report->percentage_complete }}%</td>
            </tr>
            @if($report->project->focus_area)
            <tr>
                <td class="label">Focus Area:</td>
                <td>{{ $report->project->focus_area }}</td>
            </tr>
            @endif
            @if($report->project->focus)
            <tr>
                <td class="label">Focus:</td>
                <td>{{ $report->project->focus }}</td>
            </tr>
            @endif
        </table>
    </div>

    @if($report->progress_description)
    <div class="section">
        <h2>Abstract</h2>
        <p>{{ $report->progress_description }}</p>
    </div>
    @endif

    @if($report->introduction)
    <div class="section">
        <h2>Introduction</h2>
        <p>{{ $report->introduction }}</p>
    </div>
    @endif

    @if($report->project_method)
    <div class="section">
        <h2>Project Method</h2>
        <p>{{ $report->project_method }}</p>
    </div>
    @endif

    @if($report->results)
    <div class="section">
        <h2>Research and Analysis Results</h2>
        <p>{{ $report->results }}</p>
    </div>
    @endif

    @if($report->bibliography)
    <div class="section">
        <h2>Bibliography</h2>
        <p>{{ $report->bibliography }}</p>
    </div>
    @endif

    @if($report->notes)
    <div class="section">
        <h2>Notes & Updates</h2>
        <p>{{ $report->notes }}</p>
    </div>
    @endif

    <div class="footer">
        <p>This is an auto-generated document from E-PRONOC system.<br>
        Document ID: PR-{{ $report->id }}-{{ $report->project->id }}<br>
        © 2025 All Rights Reserved</p>
    </div>
</body>
</html>
