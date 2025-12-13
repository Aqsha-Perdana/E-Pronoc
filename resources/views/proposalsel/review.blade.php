@php
    $page = $page ?? 'review';

    $proposals = \App\Models\Proposal::with(['teams.member', 'budgets'])
        ->where('status', 'SUBMITTED')
        ->orderBy('created_at', 'desc')
        ->get();
@endphp

<!-- Tambahkan meta CSRF token di head -->
<meta name="csrf-token" content="{{ csrf_token() }}">

<h2 class="text-2xl font-bold mb-4">Need to be Reviewed</h2>
<table class="min-w-full bg-white border border-gray-200 rounded-lg shadow">
    <thead>
        <tr class="bg-gray-100 border-b">
            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">NO</th>
            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">PROPOSAL INFORMATION</th>
            <th class="px-6 py-3 text-center text-sm font-semibold text-gray-700">ACTION</th>
        </tr>
    </thead>

    <tbody class="divide-y divide-gray-200">
        @forelse($proposals as $index => $proposal)
        <tr id="row-{{ $proposal->id }}">
            <td class="px-6 py-4 text-gray-800 align-top">{{ $index + 1 }}</td>
            <td class="px-6 py-4 text-gray-800">
                <div class="space-y-1">
                    <div>
                        <span class="font-semibold">Code-REG</span> : {{ $proposal->registration_code ?? 'N/A' }}
                    </div>
                    <div>
                        <span class="font-semibold">Title</span> : {{ $proposal->title }}
                    </div>
                    <div>
                        <span class="font-semibold">Team</span> : 
                        @if($proposal->teams && $proposal->teams->count() > 0)
                            @php
                                $memberNames = $proposal->teams
                                    ->map(function($team) {
                                        return $team->member ? $team->member->name : 'N/A';
                                    })
                                    ->filter()
                                    ->join(', ');
                            @endphp
                            {{ $memberNames ?: 'N/A' }}
                        @else
                            N/A
                        @endif
                    </div>
                    <div>
                        <span class="font-semibold">Budget Planning</span> Rp. {{ number_format($proposal->budgets->sum('total_cost'), 0, ',', '.') }}
                    </div>
                </div>
            </td>
            <td class="px-6 py-4 text-center align-top action-column">
                <div class="flex flex-col gap-1.5">
                    <button class="px-3 py-1.5 text-xs bg-gray-200 text-gray-900 rounded font-medium hover:bg-gray-300 transition flex items-center justify-center gap-1">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                        <span>Detail</span>
                    </button>
                    
                    <button 
                        onclick="openAcceptModal({{ $proposal->id }})"
                        class="px-3 py-1.5 text-xs bg-green-600 text-white rounded font-medium hover:bg-green-700 transition flex items-center justify-center gap-1">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span>Accept</span>
                    </button>
                    
                    <button 
                        onclick="openRejectModal({{ $proposal->id }})"
                        class="px-3 py-1.5 text-xs bg-red-600 text-white rounded font-medium hover:bg-red-700 transition flex items-center justify-center gap-1">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                        <span>Reject</span>
                    </button>
                </div>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="3" class="px-6 py-4 text-center text-gray-500">
                Tidak ada proposal yang perlu direview
            </td>
        </tr>
        @endforelse
    </tbody>
</table>

<!-- Modal Accept -->
<div id="acceptModal" class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center hidden z-50">
    <div class="bg-white w-full max-w-md p-6 rounded-lg shadow-lg">
        <h3 class="text-xl font-bold mb-4">Ketentuan Persetujuan</h3>

        <p class="text-sm text-gray-700 mb-4">
            Dengan menyetujui proposal ini, Anda menyatakan telah membaca, memeriksa, dan memastikan bahwa:
        </p>

        <ul class="list-disc ml-5 text-sm text-gray-700 mb-4">
            <li>Proposal sesuai dengan regulasi dan pedoman yang berlaku</li>
            <li>Anggaran telah diperiksa dengan benar</li>
            <li>Tidak ada konflik kepentingan</li>
        </ul>

        <div class="mb-4">
            <label class="flex items-start gap-2 cursor-pointer">
                <input type="checkbox" id="confirmCheck" class="mt-1">
                <span class="text-sm">Saya setuju dengan semua ketentuan</span>
            </label>
        </div>

        <div class="flex justify-end gap-2">
            <button 
                onclick="closeAcceptModal()" 
                class="px-4 py-2 bg-gray-300 hover:bg-gray-400 rounded transition">
                Batal
            </button>
            <button 
                id="submitAccept" 
                type="button" 
                onclick="submitApproval()" 
                disabled
                class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 disabled:bg-gray-300 disabled:cursor-not-allowed transition">
                Setujui
            </button>
        </div>
    </div>
</div>

