<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('profile') }}
        </h2>
    </x-slot>
</x-app-layout>

<div class="pt-24 flex justify-center">
    <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg p-8 
                max-w-xl w-full text-center">

<div class="w-40 h-40 rounded-full overflow-hidden mx-auto border-2 border-gray-300">
    @if ($user->photo)
        <img src="{{ asset('storage/profile/' . $user->photo) }}"
             alt="Profile Photo"
             class="w-full h-full object-cover">
    @else
        {{-- Default Avatar --}}
        <img src="{{ asset('images/default-avatar.png') }}"
             alt="Default Avatar"
             class="w-full h-full object-cover">
    @endif
</div>


        <div class="mt-10 space-y-6 text-left mx-auto w-3/4">
            <div>
                <p class="text-gray-500 dark:text-gray-400 text-sm">Name</p>
                    <p class="text-gray-800 dark:text-gray-200 font-semibold">
                    {{ $user->name ?? '-' }}
                </p>
            </div>
            <div>
                <p class="text-gray-500 dark:text-gray-400 text-sm">No. Telephone</p>
                <p class="text-gray-800 dark:text-gray-200 font-semibold">
                 {{ $user->notelp ?? '-' }}
                </p>
            </div>
            <div>
                <p class="text-gray-500 dark:text-gray-400 text-sm">Institution</p>
                <p class="text-gray-800 dark:text-gray-200 font-semibold">
                    {{ $user->institution ?? '-' }}
                </p>
            </div>
        </div>

        <a href="editprofile"
           class="block mt-10 px-10 py-3 bg-[#D31119] text-white font-semibold 
                  rounded-lg shadow-md hover:bg-[#b20e14] mx-auto w-fit">
            Edit My Personal Data
        </a><br>

        <div class="flex items-center gap-3">

        {{-- Language --}}
       <a href="admin/logout"
        class="mx-auto w-fit px-5 py-2 rounded-md flex items-center gap-2 font-semibold
        shadow-sm border border-red-600 text-red-600 bg-transparent
        hover:bg-red-50 transition-all duration-200 transition-all duration-200
        {{ request()->routeIs('profile') ? 'bg-red-600 text-red-600 shadow-md border-red-600' : 'bg-gray-200 text-black' }}">
            <i class="fa-solid fa-right-from-bracket"></i> Logout
        </a>
    </div>
    </div>
</div>

