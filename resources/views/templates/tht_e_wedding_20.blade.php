@extends('layouts.wedding')
{{-- Template Name: THT E-Wedding 20 (Emerald Envelope) --}}
{{-- Type: wedding --}}
{{-- Contract: v17 --}}
{{-- THT20: presentation only. The controller owns wedding/side/content/media resolution. --}}

@section('title', e($sideData->firstName . ' và ' . $sideData->secondName . ' | Wedding Invitation'))
@section('description', e('Trân trọng kính mời ' . $guestName . ' đến chung vui cùng đám cưới của ' . $sideData->firstName . ' và ' . $sideData->secondName))
@section('og_image', e($shareUrl))

@push('styles')
    @vite(['resources/css/templates/tht-e-wedding-20.css'])
    <style>
        @font-face { font-family: 'THT20 Chuva'; src: url('{{ asset('fonts/chuvafont.otf') }}') format('opentype'); font-display: swap; }
        @font-face { font-family: 'THT20 Tieude'; src: url('{{ asset('fonts/tieude.otf') }}') format('opentype'); font-display: swap; }
        .tht20 { --tht20-heart: url('{{ asset('images/templates/tht-e-wedding-20/heart.svg') }}'); --tht20-paper-photo: url('{{ asset('images/background-3.jpg') }}'); }
    </style>
@endpush

