<!DOCTYPE html>
<html>

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
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

        #loader {
            position: fixed;
            inset: 0;
            z-index: 99999;
            background: rgba(255, 255, 255, 0.45);
            backdrop-filter: blur(3px);

            display: flex;
            justify-content: center;
            align-items: center;

            transition: all .5s ease;
        }

        .loader-content {
            text-align: center;
        }

        .loader-content img {
            width: 90px;
            height: 90px;
            margin: auto;
            animation: float 2s ease-in-out infinite;
        }

        .loader-content h2 {
            margin-top: 15px;
            font-size: 22px;
            font-weight: 700;
            letter-spacing: 4px;
            color: #111827;
        }

        .progress-container {
            width: 220px;
            height: 6px;

            background: #e5e7eb;
            border-radius: 999px;

            overflow: hidden;

            margin-top: 20px;
        }

        .progress-bar {
            height: 100%;
            width: 0%;

            background: #111827;

            border-radius: 999px;

            animation: loading 3s ease forwards;
        }

        @keyframes loading {

            from {
                width: 0%;
            }

            to {
                width: 100%;
            }

        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-8px);
            }

        }

        .loader-hidden {
            opacity: 0;
            visibility: hidden;
        }
    </style>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.2/cropper.min.css">

</head>

<body class="bg-gray-100 overflow-hidden">
    <div id="loader">

        <div class="loader-content">

            <img src="{{ asset('images/loolgo.png') }}" alt="Jobifi">
            <div class="progress-container">
                <div class="progress-bar"></div>
            </div>

        </div>

    </div>

    <div class="flex h-screen overflow-hidden">

        @include('partials.sidebar')

        <div class="flex-1 flex flex-col min-h-0">

            @include('partials.navbar')

            <main class="flex-1 p-6 overflow-y-auto min-h-0">
                {{ $slot ?? '' }}
                @yield('content')
            </main>

        </div>

    </div>
    <script type="module" src="https://unpkg.com/ionicons@8.0.13/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@8.0.13/dist/ionicons/ionicons.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.2/cropper.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script>
        window.addEventListener('load', () => {

            setTimeout(() => {

                document
                    .getElementById('loader')
                    .classList
                    .add('loader-hidden');

            }, 10);

        });
    </script>
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
                        text: `Are you sure you want to Delete "${itemName}"`,
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
    <script>
        document.querySelectorAll('.withdraw-btn').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();

                const form = this.closest('form');
                const jobTitle = this.dataset.name || 'this position';
                Swal.fire({
                    title: 'Change of plans?',
                    text: `Your application for "${jobTitle}" will be withdrawn and recruiters will no longer consider it.`,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#111827',
                    cancelButtonColor: '#9ca3af',
                    confirmButtonText: 'Withdraw Application',
                    cancelButtonText: 'Stay Applied'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });

        $(document).on('click', '.no-company', function (e) {
    e.preventDefault();

    Swal.fire({
        icon: 'info',
        title: 'Company Not Found',
        text: "This recruiter hasn't created a company profile yet.",
        confirmButtonColor: '#111827'
    });
});
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const notifButton = document.getElementById('notificationButton');
            const notifDropdown = document.getElementById('notificationDropdown');
            const closeDropdownBtn = document.getElementById('closeNotificationDropdown');

            if (notifButton && notifDropdown) {
                // Toggle dropdown on bell icon click
                notifButton.addEventListener('click', function(e) {
                    e.stopPropagation(); // Prevents the click from bubbling up to the document
                    notifDropdown.classList.toggle('hidden');
                });

                // Optional: Close dropdown when the "X" button is clicked
                if (closeDropdownBtn) {
                    closeDropdownBtn.addEventListener('click', function(e) {
                        e.stopPropagation();
                        notifDropdown.classList.add('hidden');
                    });
                }

                // Close dropdown when clicking outside of it
                document.addEventListener('click', function(e) {
                    if (!notifDropdown.contains(e.target) && !notifButton.contains(e.target)) {
                        notifDropdown.classList.add('hidden');
                    }
                });
            }
        });
    </script>
    <script>
        function loadNotifications() {

            $.ajax({

                url: "{{ route('notifications.fetch') }}",
                type: "GET",

                success: function(response) {

                    let html = "";

                    if (response.notifications.length === 0) {
                        let icon = "notifications-outline";

                        switch (notification.type) {

                            case "application":
                                icon = "briefcase-outline";
                                break;

                            case "interview":
                                icon = "chatbubble-outline";
                                break;

                            case "job":
                                icon = "sparkles-outline";
                                break;

                            case "alert":
                                icon = "alert-circle-outline";
                                break;

                            case "reminder":
                                icon = "time-outline";
                                break;

                        }

                        html = `
                    <div class="flex flex-col items-center justify-center py-10 px-6 text-center">
                        <ion-icon
                            name="notifications-off-outline"
                            class="text-4xl text-gray-300 mb-3">
                        </ion-icon>

                        <h4 class="text-[13px] font-bold text-gray-600">
                            No notifications yet
                        </h4>

                        <p class="mt-1 text-[11px] text-gray-400">
                            We'll notify you when something important happens.
                        </p>
                    </div>
                `;

                    } else {

                        response.notifications.forEach(function(notification) {

                            html += `
<a href="${notification.url ?? '#'}"
   data-id="${notification.id}"
   data-read="${notification.is_read}"
   class="notification-item flex items-start gap-4 p-5 hover:bg-gray-50 transition relative bg-white">

    ${
        !notification.is_read
        ? `<div class="absolute left-2 top-1/2 -translate-y-1/2 w-1.5 h-1.5 bg-black rounded-full"></div>`
        : ''
    }

    <div class="w-8 h-8 rounded border border-gray-200 bg-gray-50 flex items-center justify-center shrink-0">
        <ion-icon name="${icon}" class="text-gray-500"></ion-icon>
    </div>

    <div>
        <h4 class="text-[13px] font-bold text-slate-900 mb-0.5">
            ${notification.title}
        </h4>

        <p class="text-[12px] text-gray-500 leading-snug">
            ${notification.message}
        </p>

        <span class="block mt-2 text-[9px] font-bold text-gray-400 uppercase tracking-widest">
            ${notification.time}
        </span>
    </div>

</a>
                    `;
                        });

                    }

                    $("#notificationList").html(html);

                    if (response.unreadCount > 0) {
                        $(".notification-count")
                            .text(response.unreadCount)
                            .removeClass("hidden");
                    } else {
                        $(".notification-count")
                            .text(0)
                            .addClass("hidden");
                    }

                },

                error: function(error) {
                    console.error(error);
                }

            });

        }
        loadNotifications();

        setInterval(function() {

            loadNotifications();

        }, 1000);

        $("#notificationButton").on("click", function() {

            loadNotifications();

        });

        $(document).on("click", ".notification-item", function(e) {
            e.preventDefault();


            let id = $(this).data("id");

            $.ajax({
                url: "/notifications/" + id + "/read",
                type: "POST",
                data: {
                    _token: $('meta[name="csrf-token"]').attr("content")
                },
                success: function() {

                    let badges = $(".notification-count");
                    let count = parseInt(badges.first().text()) || 0;

                    let newCount = Math.max(count - 1, 0);

                    if (newCount > 0) {
                        badges.text(newCount).removeClass("hidden");
                    } else {
                        badges.addClass("hidden");
                    }

                    // Optional: visually mark this notification as read
                    // $(this).attr("data-read", "true");

                    // Sync with server in background
                    loadNotifications();
                    window.location.href = url;
                }
            });

        });

        $("#markAllRead").click(function() {

            $.ajax({

                url: "{{ route('notifications.readAll') }}",
                type: "POST",
                data: {
                    _token: $('meta[name="csrf-token"]').attr("content")
                },
                success: function(response) {

                    // Instantly update all unread count badges
                    $(".notification-count").text(0);

                    // Refresh notifications from server
                    loadNotifications();

                },

                error: function(xhr) {

                    console.error(xhr);

                }

            });

        });

        $("#clearAll").click(function() {

            Swal.fire({
                title: "Clear all notifications?",
                text: "This action cannot be undone.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#111827",
                cancelButtonColor: "#d1d5db",
                confirmButtonText: "Yes, clear all",
                cancelButtonText: "Cancel",
                reverseButtons: true
            }).then((result) => {

                if (result.isConfirmed) {

                    $.ajax({

                        url: "/notifications",
                        type: "DELETE",

                        data: {
                            _token: $('meta[name="csrf-token"]').attr("content")
                        },

                        success: function() {

                            $(".notification-count").text(0);

                            loadNotifications();

                            Swal.fire({
                                icon: "success",
                                title: "Notifications Cleared",
                                text: "All notifications have been removed.",
                                timer: 1800,
                                showConfirmButton: false
                            });

                        },

                        error: function(xhr) {

                            console.error(xhr);

                            Swal.fire({
                                icon: "error",
                                title: "Oops!",
                                text: "Unable to clear notifications."
                            });

                        }

                    });

                }

            });

        });
    </script>

    {{-- Global image crop modal (Cropper.js) --}}
    @include('partials.crop-modal')

</body>

</html>
