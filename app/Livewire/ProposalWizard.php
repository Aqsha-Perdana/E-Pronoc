<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Proposal;
use App\Models\Members; // Pastikan Model Member di-import
use Faker\Provider\Lorem;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProposalWizard extends Component
{
    use WithFileUploads;

    public $currentStep = 1;
    public $totalSteps = 6;

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

    public function mount()
    {
        $this->date = date('Y-m-d');
        
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
            }
        }
    }

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
    public function nextStep()
    {
        $this->validateStep();
        if ($this->currentStep < $this->totalSteps) {
            $this->currentStep++;
            
            // JIKA MASUK KE STEP 5, KIRIM SINYAL KE BROWSER
            if ($this->currentStep == 5) {
                $this->dispatch('init-ckeditor');
            }
        }
    }

    public function previousStep()
    {
        if ($this->currentStep > 1) {
            $this->currentStep--;

            // JIKA KEMBALI KE STEP 5 DARI STEP 6, KIRIM SINYAL JUGA
            if ($this->currentStep == 5) {
                $this->dispatch('init-ckeditor');
            }
        }
    }
    
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
            do {
                $uniqueCode = 'RCMS/RES/' . date('Y') . '/' . strtoupper(Str::random(5));
            } while (Proposal::where('registration_code', $uniqueCode)->exists());
            
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



