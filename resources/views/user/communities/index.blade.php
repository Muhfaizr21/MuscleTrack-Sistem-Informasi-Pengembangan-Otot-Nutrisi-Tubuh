@extends('layouts.user')

@section('title', 'Communities - MuscleXpert')

@section('styles')
    <style>
        .thread-container {
            background: linear-gradient(180deg, rgba(6, 78, 59, 0.1) 0%, rgba(0, 0, 0, 0.3) 100%);
            border-radius: 24px;
            border: 1px solid rgba(16, 185, 129, 0.2);
            position: relative;
            overflow: hidden;
        }

        .thread-container::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(16, 185, 129, 0.1) 0%, transparent 70%);
            animation: shimmer 8s linear infinite;
            pointer-events: none;
        }

        @keyframes shimmer {
            0% {
                transform: translate(-25%, -25%) rotate(0deg);
            }
            100% {
                transform: translate(-25%, -25%) rotate(360deg);
            }
        }

        .community-thread {
            background: linear-gradient(135deg, rgba(17, 24, 39, 0.9) 0%, rgba(31, 41, 55, 0.8) 100%);
            border: 1px solid rgba(16, 185, 129, 0.15);
            border-radius: 20px;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }

        .community-thread::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, rgba(16, 185, 129, 0.05) 0%, transparent 50%);
            opacity: 0;
            transition: opacity 0.4s ease;
        }

        .community-thread:hover {
            transform: translateY(-8px) scale(1.02);
            border-color: rgba(16, 185, 129, 0.4);
            box-shadow: 
                0 20px 40px rgba(16, 185, 129, 0.2),
                0 0 60px rgba(16, 185, 129, 0.1),
                inset 0 0 20px rgba(16, 185, 129, 0.05);
        }

        .community-thread:hover::before {
            opacity: 1;
        }

        .thread-glow {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, 
                transparent, 
                rgba(16, 185, 129, 0.6), 
                rgba(5, 150, 105, 0.8),
                rgba(16, 185, 129, 0.6), 
                transparent
            );
            box-shadow: 0 0 15px rgba(16, 185, 129, 0.6);
        }

        .community-avatar {
            position: relative;
            border: 2px solid rgba(16, 185, 129, 0.3);
            box-shadow: 
                0 0 20px rgba(16, 185, 129, 0.3),
                inset 0 0 10px rgba(16, 185, 129, 0.1);
        }

        .community-avatar::after {
            content: '';
            position: absolute;
            inset: -2px;
            border-radius: inherit;
            padding: 2px;
            background: linear-gradient(135deg, rgba(16, 185, 129, 0.5), transparent);
            -webkit-mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
            -webkit-mask-composite: xor;
            mask-composite: exclude;
        }

        .stat-pill {
            background: rgba(16, 185, 129, 0.1);
            border: 1px solid rgba(16, 185, 129, 0.2);
            padding: 0.5rem 1rem;
            border-radius: 12px;
            backdrop-filter: blur(10px);
            transition: all 0.3s ease;
        }

        .stat-pill:hover {
            background: rgba(16, 185, 129, 0.2);
            border-color: rgba(16, 185, 129, 0.4);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.2);
        }

        .privacy-badge {
            backdrop-filter: blur(10px);
            border: 1px solid currentColor;
            box-shadow: 0 0 15px currentColor;
        }

        .action-btn {
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .action-btn::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
            transform: translate(-50%, -50%);
            transition: width 0.6s, height 0.6s;
        }

        .action-btn:hover::before {
            width: 300px;
            height: 300px;
        }

        .sparkle {
            position: absolute;
            width: 4px;
            height: 4px;
            background: rgba(16, 185, 129, 0.6);
            border-radius: 50%;
            box-shadow: 0 0 10px rgba(16, 185, 129, 0.8);
            animation: sparkle 3s ease-in-out infinite;
        }

        @keyframes sparkle {
            0%, 100% {
                opacity: 0;
                transform: scale(0);
            }
            50% {
                opacity: 1;
                transform: scale(1);
            }
        }

        .header-glow {
            background: 
                linear-gradient(135deg, rgba(17, 24, 39, 0.95) 0%, rgba(31, 41, 55, 0.9) 100%),
                radial-gradient(circle at top right, rgba(16, 185, 129, 0.15), transparent 70%);
            border: 1px solid rgba(16, 185, 129, 0.3);
            box-shadow: 0 8px 32px rgba(16, 185, 129, 0.1);
        }

        .pulse-dot {
            animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }

        @keyframes pulse {
            0%, 100% {
                opacity: 1;
            }
            50% {
                opacity: 0.5;
            }
        }

        .gradient-text {
            background: linear-gradient(135deg, #10b981 0%, #34d399 50%, #6ee7b7 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            filter: drop-shadow(0 0 20px rgba(16, 185, 129, 0.3));
        }

        .thread-line {
            position: relative;
            padding-left: 2rem;
        }

        .thread-line::before {
            content: '';
            position: absolute;
            left: 0.5rem;
            top: 0;
            bottom: 0;
            width: 2px;
            background: linear-gradient(180deg, 
                rgba(16, 185, 129, 0.5),
                rgba(16, 185, 129, 0.2),
                transparent
            );
        }
    </style>
@endsection

@section('content')
    <div class="min-h-screen py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header Section -->
            <div class="header-glow rounded-3xl p-8 mb-8 relative overflow-hidden">
                <!-- Sparkle Effects -->
                <div class="sparkle" style="top: 20%; left: 10%; animation-delay: 0s;"></div>
                <div class="sparkle" style="top: 60%; left: 80%; animation-delay: 1s;"></div>
                <div class="sparkle" style="top: 40%; left: 30%; animation-delay: 2s;"></div>
                <div class="sparkle" style="top: 70%; left: 60%; animation-delay: 1.5s;"></div>

                <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-6 relative z-10">
                    <div class="flex-1">
                        <h1 class="text-5xl font-black gradient-text mb-4">
                            Fitness Communities
                        </h1>
                        <p class="text-gray-300 text-lg mb-6 leading-relaxed">
                            Join vibrant fitness communities, share your progress, get inspired, and connect with like-minded athletes
                        </p>

                        <!-- Stats -->
                        <div class="flex flex-wrap gap-4">
                            <div class="stat-pill flex items-center gap-3">
                                <div class="w-3 h-3 bg-emerald-500 rounded-full pulse-dot shadow-lg shadow-emerald-500/50"></div>
                                <span class="text-emerald-400 font-semibold">{{ $communities->total() }} Communities</span>
                            </div>
                            <div class="stat-pill flex items-center gap-3">
                                <div class="w-3 h-3 bg-blue-500 rounded-full shadow-lg shadow-blue-500/50"></div>
                                <span class="text-blue-400 font-semibold">Share Workouts</span>
                            </div>
                            <div class="stat-pill flex items-center gap-3">
                                <div class="w-3 h-3 bg-purple-500 rounded-full shadow-lg shadow-purple-500/50"></div>
                                <span class="text-purple-400 font-semibold">Get Feedback</span>
                            </div>
                        </div>
                    </div>

                    <!-- Create Community Button -->
                    <a href="{{ route('user.communities.create') }}"
                        class="action-btn bg-gradient-to-r from-emerald-500 via-emerald-600 to-teal-600 hover:from-emerald-600 hover:via-emerald-700 hover:to-teal-700 text-white px-8 py-4 rounded-2xl font-bold transition-all duration-300 flex items-center gap-3 shadow-lg shadow-emerald-500/30 hover:shadow-emerald-500/50 hover:scale-105 relative z-10">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Create Community
                    </a>
                </div>
            </div>

            <!-- Communities Thread Grid -->
            @if($communities->count() > 0)
                <div class="thread-container p-6 mb-8">
                    <div class="grid grid-cols-1 gap-6">
                        @foreach($communities as $community)
                            <div class="community-thread p-6 relative">
                                <!-- Thread Content -->
                                <div class="flex gap-4">
                                    <!-- Avatar -->
                                    <div class="flex-shrink-0">
                                        @if($community->image)
                                            <img src="{{ Storage::url($community->image) }}" 
                                                alt="{{ $community->name }}"
                                                class="community-avatar w-16 h-16 rounded-2xl object-cover">
                                        @else
                                            <div class="community-avatar w-16 h-16 bg-gradient-to-br from-emerald-500 via-emerald-600 to-teal-600 rounded-2xl flex items-center justify-center">
                                                <span class="text-white font-black text-xl">{{ substr($community->name, 0, 2) }}</span>
                                            </div>
                                        @endif
                                    </div>

                                    <!-- Main Content -->
                                    <div class="flex-1 min-w-0">
                                        <!-- Header -->
                                        <div class="flex items-start justify-between gap-4 mb-3">
                                            <div class="flex-1">
                                                <h3 class="text-xl font-bold text-white mb-2 hover:text-emerald-400 transition-colors">
                                                    {{ $community->name }}
                                                </h3>
                                                <div class="flex items-center gap-4 text-sm">
                                                    <div class="flex items-center gap-2 text-emerald-400">
                                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                            <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"/>
                                                        </svg>
                                                        <span class="font-semibold">{{ $community->member_count }}</span>
                                                        <span class="text-gray-500">members</span>
                                                    </div>
                                                    <div class="text-gray-600">•</div>
                                                    <div class="flex items-center gap-2 text-blue-400">
                                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                            <path d="M2 5a2 2 0 012-2h7a2 2 0 012 2v4a2 2 0 01-2 2H9l-3 3v-3H4a2 2 0 01-2-2V5z"/>
                                                            <path d="M15 7v2a4 4 0 01-4 4H9.828l-1.766 1.767c.28.149.599.233.938.233h2l3 3v-3h2a2 2 0 002-2V9a2 2 0 00-2-2h-1z"/>
                                                        </svg>
                                                        <span class="font-semibold">{{ $community->posts_count }}</span>
                                                        <span class="text-gray-500">posts</span>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Privacy Badge -->
                                            @if(!$community->is_public)
                                                <span class="privacy-badge bg-amber-500/10 text-amber-400 text-xs px-3 py-1.5 rounded-full font-semibold flex-shrink-0">
                                                    🔒 Private
                                                </span>
                                            @else
                                                <span class="privacy-badge bg-emerald-500/10 text-emerald-400 text-xs px-3 py-1.5 rounded-full font-semibold flex-shrink-0">
                                                    🌍 Public
                                                </span>
                                            @endif
                                        </div>

                                        <!-- Description -->
                                        <p class="text-gray-300 text-sm leading-relaxed mb-4">
                                            {{ $community->description }}
                                        </p>

                                        <!-- Action Buttons -->
                                        <div class="flex items-center gap-3 pt-4 border-t border-gray-700/50">
                                            <a href="{{ route('user.communities.show', $community) }}"
                                                class="action-btn text-emerald-400 hover:text-emerald-300 text-sm font-bold transition-all flex items-center gap-2 px-4 py-2 rounded-xl hover:bg-emerald-500/10">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                                    </path>
                                                </svg>
                                                View Community
                                            </a>

                                            @if($joinedCommunities->contains($community->id))
                                                <form action="{{ route('user.communities.leave', $community) }}" method="POST">
                                                    @csrf
                                                    <button type="submit"
                                                        class="action-btn bg-red-500/10 text-red-400 hover:bg-red-500/20 border border-red-500/30 px-5 py-2 rounded-xl text-sm font-bold transition-all flex items-center gap-2 hover:scale-105">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                                        </svg>
                                                        Leave
                                                    </button>
                                                </form>
                                            @else
                                                <form action="{{ route('user.communities.join', $community) }}" method="POST">
                                                    @csrf
                                                    <button type="submit"
                                                        class="action-btn bg-emerald-500/10 text-emerald-400 hover:bg-emerald-500/20 border border-emerald-500/30 px-5 py-2 rounded-xl text-sm font-bold transition-all flex items-center gap-2 hover:scale-105">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                                                        </svg>
                                                        Join Community
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <!-- Thread Glow Effect -->
                                <div class="thread-glow"></div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Pagination -->
                @if($communities->hasPages())
                    <div class="header-glow rounded-2xl p-6">
                        {{ $communities->links() }}
                    </div>
                @endif

            @else
                <!-- Empty State -->
                <div class="header-glow rounded-3xl p-16 text-center relative overflow-hidden">
                    <div class="sparkle" style="top: 20%; left: 20%; animation-delay: 0s;"></div>
                    <div class="sparkle" style="top: 70%; left: 70%; animation-delay: 1s;"></div>
                    
                    <div class="relative z-10">
                        <div class="w-32 h-32 bg-gradient-to-br from-emerald-500/20 to-teal-500/10 rounded-full flex items-center justify-center mx-auto mb-8 shadow-lg shadow-emerald-500/20">
                            <svg class="w-16 h-16 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                                </path>
                            </svg>
                        </div>
                        <h3 class="text-3xl font-black gradient-text mb-3">No Communities Yet</h3>
                        <p class="text-gray-400 text-lg mb-8 max-w-md mx-auto">
                            Be the first to create a fitness community and start connecting with athletes worldwide!
                        </p>
                        <a href="{{ route('user.communities.create') }}"
                            class="action-btn bg-gradient-to-r from-emerald-500 via-emerald-600 to-teal-600 hover:from-emerald-600 hover:via-emerald-700 hover:to-teal-700 text-white px-8 py-4 rounded-2xl font-bold transition-all duration-300 inline-flex items-center gap-3 shadow-lg shadow-emerald-500/30 hover:shadow-emerald-500/50 hover:scale-105">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            Create First Community
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection