<x-layouts.app>
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
</x-layouts.app>