@extends('master_index')

@section('title', 'My Applications')

@section('content')

<div class="bg-[#f8f9fa] min-h-screen font-sans py-16 px-6">

    <div class="max-w-[1100px] mx-auto">

        {{-- Page Header --}}
        <h1 class="text-[32px] font-extrabold text-[#0a192f] tracking-tight mb-8">
            My Applications
        </h1>

        {{-- Table Container --}}
        <div class="bg-white border border-gray-200 shadow-sm overflow-hidden">

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">

                    {{-- Table Header --}}
                    <thead>
                        <tr class="border-b border-gray-100">
                            <th class="px-8 py-5 text-[11px] font-bold text-[#8ba3b8] uppercase tracking-[0.15em]">
                                Job / Company
                            </th>
                            <th class="px-8 py-5 text-[11px] font-bold text-[#8ba3b8] uppercase tracking-[0.15em]">
                                Date Applied
                            </th>
                            <th class="px-8 py-5 text-[11px] font-bold text-[#8ba3b8] uppercase tracking-[0.15em]">
                                Status
                            </th>
                            <th class="px-8 py-5 text-[11px] font-bold text-[#8ba3b8] uppercase tracking-[0.15em] text-right">
                                Action
                            </th>
                        </tr>
                    </thead>

                    {{-- Table Body --}}
                    <tbody class="divide-y divide-gray-100">

                        @forelse ($applications as $application)
                            <tr class="hover:bg-gray-50/50 transition duration-200">
                                <td class="px-8 py-6">
                                    <p class="text-[15px] font-bold text-slate-900">
                                        {{ $application->job->title ?? 'N/A' }}
                                    </p>
                                    <p class="text-[13px] text-gray-500 mt-0.5">
                                        {{ $application->job->company->name ?? 'N/A' }}
                                    </p>
                                </td>
                                <td class="px-8 py-6 text-[14px] text-gray-500">
                                    {{ $application->created_at->format('M d, Y') }}
                                </td>
                                <td class="px-8 py-6">
                                    <span class="inline-block border border-black px-3 py-1 text-[12px] font-medium text-black">
                                        {{ $application->status }}
                                    </span>
                                </td>
                                <td class="px-8 py-6 text-right">
                                    <a href="#" class="text-[14px] font-bold text-slate-800 hover:text-black transition">
                                    <a href="{{ route('seeker.applications.show', $application->id) }}" class="text-[14px] font-bold text-slate-800 hover:text-black transition">
                                        View Details
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-8 py-10 text-center text-[14px] text-gray-500">
                                    You haven't applied to any jobs yet.
                                </td>
                            </tr>
                        @endforelse

                    </tbody>
                </table>
            </div>

        </div>

        {{-- Pagination Links --}}
        @if ($applications->hasPages())
            <div class="mt-8">
                {{ $applications->links() }}
            </div>
        @endif

    </div>
</div>

@endsection