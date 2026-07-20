<?php

namespace App\Http\Controllers;

use App\Models\Wedding;
use App\Services\WeddingDataService;
use App\Services\WeddingSideResolver;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WeddingController extends Controller
{
    /**
     * Display the wedding invitation
     */
    public function show(string $slug, Request $request)
    {
        /** @var Wedding $wedding */
        $wedding = Wedding::with('template')->where('slug', $slug)->first();

        if (! $wedding) {
            $wedding = Wedding::query()
                ->get()
                ->first(fn (Wedding $candidate): bool => $candidate->matchesInvitationSlug($slug));

            abort_unless($wedding, 404, 'Không tìm thấy thiệp cưới.');
            $wedding->load('template');
        }

        $user = Auth::user();

        // Check edit permission via secret key FIRST
        $isEditable = false;
        if ($request->has('key') && $request->get('key') === $wedding->edit_token) {
            $isEditable = true;
        }

        // Owner/Admin can always view their own weddings, even drafts
        $isOwner = $user && ($wedding->user_id === $user->id || $user->isSuperAdmin() || $user->isAdmin());

        if (!$isEditable && !$isOwner) {
            if (!$wedding->isViewable()) {
                abort(404, 'Thiep chua duoc xuat ban');
            }

            if (!$wedding->canView($user)) {
                if (!$user) {
                    return redirect()->route('login')
                        ->with('message', 'Vui long dang nhap de xem thiep nay.');
                }
                abort(403, 'Ban khong co quyen xem thiep nay. Thiep chua duoc chia se cong khai.');
            }

            // Check password if set
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

        // Thứ tự tên trên slug quyết định thiệp nhà gái/nhà trai.
        // Slug không theo cấu trúc tên đôi là thiệp chung.
        $side = $wedding->invitationSideForSlug($slug);
        $sideData = WeddingSideResolver::resolve($wedding, $side);

        // Resolve theme from config
        $template = $wedding->template;
        $templateSlug = $template?->view_path
            ? str_replace('templates.', '', $template->view_path)
            : 'default';
        $theme = config("wedding-themes.{$templateSlug}", config('wedding-themes.default'));

        // Prepare Media Data
        $mediaData = [
            'heroUrl'    => $wedding->getHeroUrl(),
            'shareUrl'   => $wedding->getCoverUrl(),
            'groomPhoto' => $wedding->getGroomPhotoUrl(),
            'bridePhoto' => $wedding->getBridePhotoUrl(),
            'musicUrl'   => $wedding->music_url,
            'beforeSliderImages' => $wedding->getMedia('before_slider')->take(5),
        ];

        // Prepare template data (ceremony times, DOW labels, calendar, gallery...)
        $templateData = WeddingDataService::prepare($wedding);

        // Determine View Path
        $viewPath = $template?->view_path ?? $wedding->template_view;

        return view($viewPath, array_merge(
            compact('wedding', 'isEditable', 'sideData', 'theme', 'side'),
            $mediaData,
            $templateData,
        ));
    }
}
