# Quy ước dữ liệu cho Wedding Template

Tài liệu này là hợp đồng dữ liệu bắt buộc khi tạo hoặc sửa template cưới. Mục tiêu là để Blade chỉ hiển thị dữ liệu đã được chuẩn bị, không tự suy đoán nguồn dữ liệu và không che lỗi cấu hình bằng fallback tùy tiện.

Chuẩn này áp dụng cho mọi template mới từ **THT E-Wedding 17** trở đi. Template tham chiếu: `resources/views/templates/tht_e_wedding_17.blade.php`.

Các template cũ, bao gồm THT E-Wedding 16 đang phục vụ khách hàng, là legacy và không được chỉnh sửa chỉ để đồng bộ với chuẩn này. Khi cần sửa lỗi cho template cũ, chỉ sửa tối thiểu trong đúng template đó.

## 0. Phạm vi của một template chuẩn

Mỗi template mới phải tự sở hữu phần giao diện của mình, nhưng dùng chung hợp đồng dữ liệu này:

1. Một Blade tại `resources/views/templates/<ten_template>.blade.php`, có metadata `Template Name`, `Type` và marker `Contract: v17`.
2. Một CSS riêng tại `resources/css/templates/<ten-template>.css`, được đăng ký trong `vite.config.js` và gọi qua `@vite()` từ Blade.
3. Một theme riêng trong `config/wedding-themes.php`.
4. Một bản ghi trong `TemplateSeeder` để môi trường mới có thể chọn được mẫu. Với môi trường đang vận hành, chỉ chạy `templates:sync` khi mẫu đã được duyệt giao diện.
5. Không dùng media riêng ở bản chuẩn. Nếu thiết kế thực sự cần ảnh riêng, mới thêm collection vào `config/wedding-template-media.php`; ảnh thiếu phải ẩn cả block, không thay bằng hero/gallery.
6. Nếu template có lời dẫn, bố cục hoặc nội dung riêng, khai báo các field đó trong mục **Schema dữ liệu riêng** khi sửa Template ở Admin. Không cần tạo class hay sửa config PHP.

Template chuẩn luôn có: hero, thông tin gia đình/lời mời, lịch tiệc và lễ theo `$sideData->events`, ảnh cô dâu/chú rể, RSVP, đếm ngược và footer. Album chỉ hiện khi có ảnh gallery thật.

Template và gói dịch vụ là hai khái niệm độc lập: mọi template đang bật đều có thể được chọn. `Wedding::$tier` chỉ quyết định các quyền/tính năng của thiệp (Standard hoặc Pro), không quyết định chất lượng hay khả năng chọn mẫu giao diện.

`tests/Feature/WeddingTemplateStandardTest.php` tự kiểm tra các điều bắt buộc cho mọi Blade có marker `Contract: v17`; template mới phải giữ marker này để không bỏ qua kiểm tra.

### Schema riêng của template

Nội dung dùng chung vẫn giữ trên các cột chuẩn của `weddings` (tên, gia đình, lịch tiệc/lễ, QR, nhạc và gallery). Những nội dung chỉ có ý nghĩa với một giao diện phải đặt trong đường dẫn riêng dưới cột JSON `weddings.content`.

Schema nằm tại cột JSON `templates.content_schema`. Trong Admin, mỗi field có: nhóm hiển thị, mã field, nhãn, kiểu nhập, gợi ý, lựa chọn (nếu là select), độ dài và trạng thái bắt buộc. Kiểu `Một ảnh` và `Nhiều ảnh` là media riêng của template; các kiểu còn lại được lưu tại `weddings.content.templates.<template_key>`. Khi một Wedding chọn template đó, các field tự hiện trong form Wedding.

### Chuyển schema từ local lên production

Không tạo lại từng field ở production. Tại **Cài đặt → Kho Giao diện** ở local, bấm **Xuất schema JSON**; sau khi deploy code có các Blade tương ứng, mở đúng màn hình trên production và bấm **Nhập schema JSON** để tải file đó lên. Thao tác nhập cập nhật schema của mọi mẫu có trong file (và chỉ tạo bản ghi mẫu nếu Blade của mẫu đã có trên máy chủ); schema của các mẫu trong file sẽ được thay thế đồng bộ.

