@extends('layouts.trainer')

@section('title', 'Nutrisi & Suplemen Member')

@section('content')
<div class="min-h-screen py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Header Section --}}
        <div class="glass-dark rounded-3xl p-8 border border-emerald-500/20 shadow-2xl shadow-emerald-500/10 mb-8">
            <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-6">
                <div class="flex items-center gap-4">
                    <div class="w-14 h-14 bg-gradient-to-br from-emerald-500 to-emerald-700 rounded-2xl flex items-center justify-center animate-glow">
                        <span class="text-2xl">🥗</span>
                    </div>
                    <div>
                        <h1 class="text-3xl sm:text-4xl font-black text-white">
                            Nutrition <span class="text-gradient">Management</span>
                        </h1>
                        <p class="text-emerald-400/80 text-lg mt-2">Manage nutrition plans and supplements for {{ $member->name }}</p>
                    </div>
                </div>
                <div class="flex gap-3">
                    <a href="{{ route('trainer.programs.nutrition.create', $member->id) }}"
                       class="group flex items-center gap-2 px-6 py-3 rounded-xl text-sm font-bold text-white bg-gradient-to-r from-emerald-500 to-emerald-700 hover:from-emerald-600 hover:to-emerald-800 transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-emerald-500/25">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                        </svg>
                        Add Nutrition Plan
                    </a>
                    <a href="{{ route('trainer.programs.show', $member->id) }}"
                       class="group flex items-center gap-2 px-6 py-3 rounded-xl text-sm font-bold text-gray-400 hover:text-white transition-all duration-300 border border-gray-600 hover:bg-gray-700/50">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Back to Program
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

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            {{-- Main Content --}}
            <div class="lg:col-span-2 space-y-8">
                {{-- Weekly Nutrition Plans --}}
                <div class="glass-dark rounded-3xl p-6 border border-emerald-500/20 shadow-xl shadow-emerald-500/10">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-black text-white flex items-center gap-3">
                            <span class="text-gradient">📅 Weekly Nutrition Plan</span>
                        </h2>
                        <span class="text-emerald-400 text-sm font-medium">
                            {{ $nutritionPlans->count() }} Total Plans
                        </span>
                    </div>

                    @if($plansByDay->count() > 0)
                        <div class="space-y-6">
                            @foreach($plansByDay as $day => $plans)
                                <div class="glass rounded-2xl p-5 border border-emerald-500/10">
                                    <div class="flex justify-between items-center mb-4">
                                        <h3 class="text-lg font-bold text-white">{{ $day }}</h3>
                                        <div class="flex items-center gap-4 text-sm">
                                            <span class="text-emerald-400">{{ $dailyTotals[$day]['calories'] ?? 0 }} kcal</span>
                                            <span class="text-blue-400">{{ $dailyTotals[$day]['protein'] ?? 0 }}g protein</span>
                                            <span class="text-amber-400">{{ $plans->count() }} meals</span>
                                        </div>
                                    </div>

                                    <div class="space-y-3">
                                        @foreach($plans as $plan)
                                            <div class="flex items-center justify-between p-3 rounded-xl bg-gray-800/40 border border-gray-700/50">
                                                <div class="flex-1">
                                                    <div class="flex items-center gap-3 mb-1">
                                                        <h4 class="font-semibold text-white text-sm">{{ $plan->meal_name }}</h4>
                                                        <span class="px-2 py-1 text-xs bg-emerald-500/20 text-emerald-400 rounded-full border border-emerald-500/30 capitalize">
                                                            {{ $plan->type }}
                                                        </span>
                                                    </div>
                                                    <div class="flex items-center gap-4 text-xs text-gray-400">
                                                        <span>{{ $plan->calories }} kcal</span>
                                                        <span>P: {{ $plan->protein }}g</span>
                                                        <span>C: {{ $plan->carbs }}g</span>
                                                        <span>F: {{ $plan->fat }}g</span>
                                                    </div>
                                                    @if($plan->target_fitness)
                                                        <span class="inline-block mt-1 px-2 py-1 text-xs bg-blue-500/20 text-blue-400 rounded-full border border-blue-500/30">
                                                            {{ $plan->target_fitness }}
                                                        </span>
                                                    @endif
                                                </div>
                                                <div class="flex items-center gap-2">
                                                    <a href="{{ route('trainer.programs.nutrition.edit', ['memberId' => $member->id, 'planId' => $plan->id]) }}" 
                                                       class="text-xs text-blue-400 hover:text-blue-300 transition-colors duration-200">
                                                        Edit
                                                    </a>
                                                    <form action="{{ route('trainer.programs.nutrition.destroy', ['memberId' => $member->id, 'planId' => $plan->id]) }}" method="POST" class="inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" 
                                                                onclick="return confirm('Are you sure you want to delete this nutrition plan?')"
                                                                class="text-xs text-red-400 hover:text-red-300 transition-colors duration-200">
                                                            Delete
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8">
                            <div class="w-16 h-16 bg-emerald-500/10 rounded-2xl flex items-center justify-center mx-auto mb-4 border border-emerald-500/20">
                                <span class="text-2xl">🍽️</span>
                            </div>
                            <h3 class="text-lg font-bold text-white mb-2">No Nutrition Plans Yet</h3>
                            <p class="text-emerald-400/80 mb-4">Start by creating nutrition plans for this member.</p>
                            <a href="{{ route('trainer.programs.nutrition.create', $member->id) }}"
                               class="inline-flex items-center gap-2 px-6 py-3 rounded-xl text-sm font-bold text-white bg-gradient-to-r from-emerald-500 to-emerald-700 hover:from-emerald-600 hover:to-emerald-800 transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-emerald-500/25">
                                Create First Plan
                            </a>
                        </div>
                    @endif
                </div>

                {{-- Add Supplement Form --}}
                <div class="glass-dark rounded-3xl p-6 border border-purple-500/20 shadow-xl shadow-purple-500/10">
                    <h3 class="text-xl font-black text-white mb-4 flex items-center gap-2">
                        <span class="text-purple-400">💊 Add Supplement</span>
                    </h3>

                    <form action="{{ route('trainer.programs.nutrition.supplement.store', $member->id) }}" method="POST" class="space-y-4">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-purple-400 mb-2">Supplement Name</label>
                                <input type="text" name="name" required
                                       placeholder="e.g., Whey Protein, Creatine"
                                       class="w-full px-4 py-3 bg-white border border-purple-500/20 rounded-xl text-black placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-purple-400 focus:border-transparent transition-all duration-300">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-purple-400 mb-2">Recommended Dose</label>
                                <input type="text" name="recommended_dose"
                                       placeholder="e.g., 1 scoop daily, 5g post-workout"
                                       class="w-full px-4 py-3 bg-white border border-purple-500/20 rounded-xl text-black placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-purple-400 focus:border-transparent transition-all duration-300">
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-purple-400 mb-2">Description & Benefits</label>
                            <textarea name="description" rows="3"
                                      placeholder="Describe the supplement and its benefits..."
                                      class="w-full px-4 py-3 bg-white border border-purple-500/20 rounded-xl text-black placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-purple-400 focus:border-transparent transition-all duration-300"></textarea>
                        </div>
                        <button type="submit"
                                class="flex items-center gap-2 px-6 py-3 rounded-xl text-sm font-bold text-white bg-gradient-to-r from-purple-500 to-purple-700 hover:from-purple-600 hover:to-purple-800 transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-purple-500/25">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                            </svg>
                            Add Supplement
                        </button>
                    </form>
                </div>
            </div>

            {{-- Sidebar --}}
            <div class="space-y-8">
                {{-- Member Info --}}
                <div class="glass-dark rounded-3xl p-6 border border-emerald-500/20 shadow-xl shadow-emerald-500/10">
                    <h3 class="text-lg font-black text-white mb-4 flex items-center gap-2">
                        <span class="text-gradient">👤 Member Info</span>
                    </h3>
                    
                    <div class="space-y-3">
                        <div>
                            <span class="text-emerald-400 text-sm font-medium">Name</span>
                            <p class="text-white font-medium">{{ $member->name }}</p>
                        </div>
                        <div>
                            <span class="text-emerald-400 text-sm font-medium">Email</span>
                            <p class="text-white text-sm">{{ $member->email }}</p>
                        </div>
                        @if($member->age)
                        <div>
                            <span class="text-emerald-400 text-sm font-medium">Age</span>
                            <p class="text-white text-sm">{{ $member->age }} years</p>
                        </div>
                        @endif
                        @if($member->gender)
                        <div>
                            <span class="text-emerald-400 text-sm font-medium">Gender</span>
                            <p class="text-white text-sm capitalize">{{ $member->gender }}</p>
                        </div>
                        @endif
                        @if($member->height)
                        <div>
                            <span class="text-emerald-400 text-sm font-medium">Height</span>
                            <p class="text-white text-sm">{{ $member->height }} cm</p>
                        </div>
                        @endif
                        @if($member->weight)
                        <div>
                            <span class="text-emerald-400 text-sm font-medium">Weight</span>
                            <p class="text-white text-sm">{{ $member->weight }} kg</p>
                        </div>
                        @endif
                    </div>
                </div>

                {{-- Supplements List --}}
                <div class="glass-dark rounded-3xl p-6 border border-purple-500/20 shadow-xl shadow-purple-500/10">
                    <h3 class="text-lg font-black text-white mb-4 flex items-center gap-2">
                        <span class="text-purple-400">💊 Current Supplements</span>
                        <span class="text-purple-400/60 text-sm">({{ $supplements->count() }})</span>
                    </h3>

                    @if($supplements->count() > 0)
                        <div class="space-y-3">
                            @foreach($supplements as $supplement)
                                <div class="glass rounded-xl p-4 border border-purple-500/10">
                                    <div class="flex justify-between items-start mb-2">
                                        <h4 class="font-bold text-white text-sm">{{ $supplement->name }}</h4>
                                        <form action="{{ route('trainer.programs.nutrition.supplement.destroy', ['memberId' => $member->id, 'supplementId' => $supplement->id]) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    onclick="return confirm('Delete this supplement?')"
                                                    class="text-xs text-red-400 hover:text-red-300 transition-colors duration-200">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                    @if($supplement->description)
                                        <p class="text-purple-400/70 text-xs mb-2">{{ Str::limit($supplement->description, 80) }}</p>
                                    @endif
                                    @if($supplement->recommended_dose)
                                        <div class="flex justify-between items-center text-xs">
                                            <span class="text-purple-400/60">Dose: {{ $supplement->recommended_dose }}</span>
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-4">
                            <div class="w-12 h-12 bg-purple-500/10 rounded-xl flex items-center justify-center mx-auto mb-3 border border-purple-500/20">
                                <span class="text-xl">💊</span>
                            </div>
                            <p class="text-purple-400/70 text-sm">No supplements added yet.</p>
                        </div>
                    @endif
                </div>

                {{-- Quick Stats --}}
                <div class="glass-dark rounded-3xl p-6 border border-blue-500/20 shadow-xl shadow-blue-500/10">
                    <h3 class="text-lg font-black text-white mb-4 flex items-center gap-2">
                        <span class="text-blue-400">📊 Nutrition Overview</span>
                    </h3>
                    
                    <div class="space-y-3">
                        <div class="flex justify-between items-center">
                            <span class="text-blue-400/80 text-sm">Total Plans</span>
                            <span class="text-white font-medium">{{ $nutritionPlans->count() }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-blue-400/80 text-sm">Days Covered</span>
                            <span class="text-white font-medium">{{ $plansByDay->count() }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-blue-400/80 text-sm">Supplements</span>
                            <span class="text-white font-medium">{{ $supplements->count() }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-blue-400/80 text-sm">Total Calories</span>
                            <span class="text-white font-medium">{{ $nutritionPlans->sum('calories') }}</span>
                        </div>
                    </div>
                </div>

                {{-- Analysis Button --}}
                <div class="glass-dark rounded-3xl p-6 border border-amber-500/20 shadow-xl shadow-amber-500/10">
                    <h3 class="text-lg font-black text-white mb-4 flex items-center gap-2">
                        <span class="text-amber-400">📈 Nutrition Analysis</span>
                    </h3>
                    <p class="text-amber-400/70 text-sm mb-4">View detailed analysis of member's nutrition plans and progress.</p>
                    <a href="{{ route('trainer.programs.nutrition.analysis', $member->id) }}"
                       class="w-full flex items-center justify-center gap-2 px-4 py-3 rounded-xl text-sm font-bold text-white bg-gradient-to-r from-amber-500 to-amber-700 hover:from-amber-600 hover:to-amber-800 transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-amber-500/25">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                        View Analysis
                    </a>
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
@endsection