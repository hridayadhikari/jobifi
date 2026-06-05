@extends('master_index')

@section('title', 'Admin Dashboard')

@section('content')

<div class="space-y-6">

<!-- Welcome Section -->
<div class="bg-white rounded-xl shadow p-6">
    <h1 class="text-3xl font-bold text-gray-800">
        Welcome Back, {{ Auth::user()->name }} 👋
    </h1>

    <p class="text-gray-500 mt-2">
        Find and apply for your dream job today.
    </p>
</div>

</div>

@endsection
