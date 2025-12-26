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
        
        // Set defaults - preview để user có thể xem ngay
        $validated['status'] = 'preview';
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
            // Basic info
            'groom_name' => 'required|string|max:255',
            'bride_name' => 'required|string|max:255',
            'event_date' => 'required|date',
            'template_id' => 'required|exists:templates,id',
            'status' => 'nullable|in:draft,preview,published',
            
            // Nhà trai
            'groom_father' => 'nullable|string|max:255',
            'groom_mother' => 'nullable|string|max:255',
            'groom_ceremony_time' => 'nullable',
            'groom_ceremony_date' => 'nullable|date',
            'groom_address' => 'nullable|string|max:1000',
            'groom_map_url' => 'nullable|url|max:500',
            'groom_reception_time' => 'nullable',
            'groom_reception_venue' => 'nullable|string|max:255',
            'groom_reception_address' => 'nullable|string|max:1000',
            'groom_qr_info' => 'nullable|string|max:1000',
            
            // Nhà gái  
            'bride_father' => 'nullable|string|max:255',
            'bride_mother' => 'nullable|string|max:255',
            'bride_ceremony_time' => 'nullable',
            'bride_ceremony_date' => 'nullable|date',
            'bride_address' => 'nullable|string|max:1000',
            'bride_map_url' => 'nullable|url|max:500',
            'bride_reception_time' => 'nullable',
            'bride_reception_venue' => 'nullable|string|max:255',
            'bride_reception_address' => 'nullable|string|max:1000',
            'bride_qr_info' => 'nullable|string|max:1000',
            
            // Settings
            'slug' => 'nullable|string|max:255|unique:weddings,slug,' . $wedding->id,
            'password' => 'nullable|string|max:255',
            'is_auto_approve_wishes' => 'boolean',
            'show_preload' => 'boolean',
            'falling_effect' => 'nullable|in:hearts,petals,snow,leaves,stars,none',
            
            // Media uploads
            'background_music' => 'nullable|file|mimes:mp3|max:10240',
            'cover' => 'nullable|image|max:5120',
            'hero' => 'nullable|image|max:5120',
            'groom_photo' => 'nullable|image|max:5120',
            'bride_photo' => 'nullable|image|max:5120',
            'groom_qr' => 'nullable|image|max:2048',
            'bride_qr' => 'nullable|image|max:2048',
            'gallery' => 'nullable|array',
            'gallery.*' => 'image|max:5120',
        ]);
        
        // Update template view path
        $template = Template::find($validated['template_id']);
        if (!$template) {
            return back()->with('error', 'Template không tồn tại!');
        }
        $validated['template_view'] = $template->view_path;
        
        // Handle boolean checkboxes
        $validated['is_auto_approve_wishes'] = $request->has('is_auto_approve_wishes');
        $validated['show_preload'] = $request->has('show_preload');
        
        // Remove file fields from validated data (handled separately)
        $fileFields = ['background_music', 'cover', 'hero', 'groom_photo', 'bride_photo', 'groom_qr', 'bride_qr', 'gallery'];
        foreach ($fileFields as $field) {
            unset($validated[$field]);
        }
        
        // Update wedding
        $wedding->update($validated);
        
        // Handle media uploads
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
        
        // Gallery (multiple files)
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

    /**
     * Manage RSVPs for the wedding.
     */
    public function rsvps(Request $request, Wedding $wedding)
    {
        if ($wedding->user_id !== $request->user()->id) {
            abort(403);
        }
        
        // Export to CSV
        if ($request->has('export') && $request->export === 'csv') {
            $rsvps = $wedding->rsvps()->latest()->get();
            $filename = 'danh-sach-khach-moi-' . $wedding->slug . '.csv';
            
            $headers = [
                "Content-type" => "text/csv; charset=UTF-8",
                "Content-Disposition" => "attachment; filename=$filename",
                "Pragma" => "no-cache",
                "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
                "Expires" => "0"
            ];
            
            $callback = function() use ($rsvps) {
                $file = fopen('php://output', 'w');
                
                // Add BOM for Excel UTF-8 support
                fputs($file, "\xEF\xBB\xBF");
                
                fputcsv($file, ['Họ tên', 'Số điện thoại', 'Tham dự', 'Số khách', 'Nhà', 'Ghi chú', 'Thời gian']);
                
                foreach ($rsvps as $rsvp) {
                    fputcsv($file, [
                        $rsvp->name,
                        $rsvp->phone,
                        $rsvp->attendance_text,
                        $rsvp->guests,
                        $rsvp->side_text,
                        $rsvp->note,
                        $rsvp->created_at->format('d/m/Y H:i'),
                    ]);
                }
                
                fclose($file);
            };
            
            return response()->stream($callback, 200, $headers);
        }
        
        // Stats
        $stats = [
            'total_guests' => $wedding->rsvps()->sum('guests'),
            'attending' => $wedding->rsvps()->attending()->count(),
            'not_attending' => $wedding->rsvps()->where('attendance', 'no')->count(),
            'maybe' => $wedding->rsvps()->where('attendance', 'maybe')->count(),
            'groom_side' => $wedding->rsvps()->groomSide()->sum('guests'),
            'bride_side' => $wedding->rsvps()->brideSide()->sum('guests'),
        ];
        
        $rsvps = $wedding->rsvps()->latest()->paginate(20);
        
        return view('dashboard.weddings.rsvps', compact('wedding', 'rsvps', 'stats'));
    }

    /**
     * Manage wishes for the wedding.
     */
    public function wishes(Request $request, Wedding $wedding)
    {
        if ($wedding->user_id !== $request->user()->id) {
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
        
        $stats = [
            'total' => $wedding->wishes()->count(),
            'pending' => $wedding->wishes()->where('is_approved', false)->count(),
            'approved' => $wedding->wishes()->where('is_approved', true)->count(),
        ];
        
        return view('dashboard.weddings.wishes', compact('wedding', 'wishes', 'stats', 'filter'));
    }

    /**
     * Approve a wish
     */
    public function approveWish(Request $request, Wedding $wedding, $wishId)
    {
        if ($wedding->user_id !== $request->user()->id) {
            abort(403);
        }
        
        $wish = $wedding->wishes()->findOrFail($wishId);
        $wish->update(['is_approved' => true]);
        
        return back()->with('success', 'Đã duyệt lời chúc!');
    }

    /**
     * Delete a wish
     */
    public function deleteWish(Request $request, Wedding $wedding, $wishId)
    {
        if ($wedding->user_id !== $request->user()->id) {
            abort(403);
        }
        
        $wish = $wedding->wishes()->findOrFail($wishId);
        $wish->delete();
        
        return back()->with('success', 'Đã xóa lời chúc!');
    }
}
