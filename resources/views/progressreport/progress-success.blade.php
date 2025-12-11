<x-layouts.app>
    <title>Progress Report - Success</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: Arial, sans-serif;
            background: #eef2f7;
        }
        .topbar {
            width: 100%;
            background: white;
            padding: 35px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        .topbar button {
            background: none;
            border: none;
            font-size: 20px;
            cursor: pointer;
        }
        .container {
            display: flex;
            height: calc(100vh - 80px);
        }
        .pdf-viewer {
            flex: 1;
            display: flex;
            flex-direction: column;
        }
        iframe {
            flex: 1;
            border: none;
        }
        .sidebar {
            position: fixed;
            left: 0;
            top: 0;
            height: 100%;
            width: 250px;
            background-color: #c8102e;
            color: white;
            display: flex;
            flex-direction: column;
            padding: 20px 25px;
            transform: translateX(-100%);
            transition: transform 0.3s ease;
            z-index: 1200;
            box-shadow: 3px 0 8px rgba(0,0,0,0.2);
        }
        .sidebar.open {
            transform: translateX(0);
        }
        .overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.4);
            z-index: 900;
            cursor: pointer;
        }
        .overlay.show {
            display: block;
        }
        .close-btn {
            position: absolute;
            right: 12px;
            top: 12px;
            background: transparent;
            border: none;
            color: white;
            font-size: 26px;
            cursor: pointer;
        }
        .sidebar-header {
            display: flex;
            align-items: center;
            margin-bottom: 40px;
        }
        .sidebar-header svg {
            width: 22px;
            height: 22px;
        }
        .sidebar-header h2 {
            font-size: 20px;
            font-weight: 600;
            margin-left: 8px;
        }
        .sidebar nav a {
            display: block;
            color: white;
            margin: 18px 0;
            font-size: 16px;
            text-decoration: none;
        }
        .sidebar nav a:hover {
            text-decoration: underline;
        }
        .sidebar .logout {
            margin-top: auto;
            padding-top: 20px;
            border-top: 1px solid rgba(255,255,255,0.3);
            font-size: 16px;
            text-decoration: none;
            color: white;
        }
        .action-panel {
            background: white;
            padding: 20px;
            border-top: 1px solid #ddd;
            display: flex;
            gap: 12px;
            justify-content: center;
        }
        .btn {
            padding: 12px 24px;
            border-radius: 6px;
            border: none;
            cursor: pointer;
            font-size: 14px;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }
        .btn-download {
            background: #2ecc71;
            color: white;
        }
        .btn-download:hover {
            background: #27ae60;
        }
        .btn-back {
            background: #f3f4f6;
            color: #111;
            border: 1px solid #ddd;
        }
        .btn-back:hover {
            background: #e5e7eb;
        }
        .success-message {
            background: #dcfce7;
            border-left: 4px solid #2ecc71;
            padding: 15px;
            margin-bottom: 10px;
            border-radius: 4px;
            color: #166534;
        }
    </style>
</head>
<body>
    <div class="topbar">
    </div>

    <div class="container">
        <div class="pdf-viewer">
            <div class="success-message">
                ✓ Laporan berhasil dibuat! PDF siap untuk diunduh atau dilihat di bawah.
            </div>
            <iframe src="data:application/pdf;base64,{{ $pdfBase64 }}" type="application/pdf"></iframe>
            <div class="action-panel">
                <a href="{{ route('progress.download', $report->id) }}" class="btn btn-download">
                    ⬇ Download PDF
                </a>
                <a href="/progress" class="btn btn-back">
                    ← Back to Progress
                </a>
            </div>
        </div>
    </div>
</x-layouts.app>

