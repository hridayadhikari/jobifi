<!DOCTYPE html>
<html>
<head>
    <title>@yield('title', 'Jobifi')</title>

    @vite(['resources/css/app.css'])
</head>
<body class="bg-gray-100">

    <div class="flex h-screen">

        @include('partials.sidebar')

        <div class="flex-1 flex flex-col">

            @include('partials.navbar')

            <main class="flex-1 p-6 overflow-y-auto">
                @yield('content')
            </main>

        </div>

    </div>

</body>
</html>