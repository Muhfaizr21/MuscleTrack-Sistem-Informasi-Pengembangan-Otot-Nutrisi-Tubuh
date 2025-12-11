<x-layouts.admin>
    <x-slot name="title">
        Program <span
            class="bg-gradient-to-r from-green-400 to-emerald-500 bg-clip-text text-transparent">Latihan</span>
    </x-slot>

    <!-- Tambahkan CSS untuk styling -->
    <style>
        /* Override untuk dark mode */
        .force-text-white {
            color: #ffffff !important;
        }

        .force-text-gray-300 {
            color: #d1d5db !important;
        }

        .force-text-gray-400 {
            color: #9ca3af !important;
        }

        .force-text-gray-500 {
            color: #6b7280 !important;
        }

        .force-bg-slate-800 {
            background-color: #1e293b !important;
        }

        .force-bg-slate-700 {
            background-color: #334155 !important;
        }

        .force-bg-slate-600 {
            background-color: #475569 !important;
        }

        .force-border-slate-700 {
            border-color: #334155 !important;
        }

        /* Gradient text */
        .gradient-text {
            background: linear-gradient(to right, #10b981, #059669) !important;
            -webkit-background-clip: text !important;
            -webkit-text-fill-color: transparent !important;
            background-clip: text !important;
        }

        /* Badge styling */
        .badge-blue {
            background: rgba(59, 130, 246, 0.2) !important;
            border: 1px solid rgba(59, 130, 246, 0.3) !important;
            color: #60a5fa !important;
        }

        .badge-green {
            background: rgba(5, 150, 105, 0.2) !important;
            border: 1px solid rgba(5, 150, 105, 0.3) !important;
            color: #34d399 !important;
        }

        .badge-yellow {
            background: rgba(245, 158, 11, 0.2) !important;
            border: 1px solid rgba(245, 158, 11, 0.3) !important;
            color: #fbbf24 !important;
        }

        .badge-red {
            background: rgba(239, 68, 68, 0.2) !important;
            border: 1px solid rgba(239, 68, 68, 0.3) !important;
            color: #f87171 !important;
        }

        .badge-gray {
            background: rgba(75, 85, 99, 0.2) !important;
            border: 1px solid rgba(75, 85, 99, 0.3) !important;
            color: #9ca3af !important;
        }

        /* Table styling */
        .table-row-hover:hover {
            background-color: rgba(51, 65, 85, 0.5) !important;
        }

        /* Custom checkbox */
        .custom-checkbox:checked {
            background-color: #10b981 !important;
            border-color: #10b981 !important;
        }

        /* Tooltip */
        .tooltip {
            position: relative;
        }

        .tooltip .tooltip-text {
            visibility: hidden;
            width: 120px;
            background-color: #1e293b;
            color: #fff;
            text-align: center;
            border-radius: 6px;
            padding: 5px;
            position: absolute;
            z-index: 1;
            bottom: 125%;
            left: 50%;
            margin-left: -60px;
            opacity: 0;
            transition: opacity 0.3s;
            border: 1px solid #334155;
            font-size: 12px;
        }

        .tooltip:hover .tooltip-text {
            visibility: visible;
            opacity: 1;
        }

        /* Loading overlay */
        .loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.7);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
            display: none;
        }

        /* Toast notification */
        .toast {
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 15px 20px;
            border-radius: 8px;
            color: white;
            z-index: 1000;
            display: flex;
            align-items: center;
            gap: 10px;
            transform: translateX(150%);
            transition: transform 0.3s ease-in-out;
        }

        .toast.show {
            transform: translateX(0);
        }

        .toast-success {
            background: linear-gradient(to right, #10b981, #059669);
        }

        .toast-error {
            background: linear-gradient(to right, #ef4444, #dc2626);
        }

        .toast-warning {
            background: linear-gradient(to right, #f59e0b, #d97706);
        }
    </style>

    <!-- Toast Container -->
    <div id="toast-container">
        <div id="successToast" class="toast toast-success">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span id="toastMessage"></span>
        </div>
    </div>

    <!-- Loading Overlay -->
    <div id="loadingOverlay" class="loading-overlay">
        <div class="text-center">
            <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-green-500 mx-auto"></div>
            <p class="text-white mt-4">Memproses...</p>
        </div>
    </div>

    <!-- Bulk Actions Modal -->
    <div id="bulkModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
        <div class="force-bg-slate-800 rounded-lg shadow-2xl w-full max-w-md mx-4">
            <div class="p-6 border-b force-border-slate-700">
                <h3 class="text-lg font-semibold force-text-white">Aksi Massal</h3>
            </div>
            <div class="p-6">
                <div class="mb-4">
                    <label class="block text-sm font-medium force-text-gray-300 mb-2">Pilih Aksi:</label>
                    <select id="bulkAction" class="w-full px-3 py-2 force-bg-slate-700 border force-border-slate-700 rounded-lg force-text-white focus:outline-none focus:ring-2 focus:ring-green-500">
                        <option value="">-- Pilih Aksi --</option>
                        <option value="activate">Aktifkan</option>
                        <option value="deactivate">Nonaktifkan</option>
                        <option value="toggle_premium">Ubah Status Premium</option>
                        <option value="delete">Hapus</option>
                    </select>
                </div>
                <div class="mb-4" id="confirmText" style="display: none;">
                    <p class="text-sm force-text-red-400 bg-red-500/10 p-3 rounded-lg border border-red-500/20">
                        <strong>Peringatan:</strong> Aksi ini akan menghapus program latihan yang dipilih. Tindakan ini tidak dapat dibatalkan.
                    </p>
                </div>
            </div>
            <div class="p-6 border-t force-border-slate-700 flex justify-end gap-3">
                <button type="button" onclick="closeBulkModal()" class="px-4 py-2 force-text-gray-400 hover:force-text-gray-300 hover:bg-slate-700/50 rounded-lg transition-colors">
                    Batal
                </button>
                <button type="button" onclick="executeBulkAction()" class="px-4 py-2 bg-gradient-to-r from-green-500 to-emerald-600 text-white font-semibold rounded-lg hover:shadow-lg transition-all">
                    Eksekusi
                </button>
            </div>
        </div>
    </div>

    <div class="force-bg-slate-800 force-border-slate-700 rounded-2xl shadow-2xl overflow-hidden">

        <!-- Header Section -->
        <div class="p-6 border-b force-border-slate-700">
            <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4">
                <div>
                    <h3 class="text-2xl font-bold force-text-white">
                        Master Program <span class="gradient-text">Latihan</span>
                    </h3>
                    <p class="text-sm force-text-gray-400 mt-1">Template program latihan profesional untuk user</p>
                </div>
                <div class="flex items-center gap-3">
                    <!-- Statistics Badge -->
                    <div class="px-4 py-2 force-bg-slate-700 rounded-lg border force-border-slate-700">
                        <div class="text-sm force-text-gray-300">{{ $workoutPlans->total() }} Program</div>
                    </div>

                    <!-- Bulk Actions Button -->
                    <button type="button" onclick="openBulkModal()" id="bulkActionBtn"
                            class="px-6 py-3 bg-gradient-to-r from-blue-500 to-indigo-600 text-white font-bold rounded-xl shadow-lg hover:shadow-blue-500/30 transition-all duration-300 transform hover:-translate-y-0.5 flex items-center gap-2" disabled>
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                        Aksi Massal
                    </button>

                    <!-- Create Button -->
                    <a href="{{ route('admin.workout-plans.create') }}"
                        class="px-6 py-3 rounded-xl bg-gradient-to-r from-green-500 to-emerald-600 text-white font-bold shadow-lg hover:shadow-green-500/30 transition-all duration-300 transform hover:-translate-y-0.5 flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Buat Program Baru
                    </a>
                </div>
            </div>
        </div>

        <!-- Alert Messages -->
        @if(session('success'))
            <div class="p-4 bg-green-500/20 backdrop-blur-sm text-green-300 border-b border-green-500/30">
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    {{ session('success') }}
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="p-4 bg-red-500/20 backdrop-blur-sm text-red-300 border-b border-red-500/30">
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    {{ session('error') }}
                </div>
            </div>
        @endif

        <!-- Filter Section -->
        <div class="p-4 border-b force-border-slate-700">
            <form action="{{ route('admin.workout-plans.index') }}" method="GET"
                class="flex flex-wrap items-center gap-3">
                <div class="flex-1 min-w-[200px]">
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Cari program latihan..."
                        class="w-full px-4 py-2 force-bg-slate-700 border force-border-slate-700 rounded-lg force-text-white placeholder-force-text-gray-500 focus:outline-none focus:ring-2 focus:ring-green-500">
                </div>

                <div class="flex items-center gap-2">
                    <select name="status"
                        class="px-4 py-2 force-bg-slate-700 border force-border-slate-700 rounded-lg force-text-white focus:outline-none focus:ring-2 focus:ring-green-500">
                        <option value="">Semua Status</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive
                        </option>
                    </select>

                    <select name="difficulty"
                        class="px-4 py-2 force-bg-slate-700 border force-border-slate-700 rounded-lg force-text-white focus:outline-none focus:ring-2 focus:ring-green-500">
                        <option value="">Semua Level</option>
                        <option value="beginner" {{ request('difficulty') == 'beginner' ? 'selected' : '' }}>Beginner
                        </option>
                        <option value="intermediate" {{ request('difficulty') == 'intermediate' ? 'selected' : '' }}>
                            Intermediate</option>
                        <option value="advanced" {{ request('difficulty') == 'advanced' ? 'selected' : '' }}>Advanced
                        </option>
                    </select>

                    <button type="submit"
                        class="px-4 py-2 bg-blue-500/20 text-blue-400 hover:bg-blue-500/30 border border-blue-500/30 rounded-lg transition-colors flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        Filter
                    </button>

                    <a href="{{ route('admin.workout-plans.index') }}"
                        class="px-4 py-2 bg-gray-500/20 text-gray-400 hover:bg-gray-500/30 border border-gray-500/30 rounded-lg transition-colors">
                        Reset
                    </a>
                </div>
            </form>
        </div>

        <!-- Table Section -->
        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead class="force-bg-slate-700">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold force-text-gray-400 uppercase tracking-wider w-12">
                            <input type="checkbox" id="selectAll" class="custom-checkbox h-4 w-4 rounded border-gray-300">
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-semibold force-text-gray-400 uppercase tracking-wider">
                            Program Latihan</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold force-text-gray-400 uppercase tracking-wider">
                            Target</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold force-text-gray-400 uppercase tracking-wider">
                            Level</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold force-text-gray-400 uppercase tracking-wider">
                            Durasi</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold force-text-gray-400 uppercase tracking-wider">
                            Status</th>
                        <th class="px-6 py-4 text-right text-xs font-semibold force-text-gray-400 uppercase tracking-wider">
                            Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($workoutPlans as $plan)
                        <tr class="border-t force-border-slate-700 table-row-hover" id="row-{{ $plan->id }}">
                            <!-- Checkbox Column -->
                            <td class="px-6 py-4">
                                <input type="checkbox"
                                       class="plan-checkbox custom-checkbox h-4 w-4 rounded border-gray-300"
                                       value="{{ $plan->id }}"
                                       onchange="updateBulkButton()">
                            </td>

                            <!-- Program Column -->
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 bg-gradient-to-br from-green-500/20 to-emerald-600/20 rounded-xl flex items-center justify-center">
                                        <svg class="w-6 h-6 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M13 10V3L4 14h7v7l9-11h-7z" />
                                        </svg>
                                    </div>
                                    <div class="min-w-0 flex-1">
                                        <div class="text-sm font-semibold force-text-white truncate">{{ $plan->title }}
                                        </div>
                                        <div class="text-xs force-text-gray-400 mt-1 line-clamp-2">{{ $plan->description }}
                                        </div>
                                        <div class="text-xs force-text-gray-500 mt-1">
                                            @php
                                                $exerciseCount = $plan->workout_exercises_count ?? 0;
                                            @endphp
                                            {{ $exerciseCount }} latihan
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <!-- Target Column -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full badge-blue capitalize">
                                    {{ $plan->target_fitness ?? 'General' }}
                                </span>
                            </td>

                            <!-- Level Column -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($plan->difficulty_level == 'beginner')
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full badge-green">
                                        Beginner
                                    </span>
                                @elseif($plan->difficulty_level == 'intermediate')
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full badge-yellow">
                                        Intermediate
                                    </span>
                                @elseif($plan->difficulty_level == 'advanced')
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full badge-red">
                                        Advanced
                                    </span>
                                @else
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full badge-gray">
                                        {{ $plan->difficulty_level ?? 'All Levels' }}
                                    </span>
                                @endif
                            </td>

                            <!-- Duration Column -->
                            <td class="px-6 py-4 whitespace-nowrap text-sm force-text-gray-300">
                                <div class="flex items-center gap-2">
                                    <svg class="w-4 h-4 force-text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    {{ $plan->duration_weeks ?? '-' }} Minggu
                                </div>
                            </td>

                            <!-- Status Column -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                <button type="button"
                                        onclick="toggleStatus({{ $plan->id }})"
                                        class="toggle-status-btn px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full cursor-pointer transition-all hover:scale-105"
                                        data-id="{{ $plan->id }}"
                                        data-status="{{ $plan->status }}">
                                    @if($plan->status == 'active')
                                        <span class="badge-green">Active</span>
                                    @else
                                        <span class="badge-gray">Inactive</span>
                                    @endif
                                </button>
                            </td>

                            <!-- Action Column -->
                            <td class="px-6 py-4 whitespace-nowrap text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <!-- View Button -->
                                    <a href="{{ route('admin.workout-plans.show', $plan) }}"
                                        class="px-3 py-1.5 bg-blue-500/10 text-blue-400 hover:bg-blue-500/20 border border-blue-500/30 rounded-lg transition-all duration-300 hover:scale-105 flex items-center gap-1.5 tooltip"
                                        title="Lihat Detail">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                        <span class="tooltip-text">Lihat Detail</span>
                                    </a>

                                    <!-- Edit Button -->
                                    <a href="{{ route('admin.workout-plans.edit', $plan) }}"
                                        class="px-3 py-1.5 bg-yellow-500/10 text-yellow-400 hover:bg-yellow-500/20 border border-yellow-500/30 rounded-lg transition-all duration-300 hover:scale-105 flex items-center gap-1.5 tooltip"
                                        title="Edit">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                        <span class="tooltip-text">Edit</span>
                                    </a>

                                    <!-- Delete Button -->
                                    <button type="button"
                                            onclick="deletePlan({{ $plan->id }}, '{{ addslashes($plan->title) }}')"
                                            class="px-3 py-1.5 bg-red-500/10 text-red-400 hover:bg-red-500/20 border border-red-500/30 rounded-lg transition-all duration-300 hover:scale-105 flex items-center gap-1.5 tooltip"
                                            title="Hapus">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                        <span class="tooltip-text">Hapus</span>
                                    </button>

                                    <!-- Duplicate Button -->
                                    <button type="button"
                                            onclick="duplicatePlan({{ $plan->id }})"
                                            class="px-3 py-1.5 bg-purple-500/10 text-purple-400 hover:bg-purple-500/20 border border-purple-500/30 rounded-lg transition-all duration-300 hover:scale-105 flex items-center gap-1.5 tooltip"
                                            title="Duplikat">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                        </svg>
                                        <span class="tooltip-text">Duplikat</span>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center justify-center force-text-gray-500">
                                    <svg class="w-20 h-20 mb-4 opacity-30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13 10V3L4 14h7v7l9-11h-7z" />
                                    </svg>
                                    <p class="text-xl font-semibold mb-2 force-text-white">Belum ada program latihan</p>
                                    <p class="text-sm mb-6 force-text-gray-400">Mulai dengan membuat program latihan pertama
                                    </p>
                                    <a href="{{ route('admin.workout-plans.create') }}"
                                        class="px-8 py-3 rounded-xl bg-gradient-to-r from-green-500 to-emerald-600 text-white font-semibold hover:shadow-green-500/30 transition-all duration-300 transform hover:-translate-y-0.5 flex items-center gap-2">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 4v16m8-8H4" />
                                        </svg>
                                        Buat Program Pertama
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($workoutPlans->hasPages())
            <div class="p-6 border-t force-border-slate-700">
                <div class="flex items-center justify-between">
                    <div class="text-sm force-text-gray-400">
                        Menampilkan {{ $workoutPlans->firstItem() }} - {{ $workoutPlans->lastItem() }} dari
                        {{ $workoutPlans->total() }} program
                    </div>
                    <div class="flex space-x-2">
                        {{ $workoutPlans->links() }}
                    </div>
                </div>
            </div>
        @endif
    </div>

    <!-- JavaScript untuk fungsi-fungsi -->
<script>
    // Toast notification
    function showToast(message, type = 'success') {
        const toast = document.getElementById('successToast');
        const messageSpan = document.getElementById('toastMessage');

        messageSpan.textContent = message;
        toast.className = `toast toast-${type} show`;

        setTimeout(() => {
            toast.classList.remove('show');
        }, 3000);
    }

    // Delete single plan - FIXED CSRF
    function deletePlan(id, title) {
        if (!confirm(`Apakah Anda yakin ingin menghapus program "${title}"?`)) {
            return;
        }

        // Ambil token dari meta tag atau input hidden
        let csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
        if (!csrfToken) {
            csrfToken = document.querySelector('input[name="_token"]')?.value;
        }

        if (!csrfToken) {
            // Jika tidak ada token, gunakan form biasa
            submitDeleteForm(id);
            return;
        }

        // AJAX delete dengan token yang benar
        fetch(`/admin/workout-plans/${id}`, {
            method: 'POST', // Gunakan POST untuk menghindari CORS
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                _method: 'DELETE' // Laravel method spoofing
            })
        })
        .then(response => {
            if (response.ok) {
                // Hapus row dari tabel
                const row = document.getElementById(`row-${id}`);
                if (row) {
                    row.remove();
                }
                showToast('Program berhasil dihapus', 'success');
                updateBulkButton();

                // Refresh jika tabel kosong
                const tbody = document.querySelector('tbody');
                if (tbody && tbody.children.length === 0) {
                    setTimeout(() => location.reload(), 500);
                }
            } else {
                // Jika AJAX gagal, coba metode form
                throw new Error('AJAX failed');
            }
        })
        .catch(error => {
            console.log('AJAX gagal, mencoba metode form:', error);
            // Fallback ke form submission biasa
            submitDeleteForm(id);
        });
    }

    // Fallback function untuk submit form
    function submitDeleteForm(id) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/admin/workout-plans/${id}`;
        form.style.display = 'none';

        // Token CSRF
        let csrfToken = document.querySelector('input[name="_token"]')?.value;
        if (csrfToken) {
            const tokenInput = document.createElement('input');
            tokenInput.type = 'hidden';
            tokenInput.name = '_token';
            tokenInput.value = csrfToken;
            form.appendChild(tokenInput);
        }

        // Method spoofing untuk DELETE
        const methodInput = document.createElement('input');
        methodInput.type = 'hidden';
        methodInput.name = '_method';
        methodInput.value = 'DELETE';
        form.appendChild(methodInput);

        document.body.appendChild(form);
        form.submit();
    }

    // Duplicate plan
    function duplicatePlan(id) {
        if (!confirm('Apakah Anda yakin ingin menduplikasi program ini?')) {
            return;
        }

        let csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
        if (!csrfToken) {
            csrfToken = document.querySelector('input[name="_token"]')?.value;
        }

        fetch(`/admin/workout-plans/${id}/duplicate`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showToast(data.message, 'success');
                if (data.redirect_url) {
                    window.location.href = data.redirect_url;
                }
            } else {
                showToast(data.message || 'Gagal menduplikasi program', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showToast('Terjadi kesalahan saat menduplikasi program', 'error');
        });
    }

    // Toggle status
    function toggleStatus(id) {
        let csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
        if (!csrfToken) {
            csrfToken = document.querySelector('input[name="_token"]')?.value;
        }

        fetch(`/admin/workout-plans/${id}/toggle-status`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Update badge status
                const btn = document.querySelector(`.toggle-status-btn[data-id="${id}"]`);
                if (btn) {
                    btn.innerHTML = data.status_badge;
                    btn.setAttribute('data-status', data.new_status);
                }
                showToast(data.message, 'success');
            } else {
                showToast(data.message || 'Gagal mengubah status', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showToast('Terjadi kesalahan saat mengubah status', 'error');
        });
    }

    // Bulk actions
    let selectedPlans = [];

    // Select all checkbox
    document.getElementById('selectAll')?.addEventListener('change', function() {
        const checkboxes = document.querySelectorAll('.plan-checkbox');
        checkboxes.forEach(checkbox => {
            checkbox.checked = this.checked;
        });
        updateBulkButton();
    });

    // Update bulk action button
    function updateBulkButton() {
        const checkboxes = document.querySelectorAll('.plan-checkbox:checked');
        const bulkBtn = document.getElementById('bulkActionBtn');
        const count = checkboxes.length;

        if (count > 0) {
            bulkBtn.disabled = false;
            bulkBtn.innerHTML = `
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                </svg>
                Aksi Massal (${count} terpilih)
            `;
            selectedPlans = Array.from(checkboxes).map(cb => cb.value);
        } else {
            bulkBtn.disabled = true;
            bulkBtn.innerHTML = `
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                </svg>
                Aksi Massal
            `;
            selectedPlans = [];
        }
    }

    // Open bulk modal
    function openBulkModal() {
        if (selectedPlans.length === 0) return;

        document.getElementById('bulkModal').classList.remove('hidden');
        document.getElementById('confirmText').style.display = 'none';
        document.getElementById('bulkAction').value = '';
    }

    // Close bulk modal
    function closeBulkModal() {
        document.getElementById('bulkModal').classList.add('hidden');
    }

    // Show/hide delete confirmation
    document.getElementById('bulkAction')?.addEventListener('change', function() {
        const confirmText = document.getElementById('confirmText');
        if (this.value === 'delete') {
            confirmText.style.display = 'block';
        } else {
            confirmText.style.display = 'none';
        }
    });

    // Execute bulk action
    function executeBulkAction() {
        const action = document.getElementById('bulkAction').value;
        if (!action || selectedPlans.length === 0) return;

        if (action === 'delete') {
            if (!confirm(`Apakah Anda yakin ingin menghapus ${selectedPlans.length} program? Tindakan ini tidak dapat dibatalkan.`)) {
                return;
            }
        }

        let csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
        if (!csrfToken) {
            csrfToken = document.querySelector('input[name="_token"]')?.value;
        }

        fetch('/admin/workout-plans/bulk-actions', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                action: action,
                ids: selectedPlans
            })
        })
        .then(response => response.json())
        .then(data => {
            closeBulkModal();

            if (data.success) {
                showToast(data.message, 'success');

                // Jika delete, hapus rows dari tabel
                if (action === 'delete') {
                    selectedPlans.forEach(id => {
                        const row = document.getElementById(`row-${id}`);
                        if (row) row.remove();
                    });
                    selectedPlans = [];
                    updateBulkButton();
                } else if (action === 'activate' || action === 'deactivate') {
                    // Jika update status, refresh halaman
                    location.reload();
                }
            } else {
                showToast(data.message || 'Gagal melakukan aksi massal', 'error');
            }
        })
        .catch(error => {
            closeBulkModal();
            console.error('Error:', error);
            showToast('Terjadi kesalahan saat melakukan aksi massal', 'error');
        });
    }

    // Event listeners untuk checkboxes
    document.addEventListener('DOMContentLoaded', function() {
        const checkboxes = document.querySelectorAll('.plan-checkbox');
        checkboxes.forEach(checkbox => {
            checkbox.addEventListener('change', updateBulkButton);
        });
    });
</script>
</x-layouts.admin>
