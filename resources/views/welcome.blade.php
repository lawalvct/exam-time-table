<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>AAP Exam & Timetable System</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased text-gray-900 bg-gray-50 flex flex-col min-h-screen">
    
    <!-- Header -->
    <header class="bg-white shadow">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex justify-between items-center">
            <div class="flex items-center">
                <a href="/" class="flex items-center gap-3">
                    <x-application-logo class="h-12 w-auto" />
                    <span class="font-bold text-xl text-[#008751]">Abraham Adesanya Polytechnic</span>
                </a>
            </div>
            
            <nav class="flex gap-4">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" class="font-semibold text-gray-600 hover:text-[#008751] transition">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="font-semibold text-gray-600 hover:text-[#008751] transition">Log in</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="font-semibold text-white bg-[#008751] hover:bg-green-800 px-4 py-2 rounded-md transition">Register</a>
                        @endif
                    @endauth
                @endif
            </nav>
        </div>
    </header>

    <!-- Main Content -->
    <main class="flex-grow flex flex-col justify-center items-center px-4 sm:px-6 lg:px-8 relative overflow-hidden">
        <!-- Background Decoration -->
        <div class="absolute top-0 left-0 w-full h-full opacity-5 pointer-events-none" style="background-image: url('data:image/svg+xml,%3Csvg width=\'60\' height=\'60\' viewBox=\'0 0 60 60\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'none\' fill-rule=\'evenodd\'%3E%3Cg fill=\'%23008751\' fill-opacity=\'1\'%3E%3Cpath d=\'M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>
        
        <div class="max-w-3xl w-full text-center z-10 py-16">
            <h1 class="text-4xl sm:text-5xl font-extrabold text-gray-900 mb-6 tracking-tight">
                Welcome to the <span class="text-[#008751]">AAP</span> Examination & Timetable System
            </h1>
            <p class="text-lg sm:text-xl text-gray-600 mb-10 leading-relaxed">
                Streamlining exam hall allocation, timetable generation, and operational efficiency for the School of Technology, Abraham Adesanya Polytechnic, Ijebu-Igbo.
            </p>
            
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                @auth
                    <a href="{{ url('/dashboard') }}" class="inline-flex justify-center items-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-[#008751] hover:bg-green-800 shadow-lg transition transform hover:-translate-y-0.5">
                        Go to Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}" class="inline-flex justify-center items-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-[#008751] hover:bg-green-800 shadow-lg transition transform hover:-translate-y-0.5">
                        Log in to Portal
                    </a>
                    <a href="{{ route('register') }}" class="inline-flex justify-center items-center px-6 py-3 border border-[#E3000F] text-base font-medium rounded-md text-[#E3000F] bg-white hover:bg-red-50 shadow-md transition transform hover:-translate-y-0.5">
                        Create an Account
                    </a>
                @endauth
            </div>
        </div>
        
        <!-- Features Grid -->
        <div class="max-w-5xl w-full grid grid-cols-1 md:grid-cols-3 gap-8 mt-12 pb-16 z-10">
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 border-t-4 border-t-[#008751]">
                <h3 class="text-xl font-bold text-gray-900 mb-2">Smart Timetabling</h3>
                <p class="text-gray-600">Automatically generates conflict-free schedules based on courses, hall capacities, and constraints.</p>
            </div>
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 border-t-4 border-t-[#E3000F]">
                <h3 class="text-xl font-bold text-gray-900 mb-2">Hall Allocation</h3>
                <p class="text-gray-600">Optimizes physical spaces to prevent overcrowding and ensure comfortable examination environments.</p>
            </div>
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 border-t-4 border-t-gray-800">
                <h3 class="text-xl font-bold text-gray-900 mb-2">Easy Publishing</h3>
                <p class="text-gray-600">Export, print, and securely publish finalised timetables for students and invigilators.</p>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-gray-900 text-gray-300 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row justify-between items-center gap-4">
            <div class="flex items-center gap-3">
                <x-application-logo class="h-8 w-auto grayscale opacity-75" />
                <span class="font-semibold text-white">AAP Ijebu-Igbo</span>
            </div>
            <p class="text-sm">
                &copy; {{ date('Y') }} Abraham Adesanya Polytechnic. All rights reserved.
            </p>
        </div>
    </footer>
    
</body>
</html>