<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Wedding;
use App\Http\Controllers\WeddingController;

class HomeController extends Controller
{
    /**
     * Resolve slug to Wedding
     */
    public function resolveSlug($slug)
    {
        $wedding = Wedding::where('slug', $slug)->first();
        if ($wedding) {
            return app(WeddingController::class)->show($slug, request());
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

        return view('welcome', compact('demoWeddings'));
    }
}

