<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Proposal;
<<<<<<< HEAD
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
=======
use App\Models\Members; // Pastikan Model Member di-import
use Faker\Provider\Lorem;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
>>>>>>> e68c7900a429ca0a02a86e7a4345c04cba74b760

class ProposalWizard extends Component
{
    use WithFileUploads;

    public $currentStep = 1;
    public $totalSteps = 6;

<<<<<<< HEAD
    // Data Proposal
    public $title, $registration_code, $date, $focus_area, $output;
    
    // Data Team
    public $teamMembers = []; 
    public $searchNIP = ''; 
    public $searchResults = [];

    // Data Lainnya
    public $outputIndicators = [['indicator' => 'Skema D (Sinta/Scopus)', 'description' => '']];
    public $direct_cost = 0, $non_personnel_cost = 0, $indirect_cost = 0;
    
    // File Uploads
    public $rab_file;
    public $statement_letter;

    // Content
    public $abstract, $introduction, $project_method, $bibliography;
=======
    // Step 1: General Info
    public $title, $registration_code, $date, $focus_area, $output;

    // Step 2: Team Members
    public $teamMembers = []; 
    // Array untuk menampung hasil search per baris: [index_baris => [Array of Member]]
    public $memberSuggestions = []; 

    // Step 3-6 Properties
    public $outputIndicators = [['indicator' => 'Skema D (Sinta/Scopus)', 'description' => '']];
    public $direct_cost = 0;
    public $non_personnel_cost = 0;
    public $indirect_cost = 0;
    public $rab_file;
    public $abstract, $introduction, $project_method, $bibliography;
    public $statement_letter;
>>>>>>> e68c7900a429ca0a02a86e7a4345c04cba74b760

