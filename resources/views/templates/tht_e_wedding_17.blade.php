@extends('layouts.wedding')
{{-- Template Name: THT E-Wedding 17 --}}
{{-- Type: wedding --}}
{{-- Contract: v17 --}}

@section('title', $sideData->firstName . ' & ' . $sideData->secondName . ' | THT E-Wedding')
@section('description', 'Trân trọng kính mời bạn đến chung vui cùng ' . $sideData->firstName . ' và ' . $sideData->secondName)
@section('og_image', $shareUrl)

@push('styles')
    @vite(['resources/css/templates/tht-e-wedding-17.css'])
@endpush

@section('content')
<main class="tht17 wedding-container">
    @include('components.wedding.preload', ['wedding' => $wedding, 'variant' => 'swirl'])
    @if($wedding->show_invitation_wrapper)
        <x-wedding.invitation-wrapper :wedding="$wedding" />
    @endif
    @include('components.wedding.falling-effects', ['wedding' => $wedding])
    <x-wedding.music-player :wedding="$wedding" />

    <section class="tht17-hero">
        <div class="tht17-hero__title" data-aos="fade-down">
            <span>Save</span>
            <em>the</em>
            <span>Date</span>
        </div>

        <img class="tht17-hero__floral" src="{{ asset('images/hoa-xin-1.webp') }}" alt="" aria-hidden="true">

        <figure class="tht17-hero__arch" data-aos="zoom-in" data-aos-delay="100">
            <img src="{{ $heroUrl }}" alt="{{ $sideData->firstName }} và {{ $sideData->secondName }}">
        </figure>

        <div class="tht17-hero__date" data-aos="fade-up" data-aos-delay="180">
            <div class="tht17-hero__weekday">
                <span>{{ $wedding->eventDayLabel() }}</span>
                <small>Ngày cưới</small>
            </div>
            <time datetime="{{ $wedding->event_date->toDateString() }}">{{ $wedding->event_date->format('d') }}</time>
            <div class="tht17-hero__month">
                <span>Tháng {{ $wedding->event_date->format('m') }}</span>
                <strong>{{ $wedding->event_date->format('Y') }}</strong>
            </div>
        </div>
    </section>

    @if($wedding->event_date)
        <section class="tht17-countdown" x-data="countdown('{{ $wedding->event_date->format('Y-m-d H:i:s') }}')">
            <div class="tht17-countdown__panel" data-aos="fade-up">
                <div class="tht17-countdown__heading">
                    <h2>Countdown time</h2>
                    <p>Thời gian đếm ngược</p>
                </div>
                <div class="tht17-countdown__grid">
                    <div><strong x-text="days">00</strong><span>Ngày</span></div>
                    <div><strong x-text="hours">00</strong><span>Giờ</span></div>
                    <div><strong x-text="minutes">00</strong><span>Phút</span></div>
                    <div><strong x-text="seconds">00</strong><span>Giây</span></div>
                </div>
            </div>
        </section>
    @endif

    <section class="tht17-invitation tht17-paper-section" id="loi-moi">
        <div class="tht17-invitation__intro" data-aos="fade-up">
            <p>Nhân danh tình yêu, hãy cùng đi hết quãng đời còn lại</p>
            <p>Từ nay trở đi, đông có nắng ấm, còn mình có nhau!</p>
            <h2>Thiệp mời</h2>
            <span aria-hidden="true"></span>
            <strong>Đến dự buổi tiệc chung vui cùng gia đình chúng tôi</strong>
        </div>

        <div class="tht17-invitation__cards">
            @foreach($sideData->events as $event)
                <article class="tht17-invitation-card" data-aos="fade-up">
                    <span class="tht17-invitation-card__joy" aria-hidden="true">囍</span>

                    <div class="tht17-invitation-card__families">
                        @foreach($sideData->families as $family)
                            <div class="tht17-invitation-card__family">
                                <p>{{ $family->label }}</p>
                                @if($family->father)<span>Ông: {{ $family->father }}</span>@endif
                                @if($family->mother)<span>Bà: {{ $family->mother }}</span>@endif
                            </div>
                        @endforeach
                    </div>

                    <div class="tht17-invitation-card__couple">
                        <h3>{{ $sideData->firstName }}</h3>
                        <i>&amp;</i>
                        <h3>{{ $sideData->secondName }}</h3>
                    </div>

                    <p class="tht17-invitation-card__at">Vào</p>
                    <p class="tht17-invitation-card__time">{{ $event->receptionTimeLabel() }}</p>
                    <time datetime="{{ $event->receptionDate->toDateString() }}">
                        <span>{{ $event->receptionDayLabel() }}</span>
                        <b>{{ $event->receptionDate->format('d.m.Y') }}</b>
                    </time>
                    @if($event->receptionLunarDisplay)<p class="tht17-invitation-card__lunar">({{ $event->receptionLunarDisplay }})</p>@endif

                    <div class="tht17-invitation-card__venue">
                        <p>Tại {{ $event->receptionVenue }}</p>
                        @if($event->receptionAddress)<span>{{ $event->receptionAddress }}</span>@endif
                    </div>

                    <p class="tht17-invitation-card__thanks">Sự hiện diện của quý khách là niềm vinh dự cho gia đình chúng tôi</p>

                    @if($event->receptionMapUrl)
                        <a class="tht17-invitation-card__map" href="{{ $event->receptionMapUrl }}" target="_blank" rel="noopener"><i class="fa-solid fa-location-arrow"></i> Chỉ đường</a>
                    @endif
                </article>
            @endforeach
        </div>
    </section>

    <section class="tht17-celebration" id="lich-trinh" aria-label="Lịch trình ngày cưới">
        <div class="tht17-celebration__frame" aria-hidden="true"></div>
        <img class="tht17-celebration__floral" src="{{ asset('images/hoa-xin-2.webp') }}" alt="" aria-hidden="true">

        <div class="tht17-celebration__signature" data-aos="fade-down">
            <span>{{ $sideData->firstName }}</span>
            <i>&amp;</i>
            <span>{{ $sideData->secondName }}</span>
        </div>

        <figure class="tht17-celebration__photo" data-aos="zoom-in">
            <img src="{{ $heroUrl }}" alt="{{ $sideData->firstName }} và {{ $sideData->secondName }}" loading="lazy">
        </figure>

        <div class="tht17-celebration__events">
            @foreach($sideData->events as $event)
                <article class="tht17-celebration-event" data-aos="fade-up">
                    <div class="tht17-celebration-event__icon" aria-hidden="true"><i class="fa-solid fa-champagne-glasses"></i></div>
                    <div class="tht17-celebration-event__body">
                        <h3>Tiệc Cưới Nhà {{ $event->side === 'bride' ? 'Gái' : 'Trai' }}</h3>
                        <p class="tht17-celebration-event__time">
                            <i class="fa-regular fa-clock" aria-hidden="true"></i>
                            <time datetime="{{ $event->receptionDate->toDateString() }}">{{ $event->receptionTimeLabel() }} {{ $event->receptionDayLabel() }}, ngày {{ $event->receptionDate->format('d/m/Y') }}</time>
                        </p>
                        @if($event->receptionMapUrl)
                            <a class="tht17-celebration-event__place" href="{{ $event->receptionMapUrl }}" target="_blank" rel="noopener">
                                <i class="fa-solid fa-location-dot" aria-hidden="true"></i><span>{{ $event->receptionVenue }}@if($event->receptionAddress)<small>{{ $event->receptionAddress }}</small>@endif</span>
                            </a>
                        @else
                            <p class="tht17-celebration-event__place"><i class="fa-solid fa-location-dot" aria-hidden="true"></i><span>{{ $event->receptionVenue }}@if($event->receptionAddress)<small>{{ $event->receptionAddress }}</small>@endif</span></p>
                        @endif
                    </div>
                </article>

                @if($event->side === 'groom' || $sideData->events->count() === 1)
                    <article class="tht17-celebration-event tht17-celebration-event--ceremony" data-aos="fade-up">
                        <div class="tht17-celebration-event__icon" aria-hidden="true"><i class="fa-solid fa-ring"></i></div>
                        <div class="tht17-celebration-event__body">
                            <h3>{{ $event->ceremonyTitle }}</h3>
                            <p class="tht17-celebration-event__time">
                                <i class="fa-regular fa-clock" aria-hidden="true"></i>
                                <time datetime="{{ $event->ceremonyDate->toDateString() }}">{{ $event->ceremonyTimeLabel() }} {{ $event->ceremonyDayLabel() }}, ngày {{ $event->ceremonyDate->format('d/m/Y') }}</time>
                            </p>
                            @if($event->ceremonyMapUrl)
                                <a class="tht17-celebration-event__place" href="{{ $event->ceremonyMapUrl }}" target="_blank" rel="noopener">
                                    <i class="fa-solid fa-location-dot" aria-hidden="true"></i><span>{{ $event->ceremonyVenue }}@if($event->ceremonyAddress)<small>{{ $event->ceremonyAddress }}</small>@endif</span>
                                </a>
                            @else
                                <p class="tht17-celebration-event__place"><i class="fa-solid fa-location-dot" aria-hidden="true"></i><span>{{ $event->ceremonyVenue }}@if($event->ceremonyAddress)<small>{{ $event->ceremonyAddress }}</small>@endif</span></p>
                            @endif
                        </div>
                    </article>
                @endif
            @endforeach
        </div>

        <p class="tht17-celebration__closing" data-aos="fade-up">Rất hân hạnh đón tiếp!</p>
    </section>

    @if($beforeSliderImages->isNotEmpty())
        <section class="tht17-before-slider" aria-label="Wedding album">
            <img class="tht17-before-slider__floral" src="{{ asset('images/hoa-xin-1.webp') }}" alt="" aria-hidden="true">
            <div class="tht17-before-slider__heading" data-aos="fade-right">
                <span aria-hidden="true"></span>
                <h2>Wedding Album</h2>
            </div>

            <div class="tht17-before-slider__grid tht17-before-slider__grid--count-{{ $beforeSliderImages->count() }}" data-aos="zoom-in">
                @foreach($beforeSliderImages as $image)
                    <a class="tht17-before-slider__item glightbox" href="{{ $image->getUrl() }}" data-gallery="tht-e-wedding-17-before">
                        <img src="{{ $image->getUrl() }}" alt="Khoảnh khắc của {{ $sideData->firstName }} và {{ $sideData->secondName }}" loading="lazy">
                    </a>
                @endforeach
            </div>
        </section>
    @endif

    <x-wedding.gallery :wedding="$wedding" :theme="$theme" />

    <section class="tht17-response" id="rsvp">
        <div class="tht17-response__rsvp" data-aos="fade-up" x-data="{
            submitting: false,
            success: false,
            error: null,
            formData: {
                name: '{{ $wedding->getGuestName() ? urldecode($wedding->getGuestName()) : '' }}',
                phone: '',
                attendance: 'yes',
                guests: '1',
                side: '{{ $side }}',
                note: ''
            },
            async submitRsvp() {
                this.submitting = true;
                this.error = null;
                try {
                    const response = await fetch('{{ route('wedding.rsvp.store', $wedding->slug) }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content,
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify(this.formData)
                    });
                    if (response.ok) this.success = true;
                    else this.error = (await response.json()).message || 'Có lỗi xảy ra.';
                } catch (error) {
                    this.error = 'Lỗi kết nối. Vui lòng thử lại.';
                } finally {
                    this.submitting = false;
                }
            }
        }">
            <h2>Xác nhận và gửi lời chúc</h2>
            <form @submit.prevent="submitRsvp" x-show="!success">
                <p class="tht17-response__error" x-show="error" x-text="error" style="display: none"></p>
                <input type="text" x-model="formData.name" placeholder="Tên của bạn là gì?" required>
                <select x-model="formData.side" aria-label="Bạn là khách của bên nào?">
                    <option value="both">Bạn là gì của Dâu Rể nhỉ?</option>
                    <option value="groom">Khách nhà trai</option>
                    <option value="bride">Khách nhà gái</option>
                </select>
                <select x-model="formData.attendance" aria-label="Bạn sẽ tham dự chứ?">
                    <option value="yes">Bạn sẽ tham dự chứ?</option>
                    <option value="maybe">Chưa chắc chắn</option>
                    <option value="no">Rất tiếc, không thể tham dự</option>
                </select>
                <textarea x-model="formData.note" placeholder="Gửi lời chúc đến Dâu Rể nhé!" rows="3"></textarea>
                <button type="submit" :disabled="submitting"><span x-show="!submitting">Xác nhận</span><span x-show="submitting">Đang gửi...</span></button>
            </form>
            <p class="tht17-response__success" x-show="success" style="display: none">Cảm ơn bạn đã xác nhận!</p>
        </div>

        <div class="tht17-response__gift" data-aos="fade-up">
            <h2>Hộp Mừng Cưới</h2>
            <div class="tht17-response__qr-card">
                @if($sideData->isGroom())
                    <img src="{{ $wedding->getGroomQrUrl() }}" alt="Mã QR mừng cưới chú rể" loading="lazy">
                    <p>Mừng cưới chú rể</p>
                    <a href="{{ $wedding->getGroomQrUrl() }}" target="_blank" rel="noopener">Tải ảnh QR</a>
                @else
                    <img src="{{ $wedding->getBrideQrUrl() }}" alt="Mã QR mừng cưới cô dâu" loading="lazy">
                    <p>Mừng cưới cô dâu</p>
                    <a href="{{ $wedding->getBrideQrUrl() }}" target="_blank" rel="noopener">Tải ảnh QR</a>
                @endif
            </div>
        </div>

        @foreach($sideData->events->take(1) as $event)
            <section class="tht17-response__map" aria-label="Địa chỉ tiệc cưới" data-aos="fade-up">
                <img class="tht17-response__map-floral" src="{{ asset('images/hoa-map.webp') }}" alt="" aria-hidden="true">
                <h2>Địa chỉ tiệc cưới</h2>
                @if($event->receptionMapUrl)
                    <a class="tht17-response__map-link" href="{{ $event->receptionMapUrl }}" target="_blank" rel="noopener">Xem chỉ đường</a>
                @endif
                @if($event->receptionMapFrameUrl())
                    <iframe src="{{ $event->receptionMapFrameUrl() }}" title="Bản đồ {{ $event->receptionVenue }}" loading="lazy" referrerpolicy="no-referrer-when-downgrade" allowfullscreen></iframe>
                @elseif($event->receptionMapUrl)
                    <a class="tht17-response__map-fallback" href="{{ $event->receptionMapUrl }}" target="_blank" rel="noopener"><i class="fa-solid fa-location-dot"></i>{{ $event->receptionVenue }}</a>
                @endif
            </section>
        @endforeach
    </section>

    <footer class="tht17-footer">
        <figure class="tht17-footer__arch" data-aos="zoom-in">
            <img src="{{ $heroUrl }}" alt="{{ $sideData->firstName }} và {{ $sideData->secondName }}" loading="lazy">
            <figcaption>
                <h2>Thank You!</h2>
                <p>{{ $wedding->getContentValue('rsvp_desc', 'Sự hiện diện của bạn là niềm vinh hạnh cho gia đình chúng tôi.') }}</p>
            </figcaption>
        </figure>
    </footer>
</main>

@push('scripts')
    <x-wedding.countdown-script />
@endpush
@endsection
