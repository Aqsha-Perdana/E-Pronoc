<header class="fixed top-0 left-0 w-full z-50 bg-white shadow-sm py-4 px-6 flex items-center justify-between h-15">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <script src="//unpkg.com/alpinejs" defer></script>
    <style>[x-cloak]{ display:none !important }</style>


    {{-- Logo --}}
    <div class="flex items-center gap-2">
        <img src="/images/image.png" alt="Logo" class="h-12">
    </div>

    {{-- Navigation --}}
    <nav class="flex items-center gap-4">

        <a href="{{ route('dashboard') }}"
            class="px-5 py-2 rounded-md flex items-center gap-2
          {{ request()->routeIs('dashboard') ? 'bg-red-600 text-white' : 'bg-gray-200 text-black' }}">

        <i class="fa-solid fa-house 
        {{ request()->routeIs('dashboard') ? 'text-white' : 'text-black' }}">
        </i> Dashboard 
    </a>


        <a href="{{ route('proposal') }}"
           class="px-5 py-2 rounded-md flex items-center gap-2 
           {{ request()->routeIs('proposal') ? 'bg-red-600 text-white' : 'bg-gray-200 text-black' }}">
            <i class="fa-solid fa-folder"></i> Proposal: Selection
        </a>

        <a href="{{ route('information') }}"
           class="px-5 py-2 rounded-md flex items-center gap-2 
           {{ request()->routeIs('information') ? 'bg-red-600 text-white' : 'bg-gray-200 text-black' }}">
            <i class="fa-solid fa-circle-info"></i> Information Center
        </a>
        <a href="{{ route('profile') }}"
           class="px-5 py-2 rounded-md flex items-center gap-2 
           {{ request()->routeIs('profile') ? 'bg-red-600 text-white' : 'bg-gray-200 text-black' }}">
            <i class="fa-etch fa-solid fa-user"></i> Profile
        </a>
    </nav>

    <div class="flex items-center gap-3">
    </div>

    
</header>
