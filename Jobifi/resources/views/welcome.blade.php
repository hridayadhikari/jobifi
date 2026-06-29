<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jobifi | Start Your Career Journey</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <style>
      
        .bg-dots {
            background-image: radial-gradient(#e5e7eb 1px, transparent 1px);
            background-size: 20px 20px;
        }
    </style>
</head>
<body class="bg-[#f8f9fa] min-h-screen font-sans text-slate-900 selection:bg-black selection:text-white">

    {{-- Navigation --}}
    <nav class="fixed top-0 left-0 w-full bg-white/80 backdrop-blur-md border-b border-gray-200 z-50">
        <div class="max-w-[1200px] mx-auto px-6 h-20 flex items-center justify-between">
            
            {{-- Logo --}}
            <div class="flex items-center gap-2">
                <x-application-logo class="block h-10 w-auto fill-current text-gray-800 dark:text-gray-200" />
            </div>

            {{-- Auth Links --}}
            <div class="flex items-center gap-4">
                @auth
                    <a href="{{ url('/dashboard') }}" class="text-[13px] font-bold text-slate-600 hover:text-black uppercase tracking-wider transition">
                        Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}" class="hidden md:inline-block text-[13px] font-bold text-slate-600 hover:text-black uppercase tracking-wider transition">
                        Sign In
                    </a>
                    <a href="{{ route('register') }}" class="px-6 py-2.5 bg-black text-white text-[13px] font-bold hover:bg-[#1a1a1a] transition duration-200">
                        Get Started
                    </a>
                @endauth
            </div>

        </div>
    </nav>

    {{-- Hero Section --}}
    <section class="pt-32 pb-20 px-6 bg-dots relative overflow-hidden">
        <div class="max-w-[1200px] mx-auto grid grid-cols-1 lg:grid-cols-2 gap-16 items-center pt-10">
            
            {{-- Copy --}}
            <div class="relative z-10">
                <p class="text-[11px] font-bold text-[#8ba3b8] uppercase tracking-[0.2em] mb-4">
                    The Modern Hiring Platform
                </p>
                <h1 class="text-[48px] md:text-[64px] font-extrabold text-[#0a192f] tracking-tighter leading-[1.05] mb-6">
                    Find Your Dream Job with Jobifi.
                </h1>
                <p class="text-[17px] text-gray-500 leading-relaxed mb-10 max-w-md">
                    Connecting talented professionals with top employers. A streamlined, secure, and beautiful platform to manage your career journey.
                </p>
                
                <div class="flex flex-col sm:flex-row items-center gap-4">
                    <a href="{{ route('register') }}" class="w-full sm:w-auto px-8 py-3.5 bg-black border-2 border-black text-white text-[14px] font-bold text-center hover:bg-[#1a1a1a] transition duration-200">
                        Start Searching
                    </a>
                    <a href="{{ route('login') }}" class="w-full sm:w-auto px-8 py-3.5 bg-white border-2 border-gray-200 text-black text-[14px] font-bold text-center hover:border-black transition duration-200">
                        Post a Job
                    </a>
                </div>
            </div>

            {{-- Abstract UI Illustration --}}
            <div class="relative hidden lg:block h-[500px]">
                {{-- Decorative elements imitating the dashboard UI --}}
                <div class="absolute top-10 right-0 w-80 bg-white border border-gray-200 shadow-xl p-6 transform rotate-3 hover:rotate-0 transition duration-500 z-20">
                    <div class="flex items-center gap-4 mb-4">
                        <div class="w-10 h-10 bg-gray-100 rounded-full"></div>
                        <div>
                            <div class="h-3 w-24 bg-gray-200 rounded mb-2"></div>
                            <div class="h-2 w-16 bg-gray-100 rounded"></div>
                        </div>
                    </div>
                    <div class="inline-block border border-black px-3 py-1 text-[10px] font-bold text-black uppercase tracking-widest mt-2">
                        Shortlisted
                    </div>
                </div>

                <div class="absolute top-40 right-20 w-80 bg-white border border-gray-200 shadow-xl p-6 transform -rotate-2 hover:rotate-0 transition duration-500 z-10">
                    <h3 class="text-[11px] font-bold text-[#8ba3b8] uppercase tracking-[0.15em] mb-4">
                        New Job Match
                    </h3>
                    <p class="text-[18px] font-extrabold text-slate-900 leading-none mb-1">
                        Senior UI Designer
                    </p>
                    <p class="text-[13px] text-gray-500 mb-4">Stripe Inc. &middot; San Francisco</p>
                    <div class="h-10 w-full bg-black text-white flex items-center justify-center text-[12px] font-bold">
                        Apply Now
                    </div>
                </div>

                <div class="absolute bottom-10 right-10 w-64 bg-white border border-gray-200 shadow-xl p-6 z-30">
                    <h3 class="text-[10px] font-bold text-[#8ba3b8] uppercase tracking-[0.15em] mb-2">
                        Profile Views
                    </h3>
                    <p class="text-[36px] font-extrabold text-slate-900 leading-none">
                        156
                    </p>
                </div>
            </div>

        </div>
    </section>

    {{-- Dynamic Live Stats Section --}}
    <section class="py-12 border-y border-gray-200 bg-white">
        <div class="max-w-[1200px] mx-auto px-6">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8 divide-x divide-gray-100 text-center">
                
                <div>
                    <p class="text-[32px] md:text-[40px] font-extrabold text-slate-900 tracking-tight">
                        {{ $jobsCount ?? '1,204' }}
                    </p>
                    <p class="text-[11px] font-bold text-[#8ba3b8] uppercase tracking-[0.15em] mt-1">
                        Active Jobs
                    </p>
                </div>

                <div>
                    <p class="text-[32px] md:text-[40px] font-extrabold text-slate-900 tracking-tight">
                        {{ $companiesCount ?? '342' }}
                    </p>
                    <p class="text-[11px] font-bold text-[#8ba3b8] uppercase tracking-[0.15em] mt-1">
                        Companies
                    </p>
                </div>

                <div>
                    <p class="text-[32px] md:text-[40px] font-extrabold text-slate-900 tracking-tight">
                        {{ $seekersCount ?? '8,590' }}
                    </p>
                    <p class="text-[11px] font-bold text-[#8ba3b8] uppercase tracking-[0.15em] mt-1">
                        Professionals
                    </p>
                </div>

                <div>
                    <p class="text-[32px] md:text-[40px] font-extrabold text-slate-900 tracking-tight">
                        {{ $applicationsCount ?? '24.5k' }}
                    </p>
                    <p class="text-[11px] font-bold text-[#8ba3b8] uppercase tracking-[0.15em] mt-1">
                        Applications
                    </p>
                </div>

            </div>
        </div>
    </section>

    {{-- Features: Why Jobifi? --}}
    <section class="py-24 px-6 bg-[#f8f9fa]">
        <div class="max-w-[1200px] mx-auto">
            
            <div class="text-center mb-16">
                <h2 class="text-[32px] font-extrabold text-[#0a192f] tracking-tight">Why Jobifi?</h2>
                <p class="text-[15px] text-gray-500 mt-2">Tools designed for modern professionals and modern hiring.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                
                {{-- Feature 1 --}}
                <div class="bg-white border border-gray-200 shadow-sm p-8 hover:border-gray-400 transition duration-300">
                    <ion-icon name="search-outline" class="text-3xl text-black mb-6"></ion-icon>
                    <h3 class="text-[15px] font-bold text-slate-900 mb-2">Smart Job Search</h3>
                    <p class="text-[13px] text-gray-500 leading-relaxed">
                        Filter by location, role, and requirements to instantly find the perfect match for your skillset.
                    </p>
                </div>

                {{-- Feature 2 --}}
                <div class="bg-white border border-gray-200 shadow-sm p-8 hover:border-gray-400 transition duration-300">
                    <ion-icon name="paper-plane-outline" class="text-3xl text-black mb-6"></ion-icon>
                    <h3 class="text-[15px] font-bold text-slate-900 mb-2">Easy Applications</h3>
                    <p class="text-[13px] text-gray-500 leading-relaxed">
                        Apply to top companies with a single click using your securely stored digital resume and profile.
                    </p>
                </div>

                {{-- Feature 3 --}}
                <div class="bg-white border border-gray-200 shadow-sm p-8 hover:border-gray-400 transition duration-300">
                    <ion-icon name="grid-outline" class="text-3xl text-black mb-6"></ion-icon>
                    <h3 class="text-[15px] font-bold text-slate-900 mb-2">Recruiter Dashboard</h3>
                    <p class="text-[13px] text-gray-500 leading-relaxed">
                        A dedicated suite for employers to post jobs, review candidates, and manage the hiring pipeline.
                    </p>
                </div>

                {{-- Feature 4 --}}
                <div class="bg-white border border-gray-200 shadow-sm p-8 hover:border-gray-400 transition duration-300">
                    <ion-icon name="shield-checkmark-outline" class="text-3xl text-black mb-6"></ion-icon>
                    <h3 class="text-[15px] font-bold text-slate-900 mb-2">Secure Authentication</h3>
                    <p class="text-[13px] text-gray-500 leading-relaxed">
                        Enterprise-grade security ensuring your personal data and company information remain private.
                    </p>
                </div>

            </div>

        </div>
    </section>

    {{-- How It Works --}}
    <section class="py-24 px-6 bg-white border-t border-gray-200">
        <div class="max-w-[1000px] mx-auto">
            
            <div class="text-center mb-16">
                <h2 class="text-[32px] font-extrabold text-[#0a192f] tracking-tight">How It Works</h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 relative">
                
                {{-- Decorative Line (Hidden on Mobile) --}}
                <div class="hidden md:block absolute top-6 left-10 right-10 h-0.5 bg-gray-100 z-0"></div>

                {{-- Step 1 --}}
                <div class="relative z-10 text-center flex flex-col items-center">
                    <div class="w-12 h-12 bg-black text-white rounded-full flex items-center justify-center text-[18px] font-bold mb-6 border-4 border-white shadow-sm">
                        1
                    </div>
                    <h3 class="text-[14px] font-bold text-slate-900 mb-2">Create Account</h3>
                    <p class="text-[13px] text-gray-500 px-4">Sign up as a seeker or an employer in seconds.</p>
                </div>

                {{-- Step 2 --}}
                <div class="relative z-10 text-center flex flex-col items-center">
                    <div class="w-12 h-12 bg-white text-black border border-gray-200 rounded-full flex items-center justify-center text-[18px] font-bold mb-6 shadow-sm">
                        2
                    </div>
                    <h3 class="text-[14px] font-bold text-slate-900 mb-2">Build Profile</h3>
                    <p class="text-[13px] text-gray-500 px-4">Upload your resume or set up your company details.</p>
                </div>

                {{-- Step 3 --}}
                <div class="relative z-10 text-center flex flex-col items-center">
                    <div class="w-12 h-12 bg-white text-black border border-gray-200 rounded-full flex items-center justify-center text-[18px] font-bold mb-6 shadow-sm">
                        3
                    </div>
                    <h3 class="text-[14px] font-bold text-slate-900 mb-2">Apply / Post</h3>
                    <p class="text-[13px] text-gray-500 px-4">Start discovering opportunities or finding talent.</p>
                </div>

                {{-- Step 4 --}}
                <div class="relative z-10 text-center flex flex-col items-center">
                    <div class="w-12 h-12 bg-white text-black border border-gray-200 rounded-full flex items-center justify-center text-[18px] font-bold mb-6 shadow-sm">
                        4
                    </div>
                    <h3 class="text-[14px] font-bold text-slate-900 mb-2">Track Progress</h3>
                    <p class="text-[13px] text-gray-500 px-4">Manage statuses directly from your dashboard.</p>
                </div>

            </div>

        </div>
    </section>

    {{-- CTA Section --}}
    <section class="py-24 px-6 bg-black text-white text-center">
        <div class="max-w-[800px] mx-auto">
            <h2 class="text-[36px] md:text-[48px] font-extrabold tracking-tight mb-6 leading-tight">
                Start Your Career Journey Today.
            </h2>
            <p class="text-[16px] text-gray-400 mb-10 max-w-lg mx-auto">
                Join thousands of professionals and top-tier companies building the future of work on Jobifi.
            </p>
            <a href="{{ route('register') }}" class="inline-block px-10 py-4 bg-white text-black text-[15px] font-bold hover:bg-gray-100 transition duration-200 shadow-lg">
                Create Your Free Account
            </a>
        </div>
    </section>

    {{-- Minimal Footer --}}
    <footer class="bg-white border-t border-gray-200 py-8 px-6 text-center">
        <p class="text-[12px] font-bold text-gray-400 uppercase tracking-widest">
            &copy; {{ date('Y') }} Jobifi Platform. All rights reserved.
        </p>
    </footer>

</body>
</html>