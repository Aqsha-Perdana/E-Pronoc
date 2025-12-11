<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>New Progress Report</title>
    <style>
        body { font-family: Arial, sans-serif; background: #eef2f7; margin:0; padding:0 }
        .topbar { width:100%; background:white; padding:35px; box-shadow:0 2px 5px rgba(0,0,0,0.1); }
        .container { max-width:1100px; margin:30px auto; background:white; padding:30px; border-radius:12px; }
        .left-panel { width:300px; float:left; margin-right:30px; }
        .left-panel .card { background:#fff; border:1px solid #eee; padding:20px; border-radius:10px; }
        .field { margin-bottom:16px; }
        label { display:block; margin-bottom:6px; font-weight:600; }
        input[type=text], textarea, select { width:100%; padding:10px; border:1px solid #ddd; border-radius:6px; }
        textarea { min-height:120px; }
        .submit-btn { background:#d62828; color:white; padding:10px 16px; border-radius:8px; border:none; cursor:pointer; }
        .right { overflow:hidden; }
        .section { margin-bottom:26px; }
        .section h4 { margin:0 0 8px 0; }
    </style>
</head>
<body>
    <div class="topbar">
    </div>

    <div class="container">
        <div class="container-header" style="display:flex; align-items:center; gap:20px; margin-bottom:18px;">
            <a href="/progress" class="btn-back" style="padding:8px 12px;background:#f3f4f6;border:1px solid #ddd;border-radius:6px;color:#111;text-decoration:none;">← Back to Progress</a>
            <h2 style="margin:0">New Progress Report</h2>
        </div>

        <form method="POST" action="/progress">
            @csrf
            <div class="left-panel">
                <div class="card">
                    <div class="field">
                        <label>Project Title</label>
                        <input type="text" name="title" placeholder="Insert Project Title" required />
                    </div>

                    

                    <div class="field">
                        <label>Focus Area</label>
                        <input type="text" name="focus_area" placeholder="e.g. Health, Education" />
                    </div>

                    <div class="field">
                        <label>Focus</label>
                        <input type="text" name="focus" placeholder="Specific focus/topic" />
                    </div>

                    <div class="field">
                        <label>Progress</label>
                        <input type="range" name="percentage" min="0" max="100" value="0" oninput="this.nextElementSibling.value = this.value"> 
                        <output>0</output>%
                    </div>

                    <div class="field">
                        <label>Status</label>
                        <select name="status">
                            <option>In Progress</option>
                            <option>Blocked</option>
                            <option>Complete</option>
                            <option>On Hold</option>
                        </select>
                    </div>

                    <div class="field">
                        <label>Update Note</label>
                        <textarea name="notes" placeholder="Key accomplishments, next steps, and any blockers."></textarea>
                    </div>

                    <button type="submit" class="submit-btn">Submit Report</button>
                </div>
            </div>

            <div class="right">
                <div class="section">
                    <h4>Abstract</h4>
                    <textarea name="abstract" placeholder="Abstract maximum 300 words"></textarea>
                </div>

                <div class="section">
                    <h4>Introduction</h4>
                    <textarea name="introduction" placeholder="Introduction maximum 1000 words"></textarea>
                </div>

                <div class="section">
                    <h4>Project Method</h4>
                    <textarea name="project_method" placeholder="Project Method maximum 1000 words"></textarea>
                </div>

                <div class="section">
                    <h4>Research and Analysis Results</h4>
                    <textarea name="results" placeholder="This section presents the results of the research, along with the necessary analysis."></textarea>
                </div>

                <div class="section">
                    <h4>Bibliography</h4>
                    <textarea name="bibliography" placeholder="List your references"></textarea>
                </div>
            </div>
        </form>

        <div style="clear:both"></div>
    </div>

    @include('components.sidebar')
</body>
</html>