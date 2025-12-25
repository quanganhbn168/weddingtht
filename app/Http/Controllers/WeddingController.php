<?php

namespace App\Http\Controllers;

use App\Models\Wedding;
use Illuminate\Http\Request;

class WeddingController extends Controller
{
    /**
     * Display the wedding invitation
     */
    public function show(string $slug, Request $request)
    {
        $wedding = Wedding::where('slug', $slug)->firstOrFail();

        // Check edit permission via secret key FIRST
        $isEditable = false;
        if ($request->has('key') && $request->get('key') === $wedding->edit_token) {
            $isEditable = true;
        }

        // Nếu có key đúng thì bypass luôn check status (cho phép sửa cả bản nháp)
        // Nếu không có key thì phải check status
        if (!$isEditable) {
            // Không có key -> phải là preview/published mới xem được
            if (!$wedding->isViewable()) {
                abort(404, 'Thiệp chưa được xuất bản');
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
        return view($viewPath, array_merge(compact('wedding', 'isEditable'), $mediaData));
    }
}
