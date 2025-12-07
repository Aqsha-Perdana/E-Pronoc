@extends('components.app')

@section('konten')
<section class="hero-section">
        <div class="container">
            <div class="hero-card">
                <div class="hero-content">
                    <!-- Left Content -->
                    <div class="hero-text">
                        <p class="welcome-text">Halo, Selamat Datang di <span class="highlight">E-PRONOC</span></p>
                        
                        <h1 class="hero-title">
                            Kolaborasi Lebih Mudah,<br>
                            Persetujuan Lebih Cepat
                        </h1>
                        
                        <p class="hero-description">
                            <span class="highlight">e-Pronoc</span> (Proposal NOC Elektronik) adalah sistem digital yang
                            dirancang untuk mempermudah proses pengajuan, pengelolaan, dan
                            persetujuan proposal NOC secara terintegrasi. Aplikasi ini
                            menghadirkan solusi dalam tiga mitra utama yang membaca sistem
                            pengajuan — dari tahapan proposal — mulai dari pengajuan, verifikasi,
                            hingga pelaporan — secara cepat, transparan, dan terdokumentasi
                            dengan baik.
                        </p><br>
                    </div>

                    <!-- Right Content - Logo Indonesia -->
                    <div class="hero-logo">
                        <img src="{{ asset('images/logo NOA Indonesia.png') }}" alt="Logo Indonesia NOC" class="indonesia-logo">
                    </div>
                </div>


<!-- Section Visi & Misi -->
    <div class="container mx-auto px-6">
        <h1 class="text-3xl font-bold text-center text-gray-800 mb-12">Visi & Misi</h1>

        <div class="grid md:grid-cols-2 gap-10">
            <!-- Visi -->
            <div class="p-8 bg-gray-50 rounded-xl shadow hover:shadow-lg transition">
                <h2 class="text-xl font-semibold text-red-600 mb-3">Visi</h2>
                <p class="text-gray-600 leading-relaxed">
                    Menjadi platform pengelolaan proposal NOC terbaik yang memberikan 
                    kecepatan, transparansi, dan kemudahan bagi seluruh mitra.
                </p>
            </div>

            <!-- Misi -->
            <div class="p-8 bg-gray-50 rounded-xl shadow hover:shadow-lg transition">
                <h2 class="text-xl font-semibold text-red-600 mb-3">Misi</h2>
                <ul class="text-gray-600 space-y-2 list-disc ml-5">
                    <li>Menyediakan sistem pengajuan proposal yang terstandarisasi.</li>
                    <li>Mempercepat proses persetujuan melalui digitalisasi.</li>
                    <li>Meningkatkan transparansi dan akuntabilitas proses NOC.</li>
                    <li>Mempermudah akses informasi terkait status proposal.</li>
                </ul>
            </div><br>
        </div>
    </div>

<!-- Section Our Team -->
    <div class="container mx-auto px-6">

        <h2 class="text-3xl font-bold text-center text-gray-800 mb-4">
            Tim Kami
        </h2>

        <div class="grid md:grid-cols-3 gap-10">
            <!-- Team Member 1 -->
            <div class="bg-gray-50 p-8 rounded-xl shadow hover:shadow-lg transition text-center">
                <img 
                    src="{{ asset('images/team1.png') }}" 
                    class="w-32 h-32 rounded-full mx-auto mb-5 object-cover shadow"
                    alt="Team Member 1">

                <h3 class="text-xl font-semibold text-gray-800">Muhammad Aqsha Perdana</h3>
                <p class="text-red-600 font-medium mb-3">Fullstack Developer</p>
            </div>

            <!-- Team Member 2 -->
            <div class="bg-gray-50 p-8 rounded-xl shadow hover:shadow-lg transition text-center">
                <img 
                    src="{{ asset('images/team2.jpg') }}" 
                    class="w-32 h-32 rounded-full mx-auto mb-5 object-cover shadow"
                    alt="Team Member 2">

                <h3 class="text-xl font-semibold text-gray-800">Muhammad Ridho Febriansyah</h3>
                <p class="text-red-600 font-medium mb-3">Fullstack Developer</p>
            </div>

            <!-- Team Member 3 -->
            <div class="bg-gray-50 p-8 rounded-xl shadow hover:shadow-lg transition text-center">
                <img 
                    src="{{ asset('images/team3.jpg') }}" 
                    class="w-32 h-32 rounded-full mx-auto mb-5 object-cover shadow"
                    alt="Team Member 3">

                <h3 class="text-xl font-semibold text-gray-800">Diaz Wirda Ramadhani</h3>
                <p class="text-red-600 font-medium mb-3">Fullstack Developer</p>
            </div>

            <div class="bg-gray-50 p-8 rounded-xl shadow hover:shadow-lg transition text-center">
                <img 
                    src="{{ asset('images/team3.jpg') }}" 
                    class="w-32 h-32 rounded-full mx-auto mb-5 object-cover shadow"
                    alt="Team Member 3">

                <h3 class="text-xl font-semibold text-gray-800">Rahendra Narends Hendrata</h3>
                <p class="text-red-600 font-medium mb-3">Bussiness Analyst</p>
            </div>

            <div class="bg-gray-50 p-8 rounded-xl shadow hover:shadow-lg transition text-center">
                <img 
                    src="{{ asset('images/team3.jpg') }}" 
                    class="w-32 h-32 rounded-full mx-auto mb-5 object-cover shadow"
                    alt="Team Member 3">

                <h3 class="text-xl font-semibold text-gray-800">Hafiz Alfurqan</h3>
                <p class="text-red-600 font-medium mb-3">Bussiness Analyst</p>
            </div>



        </div>

    </div>


                
@endsection