Không đặt dữ liệu dùng chung hoặc câu chữ mặc định của sản phẩm trong schema: tên đôi, ngày, gia đình, lịch, QR, nhạc, gallery, RSVP, danh sách `invited_guests` và Thank You vẫn thuộc dữ liệu dùng chung hoặc bố cục cố định của template. `invited_guests` là tính năng cấp thiệp, dùng cùng một URL mời riêng cho mọi template. `WeddingTemplateContentService` chỉ chuẩn hoá các key riêng rồi truyền `$templateContent` vào Blade. Vì vậy Blade chỉ đọc dữ liệu đã chuẩn bị; đổi sang template khác không làm mất phần nội dung đã nhập của mẫu trước đó.

## 1. Luồng dữ liệu chuẩn

```text
Database / Media Library
        ↓
Wedding model + WeddingSideResolver + WeddingDataService
        ↓
WeddingController
        ↓
Blade template
```

Trách nhiệm của từng tầng:

- `Wedding`: dữ liệu gốc từ database, casts, accessor và formatter dùng chung.
- `WeddingSideResolver`: xác định dữ liệu nhà trai, nhà gái hoặc cả hai; xử lý override ngày và tạo `WeddingEventData`.
- `WeddingDataService`: dữ liệu dùng chung hoặc dữ liệu tổng hợp cũ của các template.
- `WeddingController`: tập hợp dữ liệu và truyền vào view.
- Blade: chỉ hiển thị, lặp và ẩn/hiện; không truy vấn database, không tính ngày âm và không tạo chuỗi fallback.

## 2. Dữ liệu luôn có trong template

### `$wedding`

Model gốc. Dùng trực tiếp khi cần dữ liệu không phụ thuộc `side`:

```blade
{{ $wedding->event_date->format('d.m.Y') }}
{{ $wedding->groom_name }}
{{ $wedding->bride_name }}
```

Ngày ở hero, footer, countdown hoặc tiêu đề chung phải lấy từ `$wedding->event_date`. Không lấy ngày đầu tiên trong `$sideData->events` thay cho ngày cưới chính.

### `$sideData`

DTO đã được `WeddingSideResolver` chuẩn bị theo query `?side=bride`, `?side=groom` hoặc `?side=both`.

Các thuộc tính chính:

| Thuộc tính | Ý nghĩa |
|---|---|
| `side` | `bride`, `groom` hoặc `both` |
| `firstName`, `secondName` | Thứ tự tên phù hợp với bản thiệp đang xem |
| `firstPhoto`, `secondPhoto` | Ảnh theo cùng thứ tự tên |
| `families` | Danh sách `WeddingFamilyData` |
| `events` | Danh sách `WeddingEventData` |

Không tự kiểm tra query `side` hoặc tự đảo tên trong Blade.

### `$event` trong `$sideData->events`

Mỗi event đã có sẵn:

| Thuộc tính/phương thức | Ý nghĩa |
|---|---|
| `receptionDate` | Ngày tiệc dương lịch đã resolve |
| `receptionLunarDisplay` | Ngày tiệc âm lịch theo format được chọn |
| `receptionTime` / `receptionTimeLabel()` | Giờ tiệc |
| `receptionDayLabel()` | Thứ trong tuần của ngày tiệc |
| `receptionVenue`, `receptionAddress` | Địa điểm tiệc |
| `receptionMapUrl`, `receptionMapEmbed` | Bản đồ tiệc |
| `ceremonyDate` | Ngày làm lễ dương lịch đã resolve |
| `ceremonyLunarDisplay` | Ngày làm lễ âm lịch theo format được chọn |
| `ceremonyTime` / `ceremonyTimeLabel()` | Giờ làm lễ |
| `ceremonyDayLabel()` | Thứ trong tuần của ngày làm lễ |
| `ceremonyVenue`, `ceremonyAddress` | Địa điểm làm lễ |
| `ceremonyMapUrl`, `ceremonyMapEmbed` | Bản đồ làm lễ |

Ví dụ đúng:

```blade
@foreach($sideData->events as $event)
    <time datetime="{{ $event->receptionDate->toDateString() }}">
        {{ $event->receptionDate->format('d/m/Y') }}
    </time>

    @if($event->receptionLunarDisplay)
        <p>({{ $event->receptionLunarDisplay }})</p>
    @endif
@endforeach
```

## 3. Quy ước ngày cưới

### Ngày cưới chính

