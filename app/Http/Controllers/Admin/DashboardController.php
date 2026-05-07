<?php

namespace App\Http\Controllers\Admin;
 
use App\Http\Controllers\Controller;
use App\Models\VisitorLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Basic Metrics
        $totalVisits = VisitorLog::count();
        $todayVisits = VisitorLog::whereDate('visited_at', today())->count();
        $uniqueVisitors = VisitorLog::distinct('ip_address')->count();
        
        // Top Assets (Already Optimized)
        $topPages = VisitorLog::select('url', DB::raw('count(*) as total'))
            ->groupBy('url')
            ->orderByDesc('total')
            ->limit(10)
            ->get();

        $topDevice = VisitorLog::select('device', DB::raw('count(*) as total'))
            ->whereNotNull('device')
            ->groupBy('device')
            ->orderByDesc('total')
            ->first();
            
        $topOS = VisitorLog::select('os', DB::raw('count(*) as total'))
            ->whereNotNull('os')
            ->groupBy('os')
            ->orderByDesc('total')
            ->first();

        // Trend: SINGLE Optimized Query
        $trendData = VisitorLog::select(
                DB::raw('DATE(visited_at) as date'),
                DB::raw('count(*) as total')
            )
            ->where('visited_at', '>=', now()->subDays(6)->startOfDay())
            ->groupBy('date')
            ->get()
            ->pluck('total', 'date');

        $days = [];
        $counts = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $days[] = now()->subDays($i)->format('D');
            $counts[] = $trendData[$date] ?? 0;
        }
            
        // List: Efficient Sub-query for Unique IPs
        $visitorList = VisitorLog::select('ip_address', 'device', 'os', 'browser', 'visited_at')
            ->whereIn('id', function($query) {
                $query->select(DB::raw('MAX(id)'))
                    ->from('visitor_logs')
                    ->groupBy('ip_address');
            })
            ->orderByDesc('visited_at')
            ->limit(25)
            ->get();
            
        return view('dashboard', compact(
            'totalVisits', 
            'todayVisits', 
            'uniqueVisitors', 
            'topPages', 
            'days', 
            'counts',
            'topDevice',
            'topOS',
            'visitorList'
        ));
    }
}
