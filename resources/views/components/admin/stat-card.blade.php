@props(['title', 'value', 'trend' => null, 'ghostNumber'])

<div class="relative bg-slate-800/40 backdrop-blur-lg border border-slate-700/30 rounded-2xl p-6 overflow-hidden group hover:bg-slate-800/60 transition-all duration-300">
    <!-- Background Ghost Number -->
    <div class="absolute -right-2 -bottom-4 font-bold text-9xl text-slate-700/30 z-0 opacity-60 group-hover:opacity-80 transition-opacity duration-300">{{ $ghostNumber }}</div>

    <!-- Hover Glow Effect -->
    <div class="absolute inset-0 bg-gradient-to-br from-green-500/0 via-transparent to-emerald-500/0 opacity-0 group-hover:opacity-10 transition-opacity duration-300 rounded-2xl"></div>

    <div class="relative z-10">
        <!-- Title -->
        <div class="text-sm font-semibold text-slate-400 uppercase tracking-wider mb-2">{{ $title }}</div>

        <!-- Value -->
        <div class="text-3xl font-bold text-white mb-2">{{ $value }}</div>

        <!-- Trend -->
        @if($trend)
            <div class="flex items-center gap-1 text-xs font-medium text-green-400">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                </svg>
                {{ $trend }}
            </div>
        @endif
    </div>

    <!-- Bottom Accent Line -->
    <div class="absolute bottom-0 left-0 w-full h-1 bg-gradient-to-r from-green-500 to-emerald-600 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
</div>
