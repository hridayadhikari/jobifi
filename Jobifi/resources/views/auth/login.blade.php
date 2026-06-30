<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="icon" href="{{ asset('images/loolgo.png') }}">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jobifi | Sign In</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body
    class="bg-[#f8f9fa] min-h-screen font-sans text-slate-900 flex items-center justify-center p-6 selection:bg-black selection:text-white">

    {{-- Main Login Card --}}
    <div class="w-full max-w-[440px] bg-white border border-gray-200 shadow-sm p-10 md:p-12">

        {{-- Header Section --}}
        <div class="text-center mb-10">

            {{-- Fixed Brand Logo Element --}}
            <div
                class="inline-flex items-center justify-center   text-white font-bold text-xl leading-none tracking-tighter mb-4 shadow-sm mx-auto">
                <x-application-logo class="block h-10 w-auto fill-current text-gray-800 dark:text-gray-200" />
            </div>

            <h1 class="text-[28px] font-extrabold text-[#0a192f] tracking-tight leading-tight mb-2">
                Welcome Back
            </h1>
            <p class="text-[14px] text-gray-500">
                Sign in to continue to Jobifi.
            </p>
        </div>

        {{-- Session Status Alert --}}
        @if (session('status'))
            <div
                class="mb-6 p-4 bg-green-50 border border-green-200 text-sm font-bold text-green-700 uppercase tracking-wide rounded-sm">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            {{-- Email Address --}}
            <div class="mb-6">
                <label for="email"
                    class="block text-[11px] font-bold text-[#8ba3b8] uppercase tracking-[0.15em] mb-2.5">
                    Email Address
                </label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                    autocomplete="username"
                    class="w-full bg-white border {{ $errors->has('email') ? 'border-red-500' : 'border-gray-200' }} px-4 py-3.5 text-[14px] text-slate-700 focus:outline-none focus:border-black focus:ring-0 transition duration-200">
                @error('email')
                    <p class="text-red-500 text-[12px] font-bold mt-2">{{ $message }}</p>
                @enderror
            </div>

            {{-- Password --}}
            <div class="mb-6">
                <div class="flex justify-between items-center mb-2.5">
                    <label for="password"
                        class="block text-[11px] font-bold text-[#8ba3b8] uppercase tracking-[0.15em]">
                        Password
                    </label>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}"
                            class="text-[11px] font-bold text-gray-400 hover:text-black uppercase tracking-wider transition duration-200">
                            Forgot?
                        </a>
                    @endif
                </div>
                <input id="password" type="password" name="password" required autocomplete="current-password"
                    class="w-full bg-white border {{ $errors->has('password') ? 'border-red-500' : 'border-gray-200' }} px-4 py-3.5 text-[14px] text-slate-700 focus:outline-none focus:border-black focus:ring-0 transition duration-200">
                @error('password')
                    <p class="text-red-500 text-[12px] font-bold mt-2">{{ $message }}</p>
                @enderror
            </div>

            {{-- Remember Me --}}
            <div class="mb-8 flex items-center">
                <input id="remember_me" type="checkbox" name="remember"
                    class="w-4 h-4 text-black border-gray-300 rounded-sm focus:ring-black focus:ring-offset-0 transition duration-200 cursor-pointer">
                <label for="remember_me" class="ml-2 block text-[13px] font-semibold text-slate-700 cursor-pointer">
                    Keep me logged in
                </label>
            </div>

            {{-- Submit Action --}}
            <div>
                <button type="submit"
                    class="w-full px-6 py-3.5 bg-black border-2 border-black text-white text-[14px] font-bold hover:bg-[#1a1a1a] transition duration-200 shadow-sm">
                    Log In
                </button>
            </div>

        </form>

        {{-- Optional Registration Link --}}
        @if (Route::has('register'))
            <div class="mt-8 pt-6 border-t border-gray-100 text-center">
                <p class="text-[13px] text-gray-500">
                    Don't have an account?
                    <a href="{{ route('register') }}"
                        class="font-bold text-slate-900 hover:text-black hover:underline transition duration-200">
                        Get Started
                    </a>
                </p>
            </div>
        @endif

    </div>

</body>

</html>
