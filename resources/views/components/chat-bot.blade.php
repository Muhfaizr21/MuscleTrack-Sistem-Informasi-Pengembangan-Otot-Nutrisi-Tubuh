<button @click="isChatOpen = !isChatOpen" class="fixed z-50 bottom-6 right-6 w-14 h-14 rounded-full bg-black border-2 border-amber-400 text-amber-400 flex items-center justify-center shadow-lg shadow-amber-500/20 hover:bg-amber-400 hover:text-black transition-all">
    <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10c0 3.866-3.582 7-8 7a8.841 8.841 0 01-4.083-.98L2 17.608V13.2A7.97 7.97 0 012 10c0-3.866 3.582-7 8-7s8 3.134 8 7zM7 9H5v2h2V9zm8 0h-2v2h2V9zm-4 0H9v2h2V9z" clip-rule="evenodd"></path></svg>
</button>

<div x-show="isChatOpen"
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0 transform translate-y-4"
     x-transition:enter-end="opacity-100 transform translate-y-0"
     class="fixed z-40 bottom-24 right-6 w-80 h-96 rounded-lg shadow-2xl bg-black/80 backdrop-blur-lg border border-amber-500/50 flex flex-col"
     style="display: none;">

    <div class="flex justify-between items-center p-3 border-b border-amber-500/30">
        <h3 class="font-serif text-lg text-amber-400">MuscleXpert AI</h3>
        <button @click="isChatOpen = false" class="text-gray-400 hover:text-white">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
        </button>
    </div>

    <div class="flex-1 p-3 space-y-3 overflow-y-auto">
        <div class="text-sm p-2 bg-gray-800 rounded-lg max-w-xs">
            Selamat datang di MuscleXpert. Ada yang bisa dibantu?
        </div>
    </div>

    <div class="p-3 border-t border-amber-500/30">
        <input type="text" placeholder="Ketik pesan..." class="w-full p-2 bg-gray-800 border border-gray-700 rounded-md text-sm text-white focus:outline-none focus:border-amber-400">
    </div>
</div>
