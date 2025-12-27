<?php

namespace App\Http\Controllers;

use App\Models\Wedding;
use App\Services\WeddingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;

class RsvpController extends Controller
{
    /**
     * Store a new RSVP
     */
    public function store(Request $request, Wedding $wedding)
    {
        // Rate limiting: 10 submissions per hour per IP
        $key = 'rsvp:' . $request->ip();
        if ($request->wantsJson()) {
            if (RateLimiter::tooManyAttempts($key, 10)) {
                return response()->json(['message' => 'Bạn đã gửi quá nhiều lần. Vui lòng thử lại sau.'], 429);
            }
        } else {
            if (RateLimiter::tooManyAttempts($key, 10)) {
                return back()->with('error', 'Bạn đã gửi quá nhiều lần. Vui lòng thử lại sau.');
            }
        }
        RateLimiter::hit($key, 3600); // 1 hour window
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'attendance' => 'required|in:yes,no,maybe',
            'guests' => 'nullable|integer|min:1|max:20',
            'side' => 'nullable|in:groom,bride,both',
            'note' => 'nullable|string|max:500',
        ]);
        
        $message = WeddingService::createRsvp($wedding, $validated, $request->ip());
        
        if ($request->wantsJson()) {
            return response()->json(['message' => $message]);
        }
        
        return back()->with('success', $message);
    }
}
