<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jobifi | Reset Password</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Position */
        #toast-container.toast-top-right {
            top: 80px !important;
            right: 20px !important;
        }

        /* Main Toast */
        #toast-container>.toast,
        #toast-container>.toast-success {
            background: #ffffff !important;
            background-color: #ffffff !important;
            background-image: none !important;

            color: #4b5563 !important;
            border-radius: 14px !important;

            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.12) !important;

            padding: 16px 18px 16px 60px !important;
            min-width: 340px !important;

            position: relative;
        }

        /* Remove toastr default icon */
        .toast-success {
            background-image: none !important;
        }

        /* Custom Success Icon */
        #toast-container>.toast-success::before {
            content: "✓";

            position: absolute;
            left: 18px;
            top: 50%;
            transform: translateY(-50%);

            width: 32px;
            height: 32px;

            border-radius: 50%;
            background: #22c55e;

            color: white;
            font-size: 20px;
            font-weight: bold;
            text-align: center;
            line-height: 32px;
        }

        /* Message */
        .toast-message {
            color: #6b7280 !important;
            font-size: 15px !important;
            font-weight: 500 !important;
        }

        /* Title */
        .toast-title {
            color: #374151 !important;
            font-size: 16px !important;
            font-weight: 600 !important;
        }

        /* Progress Bar */
        .toast-progress {
            background: #22c55e !important;
            opacity: 1 !important;
            height: 4px !important;
        }

        /* Close Button */
        .toast-close-button {
            color: #9ca3af !important;
            font-size: 20px !important;
            font-weight: bold !important;
            right: 10px !important;
            top: 6px !important;
        }

        /* Hover */
        #toast-container>.toast:hover {
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.18) !important;
        }

        /* Error Toast */
        #toast-container>.toast-error {
            background: #ffffff !important;
            background-color: #ffffff !important;
            background-image: none !important;

            color: #4b5563 !important;

            border-left: 5px solid #ef4444 !important;
            border-radius: 14px !important;

            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.12) !important;

            padding: 16px 18px 16px 60px !important;

            position: relative;
        }

        /* Custom Error Icon */
        #toast-container>.toast-error::before {
            content: "✕";

            position: absolute;
            left: 18px;
            top: 50%;
            transform: translateY(-50%);

            width: 32px;
            height: 32px;

            border-radius: 50%;
            background: #ef4444;

            color: white;
            font-size: 18px;
            font-weight: bold;
            text-align: center;
            line-height: 32px;
        }

        /* Error Progress Bar */
        .toast-error .toast-progress {
            background: #ef4444 !important;
            opacity: 1 !important;
        }
</style>
</head>

<body
    class="bg-[#f8f9fa] min-h-screen font-sans text-slate-900 flex items-center justify-center p-6 selection:bg-black selection:text-white">

    {{-- Main Forgot Password Card --}}
    <div class="w-full max-w-[440px] bg-white border border-gray-200 shadow-sm p-10 md:p-12">

        {{-- Header Section --}}
        <div class="text-center mb-8">
            
            {{-- Fixed Brand Logo Element --}}
            <div
                class="inline-flex items-center justify-center text-white font-bold text-xl leading-none tracking-tighter mb-4 shadow-sm mx-auto">
                <x-application-logo class="block h-10 w-auto fill-current text-gray-800 dark:text-gray-200" />
            </div>
            
            <h1 class="text-[28px] font-extrabold text-[#0a192f] tracking-tight leading-tight mb-3">
                Reset Password
            </h1>
            <p class="text-[14px] text-gray-500 leading-relaxed">
                Forgot your password? No problem. Enter your email address and we will send you a password reset link.
            </p>
        </div>

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            {{-- Email Address --}}
            <div class="mb-8">
                <label for="email"
                    class="block text-[11px] font-bold text-[#8ba3b8] uppercase tracking-[0.15em] mb-2.5">
                    Email Address
                </label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                    class="w-full bg-white border {{ $errors->has('email') ? 'border-red-500' : 'border-gray-200' }} px-4 py-3.5 text-[14px] text-slate-700 focus:outline-none focus:border-black focus:ring-0 transition duration-200">
                @error('email')
                    <p class="text-red-500 text-[12px] font-bold mt-2">{{ $message }}</p>
                @enderror
            </div>

            {{-- Submit Action --}}
            <div>
                <button type="submit"
                    class="w-full px-6 py-3.5 bg-black border-2 border-black text-white text-[14px] font-bold hover:bg-[#1a1a1a] transition duration-200 shadow-sm">
                    Send Reset Link
                </button>
            </div>

        </form>

        {{-- Back to Login Link --}}
        <div class="mt-8 pt-6 border-t border-gray-100 text-center">
            <p class="text-[13px] text-gray-500">
                Remembered your password?
                <a href="{{ route('login') }}"
                    class="font-bold text-slate-900 hover:text-black hover:underline transition duration-200">
                    Back to Sign In
                </a>
            </p>
        </div>

    </div>

    {{-- Add jQuery and Toastr JS --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    
    {{-- Toastr Logic --}}
    <script>
        toastr.options = {
            "closeButton": true,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "timeOut": "3000"
        };

        // Laravel Breeze uses session('status') for password reset messages
        @if (session('status'))
            toastr.success("{{ session('status') }}");
        @endif

        @if (session('success'))
            toastr.success("{{ session('success') }}");
        @endif

        @if (session('error'))
            toastr.error("{{ session('error') }}");
        @endif
    </script>
</body>

</html>