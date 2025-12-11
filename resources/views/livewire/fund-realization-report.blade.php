<div class="min-h-screen bg-gray-50 py-8 px-4 sm:px-6 lg:px-8">
    
    {{-- Header Section --}}
    <div class="max-w-7xl mx-auto mb-8">
        <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Fund Realization Report</h1>
        <p class="mt-2 text-sm text-gray-500">Manage and monitor your proposal budget realizations.</p>
    </div>

    {{-- Main Card --}}
    <div class="max-w-7xl mx-auto bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        
        {{-- Toolbar (Filter & Search) --}}
        <div class="p-6 border-b border-gray-100 bg-white flex flex-col sm:flex-row justify-between items-center gap-4">
            {{-- Show Entries --}}
            <div class="flex items-center gap-3 text-sm text-gray-600">
                <span class="font-medium text-gray-500">Show</span>
                <select wire:model.live="perPage" class="form-select border-gray-300 rounded-lg text-sm focus:ring-orange-500 focus:border-orange-500 py-2 pl-3 pr-8 shadow-sm cursor-pointer">
                    <option value="5">5</option>
                    <option value="10">10</option>
                    <option value="25">25</option>
                </select>
                <span class="font-medium text-gray-500">entries</span>
            </div>

            {{-- Search Box --}}
            <div class="relative w-full sm:w-72">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
                <input type="text" wire:model.live.debounce.300ms="search" 
                    class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg leading-5 bg-white placeholder-gray-400 focus:outline-none focus:placeholder-gray-300 focus:ring-2 focus:ring-orange-500 focus:border-orange-500 sm:text-sm transition duration-150 ease-in-out" 
                    placeholder="Search proposal...">
            </div>
        </div>

        {{-- Table --}}
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm whitespace-nowrap">
                <thead class="bg-gray-50 text-gray-600 font-semibold uppercase tracking-wider text-xs border-b border-gray-200">
                    <tr>
                        <th scope="col" class="px-6 py-4">Proposal Title</th>
                        <th scope="col" class="px-6 py-4">Fund Plan</th>
                        <th scope="col" class="px-6 py-4">Fund Realization</th>
                        <th scope="col" class="px-6 py-4">Remaining Fund</th>
                        <th scope="col" class="px-6 py-4 text-center">Status</th>
                        <th scope="col" class="px-6 py-4 text-center">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 bg-white">
                    @forelse($budgets as $budget)
                        {{-- ==================================================== --}}
                        {{-- LOGIKA BARU PENENTUAN STATUS --}}
                        {{-- ==================================================== --}}
                        @php
                            $proposalStatus = strtolower($budget->proposal->status ?? '');
                            $budgetStatus   = strtolower($budget->status ?? '');

                            // Logic:
                            // 1. Prioritas Utama: Jika Budget sudah 'done', maka status = done.
                            // 2. Jika Budget belum done, TAPI Proposal sudah 'approved', maka status = active (siap diisi).
                            // 3. Sisanya = waiting.
                            
                            if ($budgetStatus === 'done') {
                                $displayStatus = 'done';
                            } elseif ($proposalStatus === 'approved') {
                                $displayStatus = 'active'; 
                            } else {
                                $displayStatus = 'waiting';
                            }
                        @endphp

                        <tr class="hover:bg-gray-50 transition-colors duration-200">
                            {{-- Proposal Title & Code --}}
                            <td class="px-6 py-4">
                                <div class="flex flex-col">
                                    <span class="text-[10px] uppercase tracking-wide font-bold text-gray-400 mb-0.5">
                                        {{ $budget->proposal->registration_code ?? '#CODE-UNKNOWN' }}
                                    </span>
                                    <div class="text-sm font-medium text-gray-900 truncate max-w-xs" title="{{ $budget->proposal->title ?? '-' }}">
                                        {{ $budget->proposal->title ?? '-' }}
                                    </div>
                                </div>
                            </td>

                            {{-- Fund Plan --}}
                            <td class="px-6 py-4 text-gray-500">
                                Rp. {{ number_format($budget->total_plan, 0, ',', '.') }}
                            </td>

                            {{-- Fund Realization --}}
                            <td class="px-6 py-4 text-gray-500">
                                @if($budget->total_realization > 0)
                                    Rp. {{ number_format($budget->total_realization, 0, ',', '.') }}
                                @else
                                    <span class="text-gray-300">-</span>
                                @endif
                            </td>

                            {{-- Remaining Fund --}}
                            <td class="px-6 py-4 text-gray-500">
                                Rp. {{ number_format($budget->remaining_fund, 0, ',', '.') }}
                            </td>

                            {{-- Status Column (Menggunakan $displayStatus) --}}
                            <td class="px-6 py-4 text-center">
                                @if($displayStatus === 'active')
                                    <span class="inline-flex items-center px-2.5 py-0.5 text-xs font-bold text-orange-600 bg-orange-50 rounded-full border border-orange-100">
                                        Active
                                    </span>
                                @elseif($displayStatus === 'done')
                                    <span class="inline-flex items-center px-2.5 py-0.5 text-xs font-bold text-green-600 bg-green-50 rounded-full border border-green-100">
                                        Done
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 text-xs font-bold text-gray-700 bg-gray-100 rounded-full border border-gray-200">
                                        Waiting Approval
                                    </span>
                                @endif
                            </td>

                            {{-- Action Column (Menggunakan $displayStatus) --}}
                            <td class="px-6 py-4 text-center">
                                <div class="flex justify-center items-center gap-2">
                                    
                                    {{-- ACTIVE: Edit Button --}}
                                    @if($displayStatus === 'active')
                                        <a href="{{ route('report.fund.edit', $budget->id) }}" 
                                           class="p-2 bg-orange-500 text-white rounded-lg hover:bg-orange-600 transition shadow-sm hover:shadow-md" 
                                           title="Fill Realization">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                                <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                            </svg>
                                        </a>

                                    {{-- DONE: View & Download Buttons --}}
                                    @elseif($displayStatus === 'done')
                                        <a href="{{ route('report.fund.show', $budget->id) }}" class="p-2 bg-gray-100 text-gray-500 rounded-lg hover:bg-gray-200 border border-gray-200 transition shadow-sm" title="View Detail">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                            </svg>
                                        </a>

                                        <a href="{{ route('report.fund.download', $budget->id) }}" target="_blank" class="p-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition shadow-sm hover:shadow-md inline-flex items-center justify-center" title="Download Report PDF"> 
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                            </svg>
                                        </a>

                                    {{-- WAITING --}}
                                    @else
                                        <span class="text-xs text-gray-400 italic flex items-center gap-1">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                            Waiting
                                        </span>
                                    @endif

                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-10 text-center text-gray-500">
                                <div class="flex flex-col items-center justify-center">
                                    <svg class="w-10 h-10 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                    <p>No proposals found.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="bg-gray-50 px-6 py-4 border-t border-gray-200">
            {{ $budgets->links() }}
        </div>
    </div>
</div>