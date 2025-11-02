@props(['icon', 'label', 'value', 'unit' => '', 'target' => 0, 'color' => 'text-amber-400'])

<div class="group relative bg-gradient-to-br from-gray-900/80 to-gray-800/40 border border-gray-700/60 
           rounded-2xl p-5 text-center overflow-hidden transition-all duration-300 hover:border-amber-400/60
           hover:shadow-lg hover:shadow-amber-400/10">

    {{-- Background icon dengan efek blur --}}
    <div
        class="absolute -right-3 -bottom-3 text-8xl opacity-10 text-amber-400/30 blur-sm transform group-hover:scale-110 transition-transform duration-300">
        {{ $icon }}
    </div>

    {{-- Konten utama --}}
    <div class="relative z-10 space-y-1">
        <p class="text-sm text-gray-400 tracking-wide uppercase">{{ $label }}</p>
        <p class="text-3xl font-extrabold {{ $color }} drop-shadow-sm">
            {{ number_format($value, 1) }} <span class="text-base font-semibold text-gray-400">{{ $unit }}</span>
        </p>

        {{-- Progress bar (jika ada target) --}}
        @if ($target > 0)
            @php
                $progress = min(100, ($value / $target) * 100);
            @endphp
            <div class="mt-3">
                <div class="w-full h-2 bg-gray-800 rounded-full overflow-hidden">
                    <div class="h-2 rounded-full bg-gradient-to-r from-amber-400 to-yellow-500 transition-all duration-500"
                        style="width: {{ $progress }}%">
                    </div>
                </div>
                <p class="text-xs text-gray-500 mt-1">
                    🎯 Target: {{ $target }} {{ $unit }}
                </p>
            </div>
        @endif
    </div>
</div>