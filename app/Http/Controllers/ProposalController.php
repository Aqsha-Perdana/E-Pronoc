<?php

namespace App\Http\Controllers;

use App\Models\Proposal;
<<<<<<< HEAD
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use DOMDocument;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth; // PENTING: Untuk filter berdasarkan User Login

class ProposalController 
{
    /**
     * Menampilkan daftar proposal milik user yang sedang login.
     */
    public function index()
    {
        // 1. Ambil ID User yang sedang login
        $userId = Auth::id();

        // 2. Query Proposal dengan filter user via relasi teamMembers
        $proposals = Proposal::with('budget')
            ->whereHas('teamMembers', function($query) use ($userId) {
                $query->where('user_id', $userId);
            })
            ->latest()
            ->paginate(10);

        return view('proposalutama.index', compact('proposals'));
    }

    /**
     * Menampilkan detail proposal.
     * Hanya bisa diakses jika user adalah anggota tim proposal tersebut.
     */
    public function show($id)
    {
        $proposal = Proposal::with(['teamMembers.member', 'budget', 'outputIndicators'])
            ->whereHas('teamMembers', function($q) {
                $q->where('user_id', Auth::id());
            })
            ->findOrFail($id);

        return view('proposals.show', compact('proposal'));
    }

    /**
     * Generate dan Download PDF Proposal.
     */
    public function download($id)
    {
        // 1. Ambil Data (Filter User & Eager Load Relasi)
        $proposal = Proposal::with(['teamMembers.member', 'budget', 'outputIndicators'])
                            ->whereHas('teamMembers', function($q) {
                                $q->where('user_id', Auth::id());
                            })
                            ->findOrFail($id);
                            
        // 2. Proses HTML: Ubah semua gambar (Lokal & Online) menjadi Base64
        // Ini wajib agar gambar tampil di DomPDF
=======
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProposalController extends Controller
{
    public function list()
    {
        $proposals = Proposal::all();
        return view('proposalsel.list', compact('proposals'))->with('page', 'list');
    }

    public function review()
    {
        // Ambil semua proposal yang perlu direview
        $proposals = Proposal::where('status', 'SUBMITTED')->get();
        return view('proposalsel.review', compact('proposals'));
    }

    public function accept($id)
    {
        try {
            Log::info("Accept proposal request received", ['id' => $id]);
            
            // Cari proposal berdasarkan ID
            $proposal = Proposal::findOrFail($id);
            
            Log::info("Proposal found", [
                'id' => $proposal->id,
                'current_status' => $proposal->status
            ]);
            
            // Validasi status - hanya proposal dengan status SUBMITTED yang bisa di-accept
            if ($proposal->status !== 'SUBMITTED') {
                Log::warning("Invalid status for approval", [
                    'proposal_id' => $id,
                    'current_status' => $proposal->status
                ]);
                
                return response()->json([
                    'success' => false,
                    'message' => 'Proposal ini tidak dapat disetujui karena statusnya bukan SUBMITTED. Status saat ini: ' . $proposal->status
                ], 400);
            }
            
            // Update status menjadi ACCEPTED
            $proposal->status = 'ACCEPTED';
            $proposal->reviewed_at = now();
            $proposal->save();
            
            Log::info("Proposal accepted successfully", [
                'proposal_id' => $proposal->id,
                'new_status' => $proposal->status
            ]);
            
            return response()->json([
                'success' => true,
                'message' => 'Proposal berhasil disetujui',
                'data' => [
                    'id' => $proposal->id,
                    'status' => $proposal->status,
                    'reviewed_at' => $proposal->reviewed_at
                ]
            ]);
            
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            Log::error("Proposal not found", ['id' => $id]);
            
            return response()->json([
                'success' => false,
                'message' => 'Proposal tidak ditemukan'
            ], 404);
            
        } catch (\Exception $e) {
            Log::error("Error accepting proposal", [
                'id' => $id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }
    
    public function reject($id)
    {
        try {
            $proposal = Proposal::findOrFail($id);
            
            if ($proposal->status !== 'SUBMITTED') {
                return response()->json([
                    'success' => false,
                    'message' => 'Proposal ini tidak dapat ditolak karena statusnya bukan SUBMITTED'
                ], 400);
            }
            
            $proposal->status = 'REJECTED';
            $proposal->reviewed_at = now();
            $proposal->save();
            
            return response()->json([
                'success' => true,
                'message' => 'Proposal berhasil ditolak',
                'data' => [
                    'id' => $proposal->id,
                    'status' => $proposal->status
                ]
            ]);
            
        } catch (\Exception $e) {
            Log::error("Error rejecting proposal: " . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    //peneliti
    public function index()
{
    $proposals = Proposal::with('budgets')
        ->where('user_id', auth()->id())   // 🔥 ini yang memisahkan data antar peneliti
        ->latest()
        ->paginate(10);

    return view('index', compact('proposals'));
}
public function download($id)
    {
        // 1. Ambil Data
        $proposal = Proposal::with(['members', 'budget', 'outputIndicators'])->findOrFail($id);

        // 2. Proses HTML: Ubah semua gambar (Lokal & Online) menjadi Base64
        // Agar PDF tidak perlu download ulang saat render.
>>>>>>> e68c7900a429ca0a02a86e7a4345c04cba74b760
        $proposal->abstract = $this->processImages($proposal->abstract);
        $proposal->introduction = $this->processImages($proposal->introduction);
        $proposal->project_method = $this->processImages($proposal->project_method);
        $proposal->bibliography = $this->processImages($proposal->bibliography);

<<<<<<< HEAD
        // 3. Load View PDF
        $pdf = Pdf::loadView('pdf.proposal_document', compact('proposal'));
        
        // 4. Konfigurasi PDF
=======
        // 3. Load View
        $pdf = Pdf::loadView('pdf.proposal_document', compact('proposal'));
        
        // Aktifkan remote agar aman, meski kita sudah convert ke Base64
>>>>>>> e68c7900a429ca0a02a86e7a4345c04cba74b760
        $pdf->setOptions([
            'isRemoteEnabled' => true, 
            'isHtml5ParserEnabled' => true
        ]);
<<<<<<< HEAD
        $pdf->setPaper('A4', 'portrait');

        // 5. Nama File Aman (ganti slash dengan dash)
=======
        
        $pdf->setPaper('A4', 'portrait');

>>>>>>> e68c7900a429ca0a02a86e7a4345c04cba74b760
        $safeFileName = str_replace('/', '-', $proposal->registration_code);

        return $pdf->stream('Proposal-' . $safeFileName . '.pdf');
    }

    /**
<<<<<<< HEAD
     * Helper Private: Mengubah src gambar (lokal/url) menjadi Base64 string.
     * Solusi ampuh untuk masalah gambar broken di DomPDF.
     */
    private function processImages($htmlContent)
    {
        // Jika konten kosong atau tidak ada gambar, kembalikan langsung
=======
     * Fungsi SUPER: Mengubah baik path lokal maupun URL https menjadi Base64
     * Ini menjamin gambar muncul 100% di PDF.
     */
    private function processImages($htmlContent)
    {
>>>>>>> e68c7900a429ca0a02a86e7a4345c04cba74b760
        if (empty($htmlContent) || strpos($htmlContent, '<img') === false) {
            return $htmlContent;
        }

        $dom = new DOMDocument();
<<<<<<< HEAD
        // Suppress error parsing HTML5 tags
        libxml_use_internal_errors(true);
        
        // Load HTML dengan encoding UTF-8
        $dom->loadHTML(
            mb_convert_encoding('<div>' . $htmlContent . '</div>', 'HTML-ENTITIES', 'UTF-8'), 
            LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD
        );
=======
        libxml_use_internal_errors(true);
        // Load HTML dengan encoding UTF-8
        $dom->loadHTML(mb_convert_encoding('<div>' . $htmlContent . '</div>', 'HTML-ENTITIES', 'UTF-8'), LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
>>>>>>> e68c7900a429ca0a02a86e7a4345c04cba74b760
        libxml_clear_errors();

        $images = $dom->getElementsByTagName('img');

        foreach ($images as $img) {
            $src = $img->getAttribute('src');
            $imageData = null;
            $type = 'jpg'; // Default fallback

            // SKENARIO 1: Gambar Lokal (/storage/...)
            if (strpos($src, '/') === 0) {
                $path = public_path($src);
                if (file_exists($path)) {
                    $imageData = file_get_contents($path);
                    $type = pathinfo($path, PATHINFO_EXTENSION);
                }
            } 
            // SKENARIO 2: Gambar Online (https://...)
            elseif (filter_var($src, FILTER_VALIDATE_URL)) {
                try {
<<<<<<< HEAD
                    // Gunakan HTTP Client Laravel (ignore SSL verify untuk local dev)
=======
                    // Download gambar menggunakan HTTP Client Laravel
                    // verify=false untuk menghindari error SSL di localhost
>>>>>>> e68c7900a429ca0a02a86e7a4345c04cba74b760
                    $response = Http::withoutVerifying()->get($src);
                    
                    if ($response->successful()) {
                        $imageData = $response->body();
<<<<<<< HEAD
                        $contentType = $response->header('Content-Type'); 
                        if($contentType) {
                            // Ambil ekstensi dari header (contoh: image/png -> png)
=======
                        // Coba tebak ekstensi dari header
                        $contentType = $response->header('Content-Type'); 
                        if($contentType) {
>>>>>>> e68c7900a429ca0a02a86e7a4345c04cba74b760
                            $type = explode('/', $contentType)[1] ?? 'jpg';
                        }
                    }
                } catch (\Exception $e) {
<<<<<<< HEAD
                    continue; // Skip jika gagal download
                }
            } 
=======
                    // Jika gagal download, biarkan src apa adanya (atau log error)
                    continue; 
                }
            }
>>>>>>> e68c7900a429ca0a02a86e7a4345c04cba74b760
            // SKENARIO 3: Sudah Base64
            else {
                continue; // Tidak perlu diproses
            }

            // Jika berhasil mendapatkan data gambar, ubah src jadi Base64
            if ($imageData) {
                $base64 = 'data:image/' . $type . ';base64,' . base64_encode($imageData);
                $img->setAttribute('src', $base64);
                
<<<<<<< HEAD
                // Reset ukuran style agar pas di PDF (Opsional, agar tidak melebar)
=======
                // Opsional: Reset ukuran style agar pas di PDF jika terlalu besar
>>>>>>> e68c7900a429ca0a02a86e7a4345c04cba74b760
                $img->removeAttribute('style'); 
                $img->setAttribute('style', 'max-width: 100%; height: auto;');
            }
        }

<<<<<<< HEAD
        // Simpan HTML yang sudah diproses (hapus wrapper div yang kita buat di awal)
        $processedHtml = $dom->saveHTML($dom->documentElement);
        return substr($processedHtml, 5, -6);
    }
=======
        

        $processedHtml = $dom->saveHTML($dom->documentElement);
        return substr($processedHtml, 5, -6);
    }

    public function show($id)
{
    // Load proposal beserta relasinya (members, budget, outputIndicators)
    $proposal = \App\Models\Proposal::with(['members', 'budget', 'outputIndicators'])->findOrFail($id);

    return view('proposals.show', compact('proposal'));
}

>>>>>>> e68c7900a429ca0a02a86e7a4345c04cba74b760
}