| Cột | Vai trò |
|---|---|
| `event_date` | Ngày dương cưới chính, bắt buộc |
| `event_date_lunar` | Ngày âm của ngày cưới chính |
| `lunar_date_format` | `short` hoặc `full` |

`event_date` là nguồn duy nhất cho ngày chung của toàn thiệp.

Không dùng:

```blade
{{ $sideData->events->first()->receptionDate }}
```

để thay cho ngày cưới chính.

### Ngày riêng của nhà trai và nhà gái

Các cột override:

- `groom_reception_date`
- `groom_ceremony_date`
- `bride_reception_date`
- `bride_ceremony_date`

Quy tắc resolve duy nhất:

```text
Ngày riêng có dữ liệu → dùng ngày riêng
Ngày riêng để trống     → dùng event_date
```

Ngày tiệc không được fallback sang ngày làm lễ. Form Filament ghi “nếu khác ngày cưới”, vì vậy giá trị trống mang nghĩa là dùng `event_date`.

### Ngày âm của từng event

Không tạo thêm cột ngày âm cho từng ngày tiệc/lễ khi ngày âm chỉ là dữ liệu suy ra.

`WeddingSideResolver` tính ngày âm từ ngày dương đã resolve và đưa vào:

- `$event->receptionLunarDisplay`
- `$event->ceremonyLunarDisplay`

Hai giá trị này tự tuân theo `lunar_date_format` trong database. Chỉ thêm cột riêng nếu sản phẩm cần cho phép người dùng nhập hoặc sửa ngày âm thủ công.

## 4. Quy ước media

Media dùng Spatie Media Library và được lưu trong bảng `media` theo `collection_name`, không phải mỗi ảnh là một cột trong bảng `weddings`.

### Collection dùng chung

| Collection | Cách lấy |
|---|---|
| `hero` | `$wedding->getHeroUrl()` hoặc `$heroUrl` |
| `cover` | `$wedding->getCoverUrl()` hoặc `$shareUrl` |
| `groom_photo` | `$wedding->getGroomPhotoUrl()` |
| `bride_photo` | `$wedding->getBridePhotoUrl()` |
| `gallery` | `$wedding->gallery_images` hoặc `$albumImages` |
| `groom_qr`, `bride_qr` | Các helper QR trên `Wedding` |

Các helper media dùng chung có thể dùng dữ liệu demo khi wedding là demo. Đây là fallback cấp domain đã được định nghĩa trong model, không phải fallback tự viết trong Blade.

### Media riêng của template

Khai báo trong `config/wedding-template-media.php`:

```php
'templates.my_template' => [
    'label' => 'Ảnh riêng của My Template',
    'description' => 'Vị trí chưa có ảnh sẽ không hiển thị.',
    'fields' => [
        [
            'name' => 'my_template_banner',
            'collection' => 'my_template_banner',
            'label' => 'Ảnh banner',
            'aspect_ratio' => '16:9',
        ],
    ],
],
```

Sau đó lấy đúng collection:

```blade
@if($wedding->getTemplateMediaUrl('my_template_banner'))
    <img src="{{ $wedding->getTemplateMediaUrl('my_template_banner') }}" alt="">
@endif
```

Không làm như sau:

```blade
{{-- Sai: ảnh thiếu ở một vị trí bị che bằng ảnh không đúng mục đích --}}
{{ $wedding->getTemplateMediaUrl('my_template_banner')
    ?? $albumImages->first()
    ?? $heroUrl }}
```

Nếu media riêng là bắt buộc, validation phải đặt trong schema Filament. Nếu media là tùy chọn, Blade ẩn cả block khi collection chưa có dữ liệu.

## 5. Fallback nào được phép

Fallback chỉ hợp lệ khi nó là quy tắc nghiệp vụ có tên và được xử lý trước khi vào Blade.

Được phép:

- Ngày tiệc/lễ override để trống thì dùng `event_date`.
- Wedding demo dùng media của `DemoContent` thông qua helper trong model.
- Địa điểm hoặc map dùng quy tắc chung đã được định nghĩa trong `WeddingSideResolver`.

Không được phép:

- Dùng `now()` thay cho `event_date` bắt buộc.
- Dùng ngày tiệc hoặc ngày làm lễ thay cho ngày cưới chính ở hero/footer.
- Dùng ảnh gallery/hero để lấp media riêng của template.
- Viết chuỗi `??` nhiều tầng trong Blade để che dữ liệu thiếu.
- Dùng placeholder từ internet trên thiệp production.

