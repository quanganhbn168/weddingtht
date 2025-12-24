---
description: Quy tắc phát triển SaaS E-Wedding (Thiệp cưới online)
---

# PROJECT RULES: SAAS E-WEDDING (THIỆP CƯỚI ONLINE)

## 1. TỔNG QUAN DỰ ÁN
Xây dựng nền tảng tạo thiệp cưới online (SaaS).
- **Mô hình:** Admin tạo thiệp/quản lý khách hàng + Khách hàng có thể tự chỉnh sửa (Upload ảnh, sửa text) thông qua "Secret Link".
- **Ưu điểm:** Nhanh, linh hoạt mẫu giao diện, chi phí vận hành thấp, trải nghiệm người dùng cao cấp (Edit-in-place).

---

## 2. TECH STACK (BẮT BUỘC)
| Thành phần | Công nghệ | Ghi chú |
| :--- | :--- | :--- |
| **Backend** | **Laravel 11** | Framework cốt lõi. |
| **Database** | MySQL | Lưu trữ dữ liệu. |
| **Admin Panel** | **FilamentPHP v3** | Quản lý dự án, khách hàng, cấu hình. |
| **Frontend** | Blade + TailwindCSS | Render giao diện chuẩn SEO. |
| **Interactivity** | **Livewire 3** | Xử lý logic realtime (Upload, Save). |
| **Client Logic** | **Alpine.js** | Xử lý Modal, Toggle UI. |
| **Image Tool** | **Cropper.js** | Cắt, xoay, chỉnh khung ảnh phía Client. |
| **Media** | Spatie Media Library | Quản lý file, tối ưu ảnh tự động. |

---

## 3. CẤU TRÚC DATABASE SCHEMA

### Bảng `weddings` (Core Table)
```php
Schema::create('weddings', function (Blueprint $table) {
    $table->id();
    $table->string('slug')->unique();         // URL định danh (vd: tung-duong-2024)
    $table->string('groom_name');             // Tên chú rể
    $table->string('bride_name');             // Tên cô dâu
    $table->date('event_date');               // Ngày cưới
    
    // Quản lý trạng thái & Giao diện
    $table->string('template_view');          // File view blade (vd: 'templates.modern_01')
    $table->enum('status', ['draft', 'preview', 'published', 'archived'])->default('draft');
    
    // Bảo mật & Quyền hạn
    $table->uuid('edit_token')->unique();     // Secret Key để khách tự sửa
    $table->string('password')->nullable();   // Mật khẩu xem thiệp (Option)
    
    // Dữ liệu động (Quan trọng nhất)
    // Lưu: video_url, map_url, wishes, colors, fonts, music_url...
    $table->json('content')->nullable(); 
    
    $table->timestamps();
});
```

---

## 4. MODEL CHUẨN

### Model `Wedding` (app/Models/Wedding.php)
```php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Wedding extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $guarded = [];

    protected $casts = [
        'event_date' => 'date',
        'content' => 'array', // Tự động convert JSON <-> Array
    ];

    // Tạo UUID tự động cho edit_token khi tạo mới
    protected static function booted()
    {
        static::creating(function ($wedding) {
            $wedding->edit_token = (string) \Illuminate\Support\Str::uuid();
        });
    }
}
```

---

## 5. ROUTING RULES

### Route hiển thị thiệp (web.php)
```php
// Đặt ở CUỐI file để hứng mọi request
Route::get('/{slug}', [App\Http\Controllers\WeddingController::class, 'show'])->name('wedding.show');
```

### Controller Logic (WeddingController.php)
```php
public function show($slug, Request $request)
{
    $wedding = Wedding::where('slug', $slug)->firstOrFail();

    // Check quyền xem
    if ($wedding->status === 'draft') abort(404);
    
    // Check quyền sửa (nếu có key trên URL)
    $isEditable = false;
    if ($request->has('key') && $request->get('key') === $wedding->edit_token) {
        $isEditable = true;
    }

    // Trả về đúng mẫu giao diện
    return view($wedding->template_view, compact('wedding', 'isEditable'));
}
```

---

## 6. TÍNH NĂNG "EDIT IN PLACE" (CỐT LÕI)

### Livewire Component `EditableImage`
**Backend (app/Livewire/EditableImage.php):**
```php
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Wedding;

class EditableImage extends Component
{
    use WithFileUploads;

    public $weddingId;
    public $collectionName; // vd: 'cover', 'gallery'
    public $aspectRatio;    // vd: 16/9
    public $photo;          // Biến hứng file upload

    public function updatedPhoto()
    {
        $wedding = Wedding::find($this->weddingId);
        
        // Xóa ảnh cũ trong collection này (nếu là ảnh đơn)
        $wedding->clearMediaCollection($this->collectionName);
        
        // Add ảnh mới từ file tạm của Livewire
        $wedding->addMedia($this->photo->getRealPath())
                ->toMediaCollection($this->collectionName);

        $this->dispatch('refresh-ui');
    }

    public function render()
    {
        $wedding = Wedding::find($this->weddingId);
        $imageUrl = $wedding->getFirstMediaUrl($this->collectionName); 
        
        return view('livewire.editable-image', compact('imageUrl'));
    }
}
```

