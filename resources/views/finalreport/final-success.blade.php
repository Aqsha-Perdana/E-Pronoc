<x-layouts.app>
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
    </div>
</x-layouts.app>