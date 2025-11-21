@extends('layouts.trainer')

@section('title', 'Detail Member')

@section('content')
    <div class="min-h-screen py-4 md:py-8">
        <div class="max-w-7xl mx-auto px-3 sm:px-4 lg:px-8">

            {{-- Header Section --}}
            <div
                class="glass-dark rounded-2xl md:rounded-3xl p-4 md:p-8 border border-emerald-500/20 shadow-lg md:shadow-2xl shadow-emerald-500/10 mb-6 md:mb-8">
                <div class="flex flex-col lg:flex-row justify-between items-start gap-4 md:gap-6">
                    <div class="flex items-center gap-3 md:gap-4">
                        <div
                            class="w-10 h-10 md:w-14 md:h-14 bg-gradient-to-br from-emerald-500 to-emerald-700 rounded-xl md:rounded-2xl flex items-center justify-center animate-glow">
                            <span class="text-xl md:text-2xl">👤</span>
                        </div>
                        <div class="flex-1 min-w-0">
                            <h1 class="text-2xl sm:text-3xl md:text-4xl font-black text-white leading-tight">
                                Member <span class="text-gradient">Details</span>
                            </h1>
                            <p class="text-emerald-400/80 text-sm md:text-lg mt-1 md:mt-2">Track and monitor
                                {{ $member->name }}'s progress and subscription</p>
                        </div>
                    </div>
                    <div class="text-left lg:text-right w-full lg:w-auto mt-4 lg:mt-0">
                        <div class="text-emerald-400 font-bold text-xs md:text-sm uppercase tracking-wider mb-1 md:mb-2">
                            Status</div>
                        @php
                            $memberStatus = $latestPremiumAccess ?
                                App\Http\Controllers\Trainer\MemberController::getMemberStatus($latestPremiumAccess) :
                                ['status' => 'inactive', 'label' => 'Tidak Aktif', 'color' => 'red', 'days_remaining' => 0];
                        @endphp
                        @if($memberStatus['color'] === 'green')
                            <span
                                class="px-3 py-2 text-sm font-medium rounded-full bg-green-500/20 text-green-400 border border-green-500/30">
                                ✅ {{ $memberStatus['label'] }} - {{ $memberStatus['days_remaining'] }} days left
                            </span>
                        @elseif($memberStatus['color'] === 'yellow')
                            <span
                                class="px-3 py-2 text-sm font-medium rounded-full bg-yellow-500/20 text-yellow-400 border border-yellow-500/30">
                                ⚠️ {{ $memberStatus['label'] }} - {{ $memberStatus['days_remaining'] }} days left
                            </span>
                        @else
                            <span
                                class="px-3 py-2 text-sm font-medium rounded-full bg-red-500/20 text-red-400 border border-red-500/30">
                                ❌ {{ $memberStatus['label'] }}
                            </span>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Member Info Cards --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 md:gap-6 mb-6 md:mb-8">
                {{-- Basic Info --}}
                <div class="glass rounded-xl md:rounded-2xl p-4 md:p-6 border border-emerald-500/20">
                    <div class="flex items-center gap-3 md:gap-4 mb-3 md:mb-4">
                        <div
                            class="w-10 h-10 md:w-12 md:h-12 bg-emerald-500/10 rounded-xl flex items-center justify-center">
                            <span class="text-emerald-400 text-lg">👤</span>
                        </div>
                        <div>
                            <h3 class="text-lg md:text-xl font-black text-white">Profile Info</h3>
                            <p class="text-emerald-400 text-sm">Member Details</p>
                        </div>
                    </div>
                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-400">Name:</span>
                            <span class="text-white font-medium">{{ $member->name }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-400">Email:</span>
                            <span class="text-white font-medium">{{ $member->email }}</span>
                        </div>
                        @if($member->age)
                            <div class="flex justify-between">
                                <span class="text-gray-400">Age:</span>
                                <span class="text-white font-medium">{{ $member->age }} years</span>
                            </div>
                        @endif
                        @if($member->gender)
                            <div class="flex justify-between">
                                <span class="text-gray-400">Gender:</span>
                                <span class="text-white font-medium capitalize">{{ $member->gender }}</span>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Subscription Info --}}
                <div class="glass rounded-xl md:rounded-2xl p-4 md:p-6 border border-emerald-500/20">
                    <div class="flex items-center gap-3 md:gap-4 mb-3 md:mb-4">
                        <div
                            class="w-10 h-10 md:w-12 md:h-12 bg-emerald-500/10 rounded-xl flex items-center justify-center">
                            <span class="text-emerald-400 text-lg">💎</span>
                        </div>
                        <div>
                            <h3 class="text-lg md:text-xl font-black text-white">Subscription</h3>
                            <p class="text-emerald-400 text-sm">Membership Status</p>
                        </div>
                    </div>
                    @if($latestPremiumAccess)
                        <div class="space-y-2 text-sm">
                            <div class="flex justify-between">
                                <span class="text-gray-400">Start Date:</span>
                                <span
                                    class="text-white font-medium">{{ \Carbon\Carbon::parse($latestPremiumAccess->start_date)->format('d M Y') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-400">End Date:</span>
                                <span
                                    class="text-white font-medium">{{ \Carbon\Carbon::parse($latestPremiumAccess->end_date)->format('d M Y') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-400">Payment Status:</span>
                                <span
                                    class="text-white font-medium capitalize">{{ $latestPremiumAccess->payment_status }}</span>
                            </div>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <span class="text-red-400 text-sm">No active subscription</span>
                        </div>
                    @endif
                </div>

                {{-- Activity Stats --}}
                <div class="glass rounded-xl md:rounded-2xl p-4 md:p-6 border border-emerald-500/20">
                    <div class="flex items-center gap-3 md:gap-4 mb-3 md:mb-4">
                        <div
                            class="w-10 h-10 md:w-12 md:h-12 bg-emerald-500/10 rounded-xl flex items-center justify-center">
                            <span class="text-emerald-400 text-lg">📊</span>
                        </div>
                        <div>
                            <h3 class="text-lg md:text-xl font-black text-white">Activity</h3>
                            <p class="text-emerald-400 text-sm">Progress Overview</p>
                        </div>
                    </div>
                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-400">Progress Logs:</span>
                            <span class="text-emerald-400 font-medium">{{ $progressLogs->count() }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-400">Payment History:</span>
                            <span class="text-emerald-400 font-medium">{{ $paymentHistory->count() }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-400">Premium Periods:</span>
                            <span class="text-emerald-400 font-medium">{{ $premiumHistory->count() }}</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Quick Actions --}}
            <div class="glass-dark rounded-xl md:rounded-2xl p-4 md:p-6 border border-emerald-500/20 mb-6 md:mb-8">
                <h3 class="text-lg md:text-xl font-black text-white mb-3 md:mb-4">Quick Actions</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 md:gap-4">
                    <a href="{{ route('trainer.communication.chat.index') }}?user_id={{ $member->id }}"
                        class="glass rounded-xl md:rounded-2xl p-3 md:p-4 border border-emerald-500/20 hover:border-emerald-500/40 transition-all duration-300 hover-glow text-center group">
                        <div
                            class="w-8 h-8 md:w-10 md:h-10 bg-emerald-500/20 rounded-lg md:rounded-xl flex items-center justify-center mx-auto mb-2 group-hover:scale-110 transition-transform duration-300">
                            <span class="text-emerald-400 text-lg">💬</span>
                        </div>
                        <div class="text-white font-semibold text-sm md:text-base">Send Message</div>
                        <div class="text-emerald-400 text-xs">Chat with Member</div>
                    </a>

                    <a href="{{ route('trainer.programs.nutrition.index', ['memberId' => $member->id]) }}"
                        class="glass rounded-xl md:rounded-2xl p-3 md:p-4 border border-blue-500/20 hover:border-blue-500/40 transition-all duration-300 hover-glow text-center group">
                        <div
                            class="w-8 h-8 md:w-10 md:h-10 bg-blue-500/20 rounded-lg md:rounded-xl flex items-center justify-center mx-auto mb-2 group-hover:scale-110 transition-transform duration-300">
                            <span class="text-blue-400 text-lg">🍎</span>
                        </div>
                        <div class="text-white font-semibold text-sm md:text-base">Nutrition Plan</div>
                        <div class="text-blue-400 text-xs">Manage Diet</div>
                    </a>

                    <a href="{{ route('trainer.programs.edit', ['memberId' => $member->id]) }}"
                        class="glass rounded-xl md:rounded-2xl p-3 md:p-4 border border-purple-500/20 hover:border-purple-500/40 transition-all duration-300 hover-glow text-center group">
                        <div
                            class="w-8 h-8 md:w-10 md:h-10 bg-purple-500/20 rounded-lg md:rounded-xl flex items-center justify-center mx-auto mb-2 group-hover:scale-110 transition-transform duration-300">
                            <span class="text-purple-400 text-lg">💪</span>
                        </div>
                        <div class="text-white font-semibold text-sm md:text-base">Workout Plan</div>
                        <div class="text-purple-400 text-xs">Training Program</div>
                    </a>

                    @if($realTimeStatus['is_expired'])
                        <form action="{{ route('trainer.members.remove', $member->id) }}" method="POST" class="contents">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="glass rounded-xl md:rounded-2xl p-3 md:p-4 border border-red-500/20 hover:border-red-500/40 transition-all duration-300 hover-glow text-center group w-full"
                                onclick="return confirm('Remove {{ $member->name }} from your member list?')">
                                <div
                                    class="w-8 h-8 md:w-10 md:h-10 bg-red-500/20 rounded-lg md:rounded-xl flex items-center justify-center mx-auto mb-2 group-hover:scale-110 transition-transform duration-300">
                                    <span class="text-red-400 text-lg">🗑️</span>
                                </div>
                                <div class="text-white font-semibold text-sm md:text-base">Remove</div>
                                <div class="text-red-400 text-xs">Expired Member</div>
                            </button>
                        </form>
                    @else
                        <div
                            class="glass rounded-xl md:rounded-2xl p-3 md:p-4 border border-gray-500/20 text-center opacity-75">
                            <div
                                class="w-8 h-8 md:w-10 md:h-10 bg-gray-500/20 rounded-lg md:rounded-xl flex items-center justify-center mx-auto mb-2">
                                <span class="text-gray-400 text-lg">👁️</span>
                            </div>
                            <div class="text-gray-400 font-semibold text-sm md:text-base">Active</div>
                            <div class="text-gray-400 text-xs">Member is Active</div>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Tabs Section --}}
            <div
                class="glass-dark rounded-xl md:rounded-2xl p-4 md:p-6 border border-emerald-500/20 shadow-lg md:shadow-xl shadow-emerald-500/10">
                <div class="border-b border-emerald-500/20 mb-4 md:mb-6">
                    <nav class="-mb-px flex space-x-4 md:space-x-8 overflow-x-auto">
                        <button id="tab-progress"
                            class="tab-button py-3 px-2 md:px-4 border-b-2 border-emerald-500 font-semibold text-sm md:text-base text-emerald-400 whitespace-nowrap"
                            data-tab="progress">
                            <span class="flex items-center gap-2">
                                <span>📈</span>
                                Progress Logs ({{ $progressLogs->count() }})
                            </span>
                        </button>
                        <button id="tab-premium"
                            class="tab-button py-3 px-2 md:px-4 border-b-2 border-transparent font-semibold text-sm md:text-base text-gray-500 hover:text-gray-400 whitespace-nowrap"
                            data-tab="premium">
                            <span class="flex items-center gap-2">
                                <span>💎</span>
                                Premium History ({{ $premiumHistory->count() }})
                            </span>
                        </button>
                        <button id="tab-payment"
                            class="tab-button py-3 px-2 md:px-4 border-b-2 border-transparent font-semibold text-sm md:text-base text-gray-500 hover:text-gray-400 whitespace-nowrap"
                            data-tab="payment">
                            <span class="flex items-center gap-2">
                                <span>💰</span>
                                Payment History ({{ $paymentHistory->count() }})
                            </span>
                        </button>
                    </nav>
                </div>

                {{-- Tab Content: Progress Logs --}}
                <div id="tab-content-progress" class="tab-content">
                    @if($progressLogs->isEmpty())
                        <div class="text-center py-8 md:py-12">
                            <div
                                class="w-16 h-16 md:w-20 md:h-20 bg-emerald-500/10 rounded-2xl flex items-center justify-center mx-auto mb-4 border border-emerald-500/20">
                                <span class="text-2xl md:text-3xl">📊</span>
                            </div>
                            <h3 class="text-lg md:text-xl font-black text-white mb-2">No Progress Logs</h3>
                            <p class="text-emerald-400/80 text-sm md:text-base max-w-md mx-auto">
                                {{ $member->name }} hasn't logged any activities yet. Progress logs will appear here once they
                                start tracking their workouts and nutrition.
                            </p>
                        </div>
                    @else
                        <div class="space-y-4 md:space-y-6">
                            @foreach($progressLogs as $log)
                                <div
                                    class="glass rounded-xl md:rounded-2xl p-4 md:p-6 border border-emerald-500/10 hover:border-emerald-500/30 transition-all duration-300">
                                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 mb-3">
                                        <h4 class="text-lg md:text-xl font-black text-emerald-400">
                                            {{ \Carbon\Carbon::parse($log->log_date)->format('d M Y') }}
                                        </h4>
                                        <span class="text-sm text-gray-400">
                                            {{ \Carbon\Carbon::parse($log->log_date)->diffForHumans() }}
                                        </span>
                                    </div>

                                    <div class="grid grid-cols-2 md:grid-cols-4 gap-3 md:gap-4 mb-3">
                                        <div class="text-center">
                                            <div class="text-2xl md:text-3xl font-black text-white">
                                                {{ $log->calories_consumed ?? '0' }}</div>
                                            <div class="text-emerald-400 text-xs md:text-sm">Calories</div>
                                        </div>
                                        <div class="text-center">
                                            <div class="text-2xl md:text-3xl font-black text-white">
                                                {{ $log->protein_consumed ?? '0' }}g</div>
                                            <div class="text-blue-400 text-xs md:text-sm">Protein</div>
                                        </div>
                                        <div class="text-center">
                                            <div class="text-2xl md:text-3xl font-black text-white">
                                                {{ $log->carbs_consumed ?? '0' }}g</div>
                                            <div class="text-yellow-400 text-xs md:text-sm">Carbs</div>
                                        </div>
                                        <div class="text-center">
                                            <div class="text-2xl md:text-3xl font-black text-white">{{ $log->fat_consumed ?? '0' }}g
                                            </div>
                                            <div class="text-red-400 text-xs md:text-sm">Fat</div>
                                        </div>
                                    </div>

                                    @if($log->notes)
                                        <div class="bg-dark-800/50 rounded-lg md:rounded-xl p-3 md:p-4 border border-emerald-500/10">
                                            <div class="flex items-start gap-2">
                                                <span class="text-emerald-400 mt-1">📝</span>
                                                <p class="text-gray-300 text-sm md:text-base leading-relaxed">{{ $log->notes }}</p>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                {{-- Tab Content: Premium History --}}
                <div id="tab-content-premium" class="tab-content hidden">
                    @if($premiumHistory->isEmpty())
                        <div class="text-center py-8 md:py-12">
                            <div
                                class="w-16 h-16 md:w-20 md:h-20 bg-emerald-500/10 rounded-2xl flex items-center justify-center mx-auto mb-4 border border-emerald-500/20">
                                <span class="text-2xl md:text-3xl">💎</span>
                            </div>
                            <h3 class="text-lg md:text-xl font-black text-white mb-2">No Premium History</h3>
                            <p class="text-emerald-400/80 text-sm md:text-base max-w-md mx-auto">
                                No premium access history found for {{ $member->name }}.
                            </p>
                        </div>
                    @else
                        <div class="space-y-4 md:space-y-6">
                            @foreach($premiumHistory as $premium)
                                <div class="glass rounded-xl md:rounded-2xl p-4 md:p-6 border 
                                            @if($premium->payment_status === 'paid') border-green-500/20 hover:border-green-500/40
                                            @else border-yellow-500/20 hover:border-yellow-500/40 @endif
                                            transition-all duration-300">
                                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 mb-3">
                                        <h4 class="text-lg md:text-xl font-black text-white">
                                            {{ \Carbon\Carbon::parse($premium->start_date)->format('d M Y') }} -
                                            {{ \Carbon\Carbon::parse($premium->end_date)->format('d M Y') }}
                                        </h4>
                                        <span class="px-3 py-1 text-xs font-medium rounded-full 
                                                    @if($premium->payment_status === 'paid') bg-green-500/20 text-green-400 border border-green-500/30
                                                    @else bg-yellow-500/20 text-yellow-400 border border-yellow-500/30 @endif
                                                    capitalize">
                                            {{ $premium->payment_status }}
                                        </span>
                                    </div>

                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3 text-sm">
                                        <div>
                                            <span class="text-gray-400">Duration:</span>
                                            <span class="text-white font-medium">
                                                {{ \Carbon\Carbon::parse($premium->start_date)->diffInDays($premium->end_date) }}
                                                days
                                            </span>
                                        </div>
                                        <div>
                                            <span class="text-gray-400">Created:</span>
                                            <span class="text-white font-medium">
                                                {{ \Carbon\Carbon::parse($premium->created_at)->format('d M Y H:i') }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                {{-- Tab Content: Payment History --}}
                <div id="tab-content-payment" class="tab-content hidden">
                    @if($paymentHistory->isEmpty())
                        <div class="text-center py-8 md:py-12">
                            <div
                                class="w-16 h-16 md:w-20 md:h-20 bg-emerald-500/10 rounded-2xl flex items-center justify-center mx-auto mb-4 border border-emerald-500/20">
                                <span class="text-2xl md:text-3xl">💰</span>
                            </div>
                            <h3 class="text-lg md:text-xl font-black text-white mb-2">No Payment History</h3>
                            <p class="text-emerald-400/80 text-sm md:text-base max-w-md mx-auto">
                                No payment history found for {{ $member->name }}.
                            </p>
                        </div>
                    @else
                        <div class="space-y-4 md:space-y-6">
                            @foreach($paymentHistory as $payment)
                                <div class="glass rounded-xl md:rounded-2xl p-4 md:p-6 border 
                                            @if($payment->status === 'paid') border-green-500/20 hover:border-green-500/40
                                            @elseif($payment->status === 'pending') border-yellow-500/20 hover:border-yellow-500/40
                                            @else border-red-500/20 hover:border-red-500/40 @endif
                                            transition-all duration-300">
                                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 mb-3">
                                        <h4 class="text-lg md:text-xl font-black text-white truncate">
                                            {{ $payment->order_id }}
                                        </h4>
                                        <span class="px-3 py-1 text-xs font-medium rounded-full 
                                                    @if($payment->status === 'paid') bg-green-500/20 text-green-400 border border-green-500/30
                                                    @elseif($payment->status === 'pending') bg-yellow-500/20 text-yellow-400 border border-yellow-500/30
                                                    @else bg-red-500/20 text-red-400 border border-red-500/30 @endif
                                                    capitalize">
                                            {{ $payment->status }}
                                        </span>
                                    </div>

                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3 text-sm mb-3">
                                        <div>
                                            <span class="text-gray-400">Amount:</span>
                                            <span class="text-white font-medium">
                                                Rp {{ number_format($payment->amount, 0, ',', '.') }}
                                            </span>
                                        </div>
                                        <div>
                                            <span class="text-gray-400">Method:</span>
                                            <span class="text-white font-medium capitalize">
                                                {{ $payment->method }}
                                            </span>
                                        </div>
                                    </div>

                                    <div class="text-sm">
                                        <span class="text-gray-400">Date:</span>
                                        <span class="text-white font-medium">
                                            {{ \Carbon\Carbon::parse($payment->created_at)->format('d M Y H:i') }}
                                        </span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const tabButtons = document.querySelectorAll('.tab-button');
            const tabContents = document.querySelectorAll('.tab-content');

            tabButtons.forEach(button => {
                button.addEventListener('click', function () {
                    const tabId = this.getAttribute('data-tab');

                    // Update active tab button
                    tabButtons.forEach(btn => {
                        btn.classList.remove('border-emerald-500', 'text-emerald-400');
                        btn.classList.add('border-transparent', 'text-gray-500');
                    });
                    this.classList.add('border-emerald-500', 'text-emerald-400');
                    this.classList.remove('border-transparent', 'text-gray-500');

                    // Show active tab content
                    tabContents.forEach(content => {
                        content.classList.add('hidden');
                    });
                    document.getElementById(`tab-content-${tabId}`).classList.remove('hidden');
                });
            });
        });
    </script>

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
            transform: translateY(-2px);
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

        .tab-button {
            transition: all 0.2s ease-in-out;
        }

        .tab-content {
            animation: fadeIn 0.3s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }
    </style>
@endsection