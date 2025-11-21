@extends('layouts.trainer')

@section('content')
    <div class="min-h-screen py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Header Section --}}
            <div class="glass-dark rounded-3xl p-8 border border-emerald-500/20 shadow-2xl shadow-emerald-500/10 mb-8">
                <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-6">
                    <div class="flex items-center gap-4">
                        <div
                            class="w-14 h-14 bg-gradient-to-br from-emerald-500 to-emerald-700 rounded-2xl flex items-center justify-center animate-glow">
                            <span class="text-2xl">💪</span>
                        </div>
                        <div>
                            <h1 class="text-3xl sm:text-4xl font-black text-white">
                                Program <span class="text-gradient">Details</span>
                            </h1>
                            <p class="text-emerald-400/80 text-lg mt-2">Complete member program overview and exercise
                                management</p>
                        </div>
                    </div>
                    <div class="flex gap-3">
                        <a href="{{ route('trainer.programs.progress', $member->id) }}"
                            class="group flex items-center gap-2 px-6 py-3 rounded-xl text-sm font-bold text-white bg-gradient-to-r from-blue-500 to-blue-700 hover:from-blue-600 hover:to-blue-800 transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-blue-500/25">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                            </svg>
                            View Progress
                        </a>
                        <a href="{{ route('trainer.programs.edit', $member->id) }}"
                            class="group flex items-center gap-2 px-6 py-3 rounded-xl text-sm font-bold text-white bg-gradient-to-r from-amber-500 to-amber-700 hover:from-amber-600 hover:to-amber-800 transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-amber-500/25">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                            Edit Program
                        </a>
                    </div>
                </div>
            </div>

            {{-- Member Overview --}}
            <div class="glass-dark rounded-3xl p-6 border border-emerald-500/20 shadow-xl shadow-emerald-500/10 mb-8">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    {{-- Member Info --}}
                    <div>
                        <h2 class="text-2xl font-black text-white mb-2">{{ $member->name }}</h2>
                        <p class="text-emerald-400/80 text-lg mb-4">{{ $member->email }}</p>

                        <div class="flex flex-wrap gap-4 mb-4">
                            <div class="flex items-center gap-2">
                                <span class="text-emerald-400 text-sm font-bold">Goal:</span>
                                <span
                                    class="text-white text-sm font-medium capitalize">{{ $member->goal->name ?? 'Not Set' }}</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="text-emerald-400 text-sm font-bold">Gender:</span>
                                <span
                                    class="text-white text-sm font-medium capitalize">{{ $member->gender ?? 'Not Set' }}</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="text-emerald-400 text-sm font-bold">Age:</span>
                                <span class="text-white text-sm font-medium">{{ $member->age ?? 'Not Set' }}</span>
                            </div>
                            @if($member->height && $member->weight)
                                <div class="flex items-center gap-2">
                                    <span class="text-emerald-400 text-sm font-bold">BMI:</span>
                                    <span class="text-white text-sm font-medium">
                                        @php
                                            $heightInMeter = $member->height / 100;
                                            $bmi = $member->weight / ($heightInMeter ** 2);
                                        @endphp
                                        {{ number_format($bmi, 1) }}
                                    </span>
                                </div>
                            @endif
                        </div>

                        <div class="flex items-center gap-2 text-sm text-emerald-400">
                            <span>Member since:</span>
                            <span class="font-bold text-white">{{ $member->created_at->format('M d, Y') }}</span>
                        </div>
                    </div>

                    {{-- Quick Stats --}}
                    <div class="grid grid-cols-2 gap-4">
                        <div class="glass rounded-xl p-4 text-center border border-emerald-500/10">
                            <div class="text-2xl font-black text-emerald-400 mb-1">
                                {{ $workoutHistory ? $workoutHistory->count() : 0 }}
                            </div>
                            <div class="text-xs text-emerald-400/80">Total Workouts</div>
                        </div>
                        <div class="glass rounded-xl p-4 text-center border border-blue-500/10">
                            <div class="text-2xl font-black text-blue-400 mb-1">
                                {{ $workoutHistory ? $workoutHistory->where('status', 'completed')->count() : 0 }}
                            </div>
                            <div class="text-xs text-blue-400/80">Completed</div>
                        </div>
                        <div class="glass rounded-xl p-4 text-center border border-amber-500/10">
                            <div class="text-2xl font-black text-amber-400 mb-1">
                                @php
                                    $totalWorkouts = $workoutHistory ? $workoutHistory->count() : 0;
                                    $completedWorkouts = $workoutHistory ? $workoutHistory->where('status', 'completed')->count() : 0;
                                    $completionRate = $totalWorkouts > 0 ? round(($completedWorkouts / $totalWorkouts) * 100) : 0;
                                @endphp
                                {{ $completionRate }}%
                            </div>
                            <div class="text-xs text-amber-400/80">Completion Rate</div>
                        </div>
                        <div class="glass rounded-xl p-4 text-center border border-purple-500/10">
                            <div class="text-2xl font-black text-purple-400 mb-1">
                                {{ $currentPlan ? ($currentPlan->duration_weeks ?? 4) : 0 }}
                            </div>
                            <div class="text-xs text-purple-400/80">Program Weeks</div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Current Program Section --}}
            @if($currentPlan)
                <div class="glass-dark rounded-3xl p-6 border border-emerald-500/20 shadow-xl shadow-emerald-500/10 mb-8">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-2xl font-black text-white flex items-center gap-2">
                            <span class="text-gradient">Current Program</span>
                        </h3>
                        <div class="flex gap-2">
                            <span
                                class="text-xs font-medium px-3 py-1 rounded-full bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 capitalize">
                                {{ $currentPlan->level ?? 'Intermediate' }}
                            </span>
                            <span
                                class="text-xs font-medium px-3 py-1 rounded-full bg-blue-500/10 text-blue-400 border border-blue-500/20">
                                {{ $currentPlan->duration_weeks ?? 4 }} weeks
                            </span>
                        </div>
                    </div>

                    {{-- Program Details --}}
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
                        <div>
                            <h4 class="text-lg font-black text-white mb-4">{{ $currentPlan->title }}</h4>
                            @if($currentPlan->description)
                                <p class="text-emerald-400/80 text-sm leading-relaxed mb-4">{{ $currentPlan->description }}</p>
                            @endif

                            <div class="flex flex-wrap gap-4">
                                @if($currentPlan->target_fitness)
                                    <div>
                                        <span class="text-emerald-400 text-sm font-bold">Target:</span>
                                        <span class="text-white text-sm ml-2 capitalize">{{ $currentPlan->target_fitness }}</span>
                                    </div>
                                @endif
                                @if($currentPlan->focus_area)
                                    <div>
                                        <span class="text-emerald-400 text-sm font-bold">Focus Area:</span>
                                        <span class="text-white text-sm ml-2 capitalize">{{ $currentPlan->focus_area }}</span>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="glass rounded-2xl p-4 border border-emerald-500/10">
                            <h5 class="text-sm font-bold text-white mb-3 flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-emerald-400" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Program Stats
                            </h5>
                            <div class="space-y-2">
                                <div class="flex justify-between text-sm">
                                    <span class="text-emerald-400/80">Created</span>
                                    <span class="text-white font-medium">{{ $currentPlan->created_at->format('M d, Y') }}</span>
                                </div>
                                <div class="flex justify-between text-sm">
                                    <span class="text-emerald-400/80">Status</span>
                                    <span
                                        class="text-white font-medium capitalize">{{ $currentPlan->status ?? 'active' }}</span>
                                </div>
                                <div class="flex justify-between text-sm">
                                    <span class="text-emerald-400/80">Exercises</span>
                                    <span class="text-white font-medium">
                                        {{ ($currentPlan->workoutExercises ? $currentPlan->workoutExercises->count() : 0) + ($currentPlan->exercises ? $currentPlan->exercises->count() : 0) }}
                                    </span>
                                </div>
                                <div class="flex justify-between text-sm">
                                    <span class="text-emerald-400/80">Duration</span>
                                    <span class="text-white font-medium">{{ $currentPlan->duration_minutes ?? 45 }}
                                        mins/session</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Exercises Section --}}
                    <div class="space-y-4">
                        <h4 class="text-lg font-black text-white mb-4">Program Exercises</h4>

                        {{-- Workout Exercises --}}
                        @if($currentPlan->workoutExercises && $currentPlan->workoutExercises->count() > 0)
                            @foreach($currentPlan->workoutExercises as $index => $exercise)
                                <div class="glass rounded-2xl p-4 border border-emerald-500/10">
                                    <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4 mb-3">
                                        <div class="flex-1">
                                            <div class="flex items-center gap-3 mb-2">
                                                <span class="text-emerald-400 text-sm font-black">#{{ $index + 1 }}</span>
                                                <h5 class="text-md font-black text-white">{{ $exercise->name }}</h5>
                                            </div>
                                            <div class="flex flex-wrap gap-2">
                                                @if($exercise->type)
                                                    <span
                                                        class="text-xs font-medium px-2.5 py-1 rounded-full bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 capitalize">
                                                        {{ $exercise->type }}
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="flex items-center gap-4 text-sm text-white">
                                            @if($exercise->sets)
                                                <div class="text-center">
                                                    <span class="block text-lg font-black text-emerald-400">{{ $exercise->sets }}</span>
                                                    <span class="text-xs text-emerald-400/80">Sets</span>
                                                </div>
                                            @endif
                                            @if($exercise->reps)
                                                <div class="text-center">
                                                    <span class="block text-lg font-black text-blue-400">{{ $exercise->reps }}</span>
                                                    <span class="text-xs text-blue-400/80">Reps</span>
                                                </div>
                                            @endif
                                            @if($exercise->rest_seconds)
                                                <div class="text-center">
                                                    <span
                                                        class="block text-lg font-black text-amber-400">{{ $exercise->rest_seconds }}</span>
                                                    <span class="text-xs text-amber-400/80">Rest</span>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <p class="text-emerald-400/70 text-sm">
                                        @if($exercise->type === 'cardio')
                                            Focus on maintaining consistent pace and proper breathing.
                                        @elseif($exercise->type === 'strength')
                                            Control the movement, focus on form and technique.
                                        @else
                                            Perform with controlled movement and proper form.
                                        @endif
                                    </p>
                                </div>
                            @endforeach
                        @endif

                        {{-- Exercises from exercises table --}}
                        @if($currentPlan->exercises && $currentPlan->exercises->count() > 0)
                            @foreach($currentPlan->exercises as $index => $exercise)
                                <div class="glass rounded-2xl p-4 border border-emerald-500/10">
                                    <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4 mb-3">
                                        <div class="flex-1">
                                            <div class="flex items-center gap-3 mb-2">
                                                <span
                                                    class="text-emerald-400 text-sm font-black">#{{ $index + 1 + ($currentPlan->workoutExercises ? $currentPlan->workoutExercises->count() : 0) }}</span>
                                                <h5 class="text-md font-black text-white">{{ $exercise->name }}</h5>
                                            </div>
                                            <div class="flex flex-wrap gap-2">
                                                <span
                                                    class="text-xs font-medium px-2.5 py-1 rounded-full bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 capitalize">
                                                    {{ $exercise->type }}
                                                </span>
                                                <span
                                                    class="text-xs font-medium px-2.5 py-1 rounded-full bg-blue-500/10 text-blue-400 border border-blue-500/20 capitalize">
                                                    {{ $exercise->muscle_group }}
                                                </span>
                                                <span
                                                    class="text-xs font-medium px-2.5 py-1 rounded-full bg-amber-500/10 text-amber-400 border border-amber-500/20 capitalize">
                                                    {{ $exercise->difficulty }}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="flex items-center gap-4 text-sm text-white">
                                            @if($exercise->pivot->sets)
                                                <div class="text-center">
                                                    <span
                                                        class="block text-lg font-black text-emerald-400">{{ $exercise->pivot->sets }}</span>
                                                    <span class="text-xs text-emerald-400/80">Sets</span>
                                                </div>
                                            @endif
                                            @if($exercise->pivot->reps)
                                                <div class="text-center">
                                                    <span class="block text-lg font-black text-blue-400">{{ $exercise->pivot->reps }}</span>
                                                    <span class="text-xs text-blue-400/80">Reps</span>
                                                </div>
                                            @endif
                                            @if($exercise->pivot->duration)
                                                <div class="text-center">
                                                    <span
                                                        class="block text-lg font-black text-amber-400">{{ $exercise->pivot->duration }}</span>
                                                    <span class="text-xs text-amber-400/80">Secs</span>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    @if($exercise->description)
                                        <p class="text-emerald-400/70 text-sm">{{ Str::limit($exercise->description, 150) }}</p>
                                    @endif
                                </div>
                            @endforeach
                        @endif

                        {{-- No Exercises Message --}}
                        @if((!$currentPlan->workoutExercises || $currentPlan->workoutExercises->count() === 0) && (!$currentPlan->exercises || $currentPlan->exercises->count() === 0))
                            <div class="glass rounded-2xl p-6 text-center border border-emerald-500/10">
                                <div
                                    class="w-12 h-12 bg-emerald-500/10 rounded-xl flex items-center justify-center mx-auto mb-3 border border-emerald-500/20">
                                    <span class="text-xl">💪</span>
                                </div>
                                <h5 class="text-md font-bold text-white mb-2">No Exercises Configured</h5>
                                <p class="text-emerald-400/70 text-sm">Add exercises to this program in the edit section.</p>
                            </div>
                        @endif
                    </div>
                </div>
            @else
                {{-- No Program Message --}}
                <div class="glass-dark rounded-3xl p-8 border border-emerald-500/20 text-center mb-8">
                    <div
                        class="w-16 h-16 bg-emerald-500/10 rounded-2xl flex items-center justify-center mx-auto mb-4 border border-emerald-500/20">
                        <span class="text-2xl">💪</span>
                    </div>
                    <h3 class="text-lg font-bold text-white mb-2">No Active Program</h3>
                    <p class="text-emerald-400/80 mb-4">This member doesn't have an active workout program yet.</p>
                    <a href="{{ route('trainer.programs.edit', $member->id) }}"
                        class="inline-flex items-center gap-2 px-6 py-3 rounded-xl text-sm font-bold text-white bg-gradient-to-r from-emerald-500 to-emerald-700 hover:from-emerald-600 hover:to-emerald-800 transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-emerald-500/25">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                                clip-rule="evenodd" />
                        </svg>
                        Create First Program
                    </a>
                </div>
            @endif

            {{-- Recent Workout History --}}
            <div class="glass-dark rounded-3xl p-6 border border-emerald-500/20 shadow-xl shadow-emerald-500/10 mb-8">
                <h3 class="text-2xl font-black text-white mb-6 flex items-center gap-2">
                    <span class="text-gradient">Recent Workout History</span>
                    <span class="text-emerald-400/60 text-lg">(Last 10 sessions)</span>
                </h3>

                @if($workoutHistory && $workoutHistory->count() > 0)
                    <div class="space-y-3">
                        @foreach($workoutHistory as $workout)
                            <div class="glass rounded-2xl p-4 border border-emerald-500/10">
                                <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4">
                                    <div class="flex-1">
                                        <div class="flex items-center gap-3 mb-2">
                                            <h4 class="text-md font-black text-white">
                                                @if($workout->workoutPlan)
                                                    {{ $workout->workoutPlan->title }}
                                                @else
                                                    {{ $workout->title ?? 'Workout Session' }}
                                                @endif
                                            </h4>
                                            <span
                                                class="text-xs font-medium px-2.5 py-1 rounded-full 
                                                            @if($workout->status === 'completed') bg-emerald-500/10 text-emerald-400 border border-emerald-500/20
                                                            @elseif($workout->status === 'scheduled') bg-blue-500/10 text-blue-400 border border-blue-500/20
                                                            @else bg-amber-500/10 text-amber-400 border border-amber-500/20 @endif capitalize">
                                                {{ $workout->status }}
                                            </span>
                                        </div>
                                        <div class="flex flex-wrap gap-4 text-sm">
                                            @if($workout->scheduled_date)
                                                <span class="text-emerald-400/80">
                                                    {{ \Carbon\Carbon::parse($workout->scheduled_date)->format('M d, Y') }}
                                                </span>
                                            @endif
                                            @if($workout->duration)
                                                <span class="text-blue-400/80">{{ $workout->duration }} minutes</span>
                                            @endif
                                            @if($workout->completed_at)
                                                <span class="text-amber-400/80">
                                                    Completed: {{ \Carbon\Carbon::parse($workout->completed_at)->format('M d') }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    @if($workout->notes)
                                        <div class="text-right">
                                            <p class="text-emerald-400/70 text-sm max-w-xs">{{ Str::limit($workout->notes, 60) }}</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="glass rounded-2xl p-6 text-center border border-emerald-500/10">
                        <div
                            class="w-12 h-12 bg-emerald-500/10 rounded-xl flex items-center justify-center mx-auto mb-3 border border-emerald-500/20">
                            <span class="text-xl">📊</span>
                        </div>
                        <h5 class="text-md font-bold text-white mb-2">No Workout History</h5>
                        <p class="text-emerald-400/70 text-sm">This member hasn't completed any workouts yet.</p>
                    </div>
                @endif
            </div>

            {{-- Action Buttons --}}
            <div class="flex flex-col sm:flex-row gap-4 justify-between items-center">
                <a href="{{ route('trainer.programs.index') }}"
                    class="group flex items-center gap-2 px-6 py-3 rounded-xl text-sm font-bold text-gray-400 hover:text-white transition-all duration-300 border border-gray-600 hover:bg-gray-700/50 w-full sm:w-auto justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Back to Members
                </a>
                <div class="flex gap-3">
                    <a href="{{ route('trainer.programs.progress', $member->id) }}"
                        class="group flex items-center gap-2 px-6 py-3 rounded-xl text-sm font-bold text-white bg-gradient-to-r from-blue-500 to-blue-700 hover:from-blue-600 hover:to-blue-800 transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-blue-500/25 w-full sm:w-auto justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                        View Progress
                    </a>
                    <a href="{{ route('trainer.programs.edit', $member->id) }}"
                        class="group flex items-center gap-2 px-6 py-3 rounded-xl text-sm font-bold text-white bg-gradient-to-r from-emerald-500 to-emerald-700 hover:from-emerald-600 hover:to-emerald-800 transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-emerald-500/25 w-full sm:w-auto justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                        Edit Program
                    </a>
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

        @keyframes glow {
            from {
                box-shadow: 0 0 10px rgba(16, 185, 129, 0.4);
            }

            to {
                box-shadow: 0 0 20px rgba(16, 185, 129, 0.6), 0 0 30px rgba(16, 185, 129, 0.4);
            }
        }
    </style>
@endsection