@extends('master_index')

@section('title', 'Skills Management')

@section('content')

<div class="space-y-6">

{{-- Page Header --}}
<div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">

    <div>
        <h1 class="text-3xl font-bold text-slate-900 uppercase">
            Skills Management
        </h1>

        <p class="mt-1 text-sm text-slate-500 uppercase">
            Manage the pool of skills available for job seekers and recruiters.
        </p>
    </div>

    <button
        type="button"
        onclick="openModal('skillModal')"
        class="px-5 py-3 bg-black text-white font-semibold uppercase hover:bg-slate-800 transition">
        + Add Skill
    </button>

</div>

{{-- Skills List --}}
<div class="bg-white border border-slate-200 overflow-hidden">

    <div class="px-6 py-4 border-b border-slate-200">
        <h2 class="font-semibold text-xl text-slate-900 uppercase">
            Available Skills
        </h2>
    </div>

    <div class="p-6">

        @if($skills->count())

            <div class="flex flex-wrap gap-3">

                @foreach($skills as $skill)

                    <div
                        class="inline-flex items-center gap-3 px-4 py-1 border border-slate-200 rounded-lg bg-slate-50 hover:bg-slate-100 transition">

                        <span class="text-sm font-medium text-slate-700">
                            {{ $skill->name }}
                        </span>

                        <form action="{{ route('skills.destroy', $skill) }}" method="POST">
                            @csrf
                            @method('DELETE')

                            <button
                                type="submit"
                                class="delete-btn text-slate-400 hover:text-red-500 transition"
                                data-name="{{ $skill->name }} skill">
                                ✕
                            </button>
                        </form>

                    </div>

                @endforeach

            </div>

        @else

            <div class="text-center py-12">

                <p class="text-slate-500">
                    No skills added yet.
                </p>

            </div>

        @endif

    </div>

</div>


</div>

{{-- Add Skill Modal --}}

<div id="skillModal"
    data-modal
    class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50">


<div class="bg-white w-full max-w-md mx-4 shadow-xl rounded-lg">

    {{-- Modal Header --}}
    <div class="flex items-center justify-between px-6 py-4 border-b">

        <h3 class="font-bold text-xl uppercase">
            Add New Skill
        </h3>

        <button
            type="button"
            onclick="closeModal('skillModal')"
            class="text-slate-500 hover:text-black text-xl">
            ✕
        </button>

    </div>

    {{-- Modal Body --}}
    <div class="p-6">

        <form action="{{ route('skills.store') }}" method="POST">

            @csrf

            <div>

                <label
                    class="block text-xs font-bold tracking-wider text-slate-400 uppercase mb-2">
                    Skill Name
                </label>

                <input
                    type="text"
                    name="name"
                    placeholder="e.g. Laravel"
                    required
                    class="w-full border border-slate-300 px-4 py-3 focus:border-black focus:ring-0">

                @error('name')
                    <p class="mt-2 text-sm text-red-500">
                        {{ $message }}
                    </p>
                @enderror

            </div>

            <div class="flex justify-end gap-3 mt-6">

                <button
                    type="button"
                    onclick="closeModal('skillModal')"
                    class="px-4 py-2 border border-slate-300 font-medium">
                    Cancel
                </button>

                <button
                    type="submit"
                    class="px-5 py-2 bg-black text-white font-semibold">
                    Save Skill
                </button>

            </div>

        </form>

    </div>

</div>


</div>

@endsection
