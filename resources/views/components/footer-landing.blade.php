<footer class="relative bg-slate-900 border-t border-slate-700/30 mt-20">
    {{-- Background Pattern --}}
    <div class="absolute inset-0 opacity-5"
         style="background-image: radial-gradient(circle, #22c55e 0.5px, transparent 0.5px);
                background-size: 30px 30px;">
    </div>

    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Main Footer Content --}}
        <div class="py-16">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 lg:gap-12">

                {{-- Brand Section --}}
                <div class="md:col-span-2">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-10 h-10 bg-gradient-to-br from-green-500 to-emerald-600 rounded-xl flex items-center justify-center">
                            <span class="text-white font-bold text-lg">M</span>
                        </div>
                        <span class="font-bold text-2xl text-white">
                            Muscle<span class="bg-gradient-to-r from-green-400 to-emerald-500 bg-clip-text text-transparent">Xpert</span>
                        </span>
                    </div>
                    <p class="text-slate-400 text-lg leading-relaxed max-w-md mb-6">
                        Platform fitness berbasis AI yang membantu Anda mencapai tujuan kebugaran dengan program latihan dan nutrisi yang dipersonalisasi.
                    </p>
                    <div class="flex space-x-4">
                        {{-- Instagram Link --}}
                        <a href="https://www.instagram.com/muscle.my.id?igsh=MWR1N2xtd3NwNWJyaA=="
                           target="_blank"
                           rel="noopener noreferrer"
                           class="w-10 h-10 bg-slate-800/50 hover:bg-gradient-to-br hover:from-pink-500 hover:to-purple-600 hover:bg-opacity-10 rounded-xl flex items-center justify-center border border-slate-700/50 hover:border-pink-500/30 transition-all duration-300 group">
                            <svg class="w-5 h-5 text-slate-400 group-hover:text-pink-400" viewBox="0 0 24 24" fill="none">
                                <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z" fill="currentColor"/>
                            </svg>
                        </a>

                        {{-- Twitter/X Link --}}
                        <a href="https://x.com/MuscleXpert2025"
                           target="_blank"
                           rel="noopener noreferrer"
                           class="w-10 h-10 bg-slate-800/50 hover:bg-gray-900 hover:bg-opacity-10 rounded-xl flex items-center justify-center border border-slate-700/50 hover:border-gray-400/30 transition-all duration-300 group">
                            <svg class="w-5 h-5 text-slate-400 group-hover:text-gray-300" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/>
                            </svg>
                        </a>
                    </div>
                </div>

                {{-- Quick Links --}}
                <div>
                    <h3 class="text-lg font-semibold text-white mb-6 flex items-center gap-2">
                        <div class="w-1 h-6 bg-gradient-to-b from-green-400 to-emerald-500 rounded-full"></div>
                        Quick Links
                    </h3>
                    <ul class="space-y-4">
                        <li>
                            <a href="{{ route('public.articles.index') }}" class="text-slate-400 hover:text-green-400 transition-colors duration-300 flex items-center gap-2 group">
                                <svg class="w-4 h-4 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                                Tips & Articles
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('contact.index') }}" class="text-slate-400 hover:text-green-400 transition-colors duration-300 flex items-center gap-2 group">
                                <svg class="w-4 h-4 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                                Contact Us
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('about') }}" class="text-slate-400 hover:text-green-400 transition-colors duration-300 flex items-center gap-2 group">
                                <svg class="w-4 h-4 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                                About Us
                            </a>
                        </li>

                    </ul>
                </div>

                {{-- Support --}}

            </div>
        </div>

        {{-- Bottom Bar --}}
        <div class="border-t border-slate-700/30 py-8">
            <div class="flex flex-col md:flex-row justify-between items-center space-y-4 md:space-y-0">
                <div class="text-slate-400 text-sm">
                    © 2025 <span class="text-green-400 font-semibold">MuscleXpert</span>. All rights reserved.
                </div>

            </div>
        </div>
    </div>

    {{-- Floating Elements --}}
    <div class="absolute bottom-10 left-10 w-20 h-20 bg-green-500/5 rounded-full blur-xl"></div>
    <div class="absolute top-10 right-10 w-16 h-16 bg-blue-500/5 rounded-full blur-xl"></div>
</footer>
