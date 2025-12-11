<!DOCTYPE html>
<html>
<head>
    <title>Proposal - {{ $proposal->registration_code }}</title>
    <style>
        /* Setup Font & Kertas */
        @page { margin: 2.5cm 2.5cm; } /* Margin kertas A4 standar */
        body { 
            font-family: sans-serif; 
            font-size: 11pt; 
            line-height: 1.5; 
            color: #333;
        }

        /* Header Styles */
        .header { text-align: center; margin-bottom: 25px; border-bottom: 2px solid #333; padding-bottom: 10px; }
        .title { font-size: 16pt; font-weight: bold; text-transform: uppercase; }
        
        /* Table Styles */
        table { width: 100%; border-collapse: collapse; margin-bottom: 15px; }
        th, td { border: 1px solid #ccc; padding: 6px; text-align: left; vertical-align: top; }
        th { background-color: #f4f4f4; font-weight: bold; }

        /* Section Header Styles */
        .section-header { 
            background-color: #eee; 
            padding: 8px; 
            font-weight: bold; 
            margin-top: 20px; 
            margin-bottom: 10px; 
            border-left: 5px solid #d32f2f; 
            font-size: 12pt;
        }

        /* --- PERBAIKAN UTAMA DISINI (CONTENT WRAPPING) --- */
        .content-body {
            width: 100%;
            text-align: justify; /* Rata kanan-kiri */
            margin-bottom: 20px;
        }

        /* Memaksa text panjang (seperti link atau kata acak) untuk turun ke bawah */
        .content-body p, 
        .content-body div, 
        .content-body span {
            word-wrap: break-word;       /* Standar CSS */
            overflow-wrap: break-word;   /* Standar CSS Modern */
            word-break: break-all;       /* Memaksa potong kata jika terlalu panjang (PENTING untuk data dummy) */
            max-width: 100%;
        }

        /* Mencegah gambar keluar dari batas kertas */
        .content-body img {
            max-width: 100%;
            height: auto;
        }

        /* Utility */
        .page-break { page-break-after: always; }
        .text-right { text-align: right; }
        .font-bold { font-weight: bold; }
    </style>
</head>
<body>

    {{-- HEADER (Halaman 1) --}}
    <div class="header">
        <div class="title">PROPOSAL PENELITIAN</div>
        <div>{{ $proposal->registration_code }}</div>
    </div>

    {{-- INFO DASAR --}}
    <table style="border: none;">
        <tr style="border: none;">
            <td style="border: none; width: 140px; font-weight: bold;">Judul Proposal</td>
            <td style="border: none;">: {{ $proposal->title }}</td>
        </tr>
        <tr style="border: none;">
            <td style="border: none; font-weight: bold;">Fokus Area</td>
            <td style="border: none;">: {{ $proposal->focus_area }}</td>
        </tr>
        <tr style="border: none;">
            <td style="border: none; font-weight: bold;">Tanggal</td>
            <td style="border: none;">: {{ \Carbon\Carbon::parse($proposal->date)->format('d F Y') }}</td>
        </tr>
    </table>

    <div class="section-header">A. TIM PENELITI</div>
    <table>
        <thead>
            <tr>
                <th style="width: 5%;">No</th>
                <th style="width: 40%;">Nama</th>
                <th style="width: 30%;">NIP</th>
                <th style="width: 25%;">Peran</th>
            </tr>
        </thead>
        <tbody>
            @foreach($proposal->members as $index => $member)
            <tr>
                <td style="text-align: center;">{{ $index + 1 }}</td>
                <td>{{ $member->name }}</td>
                <td>{{ $member->nip }}</td>
                <td>{{ $member->pivot->role }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="section-header">B. RENCANA ANGGARAN</div>
    <table>
        <tr>
            <td>Biaya Personil</td>
            <td class="text-right">Rp {{ number_format($proposal->budget->direct_personnel_cost ?? 0, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td>Biaya Non-Personil</td>
            <td class="text-right">Rp {{ number_format($proposal->budget->non_personnel_cost ?? 0, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td>Biaya Tidak Langsung</td>
            <td class="text-right">Rp {{ number_format($proposal->budget->indirect_cost ?? 0, 0, ',', '.') }}</td>
        </tr>
        <tr style="background-color: #f9f9f9;">
            <td class="font-bold">TOTAL</td>
            <td class="font-bold text-right">
                Rp {{ number_format(
                    ($proposal->budget->direct_personnel_cost ?? 0) + 
                    ($proposal->budget->non_personnel_cost ?? 0) + 
                    ($proposal->budget->indirect_cost ?? 0), 
                0, ',', '.') }}
            </td>
        </tr>
    </table>

    <div class="page-break"></div>

    {{-- ISI CONTENT DENGAN WRAPPING FIX --}}
    
    <div class="section-header">C. ABSTRAK</div>
    <div class="content-body">
        {!! $proposal->abstract !!}
    </div>

    <div class="section-header">D. PENDAHULUAN</div>
    <div class="content-body">
        {!! $proposal->introduction !!}
    </div>

    <div class="section-header">E. METODE PELAKSANAAN</div>
    <div class="content-body">
        {!! $proposal->project_method !!}
    </div>

    <div class="section-header">F. DAFTAR PUSTAKA</div>
    <div class="content-body">
        {!! $proposal->bibliography !!}
    </div>

</body>
</html>