@props([
    'title',
    'value',
    'icon' => null,
    'iconBg' => 'bg-primary-100 dark:bg-primary-900/30',
    'iconColor' => 'text-primary-600 dark:text-primary-400',
    'badge' => null,
    'badgeColor' => 'bg-emerald-50 dark:bg-emerald-900/20 text-emerald-600 dark:text-emerald-400',
    'trend' => null,
    'trendUp' => true
])

<div class="animate-card hover-lift bg-white dark:bg-dark-card rounded-xl p-5 border border-slate-200 dark:border-dark-border">
    <div class="flex items-center justify-between mb-3">
        @if($icon)
            <div class="w-10 h-10 rounded-lg {{ $iconBg }} flex items-center justify-center">
                {!! $icon !!}
            </div>
        @endif
        
        @if($badge)
            <span class="text-xs font-medium {{ $badgeColor }} px-2 py-1 rounded-full">
                {{ $badge }}
            </span>
        @endif
    </div>
    
    <div class="flex items-end justify-between">
        <div>
            <p class="text-2xl font-bold text-slate-900 dark:text-white">{{ $value }}</p>
            <p class="text-sm text-slate-500 dark:text-slate-400">{{ $title }}</p>
        </div>
        
        @if($trend)
            <div class="flex items-center text-xs font-medium {{ $trendUp ? 'text-emerald-600' : 'text-red-600' }}">
                @if($trendUp)
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                    </svg>
                @else
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6"/>
                    </svg>
                @endif
                {{ $trend }}
            </div>
        @endif
    </div>
</div>
