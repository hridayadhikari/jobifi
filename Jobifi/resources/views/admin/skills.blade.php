@extends('master_index')


@section('title', 'Skills Management')

@section('content')
<div class="space-y-6">

    {{-- Page Header --}}
    <div>
        <h1 class="text-2xl font-bold text-slate-900">
            Skills Management
        </h1>
        <p class="mt-0.5 text-sm text-slate-500">
            Manage the pool of skills available for job seekers and recruiters.
        </p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        {{-- Add Skill Card --}}
        <div class="bg-white border border-slate-200 overflow-hidden">
            
            <div class="px-6 py-4 border-b border-slate-200">
                <h2 class="font-semibold text-lg text-slate-900 uppercase tracking-wide">
                    Add New Skill
                </h2>
            </div>

            <div class="p-6">

                <form action="{{ route('skills.store') }}" method="POST">
                    @csrf

                    <div class="flex gap-3">

                        <input
                            type="text"
                            name="name"
                            placeholder="e.g. TypeScript"
                            class="flex-1 border border-slate-300 focus:border-black focus:ring-black"
                            required
                        >

                        <button
                            type="submit"
                            class="px-6 py-3 bg-black text-white font-semibold hover:bg-slate-800 transition">
                            ADD
                        </button>

                    </div>

                    @error('name')
                        <p class="mt-2 text-sm text-red-500">
                            {{ $message }}
                        </p>
                    @enderror

                </form>

            </div>

        </div>

        {{-- Skills List Card --}}
        <div class="bg-white border border-slate-200 overflow-hidden">

            <div class="px-6 py-4 border-b border-slate-200">
                <h2 class="font-semibold text-lg text-slate-900 uppercase tracking-wide">
                    Available Skills
                </h2>
            </div>

            <div class="p-6">

                <div class="flex flex-wrap gap-3">

                    @forelse($skills as $skill)
                        <div class="inline-flex items-center gap-3 px-4 py-2 border border-slate-200 rounded-lg bg-slate-50">
                            <span class="text-sm font-medium text-slate-700">
                                {{ $skill->name }}
                            </span>

                            <form action="{{ route('skills.destroy', $skill) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="delete-btn text-slate-400 hover:text-red-500 transition"
                                        data-name="{{ $skill->name }} skill">
                                    ✕
                                </button>
                            </form>
                        </div>
                    @empty
                        <p class="text-slate-500 text-sm">
                            No skills added yet.
                        </p>
                    @endforelse

                </div>

            </div>

        </div>

    </div>

</div>
@endsection