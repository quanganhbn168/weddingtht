<?php

namespace App\Http\Controllers;

use App\Models\Wedding;
use App\Services\WeddingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;

class WishController extends Controller
{
    /**
     * Get approved wishes for a wedding (API)
     */
    public function index(Wedding $wedding)
    {
        $wishes = $wedding->wishes()
            ->approved()
            ->latest()
            ->take(50)
            ->get(['id', 'name', 'message', 'created_at']);
        
        return response()->json($wishes);
    }
    
    /**
     * Store a new wish
     */
    public function store(Request $request, Wedding $wedding)
    {
        // Rate limiting: 5 submissions per hour per IP
        $key = 'wish:' . $request->ip();
        // Rate limiting checks for JSON
        if ($request->wantsJson()) {
            if (RateLimiter::tooManyAttempts($key, 5)) {
                return response()->json(['message' => 'Bạn đã gửi quá nhiều lời chúc. Vui lòng thử lại sau.'], 429);
            }
        } else {
            if (RateLimiter::tooManyAttempts($key, 5)) {
                return back()->with('error', 'Bạn đã gửi quá nhiều lời chúc. Vui lòng thử lại sau.');
            }
        }
        RateLimiter::hit($key, 3600); // 1 hour window
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'message' => 'required|string|max:1000',
        ]);
        
        // Simple profanity check (basic)
        $badWords = ['fuck', 'shit', 'ass', 'đm', 'dcm', 'vl', 'clm', 'đéo'];
        $messageCheck = strtolower($validated['message']);
        foreach ($badWords as $word) {
            if (str_contains($messageCheck, $word)) {
                $errorMsg = 'Lời chúc chứa nội dung không phù hợp.';
                if ($request->wantsJson()) {
                    return response()->json(['message' => $errorMsg], 422);
                }
                return back()->with('error', $errorMsg);
            }
        }
        
        WeddingService::createWish($wedding, $validated, $request->ip());
        
        $successMsg = 'Cảm ơn lời chúc của bạn! Lời chúc sẽ hiển thị sau khi được duyệt.';
        if ($request->wantsJson()) {
            return response()->json(['message' => $successMsg]);
        }
        
        return back()->with('success', $successMsg);
    }
}
