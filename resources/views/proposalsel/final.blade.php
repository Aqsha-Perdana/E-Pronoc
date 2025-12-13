@php
    $page = $page ?? 'final';
 $proposal = \App\Models\Proposal::with('budgets')
        ->where('status', 'SUBMITTED')
        ->orderBy('created_at', 'desc')
        ->get();

    $proposals = \App\Models\Proposal::with('teams.member') // eager loading
        ->where('status', 'SUBMITTED')
        ->orderBy('created_at', 'desc')
        ->get();
@endphp
<h2 class="text-2xl font-bold mb-4">Final Report</h2>
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
        <tr>
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
            <td class="px-6 py-4 text-center align-top">
                <div class="flex flex-col gap-1.5">
                    <button class="px-3 py-1.5 text-xs bg-gray-200 text-gray-900 rounded font-medium hover:bg-gray-300 transition flex items-center justify-center gap-1">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                        <span>Detail Report</span>
                    </button>
                    
                    <button class="px-3 py-1.5 text-xs bg-red-600 text-white rounded font-medium hover:bg-red-700 transition flex items-center justify-center gap-1">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span>Add Review</span>
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