Lưu ý: `WeddingDataService` còn một số biến và placeholder phục vụ template cũ (`$solar`, `$imgs`, `$placeholders`, các biến giờ/ngày rời). Template mới không được copy cách này. Ưu tiên `$wedding` và `$sideData`; khi cần dữ liệu mới, mở rộng DTO/service trước.

## 6. Quy tắc viết Blade

Blade được phép:

- Hiển thị thuộc tính.
- Gọi formatter đơn giản như `format()` hoặc các label method của DTO.
- `@if`, `@foreach`, component và include.
- Ẩn block tùy chọn khi dữ liệu chính xác chưa có.

Blade không được phép:

- `@php` để chuẩn bị dữ liệu.
- Query model hoặc media relation.
- Tính ngày âm, thứ trong tuần hoặc resolve `side`.
- Đặt fallback nghiệp vụ.
- Tạo tên biến mới cho dữ liệu đã có tên chuẩn.

Nếu Blade cần logic kiểu này:

```blade
@php
    $someDate = ...;
    $someImage = ...;
@endphp
```

hãy dừng lại và đưa dữ liệu đó vào model, DTO hoặc service.

## 7. Khi cần thêm dữ liệu mới

### Dữ liệu người dùng nhập và cần lưu

Thực hiện đủ các bước:

1. Tạo migration.
2. Thêm vào `$fillable` và `$casts` của `Wedding` nếu cần.
3. Thêm field trong `WeddingForm`.
4. Đưa vào DTO/service nếu dữ liệu phụ thuộc `side` hoặc cần resolve.
5. Blade chỉ đọc giá trị đã chuẩn bị.

### Dữ liệu suy ra từ dữ liệu khác

Không thêm cột database chỉ để tiện gọi. Thêm formatter/accessor hoặc thuộc tính DTO, ví dụ ngày âm và thứ trong tuần.

### Ảnh riêng của template

1. Khai báo collection trong `config/wedding-template-media.php`.
2. Đặt tên collection có prefix riêng của template.
3. Lấy đúng collection trong Blade.
4. Quyết định rõ field bắt buộc hay block tùy chọn.
5. Không fallback sang collection khác.

## 8. Khung template tối thiểu

```blade
@extends('layouts.wedding')

@section('title', $sideData->firstName . ' & ' . $sideData->secondName)

@push('styles')
    @vite(['resources/css/templates/my-template.css'])
@endpush

@section('content')
    <main class="my-template wedding-container">
        <section class="hero">
            <img src="{{ $heroUrl }}" alt="">
            <h1>{{ $sideData->firstName }} & {{ $sideData->secondName }}</h1>
            <time datetime="{{ $wedding->event_date->toDateString() }}">
                {{ $wedding->event_date->format('d.m.Y') }}
            </time>
        </section>

        @foreach($sideData->events as $event)
            <section class="event">
                <h2>{{ $event->ceremonyTitle }}</h2>
                <p>{{ $event->ceremonyDate->format('d/m/Y') }}</p>
                @if($event->ceremonyLunarDisplay)
                    <p>({{ $event->ceremonyLunarDisplay }})</p>
                @endif
            </section>
        @endforeach
    </main>
@endsection
```

## 9. Checklist trước khi hoàn thành template

- [ ] Hero và footer dùng `$wedding->event_date` cho ngày cưới chính.
- [ ] Dữ liệu theo nhà trai/nhà gái lấy từ `$sideData`.
- [ ] Ngày tiệc/lễ lấy từ `$event`, không tự fallback trong Blade.
- [ ] Ngày âm lấy từ `receptionLunarDisplay` hoặc `ceremonyLunarDisplay`.
- [ ] Không có `@php` trong template.
- [ ] Không có query database trong template.
- [ ] Không có chuỗi fallback ảnh giữa các collection.
- [ ] Media riêng đã khai báo trong `config/wedding-template-media.php`.
- [ ] Block media tùy chọn được ẩn khi chưa có ảnh.
- [ ] CSS/JS riêng đi qua Vite.
- [ ] Kiểm tra `side=bride`, `side=groom` và `side=both`.
- [ ] Kiểm tra mobile 360 px, 390 px và desktop.
- [ ] Blade cache thành công và trang render HTTP 200.

Lệnh kiểm tra tối thiểu:

```bash
php artisan view:clear
php artisan view:cache
php artisan test
npm run build
```
