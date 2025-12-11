<x-layouts.app>
    <title>Progress Report</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background: #eef2f7;
        }
        .lang-select {
            padding: 8px 12px;
            border-radius: 6px;
            border: 1px solid #ccc;
            background: white;
        }
        .container {
            margin: 40px auto;
            width: 85%;
            background: white;
            padding: 30px;
            border-radius: 20px;
        }
        h2 {
            margin-bottom: 25px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table th, table td {
            border: 1px solid #ccc;
            padding: 10px;
        }
        table th {
            background: #eaeaea;
        }
        .status-inprogress { color: #4169e1; font-weight: bold; }
        .status-blocked { color: #ff3b3b; font-weight: bold; }
        .status-complete { color: #2ecc71; font-weight: bold; }
        .status-onhold { color: #e9a800; font-weight: bold; }
        .btn-new {
            background: #d62828;
            color: white;
            padding: 10px 22px;
            border-radius: 6px;
            border: none;
            cursor: pointer;
            font-size: 14px;
        }
        .action-btn {
            background: #2ecc71;
            border: none;
            padding: 6px 10px;
            border-radius: 5px;
            cursor: pointer;
            color: white;
        }
        .pagination {
            text-align: center;
            margin-top: 20px;
        }
        .pagination button {
            margin: 0 5px;
            padding: 6px 12px;
            border: 1px solid #ccc;
            background: white;
            cursor: pointer;
            border-radius: 5px;
        }
</style>


    <div class="topbar">
    </div>

    <h3 style="padding: 20px;">Progress Report</h3>

    <div class="container">
        <h2>All Project Reports</h2>

        <div style="display:flex; justify-content:flex-end; align-items:center; gap:6px; margin-bottom:10px;">
            Show
            <input type="number" value="10" style="width:60px; padding:4px;">
            entries
        </div>
        
        <table>
            <thead>
                <tr>
                    <th>Project Title</th>
                    <th>Focus Area</th>
                    <th>Report Date</th>
                    <th>Progress</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($progressReports as $report)
                    @php
                        $statusClass = 'status-' . strtolower(str_replace(' ', '', $report->status));
                    @endphp
                    <tr>
                        <td>{{ $report->project->title ?? 'N/A' }}</td>
                        <td>{{ $report->project->focus_area ?? '-' }}</td>
                        <td>{{ \Carbon\Carbon::parse($report->report_date)->format('d/m/Y') }}</td>
                        <td>{{ $report->percentage_complete }}%</td>
                        <td class="{{ $statusClass }}">{{ $report->status }}</td>
                        <td>
                            <a href="{{ route('progress.view', $report->id) }}" class="action-btn" style="text-decoration:none; display:inline-block;">PDF</a>
                            <form action="{{ route('progress.destroy', $report->id) }}" method="POST" style="display:inline-block; margin-left:8px;" onsubmit="return confirm('Are you sure you want to delete this report?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="action-btn" style="background:#e3342f;">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="text-align:center; padding:20px;">No progress reports found</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <a href="/progress/new" class="btn-new" role="button">New Report</a>

        <div class="pagination">
            <p>Show 1 to 5 of 5 entries</p>
            <button>Previous</button>
            <button>1</button>
            <button>Next</button>
        </div>
    </div>


</x-layouts.app>
