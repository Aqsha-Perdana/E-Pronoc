<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('dashboard') }}
        </h2>
    </x-slot>
</x-app-layout>

@php
    // Jika $skills belum didefinisikan oleh controller, ambil dari user yang login (jika tersedia).
    if (!isset($skills)) {
        if (auth()->check() && method_exists(auth()->user(), 'skills')) {
            $skills = auth()->user()->skills()->get();
        } else {
            $skills = collect();
        }
    }

    // Normalisasi: dukung Collection of models, array, atau plain strings.
    $skillsData = collect($skills)->map(function ($s) {
        if (is_array($s)) {
            return [
                'id' => $s['id'] ?? null,
                'skill' => $s['skill'] ?? ($s[0] ?? '')
            ];
        }
        if (is_object($s)) {
            // Model instance
            return [
                'id' => $s->id ?? null,
                'skill' => $s->skill ?? ''
            ];
        }
        // plain string
        return [
            'id' => null,
            'skill' => (string) $s
        ];
    })->values()->toArray();
@endphp

<div class="pt-24">
    <div class="max-w-screen-3xl mx-auto sm:px-6 lg:px-8">

        <!-- GRID 3 KOLOM PADA DESKTOP (1:profil, 2:konten kanan) -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            <!-- BAGIAN KIRI (Profil) -->
            <div class="flex justify-center">
                <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg p-6 w-full text-center">

                    <div class="w-40 h-40 rounded-full overflow-hidden mx-auto border-2 border-gray-300">
                        @if ($user->photo)
                            <img src="{{ asset('storage/profile/' . $user->photo) }}"
                                 alt="Profile Photo"
                                 class="w-full h-full object-cover">
                        @else
                            <img src="{{ asset('images/default-avatar.png') }}"
                                 alt="Default Avatar"
                                 class="w-full h-full object-cover">
                        @endif
                    </div>

                    <div class="mt-10 space-y-6 text-left mx-auto w-3/4">
                        <div>
                            <p class="text-gray-500 text-sm">Name</p>
                            <p class="font-semibold">{{ $user->name ?? '-' }}</p>
                        </div>

                        <div>
                            <p class="text-gray-500 text-sm">Email</p>
                            <p class="font-semibold">{{ $user->email ?? '-' }}</p>
                        </div>

                        <div>
                            <p class="text-gray-500 text-sm">No. Telephone</p>
                            <p class="font-semibold">{{ $user->notelp ?? '-' }}</p>
                        </div>

                        <div>
                            <p class="text-gray-500 text-sm">Institution</p>
                            <p class="font-semibold">{{ $user->institution ?? '-' }}</p>
                        </div>
                    </div>

                    <a href="{{ route('editprofile') }}"
                       class="block mt-10 px-10 py-3 bg-[#D31119] text-white font-semibold 
                              rounded-lg hover:bg-[#b20e14] mx-auto w-fit">
                        Edit My Personal Data
                    </a><br>
                    <a href="admin/logout"
                    class="mx-auto w-fit px-5 py-2 rounded-md flex items-center gap-2 font-semibold
                    shadow-sm border border-red-600 text-red-600 bg-transparent
                    hover:bg-red-50 transition-all duration-200 transition-all duration-200
                    {{ request()->routeIs('profile') ? 'bg-red-600 text-red-600 shadow-md border-red-600' : 'bg-gray-200 text-black' }}">
                    <i class="fa-solid fa-right-from-bracket"></i> Logout
        </a>

                </div>
            </div>

            <!-- BAGIAN KANAN (Isinya 3 kotak) -->
            <div class="lg:col-span-2 flex flex-col gap-6">

                <!-- Keahlian -->
              <!-- KEAHLIAN (card + modal dalam 1 Alpine) -->
<div x-data="{
        open: false,
        skills: {{ json_encode($skillsData) }},
        newSkill: ''
    }"
    class="bg-white dark:bg-gray-800 shadow-lg rounded-2xl p-6 relative border"
>

    <!-- Header -->
    <div class="flex justify-between items-center mb-4">
        <h3 class="text-xl font-bold">Keahlian</h3>

        <button @click="open = true"
                class="p-2 rounded-full hover:bg-blue-100 text-blue-600 transition">
            ✏️
        </button>
    </div>

    <!-- List Skill -->
    <div class="flex flex-wrap gap-2">
        <template x-for="skill in skills" :key="skill.id">
            <span class="px-3 py-1 bg-blue-50 text-blue-700 rounded-full text-sm"
                  x-text="skill.skill"></span>
        </template>
    </div>

    <!-- MODAL -->
    <div 
        x-cloak
        x-show="open"
        x-transition.opacity
        class="fixed inset-0 bg-black/50 z-[9999] flex items-center justify-center"
        @click.self="open = false"
    >
        <div 
            x-transition
            class="bg-white dark:bg-gray-900 w-96 rounded-2xl shadow-xl p-6"
            @click.stop
        >
            <h2 class="text-xl font-semibold mb-4">Edit Keahlian</h2>

            <!-- Input -->
            <div class="flex">
                <input 
                    x-ref="skillInput"
                    type="text"
                    class="w-full border px-3 py-2 rounded-lg bg-gray-50"
                >

                <button 
                    @click="
                        if ($refs.skillInput.value.trim() !== '') {
                            skills.push({ id: null, skill: $refs.skillInput.value.trim() });
                            $refs.skillInput.value='';
                        }
                    "
                    class="ml-2 px-4 py-2 bg-blue-600 text-white rounded-lg"
                >
                    Tambah
                </button>
            </div>

            <!-- Daftar skill dalam modal -->
            <div class="mt-4 space-y-2 max-h-40 overflow-y-auto">
                <template x-for="(skill, index) in skills" :key="index">
                    <div class="flex justify-between bg-gray-100 p-2 rounded-lg">
                        <span x-text="skill.skill"></span>

                        <button 
                            @click="skills.splice(index, 1)"
                            class="text-red-500 text-sm"
                        >
                            Hapus
                        </button>
                    </div>
                </template>
            </div>

            <!-- Tombol -->
            <div class="mt-5 text-right">
                <button 
    @click="
        fetch('{{ route('skills.updateSkills') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ skills })
        })
        .then(res => res.json())
        .then(data => {
            console.log(data);
            open = false;
        });
    "
    class="px-4 py-2 bg-gray-600 text-white rounded-lg"
>
    Selesai
</button>

            </div>
        </div>
    </div>

</div>



                <!-- Recent Proposal -->
                <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg p-6 min-h-[200px]">
                    <h3 class="text-lg font-bold mb-4">Recent Proposal</h3>
                    <p class="text-gray-600 dark:text-gray-300">Isinya notifikasi proposal masuk</p>
                </div>

                <!-- Aktivitas -->
                <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg p-6 min-h-[300px]">
                    <h3 class="text-lg font-bold mb-4">Aktivitas anda selama 30 hari terakhir</h3>
                </div>

            </div>

        </div>
    </div>
</div>
