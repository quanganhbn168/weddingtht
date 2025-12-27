<?php

namespace App\Http\Controllers;

use App\Models\BusinessCard;
use App\Models\Template;
use App\Services\BusinessCardService;
use Illuminate\Http\Request;

class UserBusinessCardController extends Controller
{
    protected $cardService;

    public function __construct(BusinessCardService $cardService)
    {
        $this->cardService = $cardService;
    }

    /**
     * Display a listing of user's business cards.
     */
    public function index(Request $request)
    {
        $cards = $this->cardService->getUserCards($request->user());
        
        return view('dashboard.cards.index', compact('cards'));
    }

    /**
     * Show the form for creating a new business card.
     */
    public function create(Request $request)
    {
        if (!$request->user()->canCreateBusinessCard()) {
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
        
        $validated = $request->validate($this->cardService->getValidationRules());
        
        $card = $this->cardService->createCard($user, $validated);
        
        return redirect()->route('dashboard.cards.edit', $card)
            ->with('success', 'Name Card đã được tạo thành công!');
    }

    /**
     * Show the form for editing the business card.
     */
    public function edit(Request $request, BusinessCard $card)
    {
        if (!$this->cardService->checkOwnership($request->user(), $card)) {
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
        if (!$this->cardService->checkOwnership($request->user(), $card)) {
            abort(403);
        }
        
        $validated = $request->validate($this->cardService->getValidationRules(true));
        
        $this->cardService->updateCard($card, $validated);
        
        return redirect()->route('dashboard.cards.edit', $card)
            ->with('success', 'Name Card đã được cập nhật!');
    }

    /**
     * Remove the business card.
     */
    public function destroy(Request $request, BusinessCard $card)
    {
        if (!$this->cardService->checkOwnership($request->user(), $card)) {
            abort(403);
        }
        
        $this->cardService->deleteCard($card);
        
        return redirect()->route('dashboard.cards.index')
            ->with('success', 'Name Card đã được xóa!');
    }
    
    /**
     * Preview the business card
     */
    public function preview(Request $request, BusinessCard $card)
    {
        if (!$this->cardService->checkOwnership($request->user(), $card)) {
            abort(403);
        }
        
        return redirect()->route('business.show', $card->slug);
    }
}
