<!DOCTYPE html>
<html>

<head>
    <link rel="icon" href="{{ asset('images/loolgo.png') }}">
    <title>@yield('title', 'Jobifi')</title>
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
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

</head>

<body class="bg-gray-100 overflow-hidden">

    <div class="flex h-screen overflow-hidden">

        @include('partials.sidebar')

        <div class="flex-1 flex flex-col min-h-0">

            @include('partials.navbar')

            <main class="flex-1 p-6 overflow-y-auto min-h-0">
                @yield('content')
            </main>

        </div>

    </div>
    <script type="module" src="https://unpkg.com/ionicons@8.0.13/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@8.0.13/dist/ionicons/ionicons.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
        toastr.options = {
            "closeButton": true,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "timeOut": "3000"
        };

        @if (session('success'))
            toastr.success("{{ session('success') }}");
        @endif

        @if (session('error'))
            toastr.error("{{ session('error') }}");
        @endif

        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.delete-btn').forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();

                    const form = this.closest('form');
                    if (!form) {
                        return;
                    }

                    const itemName = this.dataset.name || 'this item';

                    Swal.fire({
                        title: 'Are you sure?',
                        text: `Are you sure you want to delete "${itemName}"`,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#dc2626',
                        cancelButtonText: 'Cancel',
                        confirmButtonText: 'Delete'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });
        });
    </script>
    <script>
        window.openModal = function(modalId) {
            const modal = document.getElementById(modalId);

            if (modal) {
                modal.classList.remove('hidden');
                modal.classList.add('flex');
            }
        }

        window.closeModal = function(modalId) {
            const modal = document.getElementById(modalId);

            if (modal) {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            }
        }

        document.addEventListener('click', function(e) {
            const modal = e.target.closest('[data-modal]');

            if (modal && e.target === modal) {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            }
        });
    </script>


</body>

</html>
