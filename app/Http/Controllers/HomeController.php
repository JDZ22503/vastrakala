<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        // Fetch only products marked as "New Arrival"
        $galleryItems = \App\Models\Gallery::where('new_arrival', true)->with(['category', 'primaryImage'])->latest()->get();
        // If NO items are marked as new arrival, fallback to latest 6 to keep section from being empty
        if ($galleryItems->isEmpty()) {
            $galleryItems = \App\Models\Gallery::with(['category', 'primaryImage'])->latest()->take(6)->get();
        }
        $categories = \App\Models\Category::all();
        $testimonials = \App\Models\Testimonial::where('is_approved', true)->latest()->get();

        // --- Referral System Logic ---
        $myReferral = null;
        $myReferralCount = 0;
        $isNewUser = false;
        
        if (($settings['show_referral'] ?? '1') == '1') {
            $userIp = $request->ip();
            
            // 1. Handle incoming referral link (?via=CODE)
            if ($request->has('via')) {
                $friendCode = $request->via;
                $sharer = \App\Models\ReferralSharer::where('referral_code', $friendCode)->first();
                
                // Check if the current visitor is different from the person who shared the link
                if ($sharer && $sharer->ip_address !== $userIp) {
                    \App\Models\ReferralVisit::firstOrCreate([
                        'sharer_id' => $sharer->id,
                        'guest_ip' => $userIp
                    ], [
                        'user_agent' => $request->userAgent(),
                    ]);
                    
                    // Update goal status
                    $count = \App\Models\ReferralVisit::where('sharer_id', $sharer->id)->count();
                    if ($count >= $sharer->target_count && !$sharer->is_completed) {
                        $sharer->update([
                            'is_completed' => true,
                            'reward_code' => 'GIFT-' . strtoupper(\Illuminate\Support\Str::random(10))
                        ]);
                    }
                }
            }
            
            // 2. Identify the Sharer using a Browser ID (Persistent Cookie)
            $browserId = $request->cookie('v_ref_id');
            if (!$browserId) {
                $browserId = \Illuminate\Support\Str::random(32);
                $isNewUser = true;
            }
            
            $myReferral = \App\Models\ReferralSharer::where('browser_id', $browserId)->first();
            
            if (!$myReferral) {
                $myReferral = \App\Models\ReferralSharer::create([
                    'browser_id' => $browserId,
                    'ip_address' => $userIp,
                    'referral_code' => strtoupper(\Illuminate\Support\Str::random(6)),
                    'target_count' => 10
                ]);
            } else {
                $myReferral->update(['ip_address' => $userIp]);
                
                // If they reached goal but don't have a reward_code yet
                $count = \App\Models\ReferralVisit::where('sharer_id', $myReferral->id)->count();
                if ($count >= $myReferral->target_count && !$myReferral->reward_code) {
                    $myReferral->update([
                        'is_completed' => true,
                        'reward_code' => 'GIFT-' . strtoupper(\Illuminate\Support\Str::random(10))
                    ]);
                }
            }
            $myReferralCount = \App\Models\ReferralVisit::where('sharer_id', $myReferral->id)->count();
        }

        $response = response()->view('home', compact(
            'galleryItems', 'categories', 'testimonials', 'myReferral', 'myReferralCount'
        ));

        // If it's a new identifier, set the cookie for 1 year
        if ($isNewUser) {
            $response->cookie('v_ref_id', $browserId, 60 * 24 * 365); // 1 Year
        }

        return $response;
    }
}
