@php
    $page = $page ?? 'list';
    
    $proposals = \App\Models\Proposal::orderBy('created_at', 'desc')->get();
    
@endphp

<h2 class="text-2xl font-bold mb-4">Project List </h2>
<div class="mb-4">
    <div class="relative inline-block w-64">
        <button onclick="toggleDropdown()" class="w-full px-4 py-2 text-sm text-left rounded-lg border border-gray-300 bg-white flex justify-between items-center hover:border-gray-400 transition">
            <span id="selectedFilter">Filter by Status: All</span>
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
            </svg>
        </button>
        
        <div id="dropdownMenu" class="hidden absolute mt-1 w-full bg-white border border-gray-200 rounded-lg shadow-lg z-10">
            <button onclick="filterTable('all')" class="w-full px-4 py-2 text-sm text-left hover:bg-gray-100 transition">
                All Status
            </button>
            <button onclick="filterTable('APPROVED')" class="w-full px-4 py-2 text-sm text-left hover:bg-gray-100 transition flex items-center">
                <span class="w-3 h-3 rounded-full mr-2" style="background-color: #10b981;"></span>
                Approved
            </button>
            <button onclick="filterTable('pending')" class="w-full px-4 py-2 text-sm text-left hover:bg-gray-100 transition flex items-center">
                <span class="w-3 h-3 rounded-full mr-2" style="background-color: #f59e0b;"></span>
                Pending
            </button>
            <button onclick="filterTable('rejected')" class="w-full px-4 py-2 text-sm text-left hover:bg-gray-100 transition flex items-center">
                <span class="w-3 h-3 rounded-full mr-2" style="background-color: #ef4444;"></span>
                Rejected
            </button>
        </div>
    </div>
</div>

<div class="overflow-x-auto">
    <table class="min-w-full bg-white border border-gray-200 rounded-lg shadow">
        <thead>
            <tr class="bg-gray-100 border-b">
                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">No. Reg</th>
                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Title</th>
                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Date</th>
                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Status</th>
                <th class="px-6 py-3 text-center text-sm font-semibold text-gray-700">Action</th>
            </tr>
        </thead>

        <tbody class="divide-y divide-gray-200">
            @forelse($proposals as $proposal)
            <tr>
                <td class="px-6 py-4 text-gray-800">{{ $proposal->registration_code ?? $proposal->registration_code }}</td>
                <td class="px-6 py-4 text-gray-800">{{ $proposal->title }}</td>
                <td class="px-6 py-4 text-gray-800">{{ \Carbon\Carbon::parse($proposal->date ?? $proposal->created_at)->format('d M Y') }}</td>
                <td class="px-6 py-4">
                    @php
                        $statusLower = strtolower($proposal->status ?? '');
                        $statusStyles = [
                            'approved' => 'background-color: #d1fae5; color: #065f46;',
                            'submitted' => 'background-color: #fef3c7; color: #92400e;',
                            'rejected' => 'background-color: #fee2e2; color: #991b1b;',
                            'default' => 'background-color: #f3f4f6; color: #374151;'
                        ];
                        $style = $statusStyles[$statusLower] ?? $statusStyles['default'];
                    @endphp
                    
                    <span style="{{ $style }}" class="px-3 py-1 text-sm rounded-full inline-block">
                        {{ ucfirst($proposal->status ?? 'N/A') }}
                    </span>
                </td>
                <td class="px-6 py-4 text-center">
                    <button class="px-4 py-2 text-sm bg-[#D31119] text-white rounded-lg hover:bg-red-800 transition">
                        View
                    </button>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                    Tidak ada data proposal
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<script>
function toggleDropdown() {
    const dropdown = document.getElementById('dropdownMenu');
    dropdown.classList.toggle('hidden');
}

function filterTable(status) {
    const rows = document.querySelectorAll('.proposal-row');
    const selectedFilter = document.getElementById('selectedFilter');
    const dropdown = document.getElementById('dropdownMenu');
    const noResults = document.getElementById('noResults');
    const tableBody = document.getElementById('tableBody');
    
    // Update selected filter text
    const filterText = {
        'all': 'Filter by Status: All',
        'APPROVED': 'Filter by Status: APPROVED',
        'pending': 'Filter by Status: Pending',
        'rejected': 'Filter by Status: Rejected'
    };
    selectedFilter.textContent = filterText[status];
    
    // Close dropdown
    dropdown.classList.add('hidden');
    
    // Filter rows
    let visibleCount = 0;
    rows.forEach(row => {
        const rowStatus = row.getAttribute('data-status');
        
        if (status === 'all') {
            row.style.display = '';
            visibleCount++;
        } else {
            if (rowStatus === status) {
                row.style.display = '';
                visibleCount++;
            } else {
                row.style.display = 'none';
            }
        }
    });
    
    // Show/hide no results message
    if (visibleCount === 0 && rows.length > 0) {
        noResults.classList.remove('hidden');
        tableBody.style.display = 'none';
    } else {
        noResults.classList.add('hidden');
        tableBody.style.display = '';
    }
}

// Close dropdown when clicking outside
document.addEventListener('click', function(event) {
    const dropdown = document.getElementById('dropdownMenu');
    const dropdownContainer = event.target.closest('.relative');
    
    if (!dropdownContainer) {
        dropdown.classList.add('hidden');
    }
});

// Prevent dropdown close when clicking inside it
document.getElementById('dropdownMenu').addEventListener('click', function(event) {
    event.stopPropagation();
});
</script>