@push('scripts')
<script>
    let currentRowId = null;
    let currentRowElement = null;

    // Fungsi untuk membuka modal accept
    function openAcceptModal(id) {
        console.log('=== OPENING MODAL ===');
        console.log('Proposal ID:', id);
        
        currentRowId = id;
        currentRowElement = document.getElementById('row-' + id);
        
        console.log('Current Row Element:', currentRowElement);

        const modal = document.getElementById('acceptModal');
        const confirmCheck = document.getElementById('confirmCheck');
        const submitButton = document.getElementById('submitAccept');

        // Reset checkbox & button
        confirmCheck.checked = false;
        submitButton.disabled = true;

        // Event listener untuk checkbox
        confirmCheck.onchange = function () {
            submitButton.disabled = !this.checked;
            console.log('Checkbox changed:', this.checked);
        };

        // Tampilkan modal
        modal.classList.remove('hidden');
    }

    // Fungsi untuk menutup modal
    function closeAcceptModal() {
        const modal = document.getElementById('acceptModal');
        modal.classList.add('hidden');
        
        document.getElementById('confirmCheck').checked = false;
        document.getElementById('submitAccept').disabled = true;
    }

    // Fungsi submit approval - VERSION DEBUG
    async function submitApproval() {
        console.log('=== SUBMIT APPROVAL START ===');
        
        const submitBtn = document.getElementById('submitAccept');
        const originalText = submitBtn.innerHTML;
        
        // Cek CSRF Token
        const csrfToken = document.querySelector('meta[name="csrf-token"]');
        console.log('CSRF Meta Tag:', csrfToken);
        console.log('CSRF Token Value:', csrfToken ? csrfToken.content : 'NOT FOUND');
        
        if (!csrfToken) {
            alert('ERROR: CSRF Token tidak ditemukan! Pastikan ada <meta name="csrf-token"> di halaman.');
            return;
        }
        
        // Set loading state
        submitBtn.innerHTML = '<span>⏳ Loading...</span>';
        submitBtn.disabled = true;

        // Build URL
        const url = `/proposalsel/review/${currentRowId}/accept`;
        console.log('Request URL:', url);
        console.log('Current Row ID:', currentRowId);

        try {
            console.log('Sending fetch request...');
            
            const response = await fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken.content,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({})
            });

            console.log('=== RESPONSE RECEIVED ===');
            console.log('Response Status:', response.status);
            console.log('Response OK:', response.ok);
            console.log('Response Headers:', [...response.headers.entries()]);
            
            // Baca response sebagai text dulu
            const responseText = await response.text();
            console.log('=== RAW RESPONSE ===');
            console.log(responseText);

            // Cek apakah response kosong
            if (!responseText) {
                throw new Error('Response kosong dari server');
            }

            // Parse JSON
            let data;
            try {
                data = JSON.parse(responseText);
                console.log('=== PARSED DATA ===');
                console.log(data);
            } catch (e) {
                console.error('=== JSON PARSE ERROR ===');
                console.error(e);
                console.log('Response bukan JSON. Kemungkinan HTML error page.');
                throw new Error('Response bukan format JSON yang valid. Cek tab Network di DevTools.');
            }

            // Cek success
            console.log('Data.success:', data.success);
            console.log('Type of data.success:', typeof data.success);

            if (data.success === true) {
                console.log('=== SUCCESS ===');
                
                closeAcceptModal();
                removeRowWithAnimation(currentRowElement);
                showSuccessMessage(data.message || 'Proposal berhasil disetujui');
                checkIfTableEmpty();
            } else {
                console.log('=== FAILED ===');
                console.log('Error Message:', data.message);
                
                showErrorMessage(data.message || 'Terjadi kesalahan saat menyetujui proposal');
                
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
            }

        } catch (error) {
            console.error('=== CATCH ERROR ===');
            console.error('Error Name:', error.name);
            console.error('Error Message:', error.message);
            console.error('Error Stack:', error.stack);
            
            let errorMessage = 'Terjadi kesalahan: ' + error.message;
            
            showErrorMessage(errorMessage);
            
            submitBtn.innerHTML = originalText;
            submitBtn.disabled = false;
        }
    }

    function removeRowWithAnimation(row) {
        if (!row) {
            console.warn('Row element not found for animation');
            return;
        }
        
        row.style.transition = 'all 0.5s ease';
        row.classList.add('bg-green-100');
        
        setTimeout(() => {
            row.style.opacity = '0';
            row.style.transform = 'translateX(20px)';
            
            setTimeout(() => {
                row.remove();
                updateRowNumbers();
            }, 500);
        }, 500);
    }

    function updateRowNumbers() {
        const tbody = document.querySelector('tbody');
        const rows = tbody.querySelectorAll('tr[id^="row-"]');
        
        rows.forEach((row, index) => {
            const numberCell = row.querySelector('td:first-child');
            if (numberCell) {
                numberCell.textContent = index + 1;
            }
        });
    }

    function checkIfTableEmpty() {
        setTimeout(() => {
            const tbody = document.querySelector('tbody');
            const rows = tbody.querySelectorAll('tr[id^="row-"]');
            
            if (rows.length === 0) {
                tbody.innerHTML = `
                    <tr>
                        <td colspan="3" class="px-6 py-4 text-center text-gray-500">
                            Tidak ada proposal yang perlu direview
                        </td>
                    </tr>
                `;
            }
        }, 1000);
    }

    function showSuccessMessage(message = 'Proposal berhasil disetujui') {
        const notification = document.createElement('div');
        notification.className = 'fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50 flex items-center gap-2';
        notification.innerHTML = `
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
            <span>${message}</span>
        `;
        
        document.body.appendChild(notification);
        
        setTimeout(() => {
            notification.style.transition = 'opacity 0.3s ease';
            notification.style.opacity = '0';
            setTimeout(() => notification.remove(), 300);
        }, 3000);
    }

    function showErrorMessage(message) {
        const notification = document.createElement('div');
        notification.className = 'fixed top-4 right-4 bg-red-500 text-white px-6 py-3 rounded-lg shadow-lg z-50 flex items-center gap-2';
        notification.innerHTML = `
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
            <span>${message}</span>
        `;
        
        document.body.appendChild(notification);
        
        setTimeout(() => {
            notification.style.transition = 'opacity 0.3s ease';
            notification.style.opacity = '0';
            setTimeout(() => notification.remove(), 300);
        }, 4000);
    }

    function openRejectModal(id) {
        alert('Fitur reject belum diimplementasikan. Proposal ID: ' + id);
    }

    // Log saat halaman dimuat
    console.log('=== PAGE LOADED ===');
    console.log('CSRF Token exists:', !!document.querySelector('meta[name="csrf-token"]'));
    console.log('Current URL:', window.location.href);
</script>
@endpush