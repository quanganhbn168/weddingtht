<?php

namespace App\Http\Controllers;

use App\Models\Wedding;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WeddingController extends Controller
{
    /**
     * Display the wedding invitation
     */
    public function show(string $slug, Request $request)
    {
        $wedding = Wedding::where('slug', $slug)->firstOrFail();
        $user = Auth::user();

        // Check edit permission via secret key FIRST
        $isEditable = false;
        if ($request->has('key') && $request->get('key') === $wedding->edit_token) {
            $isEditable = true;
        }
        
        // Owner/Admin can always view their own weddings, even drafts
        $isOwner = $user && ($wedding->user_id === $user->id || $user->isSuperAdmin() || $user->isAdmin());

        // Nếu có key đúng hoặc là owner thì bypass check status
        if (!$isEditable && !$isOwner) {
            // Guest/khác owner -> phải là preview/published mới xem được
            if (!$wedding->isViewable()) {
                abort(404, 'Thiệp chưa được xuất bản');
            }

            // === SHARE/ACCESS CONTROL ===
            // Demo weddings: always viewable
            // Pro + can_share=true: public access
            // Standard or can_share=false: private link (must login as owner)
            if (!$wedding->canView($user)) {
                // Not allowed - redirect to login or show upgrade message
                if (!$user) {
                    // Guest trying to view private wedding
                    return redirect()->route('login')
                        ->with('message', 'Vui lòng đăng nhập để xem thiệp này.');
                }
                
                // Logged in but not owner
                abort(403, 'Bạn không có quyền xem thiệp này. Thiệp chưa được chia sẻ công khai.');
            }

            // Check password if set (chỉ khi xem công khai, không áp dụng cho edit mode)
            if ($wedding->password) {
                if (!session()->has('wedding_' . $wedding->id . '_authenticated')) {
                    if ($request->isMethod('post') && $request->input('password') === $wedding->password) {
                        session()->put('wedding_' . $wedding->id . '_authenticated', true);
                    } else {
                        return view('wedding.password', compact('wedding'));
                    }
                }
            }
        }

        // Show upgrade banner for Standard tier viewing their own wedding
        $showUpgradeBanner = false;
        if ($user && $wedding->user_id === $user->id && !$wedding->isPro() && !$wedding->can_share) {
            $showUpgradeBanner = true;
        }

        // Prepare Media Data
        $mediaData = [
            'heroUrl' => $wedding->getFirstMediaUrl('hero', 'optimized') ?: ($wedding->getFirstMediaUrl('cover') ?: 'https://images.unsplash.com/photo-1519741497674-611481863552?w=1920&q=80'),
            'shareUrl' => $wedding->getFirstMediaUrl('cover', 'share') ?: ($wedding->getFirstMediaUrl('hero', 'share') ?: ($wedding->getFirstMediaUrl('hero', 'optimized') ?: 'https://images.unsplash.com/photo-1519741497674-611481863552?w=1920&q=80')),
            'groomPhoto' => $wedding->getFirstMediaUrl('groom_photo') ?: 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=400&h=600&fit=crop',
            'bridePhoto' => $wedding->getFirstMediaUrl('bride_photo') ?: 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=400&h=600&fit=crop',
            'musicUrl' => $wedding->background_music ? asset('storage/' . $wedding->background_music) : null,
        ];

        // Determine View Path
        $viewPath = $wedding->template?->view_path ?? $wedding->template_view;

        // Return the template view
        return view($viewPath, array_merge(compact('wedding', 'isEditable', 'showUpgradeBanner'), $mediaData));
    }
}

