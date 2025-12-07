@php
    $page = $page ?? 'list';
@endphp

<h2 class="text-2xl font-bold mb-4">Project List</h2>
<div class="overflow-x-auto">
    <table class="min-w-full bg-white border border-gray-200 rounded-lg shadow">
        <thead>
            <tr class="bg-gray-100 border-b">
                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Title</th>
                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Team</th>
                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Status</th>
                <th class="px-6 py-3 text-center text-sm font-semibold text-gray-700">Action</th>
            </tr>
        </thead>

        <tbody class="divide-y divide-gray-200">
            <tr>
                <td class="px-6 py-4 text-gray-800"></td>
                <td class="px-6 py-4 text-gray-800"></td>
                <td class="px-6 py-4">
                    <!-- <span class="px-3 py-1 text-sm bg-green-100 text-green-700 rounded-full">
                        Approved
                    </span> -->
                </td>
                <!-- <td class="px-6 py-4 text-center">
                    <button class="px-4 py-2 text-sm bg-[#D31119] text-white rounded-lg hover:bg-blue-700 transition">
                        Edit
                    </button>
                </td> -->
            </tr>

            <tr>
                <td class="px-6 py-4 text-gray-800"></td>
                <td class="px-6 py-4 text-gray-800"></td>
                <td class="px-6 py-4">
                    <!-- <span class="px-3 py-1 text-sm bg-yellow-100 text-yellow-700 rounded-full">
                        Pending
                    </span> -->
                </td>
                <!-- <td class="px-6 py-4 text-center">
                    <button class="px-4 py-2 text-sm bg-[#D31119] text-white rounded-lg hover:bg-blue-700 transition">
                        Edit
                    </button>
                </td> -->
            </tr>

        </tbody>
    </table>
   
 