@php
    $page = $page ?? 'final';
@endphp

<h2 class="text-2xl font-bold mb-4">Final Report</h2>
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
                <td class="px-6 py-4 text-center">
                    <!-- <button class="px-4 py-2 text-sm bg-[#D31119] text-white rounded-lg hover:bg-blue-700 transition">
                        Edit
                    </button> -->
                </td>
            </tr>

            <tr>
                <td class="px-6 py-4 text-gray-800"></td>
                <td class="px-6 py-4 text-gray-800"></td>
                <td class="px-6 py-4 text-center">
                    <!-- <button class="px-4 py-2 text-sm bg-[#D31119] text-white rounded-lg hover:bg-blue-700 transition">
                        Edit
                    </button> -->
                </td>
            </tr>

        </tbody>
    </table>