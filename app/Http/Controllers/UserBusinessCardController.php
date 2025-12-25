<?php

namespace App\Http\Controllers;

use App\Models\BusinessCard;
use App\Models\Template;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class UserBusinessCardController extends Controller
{
    /**
     * Display a listing of user's business cards.
     */
    public function index(Request $request)
    {
        $cards = $request->user()->businessCards()->with('template')->latest()->paginate(10);
        
        return view('dashboard.cards.index', compact('cards'));
    }

    /**
     * Show the form for creating a new business card.
     */
    public function create(Request $request)
    {
        $user = $request->user();
        
        if (!$user->canCreateBusinessCard()) {
            return redirect()->route('dashboard.pricing')
                ->with('error', 'Bạn đã đạt giới hạn số Name Card. Vui lòng nâng cấp gói để tạo thêm.');
        }
        
        $templates = Template::where('type', 'business')->where('is_active', true)->get();
        
        return view('dashboard.cards.create', compact('templates'));
    }

    /**
     * Store a newly created business card.
     */
    public function store(Request $request)
    {
        $user = $request->user();
        
        if (!$user->canCreateBusinessCard()) {
            return redirect()->route('dashboard.pricing')
                ->with('error', 'Bạn đã đạt giới hạn số Name Card.');
        }
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'title' => 'nullable|string|max:255',
            'company' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:255',
            'website' => 'nullable|url|max:255',
            'address' => 'nullable|string|max:500',
            'about' => 'nullable|string',
            'template_id' => 'required|exists:templates,id',
        ]);
        
        // Generate unique slug
        $validated['slug'] = Str::slug($validated['name']) . '-' . rand(1000, 9999);
        $validated['is_active'] = true;
        
        $card = $user->businessCards()->create($validated);
        
        return redirect()->route('dashboard.cards.edit', $card)
            ->with('success', 'Name Card đã được tạo thành công!');
    }

    /**
     * Show the form for editing the business card.
     */
    public function edit(Request $request, BusinessCard $card)
    {
        if ($card->user_id !== $request->user()->id) {
            abort(403);
        }
        
        $templates = Template::where('type', 'business')->where('is_active', true)->get();
        
        return view('dashboard.cards.edit', compact('card', 'templates'));
    }

    /**
     * Update the business card.
     */
    public function update(Request $request, BusinessCard $card)
    {
        if ($card->user_id !== $request->user()->id) {
            abort(403);
        }
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'title' => 'nullable|string|max:255',
            'company' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:255',
            'website' => 'nullable|url|max:255',
            'address' => 'nullable|string|max:500',
            'about' => 'nullable|string',
            'template_id' => 'required|exists:templates,id',
        ]);
        
        $card->update($validated);
        
        return redirect()->route('dashboard.cards.edit', $card)
            ->with('success', 'Name Card đã được cập nhật!');
    }

    /**
     * Remove the business card.
     */
    public function destroy(Request $request, BusinessCard $card)
    {
        if ($card->user_id !== $request->user()->id) {
            abort(403);
        }
        
        $card->delete();
        
        return redirect()->route('dashboard.cards.index')
            ->with('success', 'Name Card đã được xóa!');
    }
    
    /**
     * Preview the business card
     */
    public function preview(Request $request, BusinessCard $card)
    {
        if ($card->user_id !== $request->user()->id) {
            abort(403);
        }
        
        return redirect()->route('business.show', $card->slug);
    }
}
