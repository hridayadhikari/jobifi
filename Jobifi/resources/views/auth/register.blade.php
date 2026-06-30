<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="{{ asset('images/loolgo.png') }}">
    <title>Jobifi | Create an Account</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</head>

<body
    class="bg-[#f8f9fa] min-h-screen font-sans text-slate-900 flex items-center justify-center p-4 selection:bg-black selection:text-white">

    {{-- Compact Register Card --}}
    <div class="w-full max-w-[600px] bg-white border border-gray-200 shadow-sm p-8">

        {{-- Header Section --}}
        <div class="text-center mb-8">
            {{-- Smaller Brand Logo --}}
            <div class="inline-flex items-center justify-center   text-white font-bold text-xl leading-none tracking-tighter mb-4 shadow-sm mx-auto">
                 <x-application-logo class="block h-10 w-auto fill-current text-gray-800 dark:text-gray-200" />
            </div>
            <h1 class="text-[24px] font-extrabold text-[#0a192f] tracking-tight leading-none mb-1.5">
                Create an Account
            </h1>
            <p class="text-[13px] text-gray-500">
                Join Jobifi to find your next opportunity or top talent.
            </p>
        </div>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            {{-- Grid Layout to save vertical space --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-5 gap-y-4">
                
                {{-- Name --}}
                <div>
                    <label for="name" class="block text-[10px] font-bold text-[#8ba3b8] uppercase tracking-[0.15em] mb-2">
                        Full Name
                    </label>
                    <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name"
                        class="w-full bg-white border {{ $errors->has('name') ? 'border-red-500' : 'border-gray-200' }} px-3 py-2.5 text-[14px] text-slate-700 focus:outline-none focus:border-black focus:ring-0 transition duration-200">
                    @error('name')
                        <p class="text-red-500 text-[11px] font-bold mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Email Address --}}
                <div>
                    <label for="email" class="block text-[10px] font-bold text-[#8ba3b8] uppercase tracking-[0.15em] mb-2">
                        Email Address
                    </label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username"
                        class="w-full bg-white border {{ $errors->has('email') ? 'border-red-500' : 'border-gray-200' }} px-3 py-2.5 text-[14px] text-slate-700 focus:outline-none focus:border-black focus:ring-0 transition duration-200">
                    @error('email')
                        <p class="text-red-500 text-[11px] font-bold mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Role Selection (Full Width) --}}
                <div class="md:col-span-2">
                    <label for="role" class="block text-[10px] font-bold text-[#8ba3b8] uppercase tracking-[0.15em] mb-2">
                        I want to...
                    </label>
                    <div class="relative">
                        <select id="role" name="role" required
                            class="w-full appearance-none bg-white border {{ $errors->has('role') ? 'border-red-500' : 'border-gray-200' }} px-3 py-2.5 pr-10 text-[14px] text-slate-700 focus:outline-none focus:border-black focus:ring-0 transition duration-200 cursor-pointer rounded-none">
                            <option value="" disabled {{ old('role') ? '' : 'selected' }}>Select an account type</option>
                            <option value="seeker" {{ old('role') == 'seeker' ? 'selected' : '' }}>Find a Job (Job Seeker)</option>
                            <option value="recruiter" {{ old('role') == 'recruiter' ? 'selected' : '' }}>Hire Talent (Recruiter)</option>
                        </select>
                        <ion-icon name="chevron-down-outline" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none"></ion-icon>
                    </div>
                    @error('role')
                        <p class="text-red-500 text-[11px] font-bold mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Password --}}
                <div>
                    <label for="password" class="block text-[10px] font-bold text-[#8ba3b8] uppercase tracking-[0.15em] mb-2">
                        Password
                    </label>
                    <input id="password" type="password" name="password" required autocomplete="new-password"
                        class="w-full bg-white border {{ $errors->has('password') ? 'border-red-500' : 'border-gray-200' }} px-3 py-2.5 text-[14px] text-slate-700 focus:outline-none focus:border-black focus:ring-0 transition duration-200">
                    @error('password')
                        <p class="text-red-500 text-[11px] font-bold mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Confirm Password --}}
                <div>
                    <label for="password_confirmation" class="block text-[10px] font-bold text-[#8ba3b8] uppercase tracking-[0.15em] mb-2">
                        Confirm Password
                    </label>
                    <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                        class="w-full bg-white border {{ $errors->has('password_confirmation') ? 'border-red-500' : 'border-gray-200' }} px-3 py-2.5 text-[14px] text-slate-700 focus:outline-none focus:border-black focus:ring-0 transition duration-200">
                    @error('password_confirmation')
                        <p class="text-red-500 text-[11px] font-bold mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

            </div>

            {{-- Submit Action --}}
            <div class="mt-6">
                <button type="submit"
                    class="w-full px-6 py-3 bg-black border-2 border-black text-white text-[13px] font-bold hover:bg-[#1a1a1a] transition duration-200 shadow-sm">
                    Create Account
                </button>
            </div>

        </form>

        {{-- Login Link --}}
        @if (Route::has('login'))
            <div class="mt-6 pt-5 border-t border-gray-100 text-center">
                <p class="text-[12px] text-gray-500">
                    Already registered?
                    <a href="{{ route('login') }}"
                        class="font-bold text-slate-900 hover:text-black hover:underline transition duration-200">
                        Log In
                    </a>
                </p>
            </div>
        @endif

    </div>

</body>

</html>