    public function mount()
    {
        $this->date = date('Y-m-d');
<<<<<<< HEAD
        $this->registration_code = 'RCMS/RES/' . date('Y') . '/XXXXX';
        
        $user = Auth::user();
    
        // 1. CEK KELENGKAPAN PROFIL
        // Jika user belum punya data member atau NIP kosong, redirect ke profil
        if (!$user->member || empty($user->member->nip)) {
            session()->flash('error', 'Silakan lengkapi profil Anda terlebih dahulu!');
            return redirect()->route('profile');
        }

        // 2. OTOMATIS TAMBAHKAN KETUA (USER LOGIN)
        if (empty($this->teamMembers)) {
            if ($user) {
                $nip = $user->member ? $user->member->nip : '-';

                $this->teamMembers[] = [
                    'user_id' => $user->id,
                    'nip'     => $nip,
                    'name'    => $user->name,
                    'email'   => $user->email,
                    'role'    => 'Ketua'
                ];
=======
        
        // Auto Generate Registration Code
        $this->registration_code = 'RCMS/RES/' . date('Y') . '/' . strtoupper(Str::random(5));
        
        $this->output = '';

        // Inisialisasi 1 member kosong saat pertama load
        if (empty($this->teamMembers)) {
            $this->addMember();
        }
    }

    // --- FITUR PENCARIAN MEMBER (AUTOCOMPLETE) ---

    // Hook ini berjalan otomatis (Real-time) setiap kali ada update di array $teamMembers
    public function updatedTeamMembers($value, $key)
    {
        // $key formatnya seperti: 0.nip, 1.name, dll.
        $parts = explode('.', $key);
        
        // Kita hanya trigger search jika yang diketik adalah 'nip'
        if (count($parts) === 2 && $parts[1] === 'nip') {
            $index = $parts[0];
            $searchTerm = $value;

            // Cari jika input lebih dari 2 karakter
            if (strlen($searchTerm) >= 2) {
                // Cari member berdasarkan NIP atau Nama
                $results = Members::where('nip', 'like', '%' . $searchTerm . '%')
                                 ->orWhere('name', 'like', '%' . $searchTerm . '%')
                                 ->limit(5)
                                 ->get();
                
                $this->memberSuggestions[$index] = $results;
            } else {
                $this->memberSuggestions[$index] = [];
>>>>>>> e68c7900a429ca0a02a86e7a4345c04cba74b760
            }
        }
    }

<<<<<<< HEAD
    // --- REAL-TIME VALIDATION HOOKS ---
    // Agar pesan error langsung hilang saat file dipilih
    public function updatedRabFile()
    {
        $this->validate(['rab_file' => 'required|file|mimes:xls,xlsx|max:10240']);
    }

    public function updatedStatementLetter()
    {
        $this->validate(['statement_letter' => 'required|file|mimes:pdf,doc,docx|max:10240']);
    }

    // --- TEAM MANAGEMENT ---
    public function updatedSearchNIP()
    {
        if (strlen($this->searchNIP) >= 3) {
            $this->searchResults = User::query()
                ->where('user_group', 'peneliti')
                ->where(function($q) {
                    $q->where('name', 'like', '%' . $this->searchNIP . '%')
                      ->orWhereHas('member', function ($query) {
                          $query->where('nip', 'like', '%' . $this->searchNIP . '%');
                      });
                })
                ->with('member') 
                ->take(5)
                ->get();
        } else {
            $this->searchResults = [];
        }
    }

    public function selectUserForTeam($userId)
    {
        $user = User::with('member')->find($userId);

        if ($user) {
            // Cek Duplikasi
            $exists = collect($this->teamMembers)->contains('user_id', $user->id);

            if (!$exists) {
                $this->teamMembers[] = [
                    'user_id' => $user->id,
                    'nip'     => $user->member->nip ?? '-',
                    'name'    => $user->name,
                    'email'   => $user->email,
                    'role'    => 'Anggota'
                ];
            }
        }
        
        $this->searchNIP = '';
        $this->searchResults = [];
    }

    public function removeMember($index) 
    { 
        unset($this->teamMembers[$index]); 
        $this->teamMembers = array_values($this->teamMembers); 
    }

    // --- DYNAMIC INPUTS ---
    public function addIndicator() { $this->outputIndicators[] = ['indicator' => '', 'description' => '']; }
    public function removeIndicator($index) { unset($this->outputIndicators[$index]); $this->outputIndicators = array_values($this->outputIndicators); }
    
    // Computed Property for Budget
    public function getTotalBudgetProperty() { 
        return (float)$this->direct_cost + (float)$this->non_personnel_cost + (float)$this->indirect_cost; 
    }

    // --- VALIDASI PER STEP ---
    public function validateStep()
    {
        if ($this->currentStep == 1) {
            $this->validate([
                'title' => 'required|min:5',
                'focus_area' => 'required',
                'output' => 'required',
                'date' => 'required|date',
            ]);
        }
        
        if ($this->currentStep == 2) {
            $this->validate([
                'teamMembers' => 'required|array|min:1',
                'teamMembers.*.role' => 'required',
            ]);
        }
        
        if ($this->currentStep == 3) {
            $this->validate(['outputIndicators.*.indicator' => 'required']);
        }
        
        if ($this->currentStep == 4) {
            $this->validate([
                'direct_cost' => 'required|numeric|min:0', 
                'rab_file' => 'required|file|mimes:xls,xlsx|max:10240'
            ], [
                'rab_file.required' => 'Dokumen RAB wajib diunggah.',
                'rab_file.mimes' => 'Format file harus Excel (.xls, .xlsx).',
            ]);
        }
        
        // --- [VALIDASI STEP 5: MIN 50 CHAR] ---
        if ($this->currentStep == 5) {
            $this->validate([
                'abstract'       => 'required|string|min:50',
                'introduction'   => 'required|string|min:50',
                'project_method' => 'required|string|min:50',
                'bibliography'   => 'required|string|min:50',
            ], [
                'abstract.min'       => 'Abstract harus memiliki minimal 50 karakter.',
                'introduction.min'   => 'Introduction harus memiliki minimal 50 karakter.',
                'project_method.min' => 'Project Method harus memiliki minimal 50 karakter.',
                'bibliography.min'   => 'Bibliography harus memiliki minimal 50 karakter.',
            ]);
        }

        if ($this->currentStep == 6) {
            $this->validate([
                'statement_letter' => 'required|file|mimes:pdf,doc,docx|max:10240'
            ], [
                'statement_letter.required' => 'Dokumen pendukung wajib diunggah.'
            ]);
        }
    }

=======
    // Fungsi saat user mengklik salah satu hasil search di dropdown
    public function selectMember($index, $memberId)
    {
        $member = Members::find($memberId);
        
        if ($member) {
            // Auto-fill data ke baris tersebut
            $this->teamMembers[$index]['nip'] = $member->nip;
            $this->teamMembers[$index]['name'] = $member->name;
            $this->teamMembers[$index]['email'] = $member->email;
        }

        // Kosongkan saran pencarian agar dropdown tertutup
        $this->memberSuggestions[$index] = [];
    }
    // --- END FITUR PENCARIAN ---


// --- NAVIGATION LOGIC (UPDATE BAGIAN INI) ---
>>>>>>> e68c7900a429ca0a02a86e7a4345c04cba74b760
    public function nextStep()
    {
        $this->validateStep();
        if ($this->currentStep < $this->totalSteps) {
            $this->currentStep++;
<<<<<<< HEAD
            // Re-init CKEditor jika masuk ke step konten
=======
            
            // JIKA MASUK KE STEP 5, KIRIM SINYAL KE BROWSER
>>>>>>> e68c7900a429ca0a02a86e7a4345c04cba74b760
            if ($this->currentStep == 5) {
                $this->dispatch('init-ckeditor');
            }
        }
    }

    public function previousStep()
    {
        if ($this->currentStep > 1) {
            $this->currentStep--;
<<<<<<< HEAD
=======

            // JIKA KEMBALI KE STEP 5 DARI STEP 6, KIRIM SINYAL JUGA
>>>>>>> e68c7900a429ca0a02a86e7a4345c04cba74b760
            if ($this->currentStep == 5) {
                $this->dispatch('init-ckeditor');
            }
        }
    }
<<<<<<< HEAD

    // --- SUBMIT FINAL ---
    public function submitProposal()
    {
        // 1. Validasi Akhir sebelum Transaksi
        $this->validate([
            'title' => 'required',
            'teamMembers' => 'required|array|min:1',
            'statement_letter' => 'required|file|mimes:pdf,doc,docx|max:10240', // Pastikan file ada
        ], [
            'statement_letter.required' => 'Gagal Submit: Dokumen Pendukung wajib diunggah.'
        ]);

        DB::transaction(function () {
            // Generate Unique Code
=======
    
    // Updated addMember structure
    public function addMember() { 
        $this->teamMembers[] = [
            'nip' => '', 
            'name' => '', 
            'email' => '', 
            'role' => 'Anggota'
        ]; 
    }

    public function removeMember($index) { 
        unset($this->teamMembers[$index]); 
        unset($this->memberSuggestions[$index]); // Hapus juga suggestionnya agar tidak error
        $this->teamMembers = array_values($this->teamMembers); 
    }

    public function addIndicator() { $this->outputIndicators[] = ['indicator' => '', 'description' => '']; }
    public function removeIndicator($index) { unset($this->outputIndicators[$index]); $this->outputIndicators = array_values($this->outputIndicators); }
    public function getTotalBudgetProperty() { return (float)$this->direct_cost + (float)$this->non_personnel_cost + (float)$this->indirect_cost; }

    public function validateStep()
    {
        if ($this->currentStep == 1) {
            $this->validate([
                'title' => 'required|min:5',
                'focus_area' => 'required',
                'output' => 'required', // Tambahkan validasi output
                'date' => 'required|date',
            ]);
        }
        
        if ($this->currentStep == 2) {
            $this->validate([
                'teamMembers' => 'required|array|min:1', // Minimal 1 anggota
                'teamMembers.*.nip' => 'required',
                'teamMembers.*.name' => 'required',
                'teamMembers.*.email' => 'required|email',
                'teamMembers.*.role' => 'required',
            ]);
        }

        // PERBAIKAN: Tambahkan Validasi Step 3
        if ($this->currentStep == 3) {
            $this->validate([
                'outputIndicators' => 'required|array|min:1',
                'outputIndicators.*.indicator' => 'required|string',
            ]);
        }

        // ... di dalam method validateStep()

        if ($this->currentStep == 4) {
            $this->validate([
                // Tambahkan 'required' pada semua field ini
                'direct_cost' => 'required|numeric|min:0',
                'non_personnel_cost' => 'required|numeric|min:0',
                'indirect_cost' => 'required|numeric|min:0',
                
                // Hapus tanda komentar pada rab_file dan pastikan required
                'rab_file' => 'required|file|mimes:xlsx,xls|max:10240', 
            ], [
                // Custom messages (Opsional, agar pesan lebih jelas)
                'direct_cost.required' => 'Biaya personil wajib diisi (isi 0 jika tidak ada).',
                'non_personnel_cost.required' => 'Biaya non-personil wajib diisi.',
                'indirect_cost.required' => 'Biaya tidak langsung wajib diisi.',
                'rab_file.required' => 'Anda wajib mengunggah dokumen RAB (Excel).',
                'rab_file.mimes' => 'Format file harus Excel (xls/xlsx).',
            ]);
        }

        if ($this->currentStep == 5) {
            $this->validate([
                'abstract' => 'required|string|min:50',
                'introduction' => 'required|string|min:50',
                'project_method' => 'required|string|min:50',
                'bibliography' => 'required|string',
            ]);
        }

        if ($this->currentStep == 6) {
             $this->validate([
                'statement_letter' => 'required|file|mimes:pdf|max:5120',
             ]);
        }
    }

public function submitProposal()
    {
        $this->validate([
            'title' => 'required',
            'focus_area' => 'required',
            'teamMembers' => 'required|array|min:1',
            'abstract' => 'required',
            'introduction' => 'required',
            'statement_letter' => 'required|file|mimes:pdf|max:5120',
        ]);

        DB::transaction(function () {
            // --- Generate Unique Code ---
>>>>>>> e68c7900a429ca0a02a86e7a4345c04cba74b760
            do {
                $uniqueCode = 'RCMS/RES/' . date('Y') . '/' . strtoupper(Str::random(5));
            } while (Proposal::where('registration_code', $uniqueCode)->exists());
            
<<<<<<< HEAD
            // Simpan Proposal (Link ke User Login)
            $proposal = Proposal::create([
                'user_id'           => Auth::id(), // ID Pemilik
                'registration_code' => $uniqueCode, 
                'title'             => $this->title,
                'date'              => $this->date,
                'focus_area'        => $this->focus_area,
                'output'            => $this->output, 
                'abstract'          => $this->abstract,
                'introduction'      => $this->introduction,
                'project_method'    => $this->project_method,
                'bibliography'      => $this->bibliography,
                'status'            => 'SUBMITTED',
                // Simpan File Statement
                'statement_letter'  => $this->statement_letter->store('proposals/letters', 'public'),
            ]);

            // Simpan Tim (Pivot)
            foreach ($this->teamMembers as $memberData) {
                $proposal->teamMembers()->attach($memberData['user_id'], [
                    'role' => $memberData['role']
                ]);
            }
            
            // Simpan Output Indicators
            $proposal->outputIndicators()->createMany($this->outputIndicators);
            
            // Simpan Budget & File RAB
            $proposal->budget()->create([
                'direct_personnel_cost_proposal' => $this->direct_cost,
                'non_personnel_cost_proposal'    => $this->non_personnel_cost,
                'indirect_cost_proposal'         => $this->indirect_cost,
                'document_rab_proposal'          => $this->rab_file ? $this->rab_file->store('proposals/rab', 'public') : null,
                'status'                         => 'Pending',
            ]);

            // Buat Progress Report Awal
            $proposal->progressReport()->create(['report_date' => now()]);
        });

        // Trigger Event Sukses
        $this->dispatch('proposal-submitted');
    }

    public function render()
    {
        return view('livewire.proposal-wizard');
    }
}
=======
            $this->registration_code = $uniqueCode;

            // 1. Simpan Proposal
            $proposal = Proposal::create([
                'registration_code' => $uniqueCode, 
                'title' => $this->title,
                'date' => $this->date,
                'focus_area'      => $this->focus_area,
                'output' => $this->output, 
                'abstract' => $this->abstract,
                'introduction' => $this->introduction,
                'project_method' => $this->project_method,
                'bibliography' => $this->bibliography,
                'status' => 'SUBMITTED',
                'statement_letter' => $this->statement_letter->store('proposals/letters', 'public'),
            ]);

            // 2. Simpan Member
            foreach ($this->teamMembers as $team) {
                $member = Member::firstOrCreate(
                    ['nip' => $team['nip']], 
                    [
                        'name' => $team['name'],
                        'email' => $team['email'],
                        'password' => bcrypt('password123'),
                        'role' => 'Anggota'
                    ]
                );
                $proposal->members()->attach($member->id, ['role' => $team['role']]);
            }
            
            // 3. Output Indicators
            $proposal->outputIndicators()->createMany($this->outputIndicators);
            
            // 4. Budget (CORRECTED SECTION)
            // Mapping public properties to database columns based on your screenshot
            $proposal->budget()->create([
                'direct_personnel_cost_proposal' => $this->direct_cost,      // Fixed property name
                'non_personnel_cost_proposal'    => $this->non_personnel_cost, // Fixed property name
                'indirect_cost_proposal'         => $this->indirect_cost,      // Fixed property name
                'document_rab_proposal'          => $this->rab_file ? $this->rab_file->store('proposals/rab', 'public') : null, // Fixed property name
                'status' => 'Pending',
            ]);
        });

        $this->dispatch('proposal-submitted');
    }

    public function render()    
    {
        return view('livewire.proposal-wizard');
    }
}



>>>>>>> e68c7900a429ca0a02a86e7a4345c04cba74b760
