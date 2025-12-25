<?php

namespace App\Http\Controllers;

use App\Models\Wedding;
use App\Models\BusinessCard;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Show the main dashboard with user's creations
     */
    public function index(Request $request)
    {
        $user = $request->user();
        
        $weddings = $user->weddings()->with('template')->latest()->get();
        $businessCards = $user->businessCards()->with('template')->latest()->get();
        
        $subscription = $user->getActiveSubscription();
        
        return view('dashboard', compact('user', 'weddings', 'businessCards', 'subscription'));
    }
    
    /**
     * Show upgrade/pricing page
     */
    public function pricing(Request $request)
    {
        $user = $request->user();
        $currentPlan = $user->getPlan();
        
        return view('dashboard.pricing', compact('user', 'currentPlan'));
    }
}
