@extends('layouts.trainer')

@section('title', 'Communities')

@section('styles')
    <style>
        /* Base Styles */
        .community-card {
            background: rgba(17, 25, 21, 0.8);
            backdrop-filter: blur(15px) saturate(180%);
            border: 1px solid rgba(0, 255, 170, 0.25);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3), 0 0 20px rgba(0, 255, 170, 0.1);
            transition: all 0.3s ease;
            border-radius: 16px;
            overflow: hidden;
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .community-card:hover {
            border-color: rgba(0, 255, 170, 0.4);
            box-shadow: 0 12px 40px rgba(0, 0, 0, 0.4), 0 0 30px rgba(0, 255, 170, 0.2);
            transform: translateY(-5px);
        }

        .community-cover {
            height: 120px;
            background: linear-gradient(135deg, #00ff9d, #00ffcc);
            position: relative;
            overflow: hidden;
        }

        .community-avatar {
            width: 60px;
            height: 60px;
            border: 4px solid rgba(17, 25, 21, 0.95);
            background: rgba(17, 25, 21, 0.95);
            border-radius: 16px;
            position: absolute;
            top: -30px;
            left: 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            font-weight: bold;
            color: #00ffcc;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
        }

        .community-content {
            padding: 1.5rem;
            padding-top: 3rem;
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .stats-item {
            display: flex;
            align-items: center;
            gap: 6px;
            color: #9CA3AF;
            font-size: 12px;
            font-weight: 500;
        }

        .action-btn {
            padding: 8px 16px;
            border-radius: 10px;
            font-weight: 600;
            font-size: 12px;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
            text-align: center;
            text-decoration: none;
            display: inline-block;
        }

        .btn-show {
            background: rgba(59, 130, 246, 0.2);
            color: #3b82f6;
            border: 1px solid rgba(59, 130, 246, 0.4);
        }

        .btn-show:hover {
            background: rgba(59, 130, 246, 0.3);
            border-color: rgba(59, 130, 246, 0.6);
            transform: translateY(-1px);
        }

        .btn-join {
            background: linear-gradient(135deg, #00ff9d, #00ffcc);
            color: #000;
            border: 1px solid rgba(0, 255, 170, 0.4);
        }

        .btn-join:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(0, 255, 170, 0.4);
        }

        .joined-badge {
            background: rgba(0, 255, 170, 0.2);
            color: #00ffcc;
            border: 1px solid rgba(0, 255, 170, 0.4);
            padding: 6px 12px;
            border-radius: 10px;
            font-size: 12px;
            font-weight: 600;
        }

        .create-community-card {
            background: rgba(17, 25, 21, 0.6);
            border: 2px dashed rgba(0, 255, 170, 0.3);
            border-radius: 16px;
            transition: all 0.3s ease;
            cursor: pointer;
            min-height: 300px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            gap: 16px;
            text-decoration: none;
        }

        .create-community-card:hover {
            border-color: rgba(0, 255, 170, 0.6);
            background: rgba(17, 25, 21, 0.8);
            transform: translateY(-2px);
        }

        .tab-btn {
            background: rgba(17, 25, 21, 0.6);
            border: 1px solid rgba(0, 255, 170, 0.2);
            padding: 12px 24px;
            border-radius: 12px;
            color: #9CA3AF;
            font-weight: 600;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .tab-btn.active {
            background: rgba(0, 255, 170, 0.2);
            border-color: rgba(0, 255, 170, 0.4);
            color: #00ffcc;
        }

        .tab-btn:hover:not(.active) {
            background: rgba(17, 25, 21, 0.8);
            border-color: rgba(0, 255, 170, 0.3);
            color: #e5e7eb;
        }

        .empty-state {
            text-align: center;
            padding: 3rem 2rem;
            color: #6B7280;
        }

        .empty-state-icon {
            width: 80px;
            height: 80px;
            background: rgba(17, 25, 21, 0.6);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
            border: 2px dashed rgba(0, 255, 170, 0.3);
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

        /* Mobile Responsive Styles */
        @media (max-width: 640px) {
            .community-content {
                padding: 1rem;
                padding-top: 2.5rem;
            }

            .community-cover {
                height: 100px;
            }

            .community-avatar {
                width: 50px;
                height: 50px;
                top: -25px;
                left: 1rem;
                font-size: 20px;
                border-width: 3px;
            }

            .create-community-card {
                min-height: 250px;
                padding: 1.5rem;
            }

            .tab-btn {
                padding: 10px 16px;
                font-size: 14px;
            }

            .action-btn {
                padding: 6px 12px;
                font-size: 11px;
            }

            .stats-item {
                font-size: 11px;
            }

            .empty-state {
                padding: 2rem 1rem;
            }

            .empty-state-icon {
                width: 60px;
                height: 60px;
            }
        }
    </style>
@endsection

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header Section -->
        <div class="glass-card rounded-2xl p-6 lg:p-8 mb-8">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
                <div class="flex-1">
                    <h1 class="text-3xl lg:text-4xl font-bold text-white mb-3">
                        Trainer Communities
                    </h1>
                    <p class="text-gray-400 text-lg max-w-2xl">
                        Connect with fellow trainers, share expertise, and build professional networks.
                        Create specialized communities for fitness professionals.
                    </p>
                </div>
                <a href="{{ route('trainer.communities.create') }}"
                    class="btn-premium px-6 py-3 rounded-xl text-sm font-bold whitespace-nowrap self-start lg:self-auto">
                    + Create Community
                </a>
            </div>
        </div>

        <!-- Tabs Navigation -->
        <div class="flex space-x-2 mb-8 overflow-x-auto pb-2 scrollbar-hide">
            <button class="tab-btn whitespace-nowrap active" data-tab="all">
                All Communities
            </button>
            <button class="tab-btn whitespace-nowrap" data-tab="joined">
                My Communities
            </button>
            <button class="tab-btn whitespace-nowrap" data-tab="public">
                Public Communities
            </button>
        </div>

        <!-- Communities Grid -->
        <div class="space-y-8">
            <!-- All Communities Tab -->
            <div id="tab-all" class="tab-content">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    <!-- Create Community Card -->
                    <a href="{{ route('trainer.communities.create') }}" class="create-community-card">
                        <div
                            class="w-16 h-16 bg-gradient-to-br from-emerald-neon to-emerald-deep rounded-2xl flex items-center justify-center mb-4">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4">
                                </path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-white text-center">Create Community</h3>
                        <p class="text-gray-400 text-center">Start your own trainer community</p>
                    </a>

                    <!-- Community Cards -->
                    @foreach($communities as $community)
                        <div class="community-card"
                            data-joined="{{ in_array($community->id, $joinedCommunities->toArray()) ? 'true' : 'false' }}"
                            data-public="{{ $community->is_public ? 'true' : 'false' }}">
                            <!-- Cover Image -->
                            <div class="community-cover">
                                @if($community->cover_image)
                                    <img src="{{ $community->cover_image_url }}" alt="{{ $community->name }}"
                                        class="w-full h-full object-cover">
                                @endif
                            </div>

                            <!-- Community Avatar -->
                            <div class="community-avatar">
                                @if($community->image)
                                    <img src="{{ $community->image_url }}" alt="{{ $community->name }}"
                                        class="w-full h-full object-cover rounded-xl">
                                @else
                                    {{ strtoupper(substr($community->name, 0, 1)) }}
                                @endif
                            </div>

                            <!-- Community Info -->
                            <div class="community-content">
                                <div class="flex items-start justify-between mb-3">
                                    <h3 class="font-bold text-white text-lg truncate" title="{{ $community->name }}">
                                        {{ $community->name }}
                                    </h3>
                                    @if($community->is_public)
                                        <span
                                            class="text-xs bg-emerald-500/20 text-emerald-400 px-2 py-1 rounded-full flex-shrink-0 ml-2">
                                            Public
                                        </span>
                                    @else
                                        <span
                                            class="text-xs bg-gray-500/20 text-gray-400 px-2 py-1 rounded-full flex-shrink-0 ml-2">
                                            Private
                                        </span>
                                    @endif
                                </div>

                                <p class="text-gray-400 text-sm mb-4 line-clamp-2 flex-1">
                                    {{ $community->description }}
                                </p>

                                <!-- Stats -->
                                <div class="flex items-center justify-between mb-4">
                                    <div class="flex items-center gap-4">
                                        <div class="stats-item">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                                                </path>
                                            </svg>
                                            {{ $community->members_count }}
                                        </div>
                                        <div class="stats-item">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z">
                                                </path>
                                            </svg>
                                            {{ $community->posts_count }}
                                        </div>
                                    </div>
                                </div>

                                <!-- Action Buttons -->
                                <div class="flex items-center justify-between mt-auto">
                                    <span class="text-xs text-gray-500 truncate flex-1 mr-2"
                                        title="by {{ $community->creator->name }}">
                                        by {{ \Illuminate\Support\Str::limit($community->creator->name, 12) }}
                                    </span>

                                    <div class="flex space-x-2 flex-shrink-0">
                                        <a href="{{ route('trainer.communities.show', $community->slug) }}"
                                            class="action-btn btn-show">
                                            View
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Joined Communities Tab -->
            <div id="tab-joined" class="tab-content hidden">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    @php
                        $joinedCommunitiesList = $communities->filter(function ($community) use ($joinedCommunities) {
                            return in_array($community->id, $joinedCommunities->toArray());
                        });
                    @endphp

                    @if($joinedCommunitiesList->count() > 0)
                        @foreach($joinedCommunitiesList as $community)
                            <div class="community-card">
                                <!-- Cover Image -->
                                <div class="community-cover">
                                    @if($community->cover_image)
                                        <img src="{{ $community->cover_image_url }}" alt="{{ $community->name }}"
                                            class="w-full h-full object-cover">
                                    @endif
                                </div>

                                <!-- Community Avatar -->
                                <div class="community-avatar">
                                    @if($community->image)
                                        <img src="{{ $community->image_url }}" alt="{{ $community->name }}"
                                            class="w-full h-full object-cover rounded-xl">
                                    @else
                                        {{ strtoupper(substr($community->name, 0, 1)) }}
                                    @endif
                                </div>

                                <!-- Community Info -->
                                <div class="community-content">
                                    <div class="flex items-start justify-between mb-3">
                                        <h3 class="font-bold text-white text-lg truncate">{{ $community->name }}</h3>
                                        <span class="joined-badge">
                                            Joined
                                        </span>
                                    </div>

                                    <p class="text-gray-400 text-sm mb-4 line-clamp-2 flex-1">
                                        {{ $community->description }}
                                    </p>

                                    <!-- Stats -->
                                    <div class="flex items-center gap-4 mb-4">
                                        <div class="stats-item">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                                                </path>
                                            </svg>
                                            {{ $community->members_count }}
                                        </div>
                                        <div class="stats-item">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z">
                                                </path>
                                            </svg>
                                            {{ $community->posts_count }}
                                        </div>
                                    </div>

                                    <!-- Action Button -->
                                    <div class="mt-auto">
                                        <a href="{{ route('trainer.communities.show', $community->slug) }}"
                                            class="action-btn btn-show w-full text-center block">
                                            Enter Community
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="col-span-full">
                            <div class="empty-state">
                                <div class="empty-state-icon">
                                    <svg class="w-8 h-8 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z">
                                        </path>
                                    </svg>
                                </div>
                                <h3 class="text-lg font-semibold text-gray-400 mb-2">No Communities Joined</h3>
                                <p class="text-gray-500 mb-4">You haven't joined any communities yet.</p>
                                <a href="#tab-all" class="tab-btn active" data-tab="all">
                                    Explore Communities
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Public Communities Tab -->
            <div id="tab-public" class="tab-content hidden">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    @php
                        $publicCommunities = $communities->where('is_public', true);
                    @endphp

                    @if($publicCommunities->count() > 0)
                        @foreach($publicCommunities as $community)
                            <div class="community-card">
                                <!-- Cover Image -->
                                <div class="community-cover">
                                    @if($community->cover_image)
                                        <img src="{{ $community->cover_image_url }}" alt="{{ $community->name }}"
                                            class="w-full h-full object-cover">
                                    @endif
                                </div>

                                <!-- Community Avatar -->
                                <div class="community-avatar">
                                    @if($community->image)
                                        <img src="{{ $community->image_url }}" alt="{{ $community->name }}"
                                            class="w-full h-full object-cover rounded-xl">
                                    @else
                                        {{ strtoupper(substr($community->name, 0, 1)) }}
                                    @endif
                                </div>

                                <!-- Community Info -->
                                <div class="community-content">
                                    <div class="flex items-start justify-between mb-3">
                                        <h3 class="font-bold text-white text-lg truncate">{{ $community->name }}</h3>
                                        <span class="text-xs bg-emerald-500/20 text-emerald-400 px-2 py-1 rounded-full">
                                            Public
                                        </span>
                                    </div>

                                    <p class="text-gray-400 text-sm mb-4 line-clamp-2 flex-1">
                                        {{ $community->description }}
                                    </p>

                                    <!-- Stats -->
                                    <div class="flex items-center gap-4 mb-4">
                                        <div class="stats-item">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                                                </path>
                                            </svg>
                                            {{ $community->members_count }}
                                        </div>
                                        <div class="stats-item">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z">
                                                </path>
                                            </svg>
                                            {{ $community->posts_count }}
                                        </div>
                                    </div>

                                    <!-- Action Buttons -->
                                    <div class="flex items-center justify-between mt-auto">
                                        <span class="text-xs text-gray-500 flex-1 mr-2">
                                            by {{ \Illuminate\Support\Str::limit($community->creator->name, 12) }}
                                        </span>

                                        <div class="flex space-x-2 flex-shrink-0">
                                            <a href="{{ route('trainer.communities.show', $community->slug) }}"
                                                class="action-btn btn-show">
                                                View
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="col-span-full">
                            <div class="empty-state">
                                <div class="empty-state-icon">
                                    <svg class="w-8 h-8 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                                        </path>
                                    </svg>
                                </div>
                                <h3 class="text-lg font-semibold text-gray-400 mb-2">No Public Communities</h3>
                                <p class="text-gray-500">There are no public communities available at the moment.</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Pagination -->
        @if($communities->hasPages())
            <div class="mt-8">
                {{ $communities->links() }}
            </div>
        @endif
    </div>
@endsection

@section('scripts')
    <script>
        // Tab functionality
        document.addEventListener('DOMContentLoaded', function () {
            const tabButtons = document.querySelectorAll('.tab-btn');
            const tabContents = document.querySelectorAll('.tab-content');

            tabButtons.forEach(button => {
                button.addEventListener('click', function () {
                    const targetTab = this.getAttribute('data-tab');

                    // Update active tab button
                    tabButtons.forEach(btn => btn.classList.remove('active'));
                    this.classList.add('active');

                    // Show target tab content
                    tabContents.forEach(content => content.classList.add('hidden'));
                    document.getElementById(`tab-${targetTab}`).classList.remove('hidden');
                });
            });

            // Handle empty state navigation
            document.querySelectorAll('a[data-tab]').forEach(link => {
                link.addEventListener('click', function (e) {
                    e.preventDefault();
                    const targetTab = this.getAttribute('data-tab');
                    const targetButton = document.querySelector(`.tab-btn[data-tab="${targetTab}"]`);
                    if (targetButton) {
                        targetButton.click();
                    }
                });
            });
        });
    </script>
@endsection