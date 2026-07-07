@extends('layouts.wedding')
{{-- Template Name: THT E-Wedding 16 --}}
{{-- Type: wedding --}}
{{-- Tier: pro --}}

@section('title', $sideData->firstName . ' & ' . $sideData->secondName . ' | THT E-Wedding')
@section('description', 'Trân trọng kính mời bạn đến chung vui cùng ' . $sideData->firstName . ' và ' . $sideData->secondName)
@section('og_image', $shareUrl)

@section('content')
@push('styles')
@vite(['resources/css/templates/tht-e-wedding-16.css'])
@endpush
<main class="tht16 wedding-container">
    @include('components.wedding.preload', ['wedding' => $wedding, 'variant' => 'swirl'])
    @if($wedding->show_invitation_wrapper)
        <x-wedding.invitation-wrapper :wedding="$wedding" />
    @endif
    @include('components.wedding.falling-effects', ['wedding' => $wedding])
    <x-wedding.music-player :wedding="$wedding" />

    {{-- HERO --}}
    <section class="tht16-hero">
        <img class="tht16-hero__image" src="{{ $heroUrl }}" alt="{{ $sideData->firstName }} và {{ $sideData->secondName }}">
        <div class="tht16-hero__shade"></div>
        <div class="tht16-hero__content">
            <p class="tht16-hero__eyebrow" data-aos="fade-down">Lễ Thành Hôn</p>
            <h1 class="tht16-hero__names" data-aos="fade-up">
                {{ $sideData->firstName }}
                <span class="tht16-hero__amp">and</span>
                {{ $sideData->secondName }}
            </h1>
            <p class="tht16-hero__date" data-aos="fade-up" data-aos-delay="180">{{ $wedding->event_date->format('d.m.Y') }}</p>
        </div>
    </section>

    {{-- FAMILIES + FORMAL INVITATION --}}
    <section class="tht16-section tht16-paper tht16-invitation">
        <img class="tht16-invitation-flower" src="{{ asset('images/6.png') }}" alt="" aria-hidden="true">
        <div class="tht16-families" data-aos="fade-up">
            @foreach($sideData->families as $family)
                <div class="tht16-family">
                    <p class="tht16-family__label">{{ $family->label }}</p>
                    @if($family->father)<p class="tht16-family__name">Ông: {{ $family->father }}</p>@endif
                    @if($family->mother)<p class="tht16-family__name">Bà: {{ $family->mother }}</p>@endif
                </div>
            @endforeach
        </div>

        <img class="tht16-bouquet" src="{{ asset('images/2.png') }}" alt="Hoa cưới" data-aos="zoom-in">

        <div data-aos="fade-up">
            <p class="tht16-invite-title">Trân trọng kính mời</p>
            <p class="tht16-guest">{{ $wedding->getGuestName() ? $guestName : 'Bạn & người thương' }}</p>
            <p class="tht16-copy">Tới dự tiệc cưới thân mật<br>của gia đình chúng tôi</p>
        </div>

        <div class="tht16-couple" data-aos="fade-up">
            <h2 class="tht16-couple__name">{{ $sideData->firstName }}</h2>
            <p class="tht16-couple__and">and</p>
            <h2 class="tht16-couple__name">{{ $sideData->secondName }}</h2>
        </div>

        @foreach($sideData->events as $event)
            <div class="tht16-event-block" data-aos="fade-up">
                <div class="tht16-invite-date" aria-label="{{ $event->receptionDate->format('d m Y') }}">
                    <span>{{ $event->receptionDate->format('d') }}</span>
                    <span>{{ $event->receptionDate->format('m') }}</span>
                    <span>{{ $event->receptionDate->format('Y') }}</span>
                </div>
                <p class="tht16-event-time__main">Lúc {{ $event->receptionTimeLabel() }}, {{ $event->receptionDayLabel() }}</p>
                @if($event->receptionLunarDisplay)<p class="tht16-lunar">( {{ $event->receptionLunarDisplay }} )</p>@endif

                <h3 class="tht16-venue">Tại {{ $event->receptionVenue }}</h3>
                @if($event->receptionAddress)<p class="tht16-address">{{ $event->receptionAddress }}</p>@endif

                @if($event->receptionMapEmbed)
                    <div class="tht16-map">
                        <iframe src="{{ $event->receptionMapEmbed }}" loading="lazy" allowfullscreen referrerpolicy="no-referrer-when-downgrade" title="Bản đồ {{ $event->receptionTitle }}"></iframe>
                    </div>
                @endif
                @if($event->receptionMapUrl)
                    <a class="tht16-map-link" href="{{ $event->receptionMapUrl }}" target="_blank" rel="noopener">
                        <i class="fa-solid fa-location-dot"></i>
                        <span>Chỉ đường</span>
                    </a>
                @endif
            </div>
        @endforeach

    </section>

    {{-- WEDDING DAY --}}
    <section class="tht16-wedding-day" data-aos="fade-up">
        @if($wedding->getTemplateMediaUrl('tht16_torn_photo'))
            <figure class="tht16-torn-photo" data-aos="fade-up">
                <img src="{{ $wedding->getTemplateMediaUrl('tht16_torn_photo') }}" alt="Khoảnh khắc của {{ $sideData->firstName }} và {{ $sideData->secondName }}" loading="lazy">
            </figure>
        @endif
        <section class="tht16-wedding-day__content">
            <img class="tht16-wedding-stem" src="{{ asset('images/3.png') }}" alt="" aria-hidden="true">
            <h2 class="tht16-wedding-day__heading">Wedding<span>Day</span></h2>
            @foreach($sideData->events as $event)
                <div class="tht16-ceremony-block">
                    <p class="tht16-ceremony-label">{{ $event->ceremonyTitle }}</p>
                    <div class="tht16-big-date" aria-label="{{ $event->ceremonyDate->format('d m Y') }}">
                        <span>{{ $event->ceremonyDate->format('d') }}</span>
                        <span>{{ $event->ceremonyDate->format('m') }}</span>
                        <span>{{ $event->ceremonyDate->format('Y') }}</span>
                    </div>
                    <p class="tht16-wedding-meta">Vào lúc {{ $event->ceremonyTimeLabel() }}, {{ $event->ceremonyDayLabel() }}</p>
                    @if($event->ceremonyLunarDisplay)<p class="tht16-wedding-lunar">({{ $event->ceremonyLunarDisplay }})</p>@endif
                    <p class="tht16-wedding-venue">Tại {{ $event->ceremonyVenue }}</p>
                    @if($event->ceremonyAddress)<p class="tht16-address">{{ $event->ceremonyAddress }}</p>@endif

                    @if($event->ceremonyMapEmbed)
                        <div class="tht16-map">
                            <iframe src="{{ $event->ceremonyMapEmbed }}" loading="lazy" allowfullscreen referrerpolicy="no-referrer-when-downgrade" title="Bản đồ {{ $event->ceremonyTitle }}"></iframe>
                        </div>
                    @endif
                    @if($event->ceremonyMapUrl)
                        <a class="tht16-map-link" href="{{ $event->ceremonyMapUrl }}" target="_blank" rel="noopener">
                            <i class="fa-solid fa-location-dot"></i> Xem chỉ đường
                        </a>
                    @endif
                </div>
            @endforeach
        </section>
    </section>
    @if($wedding->getTemplateMediaUrl('tht16_forever_anchor'))
        <figure class="tht16-anchor-photo" data-aos="fade-up">
            <img src="{{ $wedding->getTemplateMediaUrl('tht16_forever_anchor') }}" alt="Our Forever Anchor" loading="lazy">
            <figcaption class="tht16-anchor-photo__caption">
                <span>Our</span>
                <strong>Forever Anchor</strong>
            </figcaption>
        </figure>
    @endif
    {{-- BRIDE & GROOM COLLAGE --}}
    <section class="tht16-paper tht16-couple-collage" aria-label="Cô dâu và chú rể">
        <div class="tht16-collage-photo tht16-collage-photo--bride">
            <img src="{{ $wedding->getBridePhotoUrl() }}" alt="Cô dâu {{ $wedding->bride_name }}" loading="lazy">
            <div class="tht16-collage-join">
                <div class="tht16-collage-photo tht16-collage-photo--groom">
                    <img src="{{ $wedding->getGroomPhotoUrl() }}" alt="Chú rể {{ $wedding->groom_name }}" loading="lazy">
                    <div class="tht16-collage-seal-anchor" aria-hidden="true">
                        <img class="tht16-collage-seal" src="{{ asset('images/5.png') }}" alt="">
                    </div>
                </div>
            </div>
        </div>
        <div class="tht16-collage-name tht16-collage-name--bride" data-aos="fade-left">
            <p>Cô dâu</p>
            <h2>{{ $wedding->bride_name }}</h2>
        </div>

        <div class="tht16-collage-name tht16-collage-name--groom" data-aos="fade-right">
            <p>Chú rể</p>
            <h2>{{ $wedding->groom_name }}</h2>
        </div>

    </section>

    {{-- ALBUM OF LOVE: MAIN SLIDER + THUMBNAILS --}}
    <section class="tht16-album">
        <div class="tht16-album-heading" data-aos="fade-right">
            <h2>Album <span>Of</span></h2>
        </div>
        @if($wedding->albumLoveImageUrl())
            <div class="tht16-love-mask" data-aos="fade-up">
            <svg class="tht16-love-mask__word" viewBox="0 0 1000 300" role="img" aria-label="LOVE">
                <defs>
                    <mask id="tht16-love-image-mask" maskUnits="userSpaceOnUse" x="0" y="0" width="1000" height="300">
                        <text class="tht16-love-mask__text" x="500" y="270" text-anchor="middle">LOVE</text>
                        <ellipse class="tht16-love-mask__o-fill" cx="365" cy="158" rx="72" ry="88" />
                    </mask>
                </defs>
                <image href="{{ $wedding->albumLoveImageUrl() }}" x="0" y="0" width="1000" height="300" preserveAspectRatio="xMidYMin slice" mask="url(#tht16-love-image-mask)" />
                <foreignObject x="0" y="0" width="1000" height="300" mask="url(#tht16-love-image-mask)">
                    <div
                        xmlns="http://www.w3.org/1999/xhtml"
                        class="tht16-love-mask__image"
                        style="background-image: url('{{ $wedding->albumLoveImageUrl() }}'); background-position: {{ $wedding->albumLoveFocalPoint()['x'] }}% {{ $wedding->albumLoveFocalPoint()['y'] }}%;"
                    ></div>
                </foreignObject>
            </svg>
            </div>
        @endif

        <div class="swiper tht16-album-main" data-aos="fade-up">
            <div class="swiper-wrapper">
                @foreach($albumImages as $image)
                    <div class="swiper-slide">
                        <a class="glightbox" href="{{ $image }}" data-gallery="tht-e-wedding-16">
                            <img src="{{ $image }}" alt="Khoảnh khắc của {{ $sideData->firstName }} và {{ $sideData->secondName }}" loading="lazy">
                        </a>
                    </div>
                @endforeach
            </div>
            <div class="swiper-button-prev"></div>
            <div class="swiper-button-next"></div>
        </div>
        <div class="swiper tht16-album-thumbs" aria-label="Ảnh thu nhỏ album">
            <div class="swiper-wrapper">
                @foreach($albumImages as $image)
                    <div class="swiper-slide"><img src="{{ $image }}" alt="" loading="lazy"></div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- RSVP / INVITE RESPONSE --}}
    <section class="tht16-paper tht16-rsvp" id="rsvp" data-aos="fade-up">
        <x-wedding.rsvp-form :wedding="$wedding" />
    </section>

    {{-- COUNTDOWN --}}
    @if($wedding->event_date)
    <section class="tht16-paper tht16-countdown" x-data="countdown('{{ $wedding->event_date->format('Y-m-d H:i:s') }}')">
        <h2 class="tht16-countdown__title" data-aos="fade-up">Countdown</h2>
        <div class="tht16-countdown-grid" data-aos="fade-up">
            <div class="tht16-countdown-box"><span class="tht16-countdown-number" x-text="days">00</span><span class="tht16-countdown-label">Ngày</span></div>
            <div class="tht16-countdown-box"><span class="tht16-countdown-number" x-text="hours">00</span><span class="tht16-countdown-label">Giờ</span></div>
            <div class="tht16-countdown-box"><span class="tht16-countdown-number" x-text="minutes">00</span><span class="tht16-countdown-label">Phút</span></div>
            <div class="tht16-countdown-box"><span class="tht16-countdown-number" x-text="seconds">00</span><span class="tht16-countdown-label">Giây</span></div>
        </div>
    </section>
    @endif

    {{-- THANK YOU --}}
    <footer class="tht16-thankyou">
        <img class="tht16-thankyou__bg" src="{{ $thankYouImage }}" alt="">
        <div class="tht16-thankyou__shade"></div>
        <div class="tht16-thankyou__content" data-aos="zoom-in">
            <p class="tht16-thankyou__title">Thank You</p>
            <p class="tht16-thankyou__names">{{ $sideData->firstName }} &amp; {{ $sideData->secondName }}</p>
            <p class="tht16-thankyou__date">{{ $wedding->event_date->format('d.m.Y') }}</p>
        </div>
        <p class="tht16-credit">THT E-Wedding · Made with love</p>
    </footer>
</main>

@push('scripts')
<x-wedding.countdown-script />
<script>
document.addEventListener('DOMContentLoaded', function () {
    const thumbsElement = document.querySelector('.tht16-album-thumbs');
    const mainElement = document.querySelector('.tht16-album-main');

    if (!window.Swiper || !thumbsElement || !mainElement) return;

    const thumbs = new window.Swiper(thumbsElement, {
        spaceBetween: 8,
        slidesPerView: 4.25,
        freeMode: true,
        watchSlidesProgress: true,
    });

    new window.Swiper(mainElement, {
        loop: {{ $albumImages->count() > 1 ? 'true' : 'false' }},
        speed: 700,
        spaceBetween: 10,
        autoplay: {{ $albumImages->count() > 1 ? "{ delay: 4200, disableOnInteraction: false }" : 'false' }},
        navigation: {
            nextEl: mainElement.querySelector('.swiper-button-next'),
            prevEl: mainElement.querySelector('.swiper-button-prev'),
        },
        thumbs: { swiper: thumbs },
    });
});
</script>
@endpush
@endsection
