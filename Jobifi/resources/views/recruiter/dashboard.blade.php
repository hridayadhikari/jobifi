@extends('master_index')

@section('title', 'Recruiter Dashboard')

@section('content')

<div class="space-y-6">


<div class="bg-white rounded-xl shadow p-6">
    <h1 class="text-3xl font-bold text-gray-800">
        Welcome Back, {{ Auth::user()->name }} 👋
    </h1>

    
</div>



</div>

@endsection
