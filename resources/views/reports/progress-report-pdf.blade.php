<!DOCTYPE html>
<html>
<head>
<<<<<<< HEAD
    <meta charset="utf-8">
    <title>Progress Report</title>
    <style>
        body { font-family: sans-serif; color: #333; line-height: 1.6; }
        .header { text-align: center; border-bottom: 2px solid #ddd; padding-bottom: 20px; margin-bottom: 30px; }
        .header h1 { margin: 0; color: #c8102e; }
        .header p { margin: 5px 0; color: #666; font-size: 14px; }
        
        .meta-table { width: 100%; border-collapse: collapse; margin-bottom: 30px; }
        .meta-table td { padding: 8px 0; vertical-align: top; }
        .meta-label { width: 140px; font-weight: bold; color: #555; }
        .meta-value { font-weight: normal; }

        .section { margin-bottom: 25px; }
        .section-title { font-size: 16px; font-weight: bold; color: #c8102e; border-bottom: 1px solid #eee; padding-bottom: 5px; margin-bottom: 10px; text-transform: uppercase; }
        .content { font-size: 14px; text-align: justify; }
        
        .badge { display: inline-block; padding: 4px 8px; border-radius: 4px; font-size: 12px; font-weight: bold; background: #eee; }
        .badge-complete { background: #dcfce7; color: #166534; }
    </style>
</head>
<body>

    <div class="header">
        <h1>Progress Report</h1>
        <p>E-PRONOC System • Generated on {{ now()->format('d M Y') }}</p>
    </div>

    <table class="meta-table">
        <tr>
            <td class="meta-label">Project Title</td>
            <td class="meta-value">: {{ $report->proposal->title }}</td>
        </tr>
        <tr>
            <td class="meta-label">Focus Area</td>
            <td class="meta-value">: {{ $report->proposal->focus_area }}</td>
        </tr>
        <tr>
            <td class="meta-label">Specific Focus</td>
            <td class="meta-value">: {{ $report->proposal->output ?? '-' }}</td>
        </tr>
        <tr>
            <td class="meta-label">Report Date</td>
            <td class="meta-value">: {{ \Carbon\Carbon::parse($report->report_date)->format('d F Y') }}</td>
        </tr>
        <tr>
            <td class="meta-label">Completion</td>
            <td class="meta-value">: 
                @if($report->percentage_complete == 100)
                    <span class="badge badge-complete">100% (Complete)</span>
                @else
                    {{ $report->percentage_complete }}%
                @endif
            </td>
        </tr>
    </table>

    @if($report->activities)
    <div class="section">
        <div class="section-title">Activities Conducted</div>
        <div class="content">{!! $report->activities !!}</div>
=======
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
>>>>>>> e68c7900a429ca0a02a86e7a4345c04cba74b760
    </div>
    @endif

    @if($report->results)
    <div class="section">
<<<<<<< HEAD
        <div class="section-title">Results Achieved</div>
        <div class="content">{!! $report->results !!}</div>
    </div>
    @endif

    @if($report->obstacles)
    <div class="section">
        <div class="section-title">Obstacles & Solutions</div>
        <div class="content">{!! $report->obstacles !!}</div>
    </div>
    @endif

    @if($report->next_steps)
    <div class="section">
        <div class="section-title">Next Steps</div>
        <div class="content">{!! $report->next_steps !!}</div>
=======
        <h2>Research and Analysis Results</h2>
        <p>{{ $report->results }}</p>
    </div>
    @endif

    @if($report->bibliography)
    <div class="section">
        <h2>Bibliography</h2>
        <p>{{ $report->bibliography }}</p>
>>>>>>> e68c7900a429ca0a02a86e7a4345c04cba74b760
    </div>
    @endif

    @if($report->notes)
    <div class="section">
<<<<<<< HEAD
        <div class="section-title">Additional Notes</div>
        <div class="content">{{ $report->notes }}</div>
    </div>
    @endif

</body>
</html>
=======
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
>>>>>>> e68c7900a429ca0a02a86e7a4345c04cba74b760
