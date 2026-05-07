<?php
 
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ReferralSharer;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ReferralController extends Controller
{
    /**
     * Display a listing of all referral sharers.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = ReferralSharer::withCount('visits')
                ->orderBy('is_completed', 'desc')
                ->orderBy('created_at', 'desc');

            return DataTables::of($data)
                ->addColumn('sharer', function($row) {
                    return '<div class="fw-bold text-header" style="font-size: 1.05rem; white-space: nowrap;">' . ($row->referral_code ?: "ANONYMOUS") . '</div>' .
                           '<div class="small text-muted opacity-75" style="white-space: nowrap;">' . ($row->ip_address ?: 'No IP Registered') . '</div>';
                })
                ->addColumn('progress', function($row) {
                     $percentage = min(100, ($row->visits_count / ($row->target_count ?: 10)) * 100);
                     return '<div class="d-flex align-items-center gap-3" style="min-width: 150px;">
                                <div class="progress flex-grow-1 shadow-sm" style="height: 10px; background: var(--accent-light); border-radius: 10px;">
                                    <div class="progress-bar" style="width: '.$percentage.'%; background: var(--accent-main); border-radius: 10px;"></div>
                                </div>
                                <span class="small fw-bold text-header" style="white-space: nowrap;">'.$row->visits_count.'/'.($row->target_count ?: 10).'</span>
                            </div>';
                })
                ->addColumn('reward', function($row) {
                    if($row->reward_code) {
                        return '<div style="white-space: nowrap;"><code class="px-3 py-2 rounded-3 fw-bold shadow-sm d-inline-block" style="background: var(--accent-light); color: var(--accent-main); border: 1px solid var(--glass-border); font-size: 0.85rem; letter-spacing: 0.5px;">' . $row->reward_code . '</code></div>';
                    }
                    return '<span class="text-muted small italic" style="font-style: italic; white-space: nowrap;">Awaiting completion</span>';
                })
                ->addColumn('status', function($row) {
                    if($row->is_used) {
                        return '<span class="badge rounded-pill px-3 py-2" style="background: #e6f4ea; color: #1e7e34; font-weight: 600; border: 1px solid #c3e6cb; white-space: nowrap;">REDEEMED</span>';
                    } elseif($row->is_completed) {
                        return '<span class="badge rounded-pill px-3 py-2" style="background: #fff8e1; color: #f57c00; font-weight: 600; border: 1px solid #ffe082; white-space: nowrap;">ACTIVE PRIZE</span>';
                    } else {
                        return '<span class="badge rounded-pill px-3 py-2" style="background: var(--surface-main); color: var(--text-muted); font-weight: 600; border: 1px solid var(--glass-border); white-space: nowrap;">IN PROGRESS</span>';
                    }
                })
                ->addColumn('note', function($row) {
                    return '<input type="text" class="form-control form-control-sm bg-light border-0 rounded-pill px-3 admin-note-input"
                                   data-id="'.$row->id.'" value="'.$row->admin_note.'" placeholder="Add a note..." style="font-size: 0.85rem; min-width: 150px;">';
                })
                ->addColumn('redeemed', function($row) {
                    if($row->used_at) {
                        return '<div class="small fw-bold text-header" style="font-size: 0.85rem; white-space: nowrap;">' . \Carbon\Carbon::parse($row->used_at)->format('M d, Y') . '</div>' .
                               '<div class="small text-muted" style="font-size: 0.75rem; white-space: nowrap;">at ' . \Carbon\Carbon::parse($row->used_at)->format('h:i A') . '</div>';
                    }
                    return '<span class="text-muted small" style="white-space: nowrap;">---</span>';
                })
                ->addColumn('action', function($row) {
                    if($row->is_completed) {
                        $btnClass = $row->is_used ? 'btn-outline-secondary' : 'btn-primary-themed';
                        $btnText = $row->is_used ? 'Reactivate' : 'Claim Prize';
                        return '<button type="button" class="btn btn-sm rounded-pill px-4 py-2 fw-bold shadow-sm transition-all '.$btnClass.' toggle-claim-btn" 
                                        data-id="'.$row->id.'" style="white-space: nowrap; min-width: 100px;">'.$btnText.'</button>';
                    }
                    return '<div class="d-inline-block px-4 py-2 rounded-pill bg-light text-muted fw-bold border-0" style="font-size: 0.8rem; opacity: 0.6; white-space: nowrap;">No Prize</div>';
                })
                ->rawColumns(['sharer', 'progress', 'reward', 'status', 'note', 'redeemed', 'action'])
                ->make(true);
        }

        return view('admin.referrals.index');
    }

    /**
     * Toggle the "used" status of a referral reward.
     */
    public function toggleUsed(Request $request, ReferralSharer $sharer)
    {
        $newIsUsed = !$sharer->is_used;
        
        $sharer->update([
            'is_used' => $newIsUsed,
            'used_at' => $newIsUsed ? now() : null
        ]);

        if($request->ajax()) {
            return response()->json(['success' => true]);
        }

        return back()->with('success', 'Referral reward status updated successfully!');
    }

    /**
     * Update the admin note for a referral sharer.
     */
    public function updateNote(Request $request, ReferralSharer $sharer)
    {
        $sharer->update([
            'admin_note' => $request->admin_note
        ]);

        return response()->json(['success' => true]);
    }
}
