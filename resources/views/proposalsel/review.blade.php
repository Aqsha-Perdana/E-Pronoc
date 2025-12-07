@php
    $page = $page ?? 'review';
@endphp
<h2 class="text-2xl font-bold mb-4">Need to be Reviewed</h2>
<table class="min-w-full bg-white border border-gray-200 rounded-lg shadow">
    <thead>
        <tr class="bg-gray-100 border-b">
            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">No</th>
            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Proposal Information</th>
            <th class="px-6 py-3 text-center text-sm font-semibold text-gray-700">Action</th>
            </tr>
    </thead>

    <tbody class="divide-y divide-gray-200">
        <tr>
            <td class="px-6 py-4 text-gray-800"></td>
            <td class="px-6 py-4 text-gray-800"></td>
            <td class="px-6 py-4 text-center space-y-2 w-40">
                <!-- <button class="w-full flex items-center justify-center gap-2 py-2 bg-gray-200 text-gray-900 rounded-md font-semibold hover:bg-gray-700 transition">
                    <span>Detail</span>
                </button> <br>
                 <button class=" w-full flex items-center justify-center gap-2 py-2 bg-green-600 text-white rounded-md font-semibold hover:bg-green-700 transition">
                    
                    <span>Accept</span>
                </button> <br>
                <button class="w-full flex items-center justify-center gap-2 py-2 bg-red-600 text-white rounded-md font-semibold hover:bg-red-700 transition">
                  
                    <span>Reject</span>
                </button> -->
            </td>
        </tr>

        <tr>
            <td class="px-6 py-4 text-gray-800"></td>
            <td class="px-6 py-4 text-gray-800"></td>
            <td class="px-6 py-4 text-center space-y-2 w-40">
                <!-- <button class="w-full flex items-center justify-center gap-2 py-2 bg-gray-200 text-gray-900 rounded-md font-semibold hover:bg-gray-700 transition">
                   
                    <span>Detail</span>
                </button> <br>
                 <button class=" w-full flex items-center justify-center gap-2 py-2 bg-green-600 text-white rounded-md font-semibold hover:bg-green-700 transition">
                    
                    <span>Accept</span>
                </button> <br>
                <button class="w-full flex items-center justify-center gap-2 py-2 bg-red-600 text-white rounded-md font-semibold hover:bg-red-700 transition">
                    
                    <span>Reject</span>
                </button> -->
            </td>
        </tr>

    </tbody>
</table>

