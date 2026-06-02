<?php

namespace App\Http\Middleware;

use App\Models\VisitorLog;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TrackVisitors
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $host = $request->getHost();
        $isRawIp = preg_match('/^[0-9.]+$/', $host);

        // --- SECURITY SHIELD: Block direct IP access ---
        if ($host == 'vastrakala.ayushzalavadiya.me') {
            if ($isRawIp) {
                abort(403, 'Direct IP access is not allowed.');
            }
        }

        $hasMaliciousParam = $request->has('XDEBUG_SESSION_START') || $request->has('XDEBUG_SESSION_STOP');

        // SECURITY & DATA PURITY FILTER:
        // Only track if:
        // 1. Not an AJAX request
        // 2. Not an admin route
        // 3. Not hitting the raw server IP (must use domain)
        // 4. No malicious developer-targeted parameters
        if (! $request->ajax() &&
            ! $request->is('ayush-admin*') &&
            ! $isRawIp &&
            ! $hasMaliciousParam &&
            str_contains($host, 'vastrakala.ayushzalavadiya.me')) {

            $today = now()->toDateString();

            // Check if this IP has already visited this exact URL today
            $alreadyVisited = VisitorLog::where('ip_address', $request->ip())
                ->where('url', $request->fullUrl())
                ->whereDate('visited_at', $today)
                ->exists();

            if (! $alreadyVisited) {
                // Parse User Agent
                $userAgent = $request->userAgent() ?? 'Unknown';

                // 1. OS Parsing
                $os = 'Unknown';
                if (preg_match('/windows nt 10/i', $userAgent)) {
                    $os = 'Windows 10/11';
                } elseif (preg_match('/windows nt 6\.3/i', $userAgent)) {
                    $os = 'Windows 8.1';
                } elseif (preg_match('/windows nt 6\.2/i', $userAgent)) {
                    $os = 'Windows 8';
                } elseif (preg_match('/windows nt 6\.1/i', $userAgent)) {
                    $os = 'Windows 7';
                } elseif (preg_match('/windows nt/i', $userAgent)) {
                    $os = 'Windows';
                } elseif (preg_match('/mac os x/i', $userAgent)) {
                    $os = 'Mac OS';
                } elseif (preg_match('/iphone/i', $userAgent)) {
                    $os = 'iOS (iPhone)';
                } elseif (preg_match('/ipad/i', $userAgent)) {
                    $os = 'iOS (iPad)';
                } elseif (preg_match('/android/i', $userAgent)) {
                    $os = 'Android';
                } elseif (preg_match('/linux/i', $userAgent)) {
                    $os = 'Linux';
                }

                // 2. Browser Parsing
                $browser = 'Unknown';
                if (preg_match('/edg/i', $userAgent)) {
                    $browser = 'Edge';
                } elseif (preg_match('/chrome/i', $userAgent)) {
                    $browser = 'Chrome';
                } elseif (preg_match('/safari/i', $userAgent)) {
                    $browser = 'Safari';
                } elseif (preg_match('/firefox/i', $userAgent)) {
                    $browser = 'Firefox';
                } elseif (preg_match('/opera|opr/i', $userAgent)) {
                    $browser = 'Opera';
                }

                // 3. Device Parsing
                $device = 'Desktop';
                if (preg_match('/mobile/i', $userAgent)) {
                    $device = 'Mobile';
                } elseif (preg_match('/tablet|ipad/i', $userAgent)) {
                    $device = 'Tablet';
                }

                try {
                    VisitorLog::create([
                        'ip_address' => $request->ip(),
                        'user_agent' => \Illuminate\Support\Str::limit($userAgent, 1000),
                        'device' => $device,
                        'os' => $os,
                        'browser' => $browser,
                        'url' => \Illuminate\Support\Str::limit($request->fullUrl(), 2000),
                        'method' => $request->method(),
                        'visited_at' => now(),
                    ]);
                } catch (\Exception $e) {
                    \Illuminate\Support\Facades\Log::error('Visitor tracking failed: ' . $e->getMessage());
                }
            }
        }

        return $next($request);
    }
}
