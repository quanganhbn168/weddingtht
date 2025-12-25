<?php

namespace App\Http\Controllers;

use App\Models\Wedding;
use App\Models\Template;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class UserWeddingController extends Controller
{
    /**
     * Display a listing of user's weddings.
     */
    public function index(Request $request)
    {
        $weddings = $request->user()->weddings()->with('template')->latest()->paginate(10);
        
        return view('dashboard.weddings.index', compact('weddings'));
    }

    /**
     * Show the form for creating a new wedding.
     */
    public function create(Request $request)
    {
        $user = $request->user();
        
        // Check if user can create more weddings
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
        
        // Generate unique slug
        $baseSlug = Str::slug($validated['groom_name'] . '-va-' . $validated['bride_name'] . '-' . now()->year);
        $validated['slug'] = $baseSlug . '-' . rand(1000, 9999);
        
        // Get template view path
        $template = Template::find($validated['template_id']);
        $validated['template_view'] = $template->view_path;
        
        // Set defaults
        $validated['status'] = 'draft';
        $validated['is_active'] = true;
        
        $wedding = $user->weddings()->create($validated);
        
        return redirect()->route('dashboard.weddings.edit', $wedding)
            ->with('success', 'Thiệp cưới đã được tạo thành công!');
    }

    /**
     * Show the form for editing the wedding.
     */
    public function edit(Request $request, Wedding $wedding)
    {
        // Ensure user owns this wedding
        if ($wedding->user_id !== $request->user()->id) {
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
        if ($wedding->user_id !== $request->user()->id) {
            abort(403);
        }
        
        $validated = $request->validate([
            'groom_name' => 'required|string|max:255',
            'bride_name' => 'required|string|max:255',
            'event_date' => 'required|date',
            'template_id' => 'required|exists:templates,id',
            'groom_father' => 'nullable|string|max:255',
            'groom_mother' => 'nullable|string|max:255',
            'bride_father' => 'nullable|string|max:255',
            'bride_mother' => 'nullable|string|max:255',
            'groom_address' => 'nullable|string|max:500',
            'bride_address' => 'nullable|string|max:500',
            'groom_ceremony_time' => 'nullable',
            'bride_ceremony_time' => 'nullable',
            'groom_reception_time' => 'nullable',
            'bride_reception_time' => 'nullable',
            'groom_reception_venue' => 'nullable|string|max:255',
            'bride_reception_venue' => 'nullable|string|max:255',
            'groom_reception_address' => 'nullable|string|max:500',
            'bride_reception_address' => 'nullable|string|max:500',
            'status' => 'nullable|in:draft,preview,published',
        ]);
        
        // Update template view path
        $template = Template::find($validated['template_id']);
        $validated['template_view'] = $template->view_path;
        
        $wedding->update($validated);
        
        return redirect()->route('dashboard.weddings.edit', $wedding)
            ->with('success', 'Thiệp cưới đã được cập nhật!');
    }

    /**
     * Remove the wedding.
     */
    public function destroy(Request $request, Wedding $wedding)
    {
        if ($wedding->user_id !== $request->user()->id) {
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
        if ($wedding->user_id !== $request->user()->id) {
            abort(403);
        }
        
        return redirect()->route('wedding.show', $wedding->slug);
    }
}