**Frontend (resources/views/livewire/editable-image.blade.php):**
```html
<div x-data="{ 
    open: false, 
    cropper: null,
    save() {
        this.cropper.getCroppedCanvas().toBlob((blob) => {
            @this.upload('photo', blob, 
                () => { this.open = false; }, 
                () => { alert('Lỗi!'); }
            );
        });
    }
}">
    <div class="relative group">
        <img src="{{ $imageUrl }}" class="w-full">
        
        @if(request()->has('key'))
            <button @click="fileChosen" class="absolute inset-0 ...">Sửa ảnh</button>
        @endif
    </div>
</div>
```

---

## 7. LƯU Ý TRIỂN KHAI (QUAN TRỌNG)

### 7.1 Storage & Media
- Khi đưa lên VPS/Server thật, nếu hosting yếu, cấu hình Spatie Media Library dùng **S3 (AWS/MinIO)** hoặc **Cloudinary**.
- Luôn chạy `php artisan storage:link` sau khi deploy.

### 7.2 SEO
- Với các trang có kèm `?key=...`, thêm thẻ `<meta name="robots" content="noindex">` để Google không index trang admin của khách.

### 7.3 Map & Nhạc
- **Nhạc:** Upload file mp3 lên host hoặc dùng link ZingMp3/Youtube. Lưu URL vào `content['music_url']`.
- **Map:** Lưu iframe HTML hoặc toạ độ vào `content['map_iframe']`.

---

## 8. PACKAGES CẦN CÀI ĐẶT

```bash
# Cài đặt Filament
composer require filament/filament:"^3.2" -W
php artisan filament:install --panels

# Cài đặt Spatie Media Library
composer require spatie/laravel-medialibrary
php artisan vendor:publish --provider="Spatie\MediaLibrary\MediaLibraryServiceProvider" --tag="medialibrary-migrations"

# Cài đặt Livewire (check lại nếu chưa có)
composer require livewire/livewire

# Link Storage
php artisan storage:link
```

---

## 9. PROMPT TEMPLATES CHO AI

### PROMPT 1: Khởi tạo Database & Admin
```
Act as a Senior Laravel Architect.
1. Setup a `Wedding` model with migration.
   - Columns: slug (string, unique), edit_token (uuid, unique), status (enum: draft, published), template_view (string), content (json), event_date (date).
   - Implement `Spatie\MediaLibrary\HasMedia`.
2. Generate a Filament V3 Resource for `Wedding`.
   - Form: Should have sections for Basic Info, Config (JSON KeyValue), and Media Upload (Spatie).
   - Table: Columns for Names, Status (Badge), Date.
3. Output the Migration file and the Resource class file.
```

### PROMPT 2: Xử lý Logic hiển thị (View)
```
Create a `WeddingController` and a Route.
1. Route: `/{slug}` handles the request.
2. Controller Logic:
   - Find wedding by slug.
   - Check `status`. If draft -> 404.
   - Check `request('key')` against `wedding->edit_token`. Pass `$isEditable` (bool) to view.
   - Return view dynamic based on `$wedding->template_view`.
```

### PROMPT 3: Component Cắt ảnh (Cropper + Livewire)
```
Create a Livewire Component `EditableImage` that uses Alpine.js and Cropper.js.
Requirements:
1. Props: `weddingId`, `mediaCollection`, `aspectRatio`.
2. UI: Show current image. If `$isEditable` is true, clicking image opens a Modal.
3. Modal: Use `cropper.js` to crop selected image.
4. Logic: On save, convert crop to Blob, use `@this.upload` to send to Livewire.
5. Backend: Save uploaded file to Spatie Media Library collection.
```

---

## 10. CHECKLIST TRIỂN KHAI

- [ ] Cài đặt packages (Filament, Spatie, Livewire)
- [ ] Tạo migration bảng `weddings`
- [ ] Tạo Model `Wedding` với HasMedia
- [ ] Tạo Filament Resource cho Wedding
- [ ] Tạo Route `/{slug}`
- [ ] Tạo WeddingController với logic xác thực
- [ ] Tạo Livewire EditableImage component
- [ ] Tạo Livewire EditableText component
- [ ] Tích hợp Cropper.js
- [ ] Tạo templates mẫu (modern_01, classic_01, etc.)
- [ ] Cấu hình SEO noindex cho edit pages
- [ ] Test upload ảnh, sửa text
- [ ] Deploy lên server
