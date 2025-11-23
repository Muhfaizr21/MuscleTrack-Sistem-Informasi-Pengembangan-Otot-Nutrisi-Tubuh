<x-layouts.admin>
    <x-slot name="title">
        <span class="bg-gradient-to-r from-orange-400 to-red-500 bg-clip-text text-transparent">MuscleXpert</span> Admin Dashboard
    </x-slot>

    <!-- Hero Stats Section -->
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total Users -->
        <div class="group relative">
            <div class="absolute inset-0 bg-gradient-to-r from-orange-500 to-red-500 rounded-2xl blur-lg opacity-30 group-hover:opacity-50 transition duration-300"></div>
            <div class="relative bg-slate-900/90 backdrop-blur-xl border border-orange-500/20 rounded-2xl p-6 shadow-2xl">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-orange-300 text-sm font-semibold mb-2">TOTAL USERS</p>
                        <p class="text-white text-3xl font-bold">{{ number_format($totalUsers) }}</p>
                        <div class="flex items-center gap-1 mt-2">
                            <svg class="w-4 h-4 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M12 7a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0V8.414l-4.293 4.293a1 1 0 01-1.414 0L8 10.414l-4.293 4.293a1 1 0 01-1.414-1.414l5-5a1 1 0 011.414 0L11 10.586 14.586 7H12z" clip-rule="evenodd"/>
                            </svg>
                            <span class="text-green-400 text-xs font-medium">+12% growth</span>
                        </div>
                    </div>
                    <div class="w-12 h-12 bg-gradient-to-br from-orange-500 to-red-500 rounded-xl flex items-center justify-center shadow-lg shadow-orange-500/25">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Trainers -->
        <div class="group relative">
            <div class="absolute inset-0 bg-gradient-to-r from-blue-500 to-cyan-500 rounded-2xl blur-lg opacity-30 group-hover:opacity-50 transition duration-300"></div>
            <div class="relative bg-slate-900/90 backdrop-blur-xl border border-blue-500/20 rounded-2xl p-6 shadow-2xl">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-blue-300 text-sm font-semibold mb-2">CERTIFIED TRAINERS</p>
                        <p class="text-white text-3xl font-bold">{{ number_format($totalTrainers) }}</p>
                        <div class="flex items-center gap-2 mt-2">
                            <span class="text-green-400 text-xs font-medium bg-green-500/10 px-2 py-1 rounded-full">{{ $verifiedTrainers }} verified</span>
                            <span class="text-yellow-400 text-xs font-medium bg-yellow-500/10 px-2 py-1 rounded-full">{{ $pendingTrainers }} pending</span>
                        </div>
                    </div>
                    <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-cyan-500 rounded-xl flex items-center justify-center shadow-lg shadow-blue-500/25">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-1.657-.672-3.157-1.757-4.243M17 20h-2m2-2v-2a3 3 0 00-3-3h-2a3 3 0 00-3 3v2m2 4v-4m4 4v-4m-4 4H7m0 0v-2a3 3 0 013-3h2a3 3 0 013 3v2m0 4v-4m-4 4H7m0 0H3v-2a3 3 0 015.356-1.857M3 20v-2c0-1.657.672-3.157 1.757-4.243M3 20h2M3 18v-2a3 3 0 013-3h2a3 3 0 013 3v2m-4 4v-4"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Active Memberships -->
        <div class="group relative">
            <div class="absolute inset-0 bg-gradient-to-r from-green-500 to-emerald-500 rounded-2xl blur-lg opacity-30 group-hover:opacity-50 transition duration-300"></div>
            <div class="relative bg-slate-900/90 backdrop-blur-xl border border-green-500/20 rounded-2xl p-6 shadow-2xl">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-green-300 text-sm font-semibold mb-2">PREMIUM MEMBERSHIPS</p>
                        <p class="text-white text-3xl font-bold">{{ number_format($activeTrainerMemberships) }}</p>
                        <div class="flex items-center gap-1 mt-2">
                            <svg class="w-4 h-4 text-emerald-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M12.395 2.553a1 1 0 00-1.45-.385c-.345.23-.614.558-.822.88-.214.33-.403.713-.57 1.116-.334.804-.614 1.768-.84 2.734a31.365 31.365 0 00-.613 3.58 2.64 2.64 0 01-.945-1.067c-.328-.68-.398-1.534-.398-2.654A1 1 0 005.05 6.05 6.981 6.981 0 003 11a7 7 0 1011.95-4.95c-.592-.591-.98-.985-1.348-1.467-.363-.476-.724-1.063-1.207-2.03zM12.12 15.12A3 3 0 017 13s.879.5 2.5.5c0-1 .5-4 1.25-4.5.5 1 .786 1.293 1.371 1.879A2.99 2.99 0 0113 13a2.99 2.99 0 01-.879 2.121z" clip-rule="evenodd"/>
                            </svg>
                            <span class="text-emerald-400 text-xs font-medium">Active training programs</span>
                        </div>
                    </div>
                    <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-emerald-500 rounded-xl flex items-center justify-center shadow-lg shadow-green-500/25">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Revenue -->
        <div class="group relative">
            <div class="absolute inset-0 bg-gradient-to-r from-purple-500 to-pink-500 rounded-2xl blur-lg opacity-30 group-hover:opacity-50 transition duration-300"></div>
            <div class="relative bg-slate-900/90 backdrop-blur-xl border border-purple-500/20 rounded-2xl p-6 shadow-2xl">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-purple-300 text-sm font-semibold mb-2">MONTHLY REVENUE</p>
                        <p class="text-white text-3xl font-bold">${{ number_format($premiumTransactions * 150) }}</p>
                        <div class="flex items-center gap-1 mt-2">
                            <svg class="w-4 h-4 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                            </svg>
                            <span class="text-green-400 text-xs font-medium">{{ $premiumTransactions }} transactions</span>
                        </div>
                    </div>
                    <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-pink-500 rounded-xl flex items-center justify-center shadow-lg shadow-purple-500/25">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v1m0 6v1m0-1v1m6-13a2 2 0 11-4 0 2 2 0 014 0zM6 15a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Dashboard Grid -->
    <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">
        <!-- Left Column -->
        <div class="xl:col-span-2 space-y-8">
            <!-- Growth Analytics -->
            <div class="bg-slate-900/90 backdrop-blur-xl border border-slate-700/30 rounded-2xl shadow-2xl overflow-hidden">
                <div class="p-6 border-b border-slate-700/50">
                    <div class="flex items-center justify-between">
                        <h3 class="text-xl font-bold text-white">
                            <span class="bg-gradient-to-r from-orange-400 to-red-500 bg-clip-text text-transparent">Growth Analytics</span>
                        </h3>
                        <div class="flex gap-2">
                            <button class="px-3 py-1 text-xs font-medium text-orange-400 bg-orange-500/10 border border-orange-500/20 rounded-lg hover:bg-orange-500/20 transition-colors">
                                30 Days
                            </button>
                            <button class="px-3 py-1 text-xs font-medium text-slate-400 bg-slate-800/50 border border-slate-600/50 rounded-lg hover:bg-slate-700/50 transition-colors">
                                90 Days
                            </button>
                        </div>
                    </div>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                        <!-- User Growth -->
                        <div>
                            <h4 class="text-sm font-semibold text-slate-300 mb-4 flex items-center gap-2">
                                <div class="w-2 h-2 bg-green-500 rounded-full"></div>
                                USER GROWTH
                            </h4>
                            <div class="h-48">
                                <canvas id="userGrowthChart"></canvas>
                            </div>
                        </div>

                        <!-- Trainer Growth -->
                        <div>
                            <h4 class="text-sm font-semibold text-slate-300 mb-4 flex items-center gap-2">
                                <div class="w-2 h-2 bg-blue-500 rounded-full"></div>
                                TRAINER GROWTH
                            </h4>
                            <div class="h-48">
                                <canvas id="trainerGrowthChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Performance Metrics -->
            <div class="bg-slate-900/90 backdrop-blur-xl border border-slate-700/30 rounded-2xl shadow-2xl overflow-hidden">
                <div class="p-6 border-b border-slate-700/50">
                    <h3 class="text-xl font-bold text-white">
                        <span class="bg-gradient-to-r from-blue-400 to-cyan-500 bg-clip-text text-transparent">Performance Metrics</span>
                    </h3>
                </div>
                <div class="p-6">
                    <div class="h-80">
                        <canvas id="performanceChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column -->
        <div class="space-y-8">
            <!-- Top Trainers -->
            <div class="bg-slate-900/90 backdrop-blur-xl border border-slate-700/30 rounded-2xl shadow-2xl overflow-hidden">
                <div class="p-6 border-b border-slate-700/50">
                    <h3 class="text-xl font-bold text-white flex items-center gap-2">
                        <span class="bg-gradient-to-r from-amber-400 to-orange-500 bg-clip-text text-transparent">Elite Trainers</span>
                        <span class="text-xs font-semibold text-amber-400 bg-amber-500/10 px-2 py-1 rounded-full">TOP 5</span>
                    </h3>
                </div>
                <div class="divide-y divide-slate-700/50">
                    @forelse($topTrainers as $index => $trainer)
                    <div class="p-4 hover:bg-slate-800/30 transition-colors duration-300 group">
                        <div class="flex items-center gap-3">
                            <div class="relative">
                                <div class="w-10 h-10 bg-gradient-to-br from-amber-500 to-orange-600 rounded-xl flex items-center justify-center text-white font-bold text-sm shadow-lg shadow-amber-500/25">
                                    {{ $index + 1 }}
                                </div>
                                @if($index === 0)
                                <div class="absolute -top-1 -right-1">
                                    <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                </div>
                                @endif
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center gap-2">
                                    <p class="text-white font-semibold text-sm truncate">{{ $trainer['name'] }}</p>
                                    <div class="flex items-center gap-1">
                                        <svg class="w-3 h-3 text-amber-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                        </svg>
                                        <span class="text-amber-400 text-xs font-bold">{{ $trainer['rating'] }}</span>
                                    </div>
                                </div>
                                <p class="text-slate-400 text-xs truncate">{{ $trainer['specialization'] }}</p>
                                <div class="flex items-center gap-4 mt-1">
                                    <span class="text-slate-300 text-xs font-medium">{{ $trainer['member_count'] }} members</span>
                                    <span class="text-green-400 text-xs font-medium bg-green-500/10 px-2 py-0.5 rounded-full">Verified</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="p-8 text-center text-slate-500">
                        <svg class="w-12 h-12 mx-auto mb-3 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-1.657-.672-3.157-1.757-4.243M17 20h-2m2-2v-2a3 3 0 00-3-3h-2a3 3 0 00-3 3v2m2 4v-4m4 4v-4m-4 4H7m0 0v-2a3 3 0 013-3h2a3 3 0 013 3v2m0 4v-4m-4 4H7m0 0H3v-2a3 3 0 015.356-1.857M3 20v-2c0-1.657.672-3.157 1.757-4.243M3 20h2M3 18v-2a3 3 0 013-3h2a3 3 0 013 3v2m-4 4v-4"/>
                        </svg>
                        <p class="text-sm">No trainer data available</p>
                    </div>
                    @endforelse
                </div>
            </div>

            <!-- Quick Stats -->
            <div class="bg-slate-900/90 backdrop-blur-xl border border-slate-700/30 rounded-2xl shadow-2xl p-6">
                <h3 class="text-lg font-bold text-white mb-4">
                    <span class="bg-gradient-to-r from-emerald-400 to-green-500 bg-clip-text text-transparent">Platform Stats</span>
                </h3>
                <div class="space-y-4">
                    <div class="flex items-center justify-between p-3 bg-slate-800/50 rounded-xl">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 bg-blue-500/10 rounded-lg flex items-center justify-center">
                                <svg class="w-4 h-4 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                            </div>
                            <span class="text-slate-300 text-sm font-medium">Articles</span>
                        </div>
                        <span class="text-white font-bold">{{ number_format($totalArticles) }}</span>
                    </div>

                    <div class="flex items-center justify-between p-3 bg-slate-800/50 rounded-xl">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 bg-purple-500/10 rounded-lg flex items-center justify-center">
                                <svg class="w-4 h-4 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
                                </svg>
                            </div>
                            <span class="text-slate-300 text-sm font-medium">Messages</span>
                        </div>
                        <span class="text-white font-bold">{{ number_format($unreadMessages) }}</span>
                    </div>

                    <div class="flex items-center justify-between p-3 bg-slate-800/50 rounded-xl">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 bg-amber-500/10 rounded-lg flex items-center justify-center">
                                <svg class="w-4 h-4 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                </svg>
                            </div>
                            <span class="text-slate-300 text-sm font-medium">Pending</span>
                        </div>
                        <span class="text-white font-bold">{{ number_format($pendingTrainers) }}</span>
                    </div>
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="bg-slate-900/90 backdrop-blur-xl border border-slate-700/30 rounded-2xl shadow-2xl overflow-hidden">
                <div class="p-6 border-b border-slate-700/50">
                    <h3 class="text-lg font-bold text-white flex items-center gap-2">
                        <span class="bg-gradient-to-r from-rose-400 to-pink-500 bg-clip-text text-transparent">Live Activity</span>
                        <div class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></div>
                    </h3>
                </div>
                <div class="max-h-80 overflow-y-auto">
                    <div class="divide-y divide-slate-700/50">
                        @foreach($recentActivities as $activity)
                        <div class="p-4 hover:bg-slate-800/30 transition-colors duration-300">
                            <div class="flex items-start gap-3">
                                <div class="w-8 h-8 bg-{{ $activity['color'] }}-500/10 rounded-lg flex items-center justify-center flex-shrink-0 mt-1">
                                    @if($activity['icon'] === 'user')
                                    <svg class="w-4 h-4 text-{{ $activity['color'] }}-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                                    </svg>
                                    @elseif($activity['icon'] === 'trainer')
                                    <svg class="w-4 h-4 text-{{ $activity['color'] }}-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-1.657-.672-3.157-1.757-4.243M17 20h-2m2-2v-2a3 3 0 00-3-3h-2a3 3 0 00-3 3v2m2 4v-4m4 4v-4m-4 4H7m0 0v-2a3 3 0 013-3h2a3 3 0 013 3v2m0 4v-4m-4 4H7m0 0H3v-2a3 3 0 015.356-1.857M3 20v-2c0-1.657.672-3.157 1.757-4.243M3 20h2M3 18v-2a3 3 0 013-3h2a3 3 0 013 3v2m-4 4v-4"/>
                                    </svg>
                                    @endif
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-white text-sm font-medium leading-tight">{{ $activity['title'] }}</p>
                                    <p class="text-slate-400 text-xs mt-1">{{ $activity['description'] }}</p>
                                    <p class="text-slate-500 text-xs mt-2">{{ $activity['time'] }}</p>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Chart configuration
            Chart.defaults.color = 'rgba(148, 163, 184, 0.8)';
            Chart.defaults.borderColor = 'rgba(71, 85, 105, 0.3)';

            // User Growth Chart
            const ctxUser = document.getElementById('userGrowthChart').getContext('2d');
            new Chart(ctxUser, {
                type: 'line',
                data: {
                    labels: @json($userGrowthData['labels']),
                    datasets: [{
                        label: 'New Users',
                        data: @json($userGrowthData['data']),
                        fill: true,
                        borderColor: '#22c55e',
                        backgroundColor: 'rgba(34, 197, 94, 0.1)',
                        tension: 0.4,
                        pointBackgroundColor: '#22c55e',
                        pointBorderColor: '#0f172a',
                        pointBorderWidth: 2,
                        pointRadius: 3
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: { color: 'rgba(71, 85, 105, 0.2)' }
                        },
                        x: {
                            grid: { display: false }
                        }
                    }
                }
            });

            // Trainer Growth Chart
            const ctxTrainer = document.getElementById('trainerGrowthChart').getContext('2d');
            new Chart(ctxTrainer, {
                type: 'line',
                data: {
                    labels: @json($trainerGrowthData['labels']),
                    datasets: [{
                        label: 'New Trainers',
                        data: @json($trainerGrowthData['data']),
                        fill: true,
                        borderColor: '#3b82f6',
                        backgroundColor: 'rgba(59, 130, 246, 0.1)',
                        tension: 0.4,
                        pointBackgroundColor: '#3b82f6',
                        pointBorderColor: '#0f172a',
                        pointBorderWidth: 2,
                        pointRadius: 3
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: { color: 'rgba(71, 85, 105, 0.2)' }
                        },
                        x: {
                            grid: { display: false }
                        }
                    }
                }
            });

            // Performance Chart
            const ctxPerf = document.getElementById('performanceChart').getContext('2d');
            new Chart(ctxPerf, {
                type: 'bar',
                data: {
                    labels: @json($trainerPerformance['labels']),
                    datasets: [
                        {
                            label: 'Members',
                            data: @json($trainerPerformance['members']),
                            backgroundColor: 'rgba(249, 115, 22, 0.3)',
                            borderColor: '#f97316',
                            borderWidth: 1,
                            borderRadius: 6,
                        },
                        {
                            label: 'Rating',
                            data: @json($trainerPerformance['ratings']),
                            type: 'line',
                            borderColor: '#eab308',
                            backgroundColor: 'rgba(234, 179, 8, 0.1)',
                            borderWidth: 2,
                            pointBackgroundColor: '#eab308',
                            pointBorderColor: '#0f172a',
                            pointBorderWidth: 2,
                            pointRadius: 4,
                            tension: 0.4,
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    interaction: { mode: 'index', intersect: false },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: { color: 'rgba(71, 85, 105, 0.2)' }
                        },
                        x: {
                            grid: { display: false }
                        }
                    }
                }
            });
        });
    </script>
    @endpush
</x-layouts.admin>
