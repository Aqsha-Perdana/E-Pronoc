<x-layouts.app>
<<<<<<< HEAD
    <x-slot name="title">Final Report Generated</x-slot>

    <div class="min-h-screen bg-gray-50 flex flex-col">
        
        {{-- 1. Header Toolbar --}}
        <div class="bg-white border-b border-gray-200 px-6 py-4 flex flex-col sm:flex-row justify-between items-center shadow-sm z-10 gap-4">
            
            {{-- Status Message --}}
            <div class="flex items-center gap-4">
                <div class="flex-shrink-0 bg-green-100 p-2.5 rounded-full">
                    {{-- Icon Checkmark Hijau --}}
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                <div>
                    <h1 class="text-xl font-bold text-gray-900 tracking-tight">Laporan Akhir Berhasil Dibuat</h1>
                    <p class="text-sm text-gray-500">Dokumen PDF telah digenerate. Silakan tinjau di bawah ini.</p>
                </div>
            </div>

            {{-- Action Button (Back Only) --}}
            <div>
                <a href="{{ route('final') }}" 
                   class="inline-flex items-center gap-2 px-5 py-2.5 bg-white border border-gray-300 rounded-xl text-sm font-semibold text-gray-700 hover:bg-gray-50 hover:text-gray-900 hover:border-gray-400 transition-all shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Kembali ke Daftar
                </a>
            </div>
        </div>

        {{-- 2. PDF Viewer Container --}}
        <div class="flex-1 p-4 sm:p-6 lg:p-8 h-full">
            <div class="w-full h-full max-w-6xl mx-auto bg-gray-200 rounded-2xl shadow-lg border border-gray-300 overflow-hidden relative">
                
                {{-- Loading Indicator (Placeholder) --}}
                <div class="absolute inset-0 flex items-center justify-center text-gray-400 z-0">
                    <div class="flex flex-col items-center animate-pulse">
                        <svg class="w-12 h-12 mb-3 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <span>Memuat Preview PDF...</span>
                    </div>
                </div>

                {{-- Iframe PDF --}}
                <iframe 
                    src="data:application/pdf;base64,{{ $pdfBase64 }}" 
                    class="relative z-10 w-full h-[85vh] border-none bg-white"
                    title="Final Report PDF Viewer">
                </iframe>
                
            </div>
        </div>

=======
    <title>Final Report Generated</title>
    <style>
        body{font-family:Arial, sans-serif;margin:0;background:#f6f7f9}
        .container{max-width:1100px;margin:28px auto;padding:0 18px}
        .actions{display:flex;gap:12px;align-items:center;margin:12px 0}
        .btn{background:#c8102e;color:#fff;padding:10px 14px;border-radius:6px;text-decoration:none}
        .btn-secondary{background:#eee;color:#333;padding:10px 14px;border-radius:6px;text-decoration:none}
        .viewer{border:1px solid #ddd;border-radius:6px;overflow:hidden}
        iframe{width:100%;height:800px;border:0}
    </style>

    <div class="top">Final Report</div>
    <div class="container">
        <div style="margin-top:8px; font-weight:600">Your final report was generated</div>
        <div class="actions">
            <a href="{{ route('final.download', $final->id) }}" class="btn">Download PDF</a>
            <a href="/final" class="btn-secondary">Back to Final Reports</a>
        </div>

        <div class="viewer">
            <iframe src="data:application/pdf;base64,{{ $pdfBase64 }}"></iframe>
        </div>
>>>>>>> e68c7900a429ca0a02a86e7a4345c04cba74b760
    </div>
</x-layouts.app>