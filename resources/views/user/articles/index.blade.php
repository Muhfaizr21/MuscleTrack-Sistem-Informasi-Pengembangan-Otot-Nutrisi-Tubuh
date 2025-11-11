@extends('layouts.user')

@section('content')
<div class="min-h-screen py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Header Section --}}
        <div class="glass-dark rounded-3xl p-8 border border-emerald-500/20 shadow-2xl shadow-emerald-500/10 mb-8">
            <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-6">
                <div class="flex items-center gap-4">
                    <div class="w-14 h-14 bg-gradient-to-br from-emerald-500 to-emerald-700 rounded-2xl flex items-center justify-center animate-glow">
                        <span class="text-2xl">📚</span>
                    </div>
                    <div>
                        <h1 class="text-3xl sm:text-4xl font-black text-white">
                            Tips & <span class="text-gradient">Articles</span>
                        </h1>
                        <p class="text-emerald-400/80 text-lg mt-2">Inspiration & education about fitness, nutrition, and healthy lifestyle</p>
                    </div>
                </div>
                <div class="text-right">
                    <div class="text-emerald-400 font-bold text-sm uppercase tracking-wider mb-2">Weekly Reading</div>
                    <p class="text-white font-semibold">Read 1 article every week for new knowledge and motivation 💪</p>
                </div>
            </div>
        </div>

        {{-- 🔔 New Articles Notification --}}
        @if($showNotification)
            <div class="glass rounded-2xl p-6 mb-8 border border-emerald-500/30 bg-emerald-500/10">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-emerald-500/20 rounded-xl flex items-center justify-center border border-emerald-500/30">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-emerald-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-emerald-400 mb-1">New Articles Available!</h3>
                        <p class="text-emerald-400/80">
                            There are <strong class="text-white">{{ $newArticlesCount }}</strong> new articles this week! Read them now to boost your fitness journey 💪
                        </p>
                    </div>
                </div>
            </div>
        @endif

        {{-- 📰 Articles Grid --}}
        @if($articles->count())
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                @foreach($articles as $article)
                    <a href="{{ route('user.articles.show', $article->slug) }}"
                       class="group glass rounded-2xl border border-emerald-500/10 overflow-hidden transition-all duration-300 hover:border-emerald-500/30 hover-glow">
                        
                        {{-- Article Image --}}
                        @if($article->image)
                            <div class="h-48 w-full overflow-hidden">
                                <img src="{{ asset('storage/'.$article->image) }}" alt="{{ $article->title }}"
                                     class="h-full w-full object-cover group-hover:scale-105 transition-transform duration-500">
                            </div>
                        @else
                            <div class="h-48 w-full bg-gradient-to-br from-emerald-500/10 to-emerald-700/10 flex items-center justify-center border-b border-emerald-500/10">
                                <div class="text-center">
                                    <span class="text-4xl text-emerald-400">📖</span>
                                    <p class="text-emerald-400/60 text-sm mt-2 font-medium">Fitness Article</p>
                                </div>
                            </div>
                        @endif

                        {{-- Article Content --}}
                        <div class="p-6">
                            {{-- Category Badge --}}
                            <div class="flex justify-between items-start mb-3">
                                <span class="text-xs font-bold text-emerald-400 bg-emerald-500/10 px-3 py-1 rounded-full border border-emerald-500/20">
                                    {{ $article->category ?? 'General' }}
                                </span>
                                <span class="text-xs text-emerald-400/60 font-medium">
                                    {{ $article->created_at->format('M d, Y') }}
                                </span>
                            </div>

                            {{-- Title --}}
                            <h3 class="font-serif text-xl font-bold text-white mb-3 group-hover:text-emerald-100 transition-colors duration-300 line-clamp-2">
                                {{ Str::limit($article->title, 70) }}
                            </h3>

                            {{-- Summary --}}
                            <p class="text-emerald-400/80 text-sm leading-relaxed mb-4 line-clamp-3">
                                {{ Str::limit($article->summary, 120) }}
                            </p>

                            {{-- Read More --}}
                            <div class="flex items-center justify-between pt-4 border-t border-emerald-500/10">
                                <span class="text-emerald-400 text-sm font-bold group-hover:text-white transition-colors duration-300 flex items-center gap-2">
                                    Read Article
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 group-hover:translate-x-1 transition-transform duration-300" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </span>
                                <div class="flex items-center gap-1 text-emerald-400/60">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                                    </svg>
                                    <span class="text-xs font-medium">5 min read</span>
                                </div>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>

            {{-- Pagination --}}
            <div class="glass-dark rounded-2xl p-6 border border-emerald-500/20">
                {{ $articles->links('pagination::tailwind') }}
            </div>
        @else
            {{-- Empty State --}}
            <div class="glass-dark rounded-3xl p-12 text-center border border-emerald-500/20">
                <div class="w-24 h-24 bg-emerald-500/10 rounded-3xl flex items-center justify-center mx-auto mb-6 border border-emerald-500/20">
                    <span class="text-4xl">📚</span>
                </div>
                <h3 class="text-2xl font-bold text-white mb-3">No Articles Available</h3>
                <p class="text-emerald-400/80 text-lg mb-6 max-w-md mx-auto">
                    We're working on new content to help you on your fitness journey. Check back soon for amazing articles!
                </p>
                <div class="flex items-center justify-center gap-2 text-emerald-400/60">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                    </svg>
                    <span class="text-sm font-medium">New articles coming soon</span>
                </div>
            </div>
        @endif

        {{-- 🧠 Weekly Reading Tips --}}
        <div class="glass rounded-2xl p-6 mt-8 border border-emerald-500/20 bg-emerald-500/5">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-emerald-500/10 rounded-xl flex items-center justify-center border border-emerald-500/20">
                    <span class="text-xl text-emerald-400">💡</span>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-white mb-2">Weekly Reading Challenge</h3>
                    <p class="text-emerald-400/80">
                        <strong class="text-emerald-400">Tip:</strong> Read at least 1 article every week to gain new knowledge and stay motivated on your fitness journey. 
                        Consistent learning leads to consistent results! 🌱
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .text-gradient {
        background: linear-gradient(135deg, #10b981 0%, #34d399 50%, #6ee7b7 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .glass {
        background: rgba(10, 10, 10, 0.7);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(16, 185, 129, 0.2);
    }

    .glass-dark {
        background: rgba(0, 0, 0, 0.8);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(16, 185, 129, 0.3);
    }

    .hover-glow:hover {
        box-shadow: 0 0 25px rgba(16, 185, 129, 0.3);
        transition: all 0.3s ease;
    }

    .animate-glow {
        animation: glow 2s ease-in-out infinite alternate;
    }

    @keyframes glow {
        from {
            box-shadow: 0 0 10px rgba(16, 185, 129, 0.4);
        }
        to {
            box-shadow: 0 0 20px rgba(16, 185, 129, 0.6), 0 0 30px rgba(16, 185, 129, 0.4);
        }
    }

    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .line-clamp-3 {
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>
@endsection