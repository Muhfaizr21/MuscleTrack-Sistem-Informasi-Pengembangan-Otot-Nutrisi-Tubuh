<?php

namespace App\Http\Controllers\Trainer;

use App\Http\Controllers\Controller;
use App\Models\ProgressLog;
use App\Models\User;
use App\Models\PremiumAccessLog;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class MemberController extends Controller
{
    /**
     * 🧍 Daftar semua member yang menjadi bimbingan trainer.
     */
    public function index()
    {
        $trainer = Auth::user();

        // Ambil semua member yang dibimbing oleh trainer login dengan data premium access
        $members = User::where('trainer_id', $trainer->id)
            ->where('role', 'user')
            ->withCount('progressLogs')
            ->with(['premiumAccessLogsAsUser' => function ($query) use ($trainer) {
                $query->where('trainer_id', $trainer->id)
                    ->orderBy('created_at', 'desc');
            }, 'paymentsMade' => function ($query) use ($trainer) {
                $query->where('trainer_id', $trainer->id)
                    ->where('status', 'paid')
                    ->orderBy('created_at', 'desc');
            }])
            ->get()
            ->map(function ($member) use ($trainer) {
                // Tambahkan latest premium access secara manual
                $member->latest_premium_access = $member->premiumAccessLogsAsUser
                    ->where('trainer_id', $trainer->id)
                    ->where('payment_status', 'paid') // Hanya yang status pembayaran paid
                    ->sortByDesc('created_at')
                    ->first();

                $member->latest_payment = $member->paymentsMade
                    ->where('trainer_id', $trainer->id)
                    ->where('status', 'paid')
                    ->sortByDesc('created_at')
                    ->first();

                // Hitung status real-time
                $member->real_time_status = $this->calculateRealTimeStatus($member->latest_premium_access);

                return $member;
            });

        return view('trainer.members.index', compact('members'));
    }

    /**
     * 📊 Tampilkan detail & log aktivitas satu member
     */
    public function show($id)
    {
        $trainer = Auth::user();

        $member = User::where('id', $id)
            ->where('trainer_id', $trainer->id)
            ->firstOrFail();

        // Ambil log aktivitas terbaru
        $progressLogs = ProgressLog::where('user_id', $member->id)
            ->orderByDesc('log_date')
            ->take(15)
            ->get();

        // Ambil history premium access yang sudah PAID saja
        $premiumHistory = PremiumAccessLog::where('user_id', $member->id)
            ->where('trainer_id', $trainer->id)
            ->where('payment_status', 'paid') // Hanya yang sudah bayar
            ->orderByDesc('created_at')
            ->get();

        // Ambil history pembayaran
        $paymentHistory = Payment::where('user_id', $member->id)
            ->where('trainer_id', $trainer->id)
            ->where('status', 'paid') // Hanya yang sudah bayar
            ->orderByDesc('created_at')
            ->get();

        // Ambil premium access terbaru yang PAID
        $latestPremiumAccess = $premiumHistory->first();

        // Hitung status real-time
        $realTimeStatus = $this->calculateRealTimeStatus($latestPremiumAccess);

        return view('trainer.members.show', compact(
            'member',
            'progressLogs',
            'premiumHistory',
            'paymentHistory',
            'latestPremiumAccess',
            'realTimeStatus'
        ));
    }

    /**
     * 📝 Tambahkan log aktivitas baru untuk member (progres latihan/nutrisi)
     */
    public function updateProgress(Request $request, $id)
    {
        $trainer = Auth::user();

        $member = User::where('id', $id)
            ->where('trainer_id', $trainer->id)
            ->firstOrFail();

        // Cek apakah member masih aktif
        $premiumAccess = PremiumAccessLog::where('user_id', $member->id)
            ->where('trainer_id', $trainer->id)
            ->where('payment_status', 'paid')
            ->orderByDesc('created_at')
            ->first();

        if (!$premiumAccess || Carbon::parse($premiumAccess->end_date)->isPast()) {
            return redirect()
                ->route('trainer.members.show', $member->id)
                ->with('error', 'Member tidak aktif atau masa berlaku telah habis!');
        }

        $validated = $request->validate([
            'workout_plan_id' => 'nullable|exists:workout_plans,id',
            'nutrition_plan_id' => 'nullable|exists:nutrition_plans,id',
            'calories_consumed' => 'nullable|numeric|min:0',
            'protein_consumed' => 'nullable|numeric|min:0',
            'carbs_consumed' => 'nullable|numeric|min:0',
            'fat_consumed' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string|max:500',
            'log_date' => 'required|date',
        ]);

        $validated['user_id'] = $member->id;

        ProgressLog::create($validated);

        return redirect()
            ->route('trainer.members.show', $member->id)
            ->with('success', 'Log progres member berhasil ditambahkan!');
    }

    /**
     * 🔍 Cek status keaktifan member berdasarkan premium access
     */
    public static function getMemberStatus($premiumAccess)
    {
        if (!$premiumAccess) {
            return [
                'status' => 'inactive',
                'label' => 'Tidak Aktif',
                'color' => 'red',
                'days_remaining' => 0,
                'is_active' => false
            ];
        }

        $endDate = Carbon::parse($premiumAccess->end_date);
        $today = Carbon::today();

        if ($endDate->lessThan($today)) {
            return [
                'status' => 'expired',
                'label' => 'Kadaluarsa',
                'color' => 'red',
                'days_remaining' => 0,
                'is_active' => false
            ];
        }

        $daysRemaining = $today->diffInDays($endDate, false);

        if ($daysRemaining <= 7) {
            return [
                'status' => 'expiring_soon',
                'label' => 'Akan Berakhir',
                'color' => 'yellow',
                'days_remaining' => $daysRemaining,
                'is_active' => true
            ];
        }

        return [
            'status' => 'active',
            'label' => 'Aktif',
            'color' => 'green',
            'days_remaining' => $daysRemaining,
            'is_active' => true
        ];
    }

    /**
     * 🕒 Hitung status real-time dengan countdown
     */
    private function calculateRealTimeStatus($premiumAccess)
    {
        if (!$premiumAccess) {
            return [
                'status' => 'inactive',
                'label' => 'Tidak Aktif',
                'color' => 'red',
                'days_remaining' => 0,
                'hours_remaining' => 0,
                'minutes_remaining' => 0,
                'total_seconds' => 0,
                'is_expired' => true,
                'is_active' => false,
                'end_date_timestamp' => null
            ];
        }

        $endDate = Carbon::parse($premiumAccess->end_date . ' 23:59:59');
        $now = Carbon::now();

        if ($endDate->lessThan($now)) {
            return [
                'status' => 'expired',
                'label' => 'Kadaluarsa',
                'color' => 'red',
                'days_remaining' => 0,
                'hours_remaining' => 0,
                'minutes_remaining' => 0,
                'total_seconds' => 0,
                'is_expired' => true,
                'is_active' => false,
                'end_date_timestamp' => $endDate->timestamp
            ];
        }

        $totalSeconds = $now->diffInSeconds($endDate, false);
        $daysRemaining = $now->diffInDays($endDate, false);
        $hoursRemaining = $now->copy()->addDays($daysRemaining)->diffInHours($endDate, false);
        $minutesRemaining = $now->copy()->addDays($daysRemaining)->addHours($hoursRemaining)->diffInMinutes($endDate, false);

        if ($daysRemaining <= 7) {
            return [
                'status' => 'expiring_soon',
                'label' => 'Akan Berakhir',
                'color' => 'yellow',
                'days_remaining' => $daysRemaining,
                'hours_remaining' => $hoursRemaining,
                'minutes_remaining' => $minutesRemaining,
                'total_seconds' => $totalSeconds,
                'is_expired' => false,
                'is_active' => true,
                'end_date_timestamp' => $endDate->timestamp
            ];
        }

        return [
            'status' => 'active',
            'label' => 'Aktif',
            'color' => 'green',
            'days_remaining' => $daysRemaining,
            'hours_remaining' => $hoursRemaining,
            'minutes_remaining' => $minutesRemaining,
            'total_seconds' => $totalSeconds,
            'is_expired' => false,
            'is_active' => true,
            'end_date_timestamp' => $endDate->timestamp
        ];
    }

    /**
     * 🔄 API untuk mendapatkan status real-time member
     */
    public function getRealTimeStatus($id)
    {
        $trainer = Auth::user();

        $member = User::where('id', $id)
            ->where('trainer_id', $trainer->id)
            ->firstOrFail();

        $premiumAccess = PremiumAccessLog::where('user_id', $member->id)
            ->where('trainer_id', $trainer->id)
            ->where('payment_status', 'paid')
            ->orderByDesc('created_at')
            ->first();

        $realTimeStatus = $this->calculateRealTimeStatus($premiumAccess);

        return response()->json([
            'success' => true,
            'status' => $realTimeStatus,
            'timestamp' => Carbon::now()->timestamp,
            'member_name' => $member->name
        ]);
    }

    /**
     * 🗑️ Hapus member yang sudah expired dari daftar bimbingan
     */
    public function removeExpiredMember($id)
    {
        $trainer = Auth::user();

        $member = User::where('id', $id)
            ->where('trainer_id', $trainer->id)
            ->firstOrFail();

        // Cek apakah member sudah expired
        $premiumAccess = PremiumAccessLog::where('user_id', $member->id)
            ->where('trainer_id', $trainer->id)
            ->where('payment_status', 'paid')
            ->orderByDesc('created_at')
            ->first();

        if (!$premiumAccess || Carbon::parse($premiumAccess->end_date)->isPast()) {
            // Hapus trainer_id untuk memutus hubungan
            $member->update(['trainer_id' => null]);

            return redirect()
                ->route('trainer.members.index')
                ->with('success', 'Member telah dihapus dari daftar bimbingan karena masa berlaku telah habis.');
        }

        return redirect()
            ->route('trainer.members.show', $member->id)
            ->with('error', 'Tidak dapat menghapus member yang masih aktif.');
    }

    /**
     * 🔍 Cek dan update status semua member
     */
    public function checkAllMembersStatus()
    {
        $trainer = Auth::user();

        $members = User::where('trainer_id', $trainer->id)
            ->where('role', 'user')
            ->get();

        $expiredCount = 0;

        foreach ($members as $member) {
            $premiumAccess = PremiumAccessLog::where('user_id', $member->id)
                ->where('trainer_id', $trainer->id)
                ->where('payment_status', 'paid')
                ->orderByDesc('created_at')
                ->first();

            // Jika tidak ada premium access atau sudah expired, hapus dari bimbingan
            if (!$premiumAccess || Carbon::parse($premiumAccess->end_date)->isPast()) {
                $member->update(['trainer_id' => null]);
                $expiredCount++;
            }
        }

        return redirect()
            ->route('trainer.members.index')
            ->with('info', "Berhasil memeriksa status member. {$expiredCount} member expired telah dihapus.");
    }
}
