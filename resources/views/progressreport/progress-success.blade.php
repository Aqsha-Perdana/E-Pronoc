<x-layouts.app>
<<<<<<< HEAD
    <x-slot name="title">Laporan Berhasil Dibuat</x-slot>

    <div class="min-h-screen bg-gray-50 flex flex-col">
        
        {{-- 1. Modern Header / Toolbar --}}
        <div class="bg-white border-b border-gray-200 px-6 py-4 flex flex-col sm:flex-row justify-between items-center shadow-sm z-10 gap-4">
            
            {{-- Status & Title --}}
            <div class="flex items-center gap-4">
                <div class="flex-shrink-0 bg-green-100 p-2.5 rounded-full">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                <div>
                    <h1 class="text-xl font-bold text-gray-900 tracking-tight">Laporan Berhasil Dibuat</h1>
                    <p class="text-sm text-gray-500">Dokumen PDF telah digenerate dan siap untuk ditinjau.</p>
                </div>
            </div>

            {{-- Action Button (Back) --}}
            <div>
                <a href="{{ route('progress.index') }}" 
                   class="inline-flex items-center gap-2 px-5 py-2.5 bg-white border border-gray-300 rounded-xl text-sm font-semibold text-gray-700 hover:bg-gray-50 hover:text-gray-900 hover:border-gray-400 transition-all shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Kembali ke Daftar
                </a>
            </div>
        </div>

        {{-- 2. PDF Viewer Area --}}
        <div class="flex-1 p-4 sm:p-6 lg:p-8 h-full">
            <div class="w-full h-full max-w-5xl mx-auto bg-gray-200 rounded-2xl shadow-lg border border-gray-300 overflow-hidden relative">
                
                {{-- Loading Placeholder (Akan tertutup jika PDF load cepat) --}}
                <div class="absolute inset-0 flex items-center justify-center text-gray-400 z-0">
                    <div class="flex flex-col items-center animate-pulse">
                        <svg class="w-12 h-12 mb-3 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        <span>Memuat Dokumen...</span>
                    </div>
                </div>

                {{-- Iframe PDF --}}
                <iframe 
                    src="data:application/pdf;base64,{{ $pdfBase64 }}" 
                    class="relative z-10 w-full h-[80vh] border-none bg-white"
                    title="PDF Viewer">
                </iframe>
            </div>
        </div>

    </div>
</x-layouts.app>
=======
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

>>>>>>> e68c7900a429ca0a02a86e7a4345c04cba74b760
