@extends('layouts.app')

@section('title', 'System Logs')

@section('page-title', 'System Logs')

@section('content')
<div class="space-y-6">
    {{-- Header Card --}}
    <div class="bg-white dark:bg-dark-card rounded-2xl shadow-sm border border-gray-100 dark:border-dark-border p-6">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div class="flex items-center space-x-4">
                <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-[#0f2744] to-[#0e7490] flex items-center justify-center shadow-lg shadow-cyan-500/30">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
                <div>
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white">Activity Logs</h2>
                    <p class="text-gray-500 dark:text-gray-400 text-sm">System activity and user actions</p>
                </div>
            </div>
            
            {{-- Search --}}
            <form action="{{ route('logs.index') }}" method="GET" class="flex-1 max-w-md">
                <div class="relative">
                    <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    <input type="text" name="search" value="{{ request('search') }}" 
                           placeholder="Search action or user..." 
                           class="w-full pl-12 pr-4 py-3 rounded-xl border border-gray-200 dark:border-dark-border bg-gray-50 dark:bg-dark-bg text-gray-900 dark:text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 transition-all duration-300">
                </div>
            </form>
        </div>
    </div>

    {{-- Logs Table --}}
    <div class="bg-white dark:bg-dark-card rounded-2xl shadow-sm border border-gray-100 dark:border-dark-border overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-gray-50 dark:bg-dark-bg border-b border-gray-100 dark:border-dark-border">
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Date & Time</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">User</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-dark-border">
                    @forelse($logs as $index => $log)
                    <tr class="hover:bg-gray-50 dark:hover:bg-dark-border/30 transition-colors" style="animation: slideUp 0.3s ease-out {{ $index * 0.05 }}s both;">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="w-8 h-8 rounded-lg bg-slate-100 dark:bg-slate-800 flex items-center justify-center mr-3">
                                    <svg class="w-4 h-4 text-slate-500 dark:text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                                <span class="text-sm text-gray-600 dark:text-gray-400">{{ $log->date_time->format('M d, Y h:i A') }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                @if($log->user && $log->user->profile_image)
                                    <img class="h-10 w-10 rounded-xl object-cover shadow-sm" src="{{ asset('storage/' . $log->user->profile_image) }}" alt="">
                                @else
                                    <div class="h-10 w-10 rounded-xl bg-gradient-to-br from-slate-500 to-slate-700 flex items-center justify-center shadow-sm">
                                        <span class="text-white font-bold text-sm">{{ strtoupper(substr($log->user->full_name ?? 'S', 0, 1)) }}</span>
                                    </div>
                                @endif
                                <div class="ml-4">
                                    <div class="text-sm font-semibold text-gray-900 dark:text-white">
                                        {{ $log->user->full_name ?? 'System / Deleted User' }}
                                    </div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400">
                                        @php
                                            $roleColors = [
                                                'admin' => 'text-red-500',
                                                'employee' => 'text-blue-500',
                                                'customer' => 'text-green-500',
                                            ];
                                            $userRole = $log->user->role ?? null;
                                        @endphp
                                        <span class="{{ $roleColors[$userRole] ?? 'text-gray-500' }}">{{ ucfirst($userRole ?? '-') }}</span>
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                @php
                                    $actionIcons = [
                                        'login' => ['icon' => 'M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1', 'color' => 'text-green-500 bg-green-100 dark:bg-green-900/30'],
                                        'logout' => ['icon' => 'M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1', 'color' => 'text-amber-500 bg-amber-100 dark:bg-amber-900/30'],
                                        'created' => ['icon' => 'M12 6v6m0 0v6m0-6h6m-6 0H6', 'color' => 'text-blue-500 bg-blue-100 dark:bg-blue-900/30'],
                                        'updated' => ['icon' => 'M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z', 'color' => 'text-purple-500 bg-purple-100 dark:bg-purple-900/30'],
                                        'deleted' => ['icon' => 'M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16', 'color' => 'text-red-500 bg-red-100 dark:bg-red-900/30'],
                                    ];
                                    $actionType = 'created';
                                    foreach (array_keys($actionIcons) as $type) {
                                        if (str_contains(strtolower($log->action), $type)) {
                                            $actionType = $type;
                                            break;
                                        }
                                    }
                                @endphp
                                <div class="w-8 h-8 rounded-lg {{ $actionIcons[$actionType]['color'] }} flex items-center justify-center mr-3">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $actionIcons[$actionType]['icon'] }}"/>
                                    </svg>
                                </div>
                                <span class="text-sm text-gray-900 dark:text-white">{{ $log->action }}</span>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center">
                                <div class="w-16 h-16 rounded-full bg-gray-100 dark:bg-dark-bg flex items-center justify-center mb-4">
                                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                </div>
                                <p class="text-gray-500 dark:text-gray-400 font-medium">No logs found</p>
                                <p class="text-gray-400 dark:text-gray-500 text-sm mt-1">Try adjusting your search criteria</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($logs->hasPages())
        <div class="px-6 py-4 border-t border-gray-100 dark:border-dark-border">
            {{ $logs->links() }}
        </div>
        @endif
    </div>
</div>
@endsection