@section('content')
<main class="tht20 wedding-container" id="tht20-top">
    {{-- Shared opening screen, envelope wrapper, effects and music stay available. --}}
    {{-- Opening screen: the green envelope lives in the shared preload (variant emerald_envelope). --}}
    @include('components.wedding.preload', ['wedding' => $wedding, 'variant' => 'emerald_envelope', 'lockVariant' => true, 'envelopeMedia' => $templateSchemaMedia['envelope_image'] ?? null])
    @if($wedding->show_invitation_wrapper)
        <x-wedding.invitation-wrapper :wedding="$wedding" />
    @endif
    @include('components.wedding.falling-effects', ['wedding' => $wedding])
    <x-wedding.music-player :wedding="$wedding" />

    {{-- 01. Full-bleed hero with large serif names. --}}
    <section class="tht20-hero" id="tht20-hero" aria-label="{{ $sideData->firstName }} và {{ $sideData->secondName }}">
        @if($heroUrl)
            <img class="tht20-hero__image"
                 src="{{ $heroUrl }}"
                 data-position="{{ data_get($templateContent, 'hero_position') }}"
                 alt="{{ $sideData->firstName }} và {{ $sideData->secondName }}"
                 data-aos="zoom-out" data-aos-duration="1800" data-aos-offset="0" data-aos-once="true"
                 decoding="async">
        @endif
        <p class="tht20-hero__names" data-aos="fade-up" data-aos-duration="1600" data-aos-delay="250" data-aos-once="true">
            <span>{{ $sideData->firstGivenName() }}</span>
            <span class="tht20-hero__second">
                <span class="tht20-hero__amp" aria-hidden="true">&amp;</span>
                <span>{{ $sideData->secondGivenName() }}</span>
            </span>
        </p>
    </section>

    {{-- 03. Promise line, primary date and the optional save-the-date photo. --}}
    <section class="tht20-promise tht20-paper" aria-labelledby="tht20-promise-title">
        <img class="tht20-floral tht20-floral--left" src="{{ asset('images/templates/tht-e-wedding-20/top-left.png') }}" alt="" aria-hidden="true" loading="lazy">
        <h2 id="tht20-promise-title" data-aos="fade-up" data-aos-duration="1500" data-aos-once="true">Quyết định bên nhau<br>trọn đời.</h2>
        <p class="tht20-script" data-aos="fade-up" data-aos-duration="1500" data-aos-delay="100" data-aos-once="true">Save the date</p>
        @if($wedding->event_date)
            <time class="tht20-promise__date" datetime="{{ $wedding->event_date->toDateString() }}" data-aos="fade-up" data-aos-duration="1500" data-aos-delay="200" data-aos-once="true">{{ $wedding->event_date->format('d.m.Y') }}</time>
        @endif
        @if(!empty($templateSchemaMedia['save_date_image']))
            <figure class="tht20-promise__photo" data-aos="fade-up" data-aos-duration="1700" data-aos-delay="150" data-aos-once="true">
                <img src="{{ $templateSchemaMedia['save_date_image']->getUrl() }}" alt="Khoảnh khắc của {{ $sideData->firstName }} và {{ $sideData->secondName }}" loading="lazy" decoding="async">
            </figure>
        @endif
    </section>

    {{-- 04. Month calendar of the primary date; grid and highlighted days come from WeddingDataService. --}}
    @if($wedding->event_date)
        <section class="tht20-calendar" aria-labelledby="tht20-calendar-title" data-aos="fade-up" data-aos-duration="1600" data-aos-once="true">
            <h2 class="tht20-script" id="tht20-calendar-title">Tháng {{ $wedding->event_date->format('n') }}</h2>
            <div class="tht20-calendar__grid">
                @foreach(['MON', 'TUE', 'WED', 'THUR', 'FRI', 'SAT', 'SUN'] as $weekday)
                    <span class="tht20-calendar__weekday" aria-hidden="true">{{ $weekday }}</span>
                @endforeach
                @foreach($calendarWeeks as $week)
                    @foreach($week as $cell)
                        @if($cell)
                            <time datetime="{{ $cell['date'] }}" @class(['is-heart' => in_array($cell['date'], $calendarHighlightedDates, true)])>{{ $cell['day'] }}</time>
                        @else
                            <span aria-hidden="true"></span>
                        @endif
                    @endforeach
                @endforeach
            </div>
        </section>
    @endif

    {{-- 05. Invitation, guest name, polaroid portraits and both families. --}}
    <section class="tht20-invitation tht20-paper" aria-labelledby="tht20-invitation-title">
        <p class="tht20-invitation__intro" data-aos="fade-up" data-aos-duration="1500" data-aos-once="true">Thân mời tới dự lễ cưới thân mật<br>của chúng tôi</p>
        @if($guestName)
            <p class="tht20-invitation__guest" data-aos="fade-up" data-aos-duration="1500" data-aos-delay="100" data-aos-once="true">{{ $guestName }}</p>
        @endif
        <h2 class="tht20-invitation__names" id="tht20-invitation-title" data-aos="fade-up" data-aos-duration="1600" data-aos-delay="150" data-aos-once="true">
            <span>{{ $sideData->firstName }}</span>
            <span class="tht20-invitation__amp" aria-hidden="true">&amp;</span>
            <span>{{ $sideData->secondName }}</span>
        </h2>

        <div class="tht20-polaroids">
            <figure class="tht20-polaroid tht20-polaroid--first" data-aos="fade-right" data-aos-duration="1600" data-aos-once="true">
                <img src="{{ $sideData->firstPhoto }}" data-position="{{ data_get($templateContent, 'portrait_position') }}" alt="{{ $sideData->firstName }}" loading="lazy" decoding="async">
            </figure>
            <figure class="tht20-polaroid tht20-polaroid--second" data-aos="fade-left" data-aos-duration="1600" data-aos-delay="150" data-aos-once="true">
                <img src="{{ $sideData->secondPhoto }}" data-position="{{ data_get($templateContent, 'portrait_position') }}" alt="{{ $sideData->secondName }}" loading="lazy" decoding="async">
            </figure>
        </div>

        <div class="tht20-families" data-aos="fade-up" data-aos-duration="1600" data-aos-once="true">
            @foreach($sideData->families as $family)
                <article class="tht20-family">
                    <h3>{{ $family->label }}</h3>
                    @if($family->father)<p>Ông. {{ $family->father }}</p>@endif
                    @if($family->mother)<p>Bà. {{ $family->mother }}</p>@endif
                </article>
            @endforeach
        </div>
    </section>

    {{-- 06. Reception + ceremony per side, all from $sideData->events. --}}
    <section class="tht20-events tht20-paper" id="schedule" aria-label="Thời gian và địa điểm">
        @foreach($sideData->events as $event)
            <article class="tht20-event" data-aos="fade-up" data-aos-duration="1600" data-aos-once="true">
                @if($event->receptionTime)
                    <div class="tht20-event__block">
                        <h2>{{ $event->receptionTitle }} được tổ chức<br>vào lúc {{ $event->receptionTimeLongLabel() }}</h2>
                        <p class="tht20-event__weekday">{{ $event->receptionDayLabel() }}</p>
                        <time class="tht20-date" datetime="{{ $event->receptionDate->toDateString() }}">
                            <span>Tháng {{ $event->receptionDate->format('n') }}</span>
                            <strong>{{ $event->receptionDate->format('d') }}</strong>
                            <span>Năm {{ $event->receptionDate->format('Y') }}</span>
                        </time>
                        @if($event->receptionLunarFullLabel())
                            <p class="tht20-event__lunar">({{ $event->receptionLunarFullLabel() }})</p>
                        @endif
                        @unless($event->sharesVenue())
                            <div class="tht20-event__venue">
                                <h3>Tại {{ $event->receptionVenue }}</h3>
                                @if($event->receptionAddress)<address>Địa chỉ: {{ $event->receptionAddress }}</address>@endif
                                @if(filled($event->receptionMapUrl))
                                    <a class="tht20-map-link" href="{{ $event->receptionMapUrl }}" target="_blank" rel="noopener noreferrer"><i class="fa-solid fa-location-dot" aria-hidden="true"></i> Chỉ đường</a>
                                @endif
                            </div>
                        @endunless
                    </div>
                @endif

                <div class="tht20-event__block">
                    <h2>{{ $event->ceremonyTitle }} được tổ chức @if($event->ceremonyTime)<br>vào lúc {{ $event->ceremonyTimeLongLabel() }}@endif</h2>
                    <p class="tht20-event__weekday">{{ $event->ceremonyDayLabel() }}</p>
                    <time class="tht20-date" datetime="{{ $event->ceremonyDate->toDateString() }}">
                        <span>Tháng {{ $event->ceremonyDate->format('n') }}</span>
                        <strong>{{ $event->ceremonyDate->format('d') }}</strong>
                        <span>Năm {{ $event->ceremonyDate->format('Y') }}</span>
                    </time>
                    @if($event->ceremonyLunarFullLabel())
                        <p class="tht20-event__lunar">({{ $event->ceremonyLunarFullLabel() }})</p>
                    @endif
                    <div class="tht20-event__venue">
                        <h3>Tại {{ $event->ceremonyVenue }}</h3>
                        @if($event->ceremonyAddress)<address>Địa chỉ: {{ $event->ceremonyAddress }}</address>@endif
                        @if(filled($event->ceremonyMapUrl))
                            <a class="tht20-map-link" href="{{ $event->ceremonyMapUrl }}" target="_blank" rel="noopener noreferrer"><i class="fa-solid fa-location-dot" aria-hidden="true"></i> Chỉ đường</a>
                        @endif
                    </div>
                </div>
            </article>
        @endforeach
    </section>

    {{-- 07. Timeline with optional photo header, then the dress code palette. --}}
    <section class="tht20-timeline tht20-paper" aria-labelledby="tht20-timeline-title">
        <header @class(['tht20-timeline__heading', 'tht20-timeline__heading--photo' => !empty($templateSchemaMedia['timeline_image'])])
                data-aos="fade-up" data-aos-duration="1600" data-aos-once="true">
            @if(!empty($templateSchemaMedia['timeline_image']))
                <img src="{{ $templateSchemaMedia['timeline_image']->getUrl() }}" alt="Ngày vui của {{ $sideData->firstName }} và {{ $sideData->secondName }}" loading="lazy" decoding="async">
            @endif
            <h2 class="tht20-script" id="tht20-timeline-title">Timeline</h2>
        </header>

        @foreach($sideData->events as $event)
            @continue(blank(data_get($templateContent, $event->side . '_welcome_time')) && !$event->receptionTime)
            <article class="tht20-timeline__group" data-aos="fade-up" data-aos-duration="1600" data-aos-once="true">
                @if($sideData->isBoth())
                    <h3>Chương trình {{ $event->side === 'bride' ? 'nhà gái' : 'nhà trai' }}</h3>
                @endif
                <ol class="tht20-timeline__list">
                    @if(filled(data_get($templateContent, $event->side . '_welcome_time')))
                        <li>
                            <i class="fa-solid fa-camera-retro" aria-hidden="true"></i>
                            <strong>{{ data_get($templateContent, $event->side . '_welcome_time') }}</strong>
                            <div>
                                <h4>Đón khách</h4>
                                <p>Checkin và gửi lời chúc phúc đến cô dâu chú rể</p>
                            </div>
                        </li>
                    @endif
                    @if($event->receptionTime)
                        <li>
                            <i class="fa-solid fa-champagne-glasses" aria-hidden="true"></i>
                            <strong>{{ $event->receptionTimeLabel() }}</strong>
                            <div>
                                <h4>Khai tiệc</h4>
                                <p>Cùng nhau ăn tiệc, nâng ly và chúc mừng đám cưới</p>
                            </div>
                        </li>
                    @endif
                </ol>
            </article>
        @endforeach

        @if(data_get($templateContent, 'dresscode') !== 'hide')
            <div class="tht20-dresscode" data-aos="fade-up" data-aos-duration="1600" data-aos-once="true">
                <h2 class="tht20-script">Dresscode</h2>
                <ul class="tht20-dresscode__swatches" aria-label="Bảng màu trang phục gợi ý">
                    <li style="--swatch: #2c3524" title="Xanh rêu đậm"></li>
                    <li style="--swatch: #ffffff" title="Trắng"></li>
                    <li style="--swatch: #f7f2df" title="Kem"></li>
                    <li style="--swatch: #e4dccb" title="Be"></li>
                    <li style="--swatch: #e9ebee" title="Xám nhạt"></li>
                </ul>
                @if(filled(data_get($templateContent, 'dresscode_note')))
                    <p class="tht20-dresscode__note">{{ data_get($templateContent, 'dresscode_note') }}</p>
                @endif
            </div>
        @endif
    </section>

    {{-- 08. Real gallery only: first photo full width, the rest as a 2-column masonry at natural aspect ratios. --}}
    @if($galleryImages->isNotEmpty())
        <section class="tht20-album" id="album" aria-labelledby="tht20-album-title">
            <h2 class="tht20-script" id="tht20-album-title" data-aos="fade-right" data-aos-duration="1500" data-aos-once="true">Our memories</h2>
            @if(filled(data_get($templateContent, 'album_note')))
                <p class="tht20-album__note" data-aos="fade-up" data-aos-duration="1500" data-aos-once="true">{{ data_get($templateContent, 'album_note') }}</p>
            @endif
            <div class="tht20-album__grid">
                @foreach($galleryImages as $image)
                    <a class="tht20-album__photo glightbox"
                       href="{{ $image->getUrl() }}"
                       data-gallery="tht20-memories"
                       data-aos="fade-up" data-aos-duration="1400" data-aos-delay="{{ ($loop->index % 3) * 100 }}" data-aos-once="true"
                       aria-label="Xem ảnh cưới {{ $loop->iteration }}">
                        <img src="{{ $image->getUrl('gallery_web') ?: $image->getUrl() }}" alt="Ảnh cưới {{ $sideData->firstName }} và {{ $sideData->secondName }}" loading="lazy" decoding="async">
                    </a>
                @endforeach
            </div>
        </section>
    @endif

    {{-- 09. RSVP + wish in one request, gift QR, countdown. --}}
    <section class="tht20-response tht20-paper" id="rsvp" aria-labelledby="tht20-rsvp-title">
        <img class="tht20-floral tht20-floral--right" src="{{ asset('images/templates/tht-e-wedding-20/bot-right.png') }}" alt="" aria-hidden="true" loading="lazy">
        <div class="tht20-response__inner"
             x-data="{
                 submitting: false,
                 success: false,
                 successMessage: '',
                 error: '',
                 formData: {
                     name: @js(old('name', $guestName)),
                     attendance: @js(old('attendance', '')),
                     guests: @js(old('guests')),
                     side: @js(old('side', $side === 'both' ? '' : $side)),
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
                             body: JSON.stringify({ ...this.formData, guests: this.formData.guests || null, side: this.formData.side || null })
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
            <h2 class="tht20-sr-only" id="tht20-rsvp-title">Xác nhận tham dự</h2>
            <p class="tht20-response__intro" data-aos="fade-up" data-aos-duration="1500" data-aos-once="true">{{ $wedding->getContentValue('rsvp_desc', 'Hãy xác nhận sự có mặt của bạn để chúng mình chuẩn bị đón tiếp một cách chu đáo nhất. Trân trọng!') }}</p>
            @if($errors->any())<div class="tht20-notice" role="alert">@foreach($errors->all() as $error)<p>{{ $error }}</p>@endforeach</div>@endif
            <form class="tht20-form"
                  action="{{ route('wedding.rsvp.store', $wedding->slug) }}"
                  method="POST"
                  @submit.prevent="submitRsvp"
                  x-show="!success"
                  :aria-busy="submitting"
                  data-aos="fade-up" data-aos-duration="1600" data-aos-delay="100" data-aos-once="true">
                @csrf
                <p class="tht20-notice" x-cloak x-show="error" x-text="error" role="alert"></p>
                <label class="tht20-sr-only" for="tht20-name">Tên của bạn</label>
                <input id="tht20-name" name="name" type="text" autocomplete="name" maxlength="255" value="{{ old('name', $guestName) }}" x-model="formData.name" placeholder="Tên của bạn" required>
                <label class="tht20-sr-only" for="tht20-wish">Lời nhắn</label>
                <textarea id="tht20-wish" name="wish" rows="4" maxlength="1000" x-model="formData.wish" placeholder="Gửi lời nhắn đến cô dâu chú rể">{{ old('wish') }}</textarea>
                <label class="tht20-sr-only" for="tht20-attendance">Bạn sẽ đến chứ?</label>
                <select id="tht20-attendance" name="attendance" x-model="formData.attendance" required>
                    <option value="" disabled>Bạn sẽ đến chứ?</option>
                    <option value="yes">Có, mình sẽ đến</option>
                    <option value="maybe">Mình sẽ xác nhận sau</option>
                    <option value="no">Rất tiếc, mình không đến được</option>
                </select>
                <label class="tht20-sr-only" for="tht20-guests">Số người tham dự</label>
                <select id="tht20-guests" name="guests" x-model="formData.guests">
                    <option value="">Bạn tham dự mấy người?</option>
                    <option value="1">1 người</option>
                    <option value="2">2 người</option>
                    <option value="3">3 người</option>
                    <option value="4">4 người</option>
                    <option value="5">5 người trở lên</option>
                </select>
                <label class="tht20-sr-only" for="tht20-side">Bạn là khách mời của ai?</label>
                <select id="tht20-side" name="side" x-model="formData.side">
                    <option value="">Bạn là khách mời của ai?</option>
                    <option value="bride">Khách nhà gái</option>
                    <option value="groom">Khách nhà trai</option>
                    <option value="both">Khách của cả hai</option>
                </select>
                <button class="tht20-button tht20-button--outline" type="submit" :disabled="submitting">
                    <span x-show="!submitting">Gửi lời nhắn</span>
                    <span x-cloak x-show="submitting">Đang gửi…</span>
                </button>
            </form>
            <div class="tht20-confirmation" x-cloak x-show="success" role="status" tabindex="-1" x-ref="success">
                <i class="fa-regular fa-circle-check" aria-hidden="true"></i>
                <p x-text="successMessage"></p>
                <p>Cảm ơn tình cảm của bạn dành cho chúng mình.</p>
            </div>
        </div>

        {{-- Never add AOS/transform to an ancestor of the shared fixed QR modal. --}}
        @if($wedding->getBrideQrUrl() || $wedding->getGroomQrUrl())
            <x-wedding.gift-box :wedding="$wedding" class="tht20-gift">
                <div x-data="{ choose: false }">
                    @if($wedding->getBrideQrUrl() && $wedding->getGroomQrUrl())
                        <button class="tht20-button" type="button" @click="choose = !choose" :aria-expanded="choose">Mừng cưới</button>
                        <div class="tht20-gift__choices" x-cloak x-show="choose" x-transition>
                            <button class="tht20-button tht20-button--outline" type="button" @click="showQr = 'bride'" aria-haspopup="dialog">Nhà gái</button>
                            <button class="tht20-button tht20-button--outline" type="button" @click="showQr = 'groom'" aria-haspopup="dialog">Nhà trai</button>
                        </div>
                    @elseif($wedding->getBrideQrUrl())
                        <button class="tht20-button" type="button" @click="showQr = 'bride'" aria-haspopup="dialog">Mừng cưới</button>
                    @else
                        <button class="tht20-button" type="button" @click="showQr = 'groom'" aria-haspopup="dialog">Mừng cưới</button>
                    @endif
                </div>
            </x-wedding.gift-box>
        @endif

        @if($wedding->event_date)
            <div class="tht20-countdown" aria-labelledby="tht20-countdown-title" data-aos="fade-up" data-aos-duration="1600" data-aos-once="true">
                <h2 class="tht20-script" id="tht20-countdown-title">Countdown</h2>
                <div class="tht20-countdown__grid" x-data="countdown(@js($wedding->event_date->toIso8601String()))">
                    @foreach([['days', 'Ngày'], ['hours', 'Giờ'], ['minutes', 'Phút'], ['seconds', 'Giây']] as [$unit, $label])
                        @unless($loop->first)<span class="tht20-countdown__colon" aria-hidden="true">:</span>@endunless
                        <div><strong x-text="{{ $unit }}">00</strong><small>{{ $label }}</small></div>
                    @endforeach
                </div>
            </div>
        @endif
    </section>

    {{-- 10. Thank-you photo uses its own media; without it the copy sits on paper. --}}
    <footer @class(['tht20-thank-you', 'tht20-thank-you--photo' => $thankYouImage, 'tht20-paper' => !$thankYouImage])>
        @if($thankYouImage)
            <img src="{{ $thankYouImage }}" alt="{{ $sideData->firstName }} và {{ $sideData->secondName }}" loading="lazy" decoding="async">
        @endif
        <div class="tht20-thank-you__copy" data-aos="fade-up" data-aos-duration="1600" data-aos-once="true">
            <p>Cảm ơn bạn đã dành tình cảm cho chúng mình! Sự hiện diện của bạn chính là món quà ý nghĩa nhất và chúng mình vô cùng trân quý khi được cùng bạn chia sẻ niềm hạnh phúc trong ngày trọng đại này.</p>
            <h2 class="tht20-script">Thank you!</h2>
        </div>
    </footer>
    <p class="tht20-signature">{{ $sideData->firstName }} &amp; {{ $sideData->secondName }} · Wedding Invitation</p>
</main>
@endsection

@push('scripts')
    <x-wedding.countdown-script />
@endpush
