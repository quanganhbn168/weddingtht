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

        // Return the template view
        return view($wedding->template_view, compact('wedding', 'isEditable'));
    }
}
