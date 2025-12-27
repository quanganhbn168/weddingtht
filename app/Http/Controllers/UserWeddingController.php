<?php

namespace App\Http\Controllers;

use App\Models\Wedding;
use App\Models\Template;
use App\Services\WeddingService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class UserWeddingController extends Controller
{
    /**
     * Display a listing of user's weddings.
     */
    public function index(Request $request)
    {
        $weddings = WeddingService::getUserWeddings($request->user());
        
        return view('dashboard.weddings.index', compact('weddings'));
    }

    /**
     * Show the form for creating a new wedding.
     */
    public function create(Request $request)
    {
        $user = $request->user();
        
        if (!$user->canCreateWedding()) {
            return redirect()->route('dashboard.pricing')
                ->with('error', 'Bạn đã đạt giới hạn số thiệp cưới. Vui lòng nâng cấp gói để tạo thêm.');
        }
        
        $templates = Template::where('type', 'wedding')->where('is_active', true)->get();
        
        return view('dashboard.weddings.create', compact('templates'));
    }

    /**
     * Store a newly created wedding.
     */
    public function store(Request $request)
    {
        $user = $request->user();
        
        if (!$user->canCreateWedding()) {
            return redirect()->route('dashboard.pricing')
                ->with('error', 'Bạn đã đạt giới hạn số thiệp cưới.');
        }
        
        $validated = $request->validate([
            'groom_name' => 'required|string|max:255',
            'bride_name' => 'required|string|max:255',
            'event_date' => 'required|date|after:today',
            'template_id' => 'required|exists:templates,id',
            'groom_father' => 'nullable|string|max:255',
            'groom_mother' => 'nullable|string|max:255',
            'bride_father' => 'nullable|string|max:255',
            'bride_mother' => 'nullable|string|max:255',
            'groom_address' => 'nullable|string|max:500',
            'bride_address' => 'nullable|string|max:500',
        ]);
        
        $wedding = WeddingService::createWedding($user, $validated);
        
        // Update basic info that wasn't covered in initial create if needed, 
        // but WeddingService::createWedding handles normalization and slug generation.
        // The service might need to accept extra fields or we rely on edit to add details.
        // Actually, createWedding accepts an array, so we can pass all validated data.
        // We set status to preview by default here as per original controller logic
        $wedding->update(['status' => 'preview', 'is_active' => true]);
        
        return redirect()->route('dashboard.weddings.edit', $wedding)
            ->with('success', 'Thiệp cưới đã được tạo thành công!');
    }

    /**
     * Show the form for editing the wedding.
     */
    public function edit(Request $request, Wedding $wedding)
    {
        if (!WeddingService::canAccess($request->user(), $wedding)) {
            abort(403);
        }
        
        $templates = Template::where('type', 'wedding')->where('is_active', true)->get();
        
        return view('dashboard.weddings.edit', compact('wedding', 'templates'));
    }

    /**
     * Update the wedding.
     */
    public function update(Request $request, Wedding $wedding)
    {
        if (!WeddingService::canUpdate($request->user(), $wedding)) {
            abort(403);
        }
        
        $data = $request->all();
        
        // Handle boolean checkboxes
        $data['is_auto_approve_wishes'] = $request->has('is_auto_approve_wishes');
        $data['show_preload'] = $request->has('show_preload');
        
        // Validate
        $validator = \Illuminate\Support\Facades\Validator::make($data, WeddingService::getValidationRules($wedding));
        $validated = $validator->validate();
        
        // Update basic info via Service
        // Note: WeddingService::updateWedding handles normalization and template view update
        WeddingService::updateWedding($wedding, $validated);
        
        // Handle media uploads directly here or move to Service
        // Ideally should be in Service but Spatie Media Library is easy enough here
        // For strict SOC, moving to Service is better.
        // I will implement a handleMediaUploads method in Service later if requested,
        // but current instruction is just "centralize logic", updating the wedding basics is done.
        // The original controller handled media uploads manually.
        
        // Handle file field (background_music)
        if ($request->hasFile('background_music')) {
            $path = $request->file('background_music')->store('music', 'public');
            $wedding->update(['background_music' => $path]);
        }
        
        // Spatie Media Library uploads
        $mediaCollections = ['cover', 'hero', 'groom_photo', 'bride_photo', 'groom_qr', 'bride_qr'];
        foreach ($mediaCollections as $collection) {
            if ($request->hasFile($collection)) {
                $wedding->clearMediaCollection($collection);
                $wedding->addMediaFromRequest($collection)->toMediaCollection($collection);
            }
        }
        
        // Gallery
        if ($request->hasFile('gallery')) {
            foreach ($request->file('gallery') as $file) {
                $wedding->addMedia($file)->toMediaCollection('gallery');
            }
        }
        
        return redirect()->route('dashboard.weddings.edit', $wedding)
            ->with('success', 'Thiệp cưới đã được cập nhật!');
    }

    /**
     * Remove the wedding.
     */
    public function destroy(Request $request, Wedding $wedding)
    {
        if (!WeddingService::canUpdate($request->user(), $wedding)) {
            abort(403);
        }
        
        $wedding->delete();
        
        return redirect()->route('dashboard.weddings.index')
            ->with('success', 'Thiệp cưới đã được xóa!');
    }
    
    /**
     * Preview the wedding
     */
    public function preview(Request $request, Wedding $wedding)
    {
        if (!WeddingService::canAccess($request->user(), $wedding)) {
            abort(403);
        }
        
        return redirect()->route('wedding.show', $wedding->slug);
    }

    /**
     * Manage RSVPs for the wedding.
     */
    public function rsvps(Request $request, Wedding $wedding)
    {
        if (!WeddingService::canAccess($request->user(), $wedding)) {
            abort(403);
        }
        
        // Export to CSV
        if ($request->has('export') && $request->export === 'csv') {
            $callback = WeddingService::getRsvpCsvCallback($wedding);
            $filename = 'danh-sach-khach-moi-' . $wedding->slug . '.csv';
            
            $headers = [
                "Content-type" => "text/csv; charset=UTF-8",
                "Content-Disposition" => "attachment; filename=$filename",
                "Pragma" => "no-cache",
                "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
                "Expires" => "0"
            ];
            
            return response()->stream($callback, 200, $headers);
        }
        
        $stats = WeddingService::getRsvpStats($wedding);
        $rsvps = $wedding->rsvps()->latest()->paginate(20);
        
        return view('dashboard.weddings.rsvps', compact('wedding', 'rsvps', 'stats'));
    }

    /**
     * Manage wishes for the wedding.
     */
    public function wishes(Request $request, Wedding $wedding)
    {
        if (!WeddingService::canAccess($request->user(), $wedding)) {
            abort(403);
        }
        
        $filter = $request->get('filter', 'all');
        
        $query = $wedding->wishes()->latest();
        
        if ($filter === 'pending') {
            $query->where('is_approved', false);
        } elseif ($filter === 'approved') {
            $query->where('is_approved', true);
        }
        
        $wishes = $query->paginate(20);
        $stats = WeddingService::getWishStats($wedding);
        
        return view('dashboard.weddings.wishes', compact('wedding', 'wishes', 'stats', 'filter'));
    }

    /**
     * Approve a wish
     */
    public function approveWish(Request $request, Wedding $wedding, $wishId)
    {
        if (!WeddingService::canUpdate($request->user(), $wedding)) {
            abort(403);
        }
        
        WeddingService::approveWish($wedding, $wishId);
        
        return back()->with('success', 'Đã duyệt lời chúc!');
    }

    /**
     * Delete a wish
     */
    public function deleteWish(Request $request, Wedding $wedding, $wishId)
    {
        if (!WeddingService::canUpdate($request->user(), $wedding)) {
            abort(403);
        }
        
        WeddingService::deleteWish($wedding, $wishId);
        
        return back()->with('success', 'Đã xóa lời chúc!');
    }
}
