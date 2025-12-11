<x-layouts.app>
    <title>Final Report</title>
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
      /* shift content right */
  .content-title, h1 { margin-left:60px; }
</style>
</head>
<body>

    <div class="topbar">
    </div>

    <h3 style="padding: 20px;">Final Report</h3>

    <div class="container">
        <h2>All Final Reports</h2>

        <div style="display:flex; justify-content:flex-end; align-items:center; gap:6px; margin-bottom:10px;">
            Show
            <input type="number" value="10" style="width:60px; padding:4px;">
            entries
        </div>

        <table>
            <thead>
                <tr>
                    <th>Project Title</th>
                    <th>Date</th>
                    <th>Focus Area</th>
                    <th>Focus</th>
                    <th>Statement Letter</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @if(isset($finalReports) && $finalReports->count())
                    @foreach($finalReports as $final)
                        <tr>
                            <td>{{ $final->title ?? 'N/A' }}</td>
                            <td>{{ $final->date ? \Carbon\Carbon::parse($final->date)->format('d/m/Y') : '-' }}</td>
                            <td>{{ $final->focus_area ?? '-' }}</td>
                            <td>{{ $final->focus ?? '-' }}</td>
                            <td>{{ $final->statement_letter ?? '-' }}</td>
                            <td>
                                <a href="{{ route('final.view', $final->id) }}" class="action-btn" style="text-decoration:none; display:inline-block;">PDF</a>
                                <form action="{{ route('final.destroy', $final->id) }}" method="POST" style="display:inline-block; margin-left:8px;" onsubmit="return confirm('Are you sure you want to delete this final report?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="action-btn" style="background:#e3342f;">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="5" style="text-align:center; padding:20px;">No final reports found</td>
                    </tr>
                @endif
            </tbody>
        </table>

        <a href="/final/new" class="btn-new" role="button">New Report</a>

        <div class="pagination">
            <p>Show 1 to 5 of 5 entries</p>
            <button>Previous</button>
            <button>1</button>
            <button>Next</button>
        </div>
    </div>


</x-layouts.app>
