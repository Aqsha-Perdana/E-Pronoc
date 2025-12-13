<x-layouts.app>
<<<<<<< HEAD
    <x-slot name="title">Edit Final Report</x-slot>

    {{-- CSS Quill --}}
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    {{-- SweetAlert2 --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        .ql-toolbar { border-top-left-radius: 0.5rem; border-top-right-radius: 0.5rem; border-color: #e5e7eb !important; background-color: #f9fafb; }
        .ql-container { border-bottom-left-radius: 0.5rem; border-bottom-right-radius: 0.5rem; border-color: #e5e7eb !important; background-color: #ffffff; font-family: inherit; font-size: 1rem; }
        .ql-editor { min-height: 200px; }
        /* Style for error state on Quill container if needed */
        .has-error .ql-container, .has-error .ql-toolbar { border-color: #ef4444 !important; }
    </style>

    <div class="min-h-screen bg-gray-50 py-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Final Report Submission</h1>
                    <p class="mt-2 text-sm text-gray-600">
                        Lengkapi laporan akhir. Data proyek diambil otomatis dari proposal.
                    </p>
                </div>
                <div class="mt-4 sm:mt-0">
                    <a href="{{ route('final') }}" class="inline-flex items-center rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 transition">
                        <svg class="-ml-1 mr-2 h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                        </svg>
                        Back to Reports
                    </a>
                </div>
            </div>

            {{-- Show Global Error Message if any --}}
            @if ($errors->any())
                <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 text-red-700">
                    <p class="font-bold">Terdapat kesalahan pada inputan Anda:</p>
                    <ul class="list-disc list-inside text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('final.store') }}" method="POST" id="reportForm">
                @csrf
                <input type="hidden" name="proposal_id" value="{{ $proposal->id }}">
                
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    
                    {{-- SIDEBAR: PROJECT INFO --}}
                    <div class="lg:col-span-1 space-y-6">
                        <div class="bg-white rounded-xl border border-gray-200 shadow-lg p-5 sticky top-6">
                            <h3 class="text-xs font-extrabold text-red-600 uppercase tracking-widest mb-4 border-b border-gray-100 pb-2">
                                Project Data
                            </h3>
                            
                            <div class="mb-4">
                                <label class="block text-xs font-semibold text-gray-500 mb-1">Project Title</label>
                                <p class="text-sm font-bold text-gray-900 leading-snug">{{ $proposal->title }}</p>
                            </div>

                            <div class="mb-4">
                                <label class="block text-xs font-semibold text-gray-500 mb-1">Focus Area</label>
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-red-50 text-red-700 border border-red-100">
                                    {{ $proposal->focus_area }}
                                </span>
                            </div>

                            <div class="mb-6">
                                <label class="block text-xs font-semibold text-gray-500 mb-1">Target Output</label>
                                <div class="bg-gray-50 p-3 rounded-lg border border-gray-200 text-sm text-gray-800 font-medium">
                                    {{ $proposal->output ?? '-' }}
                                </div>
                            </div>

                            <div class="pt-4 border-t border-gray-100">
                                <button type="button" onclick="confirmSubmit()" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-md text-sm font-bold text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-all duration-200">
                                    Save Final Report
                                </button>
                            </div>
                        </div>
                    </div>

                    {{-- MAIN CONTENT --}}
                    <div class="lg:col-span-2 space-y-6">
                        
                        {{-- 1. ABSTRACT --}}
                        <div class="bg-white shadow-md rounded-xl border border-gray-100 p-6 {{ $errors->has('abstract') ? 'has-error' : '' }}">
                            <div class="mb-2">
                                <label class="block text-base font-semibold text-gray-900">Abstract <span class="text-red-500">*</span></label>
                                <p class="text-sm text-gray-500">Ringkasan penelitian (maks 300 kata, min 50 karakter).</p>
                            </div>
                            <div id="editor-abstract">{!! old('abstract', $finalReport->abstract) !!}</div>
                            <textarea name="abstract" id="input-abstract" class="hidden">{{ old('abstract', $finalReport->abstract) }}</textarea>
                            @error('abstract')
                                <p class="mt-2 text-sm text-red-600 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- 2. INTRODUCTION --}}
                        <div class="bg-white shadow-md rounded-xl border border-gray-100 p-6 {{ $errors->has('introduction') ? 'has-error' : '' }}">
                            <div class="mb-2">
                                <label class="block text-base font-semibold text-gray-900">Introduction <span class="text-red-500">*</span></label>
                                <p class="text-sm text-gray-500">Latar belakang, rumusan masalah, pendekatan, dan novelty (min 50 karakter).</p>
                            </div>
                            <div id="editor-introduction">{!! old('introduction', $finalReport->introduction) !!}</div>
                            <textarea name="introduction" id="input-introduction" class="hidden">{{ old('introduction', $finalReport->introduction) }}</textarea>
                            @error('introduction')
                                <p class="mt-2 text-sm text-red-600 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- 3. PROJECT METHOD --}}
                        <div class="bg-white shadow-md rounded-xl border border-gray-100 p-6 {{ $errors->has('method') ? 'has-error' : '' }}">
                            <div class="mb-2">
                                <label class="block text-base font-semibold text-gray-900">Project Method <span class="text-red-500">*</span></label>
                                <p class="text-sm text-gray-500">Metode yang digunakan dalam penelitian (min 50 karakter).</p>
                            </div>
                            <div id="editor-method">{!! old('method', $finalReport->project_method) !!}</div>
                            <textarea name="method" id="input-method" class="hidden">{{ old('method', $finalReport->project_method) }}</textarea>
                            @error('method')
                                <p class="mt-2 text-sm text-red-600 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- 4. RESULTS --}}
                        <div class="bg-white shadow-md rounded-xl border border-gray-100 p-6 {{ $errors->has('results') ? 'has-error' : '' }}">
                            <div class="mb-2">
                                <label class="block text-base font-semibold text-gray-900">Research & Analysis Results <span class="text-red-500">*</span></label>
                                <p class="text-sm text-gray-500">Hasil penelitian dan analisis (min 50 karakter).</p>
                            </div>
                            <div id="editor-results">{!! old('results', $finalReport->results) !!}</div>
                            <textarea name="results" id="input-results" class="hidden">{{ old('results', $finalReport->results) }}</textarea>
                            @error('results')
                                <p class="mt-2 text-sm text-red-600 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- 5. BIBLIOGRAPHY --}}
                        <div class="bg-white shadow-md rounded-xl border border-gray-100 p-6 {{ $errors->has('bibliography') ? 'has-error' : '' }}">
                            <div class="mb-2">
                                <label class="block text-base font-semibold text-gray-900">Bibliography <span class="text-red-500">*</span></label>
                                <p class="text-sm text-gray-500">Daftar pustaka format Vancouver.</p>
                            </div>
                            <div id="editor-bibliography">{!! old('bibliography', $finalReport->bibliography) !!}</div>
                            <textarea name="bibliography" id="input-bibliography" class="hidden">{{ old('bibliography', $finalReport->bibliography) }}</textarea>
                            @error('bibliography')
                                <p class="mt-2 text-sm text-red-600 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- 6. ADDITIONAL NOTES --}}
                        <div class="bg-white shadow-md rounded-xl border border-gray-100 p-6">
                            <div class="mb-2">
                                <label class="block text-base font-semibold text-gray-900">Additional Notes (Optional)</label>
                            </div>
                            <textarea name="note" rows="3" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm p-3">{{ old('note', $finalReport->note) }}</textarea>
                        </div>

                    </div>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
    <script>
        var toolbarOptions = [
            ['bold', 'italic', 'underline'],
            [{ 'list': 'ordered'}, { 'list': 'bullet' }],
            [{ 'header': [2, 3, false] }],
            ['clean']
        ];

        function initQuill(editorId, inputId) {
            // Cek apakah ada error untuk field ini (untuk visual feedback)
            // Ini hanya basic, lebih baik handle via CSS class 'has-error' yg sudah di-set di blade
            
            var quill = new Quill('#' + editorId, {
                theme: 'snow',
                modules: { toolbar: toolbarOptions },
                placeholder: 'Tulis di sini...'
            });
            
            // Sync data ke hidden textarea setiap kali teks berubah
            quill.on('text-change', function() {
                var html = quill.root.innerHTML;
                document.getElementById(inputId).value = html;
            });

            // Set initial value jika ada old input (penting saat validasi gagal)
            // Quill biasanya membaca dari innerHTML div editor, tapi kita pastikan hidden input juga terisi
            // agar jika user submit tanpa edit, data tetap terkirim
            document.getElementById(inputId).value = quill.root.innerHTML;
        }

        initQuill('editor-abstract', 'input-abstract');
        initQuill('editor-introduction', 'input-introduction');
        initQuill('editor-method', 'input-method');
        initQuill('editor-results', 'input-results');
        initQuill('editor-bibliography', 'input-bibliography');

        // --- Logic Pop-up SweetAlert ---
        function confirmSubmit() {
            Swal.fire({
                title: 'Apakah kamu yakin?',
                text: "Laporan akhir akan disimpan dan status menjadi Submitted.",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#166534', // Hijau tua
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Simpan!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Submit form
                    document.getElementById('reportForm').submit();
                    
                    // Tampilkan loading HANYA SETELAH submit (sebenarnya lebih baik handle di event onsubmit form)
                    // Tapi karena ini non-ajax (full reload), loading akan muncul sampai page berpindah
                    Swal.fire({
                        title: 'Menyimpan...',
                        text: 'Mohon tunggu sebentar',
                        allowOutsideClick: false,
                        didOpen: () => { Swal.showLoading(); }
                    });
                }
            });
        }
    </script>
=======
    <title>New Final Report</title>
    <style>
        body { font-family: Arial, sans-serif; background:#eef2f7; margin:0; padding:0; }
        .page { width:95%; max-width:1200px; margin:24px auto; }
        .layout { display:flex; gap:20px; }
        .left { width:320px; background:white; border-radius:8px; padding:18px; box-shadow:0 6px 16px rgba(0,0,0,0.06); }
        .right { flex:1; }
        .card { background:white; padding:14px; border-radius:6px; margin-bottom:18px; box-shadow:0 1px 3px rgba(0,0,0,0.04); }
        label { display:block; font-size:13px; margin-bottom:6px; color:#333; }
        input[type="text"], textarea { width:100%; padding:10px 12px; border:1px solid #ddd; border-radius:6px; font-size:14px; }
        textarea { min-height:160px; resize:vertical; }
        .submit-btn { display:inline-block; background:#c8102e; color:white; padding:12px 20px; border-radius:6px; text-decoration:none; border:none; cursor:pointer; }
        .hint { background:#f0f0f0; padding:10px; border-radius:6px; color:#666; font-size:13px; margin-bottom:10px; }
        .section-title { font-weight:600; font-size:14px; margin-bottom:8px; }
        .toolbar-placeholder { height:36px; background:#f7f7f9; border:1px solid #e6e6e6; border-radius:4px; margin-bottom:8px; display:flex; align-items:center; padding:6px 8px; color:#888; font-size:13px; }
    </style>

    <div class="topbar">
    </div>

    <h3 style="padding: 20px;">Final Report</h3>

    <div style="padding: 0 20px; margin-bottom: 20px;">
        <a href="{{ route('final') }}" class="btn btn-secondary" style="background:#6c757d; color:#fff; border:none; padding:8px 16px; border-radius:4px; text-decoration:none;">Back to Final Report</a>
    </div>

    <div class="page">
        <form action="/final" method="POST">
            @csrf
            <div class="layout">
                <aside class="left">
                    <div style="margin-bottom:14px;">
                        <label for="title">Project Title</label>
                        <input type="text" name="title" id="title" placeholder="Insert Project Title" required>
                    </div>


                    <div style="margin-bottom:14px;">
                        <label for="focus_area">Focus Area</label>
                        <input type="text" name="focus_area" id="focus_area" placeholder="e.g. Health, Education">
                    </div>

                    <div style="margin-bottom:14px;">
                        <label for="focus">Focus</label>
                        <input type="text" name="focus" id="focus" placeholder="Specific focus/topic">
                    </div>

                    <div style="margin-bottom:14px;">
                        <label for="statement_letter">Statement Letter</label>
                        <input type="text" name="statement_letter" id="statement_letter" placeholder="Statement letter info">
                    </div>


                    <div style="margin-top:8px;">
                        <button type="submit" class="submit-btn">Submit Report</button>
                    </div>
                </aside>

                <main class="right">
                    <div class="card">
                        <div class="section-title">Abstract</div>
                        <div class="hint">Research summary of no more than 300 words containing the urgency, objectives, and main results of the research</div>
                        <div class="toolbar-placeholder">Editor toolbar (rich text editor can be integrated later)</div>
                        <textarea name="abstract" placeholder="Abstract maximum 300 words"></textarea>
                    </div>

                    <div class="card">
                        <div class="section-title">Introduction</div>
                        <div class="toolbar-placeholder">Editor toolbar</div>
                        <textarea name="introduction" placeholder="Introduction maximum 1000 words"></textarea>
                        <div class="hint" style="margin-top:10px;">The introduction section consists of a maximum of 1000 words and includes background and formulation of the problems to be researched, approach, state of the art and novelty, explanation of previous research achievements, roadmap and partners.</div>
                    </div>

                    <div class="card">
                        <div class="section-title">Project Method</div>
                        <div class="toolbar-placeholder">Editor toolbar</div>
                        <textarea name="project_method" placeholder="Project Method maximum 1000 words"></textarea>
                    </div>

                    <div class="card">
                        <div class="section-title">Research and Analysis Results</div>
                        <div class="toolbar-placeholder">Editor toolbar</div>
                        <textarea name="results" placeholder="This section presents the results of the research, along with the necessary analysis."></textarea>
                        <div class="hint" style="margin-top:10px;">Citations are organized and written using a numbering system according to the order of citation, following the Vancouver format.</div>
                    </div>

                    <div class="card">
                        <div class="section-title">Bibliography</div>
                        <div class="toolbar-placeholder">Editor toolbar</div>
                        <textarea name="bibliography" placeholder="List references here"></textarea>
                    </div>
                </main>
            </div>
        </form>
    </div>
>>>>>>> e68c7900a429ca0a02a86e7a4345c04cba74b760
</x-layouts.app>