@props(['title', 'value', 'trend' => null, 'ghostNumber'])

<div class="relative bg-black/70 backdrop-blur-lg border border-gray-700/50 rounded-lg p-6 overflow-hidden">
    <div class="absolute -right-2 -bottom-4 font-serif text-9xl font-bold text-gray-800/50 z-0 opacity-50">{{ $ghostNumber }}</div>

    <div class="relative z-10">
        <div class="text-sm font-medium text-gray-400 uppercase tracking-wider">{{ $title }}</div>
        <div class="mt-2 text-4xl font-bold text-white">{{ $value }}</div>

        @if($trend)
            <div class="mt-2 text-xs text-amber-400">{{ $trend }}</div>
        @endif
    </div>
</div>
