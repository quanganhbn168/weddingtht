@extends('layouts.wedding')
{{-- Template Name: THT E-Wedding 19 (Olive Memories) --}}
{{-- Type: wedding --}}
{{-- Contract: v17 --}}
{{-- THT19: presentation only. The controller owns wedding/side/content/media resolution. --}}

@section('title', e($sideData->firstName . ' và ' . $sideData->secondName . ' | Wedding Invitation'))
@section('description', e('Trân trọng kính mời ' . $guestName . ' đến chung vui cùng đám cưới của ' . $sideData->firstName . ' và ' . $sideData->secondName))
@section('og_image', e($shareUrl))

@push('styles')
    @vite(['resources/css/templates/tht-e-wedding-19.css'])
    <style>
        .tht19-portraits::before {
            background-image: url('{{ asset('images/templates/tht-e-wedding-19/background-main.webp') }}');
        }
    </style>
@endpush

@section('content')
<main class="tht19 wedding-container" id="tht19-top">
    {{-- Keep the application's opening screen, envelope, effects and music. --}}
    @include('components.wedding.preload', ['wedding' => $wedding, 'variant' => 'split_botanical'])
    @if($wedding->show_invitation_wrapper)
        <x-wedding.invitation-wrapper :wedding="$wedding" />
    @endif
    @include('components.wedding.falling-effects', ['wedding' => $wedding])
    <x-wedding.music-player :wedding="$wedding" />

    {{-- 01. Full-bleed portrait cover; the primary wedding date stays primary. --}}
    <section class="tht19-hero gold-bottom-overlay" aria-labelledby="tht19-couple-title">
        @if($heroUrl)
            <img class="tht19-hero__image"
                 src="{{ $heroUrl }}"
                 data-position="{{ data_get($templateContent, 'hero_position') }}"
                 data-aos="zoom-out"
                 data-aos-duration="1800"
                 data-aos-easing="ease-out-cubic"
                 data-aos-offset="0"
                 data-aos-once="true"
                 alt="{{ $sideData->firstName }} và {{ $sideData->secondName }}"
                 fetchpriority="high" decoding="async">
        @endif
        <div class="tht19-hero__veil" aria-hidden="true"></div>
        <p class="tht19-hero__script"
           data-aos="fade-down"
           data-aos-duration="1450"
           data-aos-delay="200"
           data-aos-easing="ease-out-cubic"
           data-aos-once="true">We're getting married!</p>
        <div class="tht19-hero__caption"
             data-aos="fade-up"
             data-aos-duration="1650"
             data-aos-delay="400"
             data-aos-easing="ease-out-cubic"
             data-aos-once="true">
            <h1 id="tht19-couple-title">
                {{ $sideData->firstName }}
                &
                {{ $sideData->secondName }}
            </h1>
            @if($wedding->event_date)
                <time class="tht19-hero__date" datetime="{{ $wedding->event_date->toDateString() }}">{{ $wedding->event_date->format('d.m.Y') }}</time>
            @endif
        </div>
    </section>

    {{-- 02. Two portrait cards, with optional template-specific captions. --}}
    <section class="tht19-portraits" aria-labelledby="tht19-invitation-title">
        <header class="tht19-section-heading"
                data-aos="fade-up"
                data-aos-duration="1500"
                data-aos-easing="ease-out-cubic"
                data-aos-once="true">
            <h2 id="tht19-invitation-title">Wedding Invitation</h2>
        </header>
        <article @class(['tht19-portrait gold-bottom-overlay', 'tht19-portrait--text-only' => !$bridePhoto])
                 data-aos="fade-up"
                 data-aos-duration="1700"
                 data-aos-easing="ease-out-cubic"
                 data-aos-once="true">
            @if($bridePhoto)
                <img src="{{ $bridePhoto }}" data-position="{{ data_get($templateContent, 'bride_position') }}" alt="Cô dâu {{ $wedding->bride_name }}" loading="lazy" decoding="async">
            @endif
            <div class="tht19-portrait__caption">
                <p class="tht19-script">Cô dâu</p>
                <h3>{{ $wedding->bride_name }}</h3>
                @if(filled(data_get($templateContent, 'bride_portrait_note')))
                    <p class="tht19-portrait__note">{{ data_get($templateContent, 'bride_portrait_note') }}</p>
                @endif
            </div>
        </article>
        <div class="tht19-heart-divider" aria-hidden="true"><i class="fa-regular fa-heart"></i></div>
        <article @class(['tht19-portrait gold-bottom-overlay', 'tht19-portrait--text-only' => !$groomPhoto])
                 data-aos="fade-up"
                 data-aos-duration="1700"
                 data-aos-delay="150"
                 data-aos-easing="ease-out-cubic"
                 data-aos-once="true">
            @if($groomPhoto)
                <img src="{{ $groomPhoto }}" data-position="{{ data_get($templateContent, 'groom_position') }}" alt="Chú rể {{ $wedding->groom_name }}" loading="lazy" decoding="async">
            @endif
            <div class="tht19-portrait__caption">
                <p class="tht19-script">Chú rể</p>
                <h3>{{ $wedding->groom_name }}</h3>
                @if(filled(data_get($templateContent, 'groom_portrait_note')))
                    <p class="tht19-portrait__note">{{ data_get($templateContent, 'groom_portrait_note') }}</p>
                @endif
            </div>
        </article>
        <img class="tht19-rings"
             src="{{ asset('images/templates/tht-e-wedding-19/bo-cau.png') }}"
             alt=""
             aria-hidden="true"
             loading="lazy"
             decoding="async"
             data-aos="zoom-in"
             data-aos-duration="1500"
             data-aos-easing="ease-out-cubic"
             data-aos-once="true">
        <div class="tht19-invitation__copy"
             data-aos="fade-up"
             data-aos-duration="1700"
             data-aos-delay="100"
             data-aos-easing="ease-out-cubic"
             data-aos-once="true">
            <p class="tht19-invitation__intro">Thân mời tới dự lễ cưới thân mật<br>của chúng tôi</p>
            @if($guestName)
                <p class="tht19-invitation__guest">{{ $guestName }}</p>
            @endif
            <h2 class="tht19-invitation__names"><span>{{ $sideData->firstName }}</span><span class="tht19-invitation__connector">and</span><span>{{ $sideData->secondName }}</span></h2>
        </div>
        @if(!empty($templateSchemaMedia['save_the_date_image']))
            <figure class="tht19-save-date"
                    data-aos="zoom-in"
                    data-aos-duration="1800"
                    data-aos-easing="ease-out-cubic"
                    data-aos-once="true">
                <img src="{{ $templateSchemaMedia['save_the_date_image']->getUrl() }}" alt="Khoảnh khắc của {{ $sideData->firstName }} và {{ $sideData->secondName }}" loading="lazy" decoding="async">
                <figcaption><span>Save</span><span><i>the</i> Date</span></figcaption>
            </figure>
        @endif

    </section>

    {{-- 03. Invitation and the exact media slot declared by the schema. --}}


    {{-- 04. Ceremony details for both sides. --}}
    <section class="tht19-events" id="schedule" aria-label="Thời gian và địa điểm lễ cưới">
        <div class="tht19-families"
             data-aos="fade-up"
             data-aos-duration="1650"
             data-aos-easing="ease-out-cubic"
             data-aos-once="true">
            @foreach($sideData->families as $family)
                <article class="tht19-family">
                    <h3>{{ $family->label }}</h3>
                    @if($family->father)<p>Ông: {{ $family->father }}</p>@endif
                    @if($family->mother)<p>Bà: {{ $family->mother }}</p>@endif
                </article>
            @endforeach
        </div>
        <div class="">
            <img src="{{ asset("images/templates/tht-e-wedding-19/ring.png")}}"
                 class="inline-block mx-auto"
                 width="58"
                 height="58"
                 alt="Nhẫn của thtmedia-19"
                 data-aos="zoom-in"
                 data-aos-duration="1500"
                 data-aos-easing="ease-out-cubic"
                 data-aos-once="true">
        </div>
        @foreach($sideData->events as $event)
            <!-- Each side shows its ceremony only; reception rows stay out of this section. -->
            <article class="tht19-event"
                     data-aos="fade-up"
                     data-aos-duration="1750"
                     data-aos-easing="ease-out-cubic"
                     data-aos-once="true">
                <h2>{{ $event->ceremonyTitle }} được tổ chức</h2>
                @if($event->ceremonyTime)
                    <p class="tht19-event__time"><strong>vào lúc {{ $event->ceremonyTimeLongLabel() }}</strong></p>
                @endif
                <p class="tht19-event__weekday">{{ $event->ceremonyDayLabel() }}</p>
                <time class="tht19-date" datetime="{{ $event->ceremonyDate->toDateString() }}">
                    <span class="tht19-date__side">THÁNG {{ $event->ceremonyDate->format('m') }}</span>
                    <strong>{{ $event->ceremonyDate->format('d') }}</strong>
                    <span class="tht19-date__side">{{ $event->ceremonyDate->format('Y') }}</span>
                </time>
                @if($event->ceremonyLunarFullLabel())
                    <p class="tht19-event__lunar"><strong>({{ $event->ceremonyLunarFullLabel() }})</strong></p>
                @endif
                <img class="tht19-event__doves"
                     src="{{ asset('images/templates/tht-e-wedding-19/double-bo-cau.png') }}"
                     alt=""
                     aria-hidden="true"
                     loading="lazy"
                     decoding="async"
                     width="96"
                     height="96">
                <div class="tht19-event__venue">
                    <h3><strong>Tại {{ $event->ceremonyVenue }}</strong></h3>
                    @if($event->ceremonyAddress)
                    <address>Địa chỉ: {{ $event->ceremonyAddress }}</address>@endif
                    @if(filled($event->ceremonyMapUrl))
                        <a class="tht19-map-link" href="{{ $event->ceremonyMapUrl }}" target="_blank" rel="noopener noreferrer"><i class="fa-solid fa-route" aria-hidden="true"></i> Chỉ đường tới lễ</a>
                    @endif
                </div>
            </article>
        @endforeach
    </section>

    {{-- 05. Timeline --}}
<section class="tht19-timeline" aria-labelledby="tht19-timeline-title">
    <header
        @class([
            'tht19-timeline__heading',
            'tht19-timeline__heading--photo' => !empty($templateSchemaMedia['timeline_image'])
        ])
        data-aos="fade-up"
        data-aos-duration="1700"
        data-aos-easing="ease-out-cubic"
        data-aos-once="true"
    >
        @if(!empty($templateSchemaMedia['timeline_image']))
            <img
                src="{{ $templateSchemaMedia['timeline_image']->getUrl() }}"
                alt="Ngày vui của {{ $sideData->firstName }} và {{ $sideData->secondName }}"
                loading="lazy"
                decoding="async"
            >
        @endif

        <h2 class="tht19-script" id="tht19-timeline-title">
            Timeline
        </h2>
    </header>

    @foreach($sideData->events as $event)
        <article class="tht19-timeline__group"
                 data-aos="fade-up"
                 data-aos-duration="1750"
                 data-aos-easing="ease-out-cubic"
                 data-aos-once="true">

            <h3>
                Chương trình nhà {{ $event->side === 'bride' ? 'gái' : 'trai' }}
            </h3>

            <ol class="tht19-timeline__list">

                {{-- ĐÓN KHÁCH --}}
                @if(filled(data_get($templateContent, $event->side . '_welcome_time')))
                    <li>
                        <div>
                            <img src="{{asset("images/templates/tht-e-wedding-19/gate.webp")}}" alt="Hân hạnh đón tiếp">
                        </div>

                        <div class="tht19-timeline__when">
                            <strong>
                                {{ data_get($templateContent, $event->side . '_welcome_time') }}
                            </strong>

                            <time datetime="{{ $event->receptionDate->toDateString() }}">
                                {{ $event->receptionDate->format('d.m.Y') }}
                            </time>
                        </div>

                        <div class="tht19-timeline__what">
                            <h4>Đón khách</h4>

                            <p>
                                {{ $event->receptionVenue }}
                            </p>
                        </div>
                    </li>
                @endif
                {{-- KHAI TIỆC --}}
                @if($event->receptionTime)
                    <li>
                        <div>
                            <img src="{{asset("images/templates/tht-e-wedding-19/dinner.png")}}" alt="Hân hạnh đón tiếp">
                        </div>

                        <div class="tht19-timeline__when">
                            <strong>
                                {{ $event->receptionTimeLabel() }}
                            </strong>

                            <time datetime="{{ $event->receptionDate->toDateString() }}">
                                {{ $event->receptionDate->format('d.m.Y') }}
                            </time>
                        </div>

                        <div class="tht19-timeline__what">
                            <h4>Khai tiệc</h4>

                            <p>
                                {{ $event->receptionVenue }}
                            </p>
                        </div>
                    </li>

                {{-- LỄ THÀNH HÔN / VU QUY --}}
                @if($event->ceremonyTime)
                    <li>
                        <div>
                            <img src="{{asset("images/templates/tht-e-wedding-19/ring2.png")}}" alt="Hân hạnh đón tiếp">
                        </div>

                        <div class="tht19-timeline__when">
                            <strong>
                                {{ $event->ceremonyTimeLabel() }}
                            </strong>

                            <time datetime="{{ $event->ceremonyDate->toDateString() }}">
                                {{ $event->ceremonyDate->format('d.m.Y') }}
                            </time>
                        </div>

                        <div class="tht19-timeline__what">
                            <h4>
                                {{ $event->ceremonyTitle }}
                            </h4>

                            <p>
                                {{ $event->ceremonyVenue }}
                            </p>
                        </div>
                    </li>
                @endif



                @endif

            </ol>

        </article>
    @endforeach
</section>

    {{-- 06. Real gallery only; CSS masonry handles any number of images. --}}
    @if($galleryImages->isNotEmpty())
        <section class="tht19-album" id="album" aria-labelledby="tht19-album-title">
            <header class="tht19-album__heading"
                    data-aos="fade-right"
                    data-aos-duration="1500"
                    data-aos-easing="ease-out-cubic"
                    data-aos-once="true">
                <h2 id="tht19-album-title">Our memories</h2>
                <span aria-hidden="true"></span>
            </header>
            @if(filled(data_get($templateContent, 'album_note')))
                <p class="tht19-album__note"
                   data-aos="fade-up"
                   data-aos-duration="1450"
                   data-aos-delay="100"
                   data-aos-easing="ease-out-cubic"
                   data-aos-once="true">{{ data_get($templateContent, 'album_note') }}</p>
            @endif
            @php
    $albumImages = $galleryImages->values();

    $coverImage = $albumImages->first();
    $restImages = $albumImages->slice(1)->values();

    $leftImages = $restImages->filter(
        fn ($image, $index) => $index % 2 === 0
    );

    $rightImages = $restImages->filter(
        fn ($image, $index) => $index % 2 === 1
    );
@endphp

<div class="tht19-album__grid">

    {{-- Ảnh cover full width --}}
    @if($coverImage)
        <a
            class="tht19-album__photo tht19-album__photo--cover glightbox"
            href="{{ $coverImage->getUrl() }}"
            data-gallery="tht19-memories"
            data-aos="zoom-in"
            data-aos-duration="1600"
            aria-label="Xem ảnh cưới của {{ $sideData->firstName }} và {{ $sideData->secondName }}"
        >
            <img
                src="{{ $coverImage->getUrl('gallery_web') ?: $coverImage->getUrl() }}"
                alt="Ảnh cưới {{ $sideData->firstName }} và {{ $sideData->secondName }}"
                loading="lazy"
                decoding="async"
            >
        </a>
    @endif

    <div class="tht19-album__columns">

        {{-- CỘT TRÁI --}}
        <div class="tht19-album__column">
            @foreach($leftImages as $image)
                <a
                    class="tht19-album__photo glightbox"
                    href="{{ $image->getUrl() }}"
                    data-gallery="tht19-memories"
                    data-aos="fade-up"
                    data-aos-duration="1500"
                    data-aos-delay="{{ ($loop->index % 3) * 100 }}"
                >
                    <img
                        src="{{ $image->getUrl('gallery_web') ?: $image->getUrl() }}"
                        alt="Ảnh cưới {{ $sideData->firstName }} và {{ $sideData->secondName }}"
                        loading="lazy"
                        decoding="async"
                    >
                </a>
            @endforeach
        </div>

        {{-- CỘT PHẢI --}}
        <div class="tht19-album__column">
            @foreach($rightImages as $image)
                <a
                    class="tht19-album__photo glightbox"
                    href="{{ $image->getUrl() }}"
                    data-gallery="tht19-memories"
                    data-aos="fade-up"
                    data-aos-duration="1500"
                    data-aos-delay="{{ ($loop->index % 3) * 100 }}"
                >
                    <img
                        src="{{ $image->getUrl('gallery_web') ?: $image->getUrl() }}"
                        alt="Ảnh cưới {{ $sideData->firstName }} và {{ $sideData->secondName }}"
                        loading="lazy"
                        decoding="async"
                    >
                </a>
            @endforeach
        </div>

    </div>
</div>
            <p class="tht19-album__signature"
               data-aos="fade-left"
               data-aos-duration="1500"
               data-aos-easing="ease-out-cubic"
               data-aos-once="true">Every moment, forever.</p>
        </section>
    @endif

    {{-- 07. One transactional request: RSVP + optional wish, as supported by RsvpController. --}}
    <section class="tht19-response" id="rsvp" aria-labelledby="tht19-rsvp-title">
        <div class="tht19-response__inner"
             x-data="{
                 submitting: false,
                 success: false,
                 successMessage: '',
                 error: '',
                 formData: {
                     name: @js(old('name', $guestName)),
                     phone: @js(old('phone', '')),
                     attendance: @js(old('attendance', '')),
                     guests: @js(old('guests', 1)),
                     side: @js(old('side', $side)),
                     note: @js(old('note', '')),
                     wish: @js(old('wish', ''))
                 },
                 async submitRsvp() {
                     if (this.submitting) return;
                     this.error = '';
                     const csrf = document.querySelector('meta[name=csrf-token]')?.content;
                     if (!csrf) { this.error = 'Phiên gửi biểu mẫu không hợp lệ. Vui lòng tải lại trang.'; return; }
                     this.submitting = true;
                     const controller = new AbortController();
                     const timeout = setTimeout(() => controller.abort(), 20000);
                     try {
                         const response = await fetch(@js(route('wedding.rsvp.store', $wedding->slug)), {
                             method: 'POST', credentials: 'same-origin', redirect: 'error',
                             signal: controller.signal,
                             headers: {'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': csrf},
                             body: JSON.stringify(this.formData)
                         });
                         const data = await response.json().catch(() => null);
                         if (response.status === 419) { this.error = 'Phiên làm việc đã hết hạn. Vui lòng tải lại trang trước khi gửi.'; return; }
                         if (!response.ok) {
                             this.error = data?.errors ? Object.values(data.errors).flat().join(' ') : (data?.message || 'Chưa gửi được phản hồi. Vui lòng thử lại.');
                             return;
                         }
                         if (!data || typeof data.message !== 'string') { this.error = 'Máy chủ chưa trả về xác nhận hợp lệ. Vui lòng kiểm tra trước khi gửi lại.'; return; }
                         this.successMessage = data.message;
                         this.success = true;
                         this.$nextTick(() => this.$refs.success.focus());
                     } catch (error) {
                         this.error = error.name === 'AbortError'
                             ? 'Chưa nhận được xác nhận từ máy chủ. Vui lòng kiểm tra kết nối và tránh gửi lặp ngay.'
                             : 'Không thể kết nối tới máy chủ. Vui lòng thử lại khi có kết nối.';
                     } finally { clearTimeout(timeout); this.submitting = false; }
                 }
             }">
            <header
                data-aos="fade-up"
                data-aos-duration="1500"
                data-aos-easing="ease-out-cubic"
                data-aos-once="true">
                <p class="tht19-response__intro">{{ $wedding->getContentValue('rsvp_desc', 'Hãy xác nhận sự có mặt của bạn để chúng mình chuẩn bị đón tiếp một cách chu đáo nhất. Trân trọng!') }}</p>
            </header>
            @if(session('success'))<p class="tht19-notice tht19-notice--success" role="status">{{ session('success') }}</p>@endif
            @if(session('error'))<p class="tht19-notice tht19-notice--error" role="alert">{{ session('error') }}</p>@endif
            @if($errors->any())<div class="tht19-notice tht19-notice--error" role="alert">@foreach($errors->all() as $error)<p>{{ $error }}</p>@endforeach</div>@endif
            <form class="tht19-form"
                  action="{{ route('wedding.rsvp.store', $wedding->slug) }}"
                  method="POST"
                  @submit.prevent="submitRsvp"
                  x-show="!success"
                  :aria-busy="submitting"
                  data-aos="fade-up"
                  data-aos-duration="1650"
                  data-aos-delay="150"
                  data-aos-easing="ease-out-cubic"
                  data-aos-once="true">
                @csrf
                <p class="tht19-notice tht19-notice--error" x-cloak x-show="error" x-text="error" role="alert"></p>
                <div class="tht19-field">
                    <input id="tht19-name" name="name" type="text" autocomplete="name" maxlength="255" value="{{ old('name', $guestName) }}" x-model="formData.name" placeholder="Tên của bạn là gì?" required>
                </div>
                
                <div class="tht19-field">
                    <select id="tht19-attendance" name="attendance" x-model="formData.attendance" required>
                        <option value="" disabled @selected(!old('attendance'))>Bạn sẽ tham dự chứ?</option>
                        <option value="yes" @selected(old('attendance') === 'yes')>Có, chắc chắn mình sẽ đến</option>
                        <option value="maybe" @selected(old('attendance') === 'maybe')>Mình sẽ xác nhận lại sau</option>
                        <option value="no" @selected(old('attendance') === 'no')>Rất tiếc, mình không thể tham dự</option>
                    </select>
                </div>
                    <div class="tht19-field">
                        <select id="tht19-side" name="side" x-model="formData.side">
                            <option value="bride" @selected(old('side', $side) === 'bride')>Nhà gái</option>
                            <option value="groom" @selected(old('side', $side) === 'groom')>Nhà trai</option>
                            <option value="both" @selected(old('side', $side) === 'both')>Cả hai gia đình</option>
                        </select>
                    </div>
                <div class="tht19-field">
                    <textarea id="tht19-wish" name="wish" rows="4" maxlength="1000" x-model="formData.wish" placeholder="Gửi một lời chúc thật dễ thương…">{{ old('wish') }}</textarea>
                    <small>Lời chúc có thể được hiển thị trong sổ lưu bút sau khi được duyệt.</small>
                </div>
                <details class="tht19-form__details">
                    <summary>Ghi chú riêng cho cô dâu, chú rể</summary>
                    <div class="tht19-field">
                        <label for="tht19-note" class="tht19-sr-only">Ghi chú riêng</label>
                        <textarea id="tht19-note" name="note" rows="2" maxlength="500" x-model="formData.note" placeholder="Ví dụ: cần hỗ trợ chỗ ngồi…">{{ old('note') }}</textarea>
                    </div>
                </details>
                <button class="tht19-button tht19-button--outline" type="submit" :disabled="submitting">
                    <span x-show="!submitting">Gửi lời chúc &amp; xác nhận</span>
                    <span x-cloak x-show="submitting">Đang gửi…</span>
                    <i class="fa-regular fa-paper-plane" aria-hidden="true" x-show="!submitting"></i>
                </button>
            </form>
            <div class="tht19-confirmation" x-cloak x-show="success" role="status" tabindex="-1" x-ref="success">
                <i class="fa-regular fa-circle-check" aria-hidden="true"></i>
                <h3>Thank you!</h3>
                <p x-text="successMessage"></p>
                <p> Cảm ơn tình cảm của bạn dành cho chúng mình.</p>
            </div>
        </div>

        {{-- Never add AOS/transform to an ancestor of the shared fixed QR modal. --}}
        @if($wedding->getBrideQrUrl() || $wedding->getGroomQrUrl())
            <x-wedding.gift-box :wedding="$wedding" class="tht19-gift">
                <div class="tht19-gift__body" @keydown.escape.window="showQr = null" x-effect="document.documentElement.classList.toggle('tht19-gift-open', !!showQr)">
                    <h2>Hộp mừng cưới</h2>
                    <p>{{ $wedding->getContentValue('blessing_desc', 'Sự hiện diện của bạn là món quà ý nghĩa nhất. Cảm ơn bạn đã dành tình cảm cho chúng mình.') }}</p>
                    <div class="tht19-gift__actions">
                        @if($wedding->getBrideQrUrl())<button class="tht19-button" type="button" @click="showQr = 'bride'" aria-haspopup="dialog"><i class="fa-solid fa-gift" aria-hidden="true"></i> Mừng cưới nhà gái</button>@endif
                        @if($wedding->getGroomQrUrl())<button class="tht19-button" type="button" @click="showQr = 'groom'" aria-haspopup="dialog"><i class="fa-solid fa-gift" aria-hidden="true"></i> Mừng cưới nhà trai</button>@endif
                    </div>
                    <noscript><p>Vui lòng bật JavaScript để mở mã QR mừng cưới.</p></noscript>
                </div>
            </x-wedding.gift-box>
        @endif
    </section>

    {{-- 08. Reuse the shared countdown; ISO timestamp keeps its server timezone. --}}
    @if($wedding->event_date)
        <section class="tht19-countdown"
                 aria-labelledby="tht19-countdown-title"
                 data-aos="fade-up"
                 data-aos-duration="1750"
                 data-aos-easing="ease-out-cubic"
                 data-aos-once="true">
            <h2 class="tht19-script" id="tht19-countdown-title">Countdown</h2>
            <p class="tht19-countdown__caption">Cùng đếm ngược tới ngày cưới</p>
            <div class="tht19-countdown__grid" x-data="countdown(@js($wedding->event_date->toIso8601String()))">
                @foreach([['days', 'Ngày'], ['hours', 'Giờ'], ['minutes', 'Phút'], ['seconds', 'Giây']] as [$unit, $label])
                    <div><strong x-text="{{ $unit }}">00</strong><span>{{ $label }}</span></div>
                @endforeach
            </div>
        </section>
    @endif

    {{-- 10. The existing thank-you media is not replaced by another collection. --}}
    <footer class="tht19-thank-you">
        @if($thankYouImage)
            <figure
                data-aos="zoom-in"
                data-aos-duration="1800"
                data-aos-easing="ease-out-cubic"
                data-aos-once="true">
                <img src="{{ $thankYouImage }}" alt="{{ $sideData->firstName }} và {{ $sideData->secondName }}" loading="lazy" decoding="async">
            </figure>
        @endif
        <div class="tht19-thank-you__copy"
             data-aos="fade-up"
             data-aos-duration="1700"
             data-aos-delay="150"
             data-aos-easing="ease-out-cubic"
             data-aos-once="true">
            <p>Cảm ơn bạn đã dành tình cảm cho chúng mình! Sự hiện diện của bạn chính là món quà ý nghĩa nhất. Chúng mình vô cùng trân quý khi được cùng bạn chia sẻ niềm hạnh phúc trong ngày trọng đại này.</p>
            <h2 class="tht19-script">Thank you!</h2>
            <p class="tht19-thank-you__signature">{{ $sideData->firstName }} &amp; {{ $sideData->secondName }}</p>
            @if($wedding->event_date)<time datetime="{{ $wedding->event_date->toDateString() }}">{{ $wedding->event_date->format('d.m.Y') }}</time>@endif
        </div>
    </footer>
</main>
@endsection

@push('scripts')
    <x-wedding.countdown-script />

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const balanceAlbum = () => {
                const grid = document.querySelector('.tht19-album__grid');

                if (!grid) return;

                const photos = [...grid.querySelectorAll('.tht19-album__photo')];

                if (photos.length < 2) return;

                // Reset trước khi tính lại
                photos.forEach(photo => {
                    const img = photo.querySelector('img');

                    if (img) {
                        img.style.height = '';
                        img.style.aspectRatio = '';
                    }
                });

                requestAnimationFrame(() => {
                    /*
                     * Tìm ảnh cuối cùng ở từng cột dựa theo vị trí left.
                     */
                    const columns = {};

                    photos.forEach(photo => {
                        const rect = photo.getBoundingClientRect();
                        const key = Math.round(rect.left);

                        if (!columns[key]) {
                            columns[key] = [];
                        }

                        columns[key].push(photo);
                    });

                    const columnList = Object.values(columns);

                    if (columnList.length !== 2) return;

                    const leftLast = columnList[0].at(-1);
                    const rightLast = columnList[1].at(-1);

                    const leftBottom = leftLast.getBoundingClientRect().bottom;
                    const rightBottom = rightLast.getBoundingClientRect().bottom;

                    const diff = Math.abs(leftBottom - rightBottom);

                    if (diff < 2) return;

                    const shorter =
                        leftBottom < rightBottom
                            ? leftLast
                            : rightLast;

                    const img = shorter.querySelector('img');

                    if (!img) return;

                    const currentHeight = img.getBoundingClientRect().height;

                    img.style.aspectRatio = 'auto';
                    img.style.height = `${currentHeight + diff}px`;
                    img.style.objectFit = 'cover';
                });
            };

            const images = document.querySelectorAll(
                '.tht19-album__grid img'
            );

            let loaded = 0;

            const ready = () => {
                loaded++;

                if (loaded >= images.length) {
                    balanceAlbum();
                }
            };

            images.forEach(img => {
                if (img.complete) {
                    ready();
                } else {
                    img.addEventListener('load', ready, { once: true });
                    img.addEventListener('error', ready, { once: true });
                }
            });

            window.addEventListener('resize', () => {
                clearTimeout(window.__tht19AlbumResize);

                window.__tht19AlbumResize = setTimeout(
                    balanceAlbum,
                    150
                );
            });
        });
    </script>
@endpush