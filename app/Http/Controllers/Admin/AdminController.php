<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\NewsArticle;
use App\Models\ContactMessage;
use App\Models\Payment;
use App\Models\ActivityLog;
use App\Models\BodyMetric;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function dashboard()
    {
        // Stats Data
        $totalUsers = User::where('role', 'user')->count();
        $totalArticles = NewsArticle::count();
        $unreadMessages = ContactMessage::where('created_at', '>=', now()->subDays(7))->count();
        $premiumTransactions = Payment::where('status', 'paid')->count();

        // User Growth Data (30 hari terakhir)
        $userGrowthData = $this->getUserGrowthData();

        // User Progress Data
        $userProgressData = $this->getUserProgressData();

        // Recent Activities
        $recentActivities = $this->getRecentActivities();

        return view('admin.dashboard', compact(
            'totalUsers',
            'totalArticles',
            'unreadMessages',
            'premiumTransactions',
            'userGrowthData',
            'userProgressData',
            'recentActivities'
        ));
    }

    private function getUserGrowthData()
    {
        $labels = [];
        $data = [];

        for ($i = 30; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $labels[] = $date->format('M j');

            $userCount = User::where('role', 'user')
                ->whereDate('created_at', '<=', $date)
                ->count();

            $data[] = $userCount;
        }

        return [
            'labels' => $labels,
            'data' => $data
        ];
    }

    private function getUserProgressData()
    {
        // Data rata-rata progress berdasarkan goal
        $goals = ['Bulking', 'Cutting', 'Maintenance'];
        $progressData = [];

        foreach ($goals as $goal) {
            $avgMuscleMass = BodyMetric::join('users', 'body_metrics.user_id', '=', 'users.id')
                ->where('users.goal_id', function($query) use ($goal) {
                    $query->select('id')
                          ->from('goals')
                          ->where('name', $goal);
                })
                ->avg('body_metrics.muscle_mass');

            $progressData[] = $avgMuscleMass ? round($avgMuscleMass, 1) : rand(60, 70);
        }

        return [
            'labels' => $goals,
            'data' => $progressData
        ];
    }

    private function getRecentActivities()
    {
        $activities = [];

        // Recent user registrations
        $recentUsers = User::where('role', 'user')
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();

        foreach ($recentUsers as $user) {
            $activities[] = [
                'type' => 'user_registered',
                'title' => 'User Baru Mendaftar',
                'description' => $user->email,
                'time' => $user->created_at->diffForHumans(),
                'icon' => 'user',
                'color' => 'green'
            ];
        }

        // Recent premium payments
        $recentPayments = Payment::with('user')
            ->where('status', 'paid')
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();

        foreach ($recentPayments as $payment) {
            $activities[] = [
                'type' => 'premium_payment',
                'title' => 'Pembayaran Premium',
                'description' => 'Dari: ' . ($payment->user->name ?? 'Unknown User') . ' (Status: LUNAS)',
                'time' => $payment->created_at->diffForHumans(),
                'icon' => 'payment',
                'color' => 'emerald'
            ];
        }

        // Recent articles
        $recentArticles = NewsArticle::orderBy('created_at', 'desc')
            ->take(3)
            ->get();

        foreach ($recentArticles as $article) {
            $activities[] = [
                'type' => 'article_published',
                'title' => 'Artikel Baru Diposting',
                'description' => '"' . $article->title . '"',
                'time' => $article->created_at->diffForHumans(),
                'icon' => 'article',
                'color' => 'blue'
            ];
        }

        // Sort by time and take latest 5
        usort($activities, function($a, $b) {
            return strtotime($b['time']) - strtotime($a['time']);
        });

        return array_slice($activities, 0, 5);
    }
}
