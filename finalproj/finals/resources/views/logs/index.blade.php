@extends('layouts.app')

@section('title', 'System Logs')

@section('page-title', 'System Logs')

@section('content')
    <div class="bg-white p-6 rounded-lg shadow-lg">
        <div class="flex justify-between items-center mb-4">
            <form action="{{ route('logs.index') }}" method="GET" class="w-full max-w-sm">
                <div class="flex items-center border-b border-gray-300 py-2">
                    <input class="appearance-none bg-transparent border-none w-full text-gray-700 mr-3 py-1 px-2 leading-tight focus:outline-none" type="text" name="search" placeholder="Search action or user..." value="{{ request('search') }}">
                    <button class="flex-shrink-0 bg-transparent hover:bg-gray-100 text-gray-500 hover:text-gray-800 text-sm py-1 px-2 rounded" type="submit">
                        Search
                    </button>
                </div>
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date & Time</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User (Joined)</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                    </tr>
                </thead>
                <tbody class="bg-white">
                    @forelse($logs as $log)
                    <tr class="border-b border-gray-200 hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                            <!-- This will now work because of the $casts in the Log model -->
                            {{ $log->date_time->format('M d, Y h:i A') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-8 w-8">
                                    <!-- UPDATED: Use $log->profile_image -->
                                    <img class="h-8 w-8 rounded-full object-cover" src="{{ $log->profile_image ? asset('storage/' . $log->profile_image) : 'https://placehold.co/32x32/EBF4FF/7F9CF5?text=' . strtoupper(substr($log->full_name ?? 'S', 0, 1)) }}" alt="">
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">
                                        <!-- UPDATED: Use $log->full_name -->
                                        {{ $log->full_name ?? 'System / Deleted User' }}
                                    </div>
                                    <div class="text-sm text-gray-600">
                                        <!-- UPDATED: Use $log->role -->
                                        {{ $log->role ?? '-' }}
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-900">
                            {{ $log->action }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="px-6 py-4 text-center text-gray-500">No logs found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $logs->links() }}
        </div>
    </div>
@endsection