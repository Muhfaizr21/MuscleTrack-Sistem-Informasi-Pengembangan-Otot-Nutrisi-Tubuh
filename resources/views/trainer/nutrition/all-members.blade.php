@extends('layouts.trainer')

@section('title', 'All Members Nutrition')

@section('content')
<div class="min-h-screen py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Header Section --}}
        <div class="glass-dark rounded-3xl p-8 border border-emerald-500/20 shadow-2xl shadow-emerald-500/10 mb-8">
            <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-6">
                <div class="flex items-center gap-4">
                    <div class="w-14 h-14 bg-gradient-to-br from-emerald-500 to-emerald-700 rounded-2xl flex items-center justify-center animate-glow">
                        <span class="text-2xl">👥</span>
                    </div>
                    <div>
                        <h1 class="text-3xl sm:text-4xl font-black text-white">
                            All <span class="text-gradient">Members</span> Nutrition
                        </h1>
                        <p class="text-emerald-400/80 text-lg mt-2">Manage nutrition plans and supplements for all your members</p>
                    </div>
                </div>
                <div class="flex gap-3">
                    <a href="{{ route('trainer.nutrition.dashboard') }}"
                       class="group flex items-center gap-2 px-6 py-3 rounded-xl text-sm font-bold text-white bg-gradient-to-r from-blue-500 to-blue-700 hover:from-blue-600 hover:to-blue-800 transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-blue-500/25">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                        Dashboard
                    </a>
                </div>
            </div>
        </div>

        {{-- Toast Notification --}}
        @if(session('success'))
            <div class="mb-6 glass rounded-2xl p-4 border border-emerald-500/20 animate-pop-in">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 bg-emerald-500/20 rounded-lg flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-emerald-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <p class="text-emerald-400 font-medium">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6 glass rounded-2xl p-4 border border-red-500/20 animate-pop-in">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 bg-red-500/20 rounded-lg flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <p class="text-red-400 font-medium">{{ session('error') }}</p>
                </div>
            </div>
        @endif

        {{-- Quick Stats --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="glass-dark rounded-2xl p-6 border border-emerald-500/20 shadow-lg shadow-emerald-500/10">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-emerald-400/80 text-sm font-medium">Total Members</p>
                        <p class="text-3xl font-black text-white mt-2">{{ $members->count() }}</p>
                    </div>
                    <div class="w-12 h-12 bg-emerald-500/20 rounded-xl flex items-center justify-center">
                        <span class="text-xl">👥</span>
                    </div>
                </div>
            </div>

            <div class="glass-dark rounded-2xl p-6 border border-blue-500/20 shadow-lg shadow-blue-500/10">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-blue-400/80 text-sm font-medium">With Nutrition Plans</p>
                        <p class="text-3xl font-black text-white mt-2">{{ $membersWithPlans }}</p>
                    </div>
                    <div class="w-12 h-12 bg-blue-500/20 rounded-xl flex items-center justify-center">
                        <span class="text-xl">📋</span>
                    </div>
                </div>
            </div>

            <div class="glass-dark rounded-2xl p-6 border border-purple-500/20 shadow-lg shadow-purple-500/10">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-purple-400/80 text-sm font-medium">Total Supplements</p>
                        <p class="text-3xl font-black text-white mt-2">{{ $totalSupplements }}</p>
                    </div>
                    <div class="w-12 h-12 bg-purple-500/20 rounded-xl flex items-center justify-center">
                        <span class="text-xl">💊</span>
                    </div>
                </div>
            </div>

            <div class="glass-dark rounded-2xl p-6 border border-amber-500/20 shadow-lg shadow-amber-500/10">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-amber-400/80 text-sm font-medium">Total Calories</p>
                        <p class="text-3xl font-black text-white mt-2">{{ number_format($totalCaloriesAll) }}</p>
                    </div>
                    <div class="w-12 h-12 bg-amber-500/20 rounded-xl flex items-center justify-center">
                        <span class="text-xl">🔥</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Members List --}}
        <div class="glass-dark rounded-3xl p-6 border border-emerald-500/20 shadow-xl shadow-emerald-500/10">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-black text-white flex items-center gap-3">
                    <span class="text-gradient">📊 All Members Overview</span>
                </h2>
                <div class="flex items-center gap-3">
                    <div class="relative">
                        <input type="text" id="searchMembers" placeholder="Search members..."
                               class="px-4 py-2 bg-gray-800 border border-emerald-500/20 rounded-xl text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-emerald-400 focus:border-transparent transition-all duration-300 w-64">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 absolute right-3 top-3 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                </div>
            </div>

            @if($members->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($members as $member)
                        <div class="glass rounded-2xl p-6 border border-emerald-500/10 hover:border-emerald-500/30 transition-all duration-300 group hover:transform hover:scale-105">
                            <div class="flex items-start justify-between mb-4">
                                <div class="flex items-center gap-3">
                                    @if($member->avatar)
                                        <img src="{{ $member->avatar }}" alt="{{ $member->name }}" class="w-12 h-12 rounded-xl object-cover">
                                    @else
                                        <div class="w-12 h-12 bg-gradient-to-br from-emerald-500 to-emerald-700 rounded-xl flex items-center justify-center">
                                            <span class="text-white font-bold text-sm">{{ substr($member->name, 0, 1) }}</span>
                                        </div>
                                    @endif
                                    <div>
                                        <h3 class="font-bold text-white group-hover:text-emerald-400 transition-colors duration-300">{{ $member->name }}</h3>
                                        <p class="text-emerald-400/70 text-sm">{{ $member->email }}</p>
                                    </div>
                                </div>
                                <div class="flex flex-col items-end gap-1">
                                    <span class="px-2 py-1 text-xs bg-emerald-500/20 text-emerald-400 rounded-full border border-emerald-500/30">
                                        {{ $member->nutritionPlans->count() }} plans
                                    </span>
                                    <span class="px-2 py-1 text-xs bg-purple-500/20 text-purple-400 rounded-full border border-purple-500/30">
                                        {{ $member->supplements->count() }} supplements
                                    </span>
                                </div>
                            </div>

                            {{-- Member Stats --}}
                            <div class="space-y-2 mb-4">
                                <div class="flex justify-between items-center text-sm">
                                    <span class="text-gray-400">Total Calories</span>
                                    <span class="text-white font-medium">{{ $member->nutritionPlans->sum('calories') }}</span>
                                </div>
                                <div class="flex justify-between items-center text-sm">
                                    <span class="text-gray-400">Meal Plans</span>
                                    <span class="text-white font-medium">{{ $member->nutritionPlans->count() }}</span>
                                </div>
                                <div class="flex justify-between items-center text-sm">
                                    <span class="text-gray-400">Days Covered</span>
                                    <span class="text-white font-medium">{{ $member->nutritionPlans->groupBy('day_of_week')->count() }}</span>
                                </div>
                            </div>

                            {{-- Action Buttons --}}
                            <div class="flex gap-2">
                                <a href="{{ route('trainer.programs.nutrition.index', $member->id) }}"
                                   class="flex-1 text-center px-3 py-2 text-xs font-medium text-white bg-emerald-500/20 hover:bg-emerald-500/30 border border-emerald-500/30 hover:border-emerald-500/50 rounded-xl transition-all duration-300">
                                    Manage Nutrition
                                </a>
                                <a href="{{ route('trainer.programs.nutrition.analysis', $member->id) }}"
                                   class="px-3 py-2 text-xs font-medium text-blue-400 hover:text-blue-300 border border-blue-500/30 hover:border-blue-500/50 rounded-xl transition-all duration-300">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                    </svg>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-12">
                    <div class="w-20 h-20 bg-emerald-500/10 rounded-2xl flex items-center justify-center mx-auto mb-4 border border-emerald-500/20">
                        <span class="text-3xl">👥</span>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-2">No Members Yet</h3>
                    <p class="text-emerald-400/80 mb-6">You don't have any members assigned to you yet.</p>
                    <a href="{{ route('trainer.members.index') }}"
                       class="inline-flex items-center gap-2 px-6 py-3 rounded-xl text-sm font-bold text-white bg-gradient-to-r from-emerald-500 to-emerald-700 hover:from-emerald-600 hover:to-emerald-800 transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-emerald-500/25">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Invite Members
                    </a>
                </div>
            @endif
        </div>

        {{-- Recent Activity --}}
        @if($members->count() > 0)
        <div class="glass-dark rounded-3xl p-6 border border-blue-500/20 shadow-xl shadow-blue-500/10 mt-8">
            <h2 class="text-2xl font-black text-white mb-6 flex items-center gap-3">
                <span class="text-blue-400">📈 Recent Nutrition Activity</span>
            </h2>

            <div class="space-y-4">
                @php
                    $recentPlans = \App\Models\NutritionPlan::whereIn('user_id', $members->pluck('id'))
                        ->with('user')
                        ->orderBy('created_at', 'desc')
                        ->take(5)
                        ->get();
                @endphp

                @if($recentPlans->count() > 0)
                    @foreach($recentPlans as $plan)
                        <div class="flex items-center justify-between p-4 glass rounded-xl border border-blue-500/10">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-blue-500/20 rounded-lg flex items-center justify-center">
                                    <span class="text-blue-400">
                                        @if($plan->type == 'breakfast') 🍳
                                        @elseif($plan->type == 'lunch') 🍲
                                        @elseif($plan->type == 'dinner') 🍛
                                        @elseif($plan->type == 'snack') 🍎
                                        @endif
                                    </span>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-white text-sm">{{ $plan->meal_name }}</h4>
                                    <p class="text-blue-400/70 text-xs">
                                        {{ $plan->user->name }} •
                                        @if($plan->day_of_week == 'Monday') Senin
                                        @elseif($plan->day_of_week == 'Tuesday') Selasa
                                        @elseif($plan->day_of_week == 'Wednesday') Rabu
                                        @elseif($plan->day_of_week == 'Thursday') Kamis
                                        @elseif($plan->day_of_week == 'Friday') Jumat
                                        @elseif($plan->day_of_week == 'Saturday') Sabtu
                                        @elseif($plan->day_of_week == 'Sunday') Minggu
                                        @else {{ $plan->day_of_week }}
                                        @endif
                                    </p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-white font-medium text-sm">{{ $plan->calories }} kcal</p>
                                <p class="text-blue-400/70 text-xs">{{ $plan->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="text-center py-8">
                        <div class="w-16 h-16 bg-blue-500/10 rounded-2xl flex items-center justify-center mx-auto mb-4 border border-blue-500/20">
                            <span class="text-2xl">📝</span>
                        </div>
                        <p class="text-blue-400/70">No recent nutrition plans created yet.</p>
                    </div>
                @endif
            </div>
        </div>
        @endif
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

    .animate-glow {
        animation: glow 2s ease-in-out infinite alternate;
    }

    .animate-pop-in {
        animation: popIn 0.3s ease-out forwards;
    }

    @keyframes glow {
        from {
            box-shadow: 0 0 10px rgba(16, 185, 129, 0.4);
        }
        to {
            box-shadow: 0 0 20px rgba(16, 185, 129, 0.6), 0 0 30px rgba(16, 185, 129, 0.4);
        }
    }

    @keyframes popIn {
        0% { transform: scale(0.95); opacity: 0; }
        100% { transform: scale(1); opacity: 1; }
    }
</style>

<script>
    // Simple search functionality
    document.getElementById('searchMembers').addEventListener('input', function(e) {
        const searchTerm = e.target.value.toLowerCase();
        const memberCards = document.querySelectorAll('.glass.rounded-2xl');

        memberCards.forEach(card => {
            const memberName = card.querySelector('h3').textContent.toLowerCase();
            const memberEmail = card.querySelector('p.text-emerald-400\\/70').textContent.toLowerCase();

            if (memberName.includes(searchTerm) || memberEmail.includes(searchTerm)) {
                card.style.display = 'block';
            } else {
                card.style.display = 'none';
            }
        });
    });
</script>
@endsection
