{{-- FILE: resources/views/components/sidebar.blade.php --}}

<div id="sidebar" style="position: fixed; left: 0; top: 0; height: 100%; width: 250px; background-color: #ffffff; color: #1f2937; display: flex; flex-direction: column; padding: 20px 25px; transform: translateX(-100%); transition: transform 0.3s ease; z-index: 1200; box-shadow: 3px 0 8px rgba(0,0,0,0.05); border-right: 1px solid #e5e7eb;">
    
    {{-- Tombol Close (X) --}}
    <button id="closeSidebar" aria-label="Close menu" style="position:absolute; right:12px; top:12px; background:transparent; border:none; color:#4b5563; font-size:26px; cursor:pointer;">&times;</button>

    {{-- LOGO --}}
    <a href="/dashboard" style="display: flex; align-items: center; margin-bottom: 30px; text-decoration: none; gap: 12px; padding-top: 5px;">
        <img src="{{ asset('images/icon-epronoc.png') }}" alt="E-PRONOC logo" style="width: 32px; height: auto; object-fit: contain;" />
        <h2 style="font-size: 22px; line-height: 1; margin: 0; letter-spacing: -0.5px;">
            <span style="font-weight: 800; color: #1f2937;">E-</span><span style="font-weight: 900; color: #dc2626;">PRONOC</span>
        </h2>
    </a>

    {{-- NAVIGASI --}}
    <nav style="display: flex; flex-direction: column; gap: 6px;">
        
        {{-- 0. Dashboard (BARU DITAMBAHKAN) --}}
        <a href="/dashboard-peneliti" class="sidebar-link">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
            </svg>
            <span>Dashboard</span>
        </a>

        {{-- 1. Profil --}}
        <a href="#" class="sidebar-link">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
            </svg>
            <span>Profil</span>
        </a>

        {{-- 2. Proposal --}}
        <a href="/proposal-submission" class="sidebar-link">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
            <span>Proposal</span>
        </a>

        {{-- 3. Progress Report --}}
        <a href="/progress" class="sidebar-link">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
            </svg>
            <span>Progress Report</span>
        </a>

        {{-- 4. Fund Realization --}}
        <a href="/fund-realization-report" class="sidebar-link">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span>Fund Realization</span>
        </a>

        {{-- 5. Final Report --}}
        <a href="/final" class="sidebar-link">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
            </svg>
            <span>Final Report</span>
        </a>
    </nav>

    {{-- Logout Link --}}
    <a href="#" class="sidebar-link mt-auto pt-5 border-t border-gray-200">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
        </svg>
        <span>Logout</span>
    </a>
</div>

{{-- STYLE UPDATE: Added Flexbox for alignment --}}
<style>
    .sidebar-link {
        display: flex;
        align-items: center;
        gap: 12px;
        color: #4b5563; /* Gray-600 */
        padding: 10px 12px;
        font-size: 15px;
        text-decoration: none;
        font-weight: 500;
        border-radius: 8px;
        transition: all 0.2s;
    }
    
    /* Warna icon default */
    .sidebar-link svg {
        color: #6b7280; /* Gray-500 */
        transition: color 0.2s;
    }

    /* Efek Hover */
    .sidebar-link:hover {
        background-color: #fef2f2; /* Red-50 (Very light red) */
        color: #dc2626; /* Red-600 */
    }
    
    .sidebar-link:hover svg {
        color: #dc2626;
    }
    
    /* Margin top auto helper for layout */
    .mt-auto { margin-top: auto; }
</style>

<div id="overlay" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.4); z-index:900; cursor:pointer;"></div>

{{-- SCRIPT --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('overlay');
        const hamburger = document.getElementById('hamburger'); 
        const closeBtn = document.getElementById('closeSidebar');

        function toggleSidebar(show) {
            if (show) {
                sidebar.style.transform = 'translateX(0)';
                overlay.style.display = 'block';
                if(hamburger) hamburger.setAttribute('aria-expanded', 'true');
            } else {
                sidebar.style.transform = 'translateX(-100%)';
                overlay.style.display = 'none';
                if(hamburger) hamburger.setAttribute('aria-expanded', 'false');
            }
        }

        if (hamburger) {
            hamburger.addEventListener('click', (e) => {
                e.stopPropagation();
                const isOpen = sidebar.style.transform === 'translateX(0px)' || sidebar.style.transform === 'translateX(0%)';
                toggleSidebar(!isOpen);
            });
        }

        if (closeBtn) {
            closeBtn.addEventListener('click', () => toggleSidebar(false));
        }

        overlay.addEventListener('click', () => toggleSidebar(false));
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') toggleSidebar(false);
        });
    });
</script>