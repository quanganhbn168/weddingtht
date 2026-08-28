@extends('layouts.wedding')
{{-- Template Name: THT E-Wedding 18 (Linen Editorial) --}}
{{-- Type: wedding --}}
{{-- Contract: v17 --}}

@section('title', $sideData->firstName . ' & ' . $sideData->secondName . ' | Wedding Celebration')
@section('description', 'Trân trọng kính mời bạn đến chung vui cùng ' . $sideData->firstName . ' và ' . $sideData->secondName)
@section('og_image', $shareUrl)

@push('styles')
    @vite(['resources/css/templates/tht-e-wedding-18.css'])
@endpush

@section('content')
<main class="tht18 wedding-container">
    @include('components.wedding.preload', ['wedding' => $wedding, 'variant' => 'split_botanical'])
    @if($wedding->show_invitation_wrapper)
        <x-wedding.invitation-wrapper :wedding="$wedding" />
    @endif
    @include('components.wedding.falling-effects', ['wedding' => $wedding])
    <x-wedding.music-player :wedding="$wedding" />

    <section class="tht18-hero">
        <div class="tht18-hero__frame" data-aos="zoom-in">
            <figure class="tht18-hero__media">
                <img src="{{ $heroUrl }}" alt="{{ $sideData->firstName }} và {{ $sideData->secondName }}">
            </figure>
            <div class="tht18-hero__veil" aria-hidden="true"></div>
            <div class="tht18-hero__content">
                <h1><span>{{ $sideData->firstName }}</span><span>{{ $sideData->secondName }}</span></h1>
                @if($guestName)
                    <p class="tht18-hero__guest">Trân trọng kính mời <strong>{{ $guestName }}</strong></p>
                @endif
                <div class="tht18-hero__date">
                    <span>OUR BIG DAY</span>
                    @foreach($heroDates as $heroDate)
                        <time datetime="{{ $heroDate->toDateString() }}">{{ $heroDate->format('d.m.Y') }}</time>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <section class="tht18-invitation" aria-label="Lời mời cưới">
        <img class="tht18-invitation__flower tht18-invitation__flower--left" src="{{ asset('images/templates/tht-e-wedding-18/hoa-goc-1.svg') }}" alt="" aria-hidden="true">
        <img class="tht18-invitation__flower tht18-invitation__flower--right" src="{{ asset('images/templates/tht-e-wedding-18/hoa-goc-3.svg') }}" alt="" aria-hidden="true">
        <h2 data-aos="fade-up">Kính mời tham dự tiệc cưới thân mật<br>của gia đình chúng tôi</h2>
        <div class="tht18-invitation__families" data-aos="fade-up">
            @foreach($sideData->families as $family)
                <article class="tht18-family">
                    <p>{{ $family->label }}</p>
                    @if($family->father)<span>Ông: {{ $family->father }}</span>@endif
                    @if($family->mother)<span>Bà: {{ $family->mother }}</span>@endif
                </article>
            @endforeach
        </div>
        <div class="tht18-invitation__monogram" data-aos="zoom-in">
            <img class="tht18-invitation__monogram-frame" src="{{ asset('images/templates/tht-e-wedding-18/khungchu.svg') }}" alt="" aria-hidden="true">
            <span class="tht18-invitation__initial tht18-invitation__initial--groom">{{ $groomInitial }}</span>
            <span class="tht18-invitation__initial tht18-invitation__initial--bride">{{ $brideInitial }}</span>
        </div>
        <p class="tht18-invitation__line" data-aos="fade-up">Our Wedding Day. Our Forever Day</p>
        <div class="tht18-invitation__album" data-aos="fade-up">
            <figure><img src="{{ $groomPhoto }}" alt="{{ $wedding->groom_name }}" loading="lazy"></figure>
            <figure><img src="{{ $bridePhoto }}" alt="{{ $wedding->bride_name }}" loading="lazy"></figure>
        </div>
        <div class="tht18-invitation__names" data-aos="fade-up">
            <span>{{ $wedding->groom_name }}</span>
            <i>and</i>
            <span>{{ $wedding->bride_name }}</span>
        </div>
    </section>

    <section class="tht18-receptions" id="schedule" aria-label="Lịch tiệc cưới">
        <img class="tht18-receptions__flower tht18-receptions__flower--left" src="{{ asset('images/templates/tht-e-wedding-18/hoa-goc.svg') }}" alt="" aria-hidden="true">
        <img class="tht18-receptions__flower tht18-receptions__flower--right" src="{{ asset('images/templates/tht-e-wedding-18/hoa-goc.svg') }}" alt="" aria-hidden="true">
        @foreach($sideData->events as $event)
            <article class="tht18-reception" data-aos="fade-up">
                <p>Tiệc cưới nhà {{ $event->side === 'bride' ? 'gái' : 'trai' }} được tổ chức</p>
                <span>Vào lúc {{ $event->receptionTimeVietnameseLabel() }}, {{ $event->receptionDayLabel() }}</span>
                <time datetime="{{ $event->receptionDate->toDateString() }}">{{ $event->receptionDate->format('d.m.Y') }}</time>
                @if($event->receptionLunarInWords)<em>{{ $event->receptionLunarInWords }}</em>@endif
                <small>Tại</small>
                <h2>{{ $event->receptionVenue }}</h2>
                @if($event->receptionAddress)<address>{{ $event->receptionAddress }}</address>@endif
                @if(filled($event->receptionMapUrl))<a href="{{ $event->receptionMapUrl }}" target="_blank" rel="noopener"><i class="fa-solid fa-location-dot" aria-hidden="true"></i> Chỉ đường</a>@endif
            </article>
        @endforeach
    </section>

    @if(isset($templateSchemaMedia['love_story_main_image'], $templateSchemaMedia['love_story_detail_images']) && $templateSchemaMedia['love_story_main_image'])
        <section class="tht18-story" aria-label="Love Story">
            <figure class="tht18-story__hero" data-aos="zoom-in">
                <img src="{{ $templateSchemaMedia['love_story_main_image']->getUrl() }}" alt="Love story của {{ $sideData->firstName }} và {{ $sideData->secondName }}" loading="lazy">
                <div class="tht18-story__copy" data-aos="fade-up">
                    <h2>{{ $wedding->getContentValue('prologue_title', 'Love Story') }}</h2>
                    <p>{{ $wedding->getContentValue('prologue_desc', 'Tình yêu chúng ta là một hành trình đẹp, bắt đầu từ hôm nay và mãi về sau.') }}</p>
                </div>
            </figure>
            @if($templateSchemaMedia['love_story_detail_images']->isNotEmpty())
                <div class="tht18-story__gallery" data-aos="fade-up">
                    @foreach($templateSchemaMedia['love_story_detail_images']->take(4) as $image)
                        <figure><img src="{{ $image->getUrl() }}" alt="Khoảnh khắc của {{ $sideData->firstName }} và {{ $sideData->secondName }}" loading="lazy"></figure>
                    @endforeach
                </div>
            @endif
        </section>
    @endif

    <section class="tht18-ceremonies" aria-label="Lễ cưới">
        <img class="tht18-ceremonies__flower tht18-ceremonies__flower--top-left" src="{{ asset('images/templates/tht-e-wedding-18/hoa-goc-1.svg') }}" alt="" aria-hidden="true">
        <img class="tht18-ceremonies__flower tht18-ceremonies__flower--bottom-right" src="{{ asset('images/templates/tht-e-wedding-18/hoa-goc-3.svg') }}" alt="" aria-hidden="true">
        <h2 data-aos="fade-up">Lễ Cưới</h2>
        @foreach($sideData->events as $event)
            <article class="tht18-ceremony" data-aos="fade-up">
                <p>{{ $event->ceremonyTitle }} được cử hành</p>
                <span>Vào lúc {{ $event->ceremonyTimeVietnameseLabel() }}, {{ $event->ceremonyDayLabel() }}</span>
                <time datetime="{{ $event->ceremonyDate->toDateString() }}">{{ $event->ceremonyDate->format('d.m.Y') }}</time>
                @if($event->ceremonyLunarInWords)<em>{{ $event->ceremonyLunarInWords }}</em>@endif
                <small>Tại: {{ $event->ceremonyVenue }}</small>
                @if(filled($event->ceremonyMapUrl))<a href="{{ $event->ceremonyMapUrl }}" target="_blank" rel="noopener"><i class="fa-solid fa-location-dot" aria-hidden="true"></i> Chỉ đường</a>@endif
            </article>
        @endforeach
    </section>

    <section class="tht18-calendar" aria-label="Lịch cưới" data-aos="zoom-in">
        <div class="tht18-calendar__card">
            @if(isset($templateSchemaMedia['calendar_background']) && $templateSchemaMedia['calendar_background'])<img src="{{ $templateSchemaMedia['calendar_background']->getUrl() }}" alt="{{ $calendarMonthLabel }}" loading="lazy">@endif
            <div class="tht18-calendar__content">
                <h2>{{ $calendarMonthLabel }}</h2>
                <div class="tht18-calendar__days" aria-hidden="true"><span>Mon</span><span>Tue</span><span>Wed</span><span>Thu</span><span>Fri</span><span>Sat</span><span>Sun</span></div>
                <div class="tht18-calendar__dates">
                    @foreach($calendarWeeks as $week)
                        @foreach($week as $cell)
                            @if($cell)
                                <time datetime="{{ $cell['date'] }}" @class(['is-heart' => in_array($cell['date'], $calendarHighlightedDates, true)])><span>{{ $cell['day'] }}</span></time>
                            @else
                                <span aria-hidden="true"></span>
                            @endif
                        @endforeach
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    @if($galleryImages->isNotEmpty())
        <section class="tht18-album" aria-label="Our Love Album">
            <section class="tht18-album__heading" aria-label="Our Love Album">
                <img class="tht18-album__flower tht18-album__flower--top-left" src="{{ asset('images/templates/tht-e-wedding-18/hoa-goc-1.svg') }}" alt="" aria-hidden="true">
                <img class="tht18-album__flower tht18-album__flower--bottom-right" src="{{ asset('images/templates/tht-e-wedding-18/hoa-goc.svg') }}" alt="" aria-hidden="true">
                <h2 data-aos="fade-up">Our Love<br>Album</h2>
            </section>
            <div class="tht18-album__grid" data-aos="fade-up">
                @foreach($galleryImages->take(9) as $image)
                    <a class="glightbox" href="{{ $image->getUrl() }}" data-gallery="tht-e-wedding-18-album"><img src="{{ $image->getUrl('gallery_web') ?: $image->getUrl() }}" alt="Album tình yêu của {{ $sideData->firstName }} và {{ $sideData->secondName }}" loading="lazy"></a>
                @endforeach
            </div>
        </section>
    @endif

    <section class="tht18-response" id="rsvp">
        <div class="tht18-response__rsvp" data-aos="fade-up" x-data="{
            submitting: false,
            success: false,
            error: null,
            formData: {
                name: '{{ $wedding->getGuestName() ? urldecode($wedding->getGuestName()) : '' }}',
                phone: '', attendance: 'yes', guests: '1', side: '{{ $side }}', note: ''
            },
            async submitRsvp() {
                this.submitting = true; this.error = null;
                try {
                    const response = await fetch('{{ route('wedding.rsvp.store', $wedding->slug) }}', {
                        method: 'POST',
                        headers: {'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content, 'Accept': 'application/json'},
                        body: JSON.stringify(this.formData)
                    });
                    if (response.ok) this.success = true;
                    else this.error = (await response.json()).message || 'Có lỗi xảy ra. Vui lòng thử lại.';
                } catch (error) { this.error = 'Không thể kết nối. Vui lòng thử lại.'; }
                finally { this.submitting = false; }
            }
        }">
            <p>{{ $wedding->getContentValue('rsvp_desc', 'Hãy xác nhận sự có mặt của bạn trước để chúng mình chuẩn bị đón tiếp một cách chu đáo nhất. Trân trọng!') }}</p>
            <form action="{{ route('wedding.rsvp.store', $wedding->slug) }}" method="POST" @submit.prevent="submitRsvp" x-show="!success">
                @csrf
                <p class="tht18-response__error" x-show="error" x-text="error" style="display: none"></p>
                <input type="text" name="name" x-model="formData.name" placeholder="Tên của bạn là gì?" required>
                <select name="attendance" x-model="formData.attendance" aria-label="Bạn sẽ tham gia chứ?"><option value="yes">Bạn sẽ tham gia chứ?</option><option value="maybe">Chưa chắc chắn</option><option value="no">Rất tiếc, không thể tham dự</option></select>
                <select name="side" x-model="formData.side" aria-label="Bạn là khách mời của ai?"><option value="both">Bạn là khách mời của ai?</option><option value="groom">Khách nhà trai</option><option value="bride">Khách nhà gái</option></select>
                <select name="guests" x-model="formData.guests" aria-label="Bạn đi bao nhiêu người?"><option value="1">Bạn đi bao nhiêu người?</option><option value="2">2 người</option><option value="3">3 người</option><option value="4">4 người</option><option value="5">5 người trở lên</option></select>
                <button type="submit" :disabled="submitting"><span x-show="!submitting">Xác nhận</span><span x-show="submitting">Đang gửi…</span></button>
            </form>
            <p class="tht18-response__success" x-show="success" style="display: none">Cảm ơn bạn đã xác nhận. Hẹn gặp bạn trong ngày vui!</p>
        </div>

        <x-wedding.gift-box :wedding="$wedding" class="tht18-gift" data-aos="fade-up">
            <p>{{ $wedding->getContentValue('blessing_desc', 'Cảm ơn bạn đã gửi lời chúc và món quà mừng đến chúng mình.') }}</p>
            <div class="tht18-gift__actions"><button type="button" @click="showQr = 'bride'">Mừng cưới nhà gái</button><button type="button" @click="showQr = 'groom'">Mừng cưới nhà trai</button></div>
        </x-wedding.gift-box>
    </section>

    @if($wedding->event_date)
        <section class="tht18-countdown" aria-label="Countdown" data-aos="fade-up">
            <h2>Countdown</h2>
            <div x-data="countdown('{{ $wedding->event_date->format('Y-m-d H:i:s') }}')" class="tht18-countdown__numbers">
                @foreach([['days', 'Ngày'], ['hours', 'Giờ'], ['minutes', 'Phút'], ['seconds', 'Giây']] as [$unit, $label])
                    <div><strong x-text="{{ $unit }}">00</strong><span>{{ $label }}</span></div>
                @endforeach
            </div>
        </section>
    @endif

    <section class="tht18-guestbook" id="guestbook" data-aos="fade-up" x-data="{
        submitting: false,
        success: false,
        error: null,
        formData: {name: '', message: ''},
        async submitWish() {
            this.submitting = true; this.error = null;
            try {
                const response = await fetch('{{ route('wedding.wish.store', $wedding->slug) }}', {
                    method: 'POST',
                    headers: {'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content, 'Accept': 'application/json'},
                    body: JSON.stringify(this.formData)
                });
                if (response.ok) { this.success = true; this.formData = {name: '', message: ''}; }
                else this.error = (await response.json()).message || 'Có lỗi xảy ra. Vui lòng thử lại.';
            } catch (error) { this.error = 'Không thể kết nối. Vui lòng thử lại.'; }
            finally { this.submitting = false; }
        }
    }">
        <h2>{{ $wedding->getContentValue('guestbook_title', 'Sổ lưu bút') }}</h2>
        <p>{{ $wedding->getContentValue('guestbook_desc', 'Cảm ơn bạn rất nhiều vì đã gửi những lời chúc mừng tốt đẹp đến đám cưới của chúng tôi!') }}</p>
        <form action="{{ route('wedding.wish.store', $wedding->slug) }}" method="POST" @submit.prevent="submitWish" x-show="!success">
            @csrf
            <p class="tht18-guestbook__error" x-show="error" x-text="error" style="display: none"></p>
            <input type="text" name="name" x-model="formData.name" placeholder="Nhập tên của bạn *" required>
            <textarea name="message" x-model="formData.message" rows="3" maxlength="1000" placeholder="Nhập lời chúc của bạn *" required></textarea>
            <button type="submit" :disabled="submitting"><span x-show="!submitting">Gửi</span><span x-show="submitting">Đang gửi…</span></button>
        </form>
        <p class="tht18-guestbook__success" x-show="success" style="display: none">Cảm ơn lời chúc của bạn!</p>
        <div class="tht18-guestbook__wishes">
            @forelse($approvedWishes as $wish)
                <article><h3>{{ $wish->name }}</h3><p>{{ $wish->message }}</p></article>
            @empty
                <p class="tht18-guestbook__empty">Hãy là người đầu tiên để lại lời chúc nhé!</p>
            @endforelse
        </div>
    </section>

    <footer class="tht18-thank-you">
        @if($thankYouImage)<figure data-aos="zoom-in"><img src="{{ $thankYouImage }}" alt="{{ $sideData->firstName }} và {{ $sideData->secondName }}" loading="lazy"></figure>@endif
        <div data-aos="fade-up">
            <p>Cảm ơn bạn đã dành tình cảm cho chúng mình. Sự hiện diện của bạn chính là món quà ý nghĩa nhất.</p>
            <h2>Thank you</h2>
        </div>
    </footer>
</main>

@push('scripts')
    <x-wedding.countdown-script />
@endpush
@endsection
