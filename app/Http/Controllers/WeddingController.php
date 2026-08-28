<?php

namespace App\Http\Controllers;

use App\Models\Wedding;
use App\Services\WeddingDataService;
use App\Services\WeddingSideResolver;
use App\Services\WeddingTemplateContentService;
use App\Services\WeddingTemplateSchemaRegistry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

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

        // Thứ tự tên trên slug chỉ chọn sẵn phía trong RSVP.
        // Nội dung thiệp luôn hiển thị đầy đủ nhà gái trước, rồi nhà trai.
        $side = $wedding->invitationSideForSlug($slug);
        $sideData = WeddingSideResolver::resolve($wedding, 'both');
        $givenNameInitial = static function (?string $fullName): string {
            $parts = preg_split('/\s+/u', trim((string) $fullName), -1, PREG_SPLIT_NO_EMPTY);
            $givenName = $parts ? end($parts) : '';

            return $givenName !== ''
                ? mb_strtoupper(mb_substr($givenName, 0, 1, 'UTF-8'), 'UTF-8')
                : '';
        };
        $groomInitial = $givenNameInitial($wedding->groom_name);
        $brideInitial = $givenNameInitial($wedding->bride_name);
        $invitationMonogram = collect([$sideData->firstName, $sideData->secondName])
            ->map(fn (string $name): string => Str::upper(Str::substr(Str::ascii($name), 0, 1)))
            ->implode(' & ');

        // Resolve theme from config
        $template = $wedding->template;
        $viewPath = $template?->view_path ?? $wedding->template_view;
        $schemaTemplate = WeddingTemplateSchemaRegistry::forViewPath($viewPath, $template);
        $templateSlug = $viewPath
            ? str_replace('templates.', '', $viewPath)
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
            'templateSchemaMedia' => WeddingTemplateSchemaRegistry::mediaForWedding($schemaTemplate, $wedding),
        ];

        // Prepare template data (ceremony times, DOW labels, calendar, gallery...)
        $templateData = WeddingDataService::prepare($wedding);
        $templateData = array_merge($templateData, [
            'heroDates' => WeddingDataService::heroDates($wedding, $sideData),
        ]);
        $templateContent = WeddingTemplateContentService::for($wedding);
        $approvedWishes = $wedding->approvedWishes()->latest()->take(10)->get();

        return view($viewPath, array_merge(
            compact('wedding', 'isEditable', 'sideData', 'theme', 'side', 'templateContent', 'invitationMonogram', 'groomInitial', 'brideInitial', 'approvedWishes'),
            $mediaData,
            $templateData,
        ));
    }
}
