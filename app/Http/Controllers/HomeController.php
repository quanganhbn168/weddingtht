<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Wedding;
use App\Models\BusinessCard;
use App\Http\Controllers\WeddingController;
use App\Http\Controllers\BusinessCardController;

class HomeController extends Controller
{
    /**
     * Resolve slug to Wedding or Business Card
     */
    public function resolveSlug($slug)
    {
        $wedding = Wedding::where('slug', $slug)->first();
        if ($wedding) {
            return app(WeddingController::class)->show($slug, request());
        }
        
        $card = BusinessCard::where('slug', $slug)->first();
        if ($card) {
            return app(BusinessCardController::class)->show($slug);
        }
        
        abort(404);
    }
    /**
     * Show the application landing page.
     */
    public function index()
    {
        $demoWeddings = Wedding::where('is_demo', true)
            ->where('is_active', true)
            ->with('template')
            ->latest()
            ->get();

        $demoBusinessCards = BusinessCard::where('is_demo', true)
            ->with('template')
            ->latest()
            ->get();

        return view('welcome', compact('demoWeddings', 'demoBusinessCards'));
    }
}
