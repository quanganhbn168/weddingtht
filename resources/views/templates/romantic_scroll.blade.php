@extends('layouts.app')
{{-- Template Name: Romantic Scroll --}}
{{-- Type: wedding --}}

@section('title', 'Lễ Cưới ' . $wedding->groom_name . ' & ' . $wedding->bride_name)
@section('og_image', $shareUrl)

@section('content')

<style>
@import url('https://fonts.googleapis.com/css2?family=Great+Vibes&family=Oswald:wght@400;500;600&family=Philosopher:ital,wght@0,400;0,700;1,400&family=Quicksand:wght@300;400;500;600;700&display=swap');

@font-face {
    font-family: 'utm-viceroyjf';
    src: url('{{ asset('fonts/utm-viceroyjf.ttf') }}') format('truetype');
}
@font-face {
    font-family: 'FZ-PHOTOGRAPH';
    src: url('{{ asset('fonts/FZ-PHOTOGRAPH.TTF') }}') format('truetype');
    font-weight: normal;
    font-style: normal;
}
@font-face {
    font-family: 'VNI-HLThuphap';
    src: url('{{ asset('fonts/VNI-HLThuphap.ttf') }}') format('truetype');
    font-weight: normal;
    font-style: normal;
}

:root {
    --blue:     #4a7fa5;
    --blue-lt:  #d4e8f5;
    --blue-dk:  #2c5f7e;
    --navy:     #1e3a4f;
    --cream:    #f8fbfe;
    --script:   'utm-viceroyjf', cursive;
    --photo:    'FZ-PHOTOGRAPH', cursive;
    --phil:     'Philosopher', serif;
    --body:     'Quicksand', sans-serif;
}

* { box-sizing: border-box; }
body { font-family: var(--body); background: var(--cream); color: var(--navy); overflow-x: hidden; }

/* ── Fonts ── */
.font-script { font-family: var(--script); }

/* ── Reveal ── */
.reveal { opacity: 0; transform: translateY(24px); transition: all .85s cubic-bezier(.4,0,.2,1); }
.reveal.on { opacity: 1; transform: none; }

/* ── Divider ── */
.divider {
    display: flex; align-items: center; gap: 10px; justify-content: center;
    margin: 0 auto;
}
.divider::before, .divider::after {
    content: ''; flex: 1; max-width: 80px; height: 1px;
    background: linear-gradient(to right, transparent, var(--blue), transparent);
}

/* ── Hero ── */
.hero-wrap { position: relative; height: 100dvh; min-height: 580px; overflow: hidden; }
.hero-bg   { position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover; }
.hero-ovl  { position: absolute; inset: 0; background: linear-gradient(to bottom, rgba(0,0,0,.25) 0%, rgba(0,0,0,.5) 100%); }
.hero-names {
    position: absolute; top: 36px; left: 0; right: 0; text-align: center; z-index: 10;
    text-shadow: 0 2px 16px rgba(0,0,0,.35); padding: 0 12px;
}
.hero-info {
    position: absolute; bottom: 48px; right: 16px; z-index: 10;
    text-align: right; color: #fff; max-width: 180px;
}
.hero-info .tag { font-family: var(--phil); font-size: 11px; font-weight: 700; letter-spacing: .12em; text-transform: uppercase; color: rgba(255,255,255,.85); margin-bottom: 6px; }
.hero-info .line { width: 48px; height: 1px; background: rgba(255,255,255,.6); margin-left: auto; margin-bottom: 8px; }
.hero-info .time { font-family: var(--phil); font-size: 1.3rem; font-weight: 700; color: #fff; line-height: 1.3; }
.hero-info .label { font-family: var(--phil); font-size: 10px; font-weight: 700; letter-spacing: .12em; text-transform: uppercase; color: rgba(255,255,255,.75); margin: 5px 0 2px; }
.hero-info .date  { font-family: var(--phil); font-size: 1rem; font-weight: 700; color: rgba(255,255,255,.95); letter-spacing: .08em; }
.hero-info .lunar { font-size: 9.5px; color: rgba(255,255,255,.55); margin-top: 2px; }

/* ── Quote ── */
.quote-wrap {
    background: #fff;
    padding: 36px 28px; text-align: center;
}
.quote-text { font-family: 'Great Vibes', cursive; font-size: 1.8rem; color: var(--blue-dk); line-height: 1.7; }

/* ── Couple ── */
.couple-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }
.person { text-align: center; }
.person img { width: 100%; aspect-ratio: 3/4; object-fit: cover; object-position: top; display: block; }
.person-role { font-family: 'Oswald', sans-serif; font-size: 11px; font-weight: 500; letter-spacing: .2em; text-transform: uppercase; color: var(--blue); margin: 10px 0 2px; }
.person-name { font-family: var(--photo); font-size: 1.6rem; color: var(--navy); margin-bottom: 4px; }
.person-side { font-family: 'Oswald', sans-serif; font-size: 11px; font-weight: 700; letter-spacing: .15em; text-transform: uppercase; color: var(--blue-dk); margin-bottom: 3px; }
.person-addr { font-family: 'Oswald', sans-serif; font-size: 11px; color: #7a9ab5; line-height: 1.5; }

/* ── Invite banner ── */
.invite-banner {
    background: #fff;
    padding: 40px 24px; text-align: center; position: relative;
}
.invite-banner::before {
    content: ''; position: absolute; top: 0; left: 50%; transform: translateX(-50%);
    width: 80px; height: 1px; background: var(--blue-lt);
}

/* ── 3 Portrait Photos ── */
.trio-grid { display: grid; grid-template-columns: 1fr 1.35fr 1fr; gap: 8px; align-items: flex-end; }
.trio-grid img { width: 100%; object-fit: cover; border-radius: 12px; display: block; box-shadow: 0 4px 16px rgba(0,0,0,.1); }
.trio-grid .mid { aspect-ratio: 3/4; }
.trio-grid .side { aspect-ratio: 3/5; }

/* ── Event cards ── */
.events-grid { display: grid; grid-template-columns: 1fr; gap: 12px; }
.ev-card { background: #ddedf8; border: 1.5px dashed var(--blue); border-radius: 16px; padding: 16px 12px; text-align: center; }
.ev-card h3 { font-family: 'Philosopher', serif; font-size: 12px; font-weight: 700; letter-spacing: .12em; text-transform: uppercase; color: var(--blue-dk); margin-bottom: 8px; }
.ev-day { font-family: 'Philosopher', serif; font-size: 12px; font-weight: 700; color: var(--navy); margin-bottom: 2px; }
.ev-date { font-family: 'Philosopher', serif; font-size: 18px; font-weight: 800; letter-spacing: .1em; color: var(--navy); margin-bottom: 2px; }
.ev-lunar { font-family: 'Philosopher', serif; font-size: 9.5px; color: #6a8fa8; margin-bottom: 10px; }
.ev-venue { font-family: 'Philosopher', serif; font-size: 12px; font-weight: 700; color: var(--navy); margin-bottom: 2px; }
.ev-addr { font-size: 10px; color: #6a8fa8; line-height: 1.5; margin-bottom: 10px; }
.btn-outline { display: block; width: 100%; border: 1.5px solid var(--blue-dk); background: rgba(255,255,255,.6); color: var(--blue-dk); font-size: 10px; font-weight: 700; letter-spacing: .12em; text-transform: uppercase; padding: 8px 12px; border-radius: 6px; cursor: pointer; margin-bottom: 6px; font-family: 'Philosopher', serif; }
.btn-solid { display: block; width: 100%; background: var(--navy); color: #fff; font-size: 10px; font-weight: 700; letter-spacing: .12em; text-transform: uppercase; padding: 8px 12px; border-radius: 6px; border: none; cursor: pointer; margin-bottom: 4px; font-family: 'Philosopher', serif; }
.w-full { width: 100%; }

/* ── Lễ section ── */
.ceremony-row { display: grid; grid-template-columns: 1fr; gap: 12px; }
.cer-box { border-radius: 14px; padding: 16px 12px; }
.cer-box h4 { font-family: 'Philosopher', serif; font-size: 14px; font-weight: 700; letter-spacing: .14em; text-transform: uppercase; color: var(--blue); margin-bottom: 8px; }
.cer-time { font-family: 'Philosopher', serif; font-size: 13px; font-weight: 700; color: var(--navy); margin-bottom: 2px; }
.cer-date-num { font-family: 'VNI-HLThuphap', cursive; font-size: 4rem; font-weight: normal; color: var(--blue-dk); line-height: 1; margin: 4px 0; }
.cer-month-year { font-family: 'Philosopher', serif; display: flex; align-items: center; gap: 6px; justify-content: center; font-size: 15px; font-weight: 700; color: var(--navy); margin-bottom: 4px; }
.cer-month-year .sep { width: 1px; height: 20px; background: var(--blue-lt); }
.cer-lunar { font-family: 'Philosopher', serif; font-size: 11px; color: #8aa8bf; }

/* ── Save the Date ── */
.save-section { background: linear-gradient(135deg, #eaf4fb 0%, #f8fbfe 100%); padding: 36px 24px 28px; text-align: center; }

/* ── Calendar ── */
.cal-table { width: 100%; border-collapse: separate; border-spacing: 0; }
.cal-table thead th {
    font-family: var(--phil); font-size: 12px; font-weight: 700;
    color: var(--blue-dk); text-align: center; padding: 8px 4px;
    border-bottom: 2px solid var(--blue-lt);
}
.cal-table tbody td {
    text-align: center; padding: 10px 4px;
    font-size: 13px; font-weight: 600; color: var(--navy);
    vertical-align: middle; position: relative;
}
.cal-table tbody tr:last-child td { border-bottom: 2px solid var(--blue-lt); }
.cal-empty { color: transparent; }
.cal-wed {
    position: relative;
}
.cal-wed-inner {
    display: inline-flex; align-items: center; justify-content: center;
    width: 36px; height: 36px; position: relative;
}
.cal-wed-inner .heart-svg { width: 36px; height: 36px; }
.cal-wed-inner .day-num {
    position: absolute; top: 50%; left: 50%; transform: translate(-50%,-52%);
    font-size: 12px; font-weight: 800; color: #fff;
    line-height: 1;
}

/* ── Location ── */
.location-arch {
    background: #c5daf0; margin: 0 16px;
    border-radius: 50% 50% 12px 12px / 120px 120px 12px 12px;
    padding: 56px 24px 32px; text-align: center;
}
.loc-item { display: flex; align-items: flex-start; gap: 10px; text-align: left; margin-bottom: 14px; }
.loc-item svg { flex-shrink: 0; margin-top: 3px; }
.loc-item h4 { font-family: 'Philosopher', serif; font-size: 14px; font-weight: 700; color: var(--navy); margin-bottom: 2px; }
.loc-item p  { font-size: 11px; color: #5a7fa0; line-height: 1.5; }
.loc-divider { height: 1px; background: rgba(44,95,126,.25); margin: 12px 0; }
.btn-dir { display: inline-block; border: 1.5px solid var(--blue-dk); color: var(--blue-dk); font-family: 'Philosopher', serif; font-size: 10px; font-weight: 700; letter-spacing: .08em; text-transform: uppercase; padding: 5px 14px; border-radius: 50px; text-decoration: none; white-space: nowrap; background: rgba(255,255,255,.7); }

/* ── Gallery Masonry ── */
.gallery-masonry { columns: 2; column-gap: 4px; }
.gal-item { display: block; overflow: hidden; margin-bottom: 4px; break-inside: avoid; }
.gal-item img { width: 100%; height: auto; display: block; transition: transform .4s ease; }
.gal-item:hover img { transform: scale(1.05); }

/* ── Guestbook ── */
.gb-grid { display: grid; grid-template-columns: 1fr; gap: 16px; }
@media(min-width: 560px) { .gb-grid { grid-template-columns: 1fr 1fr; } }

/* ── Global mobile tweaks ── */
@media (max-width: 479px) {
    /* Hero: scale down names */
    .hero-names { top: 24px; }
    .hero-names > div { font-size: 2rem !important; }
    .hero-info { right: 10px; bottom: 36px; max-width: 160px; }
    .hero-info .time { font-size: 1rem; }
    .hero-info .date { font-size: 0.8rem; }

    /* Quote */
    .quote-wrap { padding: 24px 16px; }
    .quote-text { font-size: 1.5rem; }

    /* Couple section */
    .couple-grid { gap: 8px; }
    .person-name { font-size: 1.2rem; }
    .person-addr { font-size: 10px; }

    /* Invite banner */
    .invite-banner { padding: 28px 16px; }

    /* Ceremony */
    .cer-date-num { font-size: 3rem; }

    /* Calendar: scrollable */
    .save-section { padding: 24px 12px; }
    .cal-table { font-size: 11px; }
    .cal-table thead th { font-size: 10px; padding: 6px 2px; }
    .cal-table tbody td { padding: 7px 2px; font-size: 11px; }
    .cal-wed-inner { width: 28px; height: 28px; }
    .cal-wed-inner .heart-svg { width: 28px; height: 28px; }

    /* Location */
    .location-arch { margin: 0 10px; padding: 24px 14px 20px; }
    .loc-item { flex-wrap: wrap; gap: 6px; }
    .btn-dir  { display: block; width: 100%; text-align: center; margin-top: 4px; }

    /* Countdown */
    .cnt-num { font-size: 1.4rem; }
    .cnt-box { padding: 8px 4px; }
    .cnt-lbl { font-size: 8px; }

    /* Guestbook */
    .gb-grid { grid-template-columns: 1fr; }
}
.ty-wrap { position: relative; min-height: 380px; display: flex; align-items: center; justify-content: center; overflow: hidden; }
.ty-bg  { position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover; }
.ty-ovl { position: absolute; inset: 0; background: rgba(0,0,0,.55); }
.ty-txt { position: relative; z-index: 10; text-align: center; padding: 40px 24px; color: #fff; }

/* ── Scroll arrow ── */
@keyframes bounce { 0%,100%{transform:translateX(-50%) translateY(0)} 50%{transform:translateX(-50%) translateY(8px)} }
.scroll-arrow { position: absolute; bottom: 64px; left: 50%; transform: translateX(-50%); z-index: 10; animation: bounce 2s ease-in-out infinite; }

/* ── Countdown ── */
.countdown-grid { display: grid; grid-template-columns: repeat(4,1fr); gap: 8px; }
.cnt-box { background: #fff; border-radius: 12px; padding: 12px 6px; text-align: center; box-shadow: 0 4px 14px rgba(74,127,165,.1); border: 1px solid var(--blue-lt); }
.cnt-num { font-size: 1.8rem; font-weight: 700; color: var(--blue-dk); }
.cnt-lbl { font-size: 9px; font-weight: 700; letter-spacing: .12em; text-transform: uppercase; color: #8aa8bf; margin-top: 2px; }
</style>

<div class="max-w-[480px] mx-auto min-h-screen shadow-2xl" style="background: var(--cream);">

    {{-- Pro Features --}}
    @include('components.wedding.falling-effects', ['wedding' => $wedding])
    <x-wedding.music-player :wedding="$wedding" />

    {{-- ══════════════════════════════════════════ --}}
    {{-- HERO                                        --}}
    {{-- ══════════════════════════════════════════ --}}
    <section class="hero-wrap">
        <img class="hero-bg" src="{{ $heroUrl }}" alt="Hero">
        <div class="hero-ovl"></div>

        {{-- Tên trên chính giữa --}}
        <div class="hero-names">
            <div style="font-family:var(--photo); font-size:clamp(1.8rem,7vw,3rem); color:#fff; line-height:1.15; text-shadow:0 2px 20px rgba(0,0,0,.4);">
                {{ $wedding->groom_name }}&nbsp;<span style="font-family:var(--script); font-size:2rem; opacity:.8;">&amp;</span>&nbsp;{{ $wedding->bride_name }}
            </div>
        </div>

        {{-- Info góc dưới phải --}}
        <div class="hero-info">
            <p class="tag">Thư Mời Tiệc Cưới</p>
            <div class="line"></div>
            @if($groomCeremonyTime)
            <p class="time">{{ $dayOfWeek }} - {{ $groomCeremonyTime }}</p>
            @endif
            <p class="label">Lễ Thành Hôn</p>
            <p class="date">{{ $solar->format('d . m . Y') }}</p>
            @if($lunarStr)<p class="lunar">({{ $lunarStr }})</p>@endif
            @if($groomReceptionTime)
            <div class="line" style="margin:8px 0;opacity:.5;"></div>
            <p class="time">{{ $groomReceptionDow }} - {{ $groomReceptionTime }}</p>
            <p class="label">Tiệc Cưới</p>
            @if($groomReceptionCarbon->format('d.m.Y') !== $solar->format('d.m.Y'))
            <p class="date">{{ $groomReceptionCarbon->format('d . m . Y') }}</p>
            @endif
            @endif
        </div>

        {{-- Scroll hint --}}
        <div class="scroll-arrow">
            <svg width="24" height="24" fill="none" stroke="rgba(255,255,255,.7)" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19 14l-7 7m0 0l-7-7m7 7V3"/>
            </svg>
        </div>
    </section>

    {{-- ══════════════════════════════════════════ --}}
    {{-- QUOTE                                       --}}
    {{-- ══════════════════════════════════════════ --}}
    <section class="quote-wrap reveal" data-aos="fade-up">
        <div class="divider" style="margin-bottom:18px;"></div>
        <p class="quote-text">"Hôn nhân là chuyện cả đời,<br>Yêu người vừa ý, cưới người mình thương"</p>
        <div class="divider" style="margin-top:18px;"></div>
    </section>

    {{-- ══════════════════════════════════════════ --}}
    {{-- CÔ DÂU & CHÚ RỂ                           --}}
    {{-- ══════════════════════════════════════════ --}}
    <section class="reveal" style="padding: 32px 20px 40px; background:#fff;" data-aos="fade-up">

        <div class="couple-grid">
            <div class="person">
                <img src="{{ $groomPhoto }}" alt="{{ $wedding->groom_name }}">
                <p class="person-role">Chú Rể</p>
                <p class="person-name">{{ $wedding->groom_name }}</p>
                <p class="person-side">Nhà Trai</p>
                @if($wedding->groom_address)<p class="person-addr">{{ $wedding->groom_address }}</p>@endif
                @if($wedding->groom_father)<p class="person-addr" style="margin-top:4px;">Con ông: <strong>{{ $wedding->groom_father }}</strong></p>@endif
                @if($wedding->groom_mother)<p class="person-addr">Con bà: <strong>{{ $wedding->groom_mother }}</strong></p>@endif
            </div>
            <div class="person">
                <img src="{{ $bridePhoto }}" alt="{{ $wedding->bride_name }}">
                <p class="person-role">Cô Dâu</p>
                <p class="person-name">{{ $wedding->bride_name }}</p>
                <p class="person-side">Nhà Gái</p>
                @if($wedding->bride_address)<p class="person-addr">{{ $wedding->bride_address }}</p>@endif
                @if($wedding->bride_father)<p class="person-addr" style="margin-top:4px;">Con ông: <strong>{{ $wedding->bride_father }}</strong></p>@endif
                @if($wedding->bride_mother)<p class="person-addr">Con bà: <strong>{{ $wedding->bride_mother }}</strong></p>@endif
            </div>
        </div>
    </section>

    {{-- ══════════════════════════════════════════ --}}
    {{-- THƯ MỜI BANNER                             --}}
    {{-- ══════════════════════════════════════════ --}}
    <section class="invite-banner reveal" data-aos="fade-up">
        <div class="divider" style="margin-bottom:20px;"></div>
        <p class="font-script" style="font-size:clamp(2.2rem,8vw,3.5rem); color:var(--navy); margin-bottom:6px;">Thư Mời</p>
        <p style="font-family:'Great Vibes',cursive; font-size:clamp(1.4rem,5vw,2rem); color:var(--blue-dk); margin-bottom:14px;">Bạn và Người thương</p>
        <p style="font-family:'Philosopher',serif; font-size:clamp(10px,3vw,13px); font-weight:700; letter-spacing:.2em; text-transform:uppercase; color:var(--navy); margin-bottom:6px;">Tham Dự Lễ Cưới Của</p>
        <p style="font-family:var(--photo); font-size:clamp(1.4rem,6vw,2.2rem); color:var(--navy); line-height:1.3;">{{ $wedding->groom_name }} &amp; {{ $wedding->bride_name }}</p>
        <div class="divider" style="margin-top:20px;"></div>
    </section>

    {{-- ══════════════════════════════════════════ --}}
    {{-- 3 ẢNH DỌC                                 --}}
    {{-- ══════════════════════════════════════════ --}}
    <section class="reveal" style="padding: 32px 16px; background: #fff;">
        <div class="trio-grid">
            <img class="side" src="{{ $imgs[0] ?? $placeholders[0] }}" alt="photo">
            <img class="mid"  src="{{ $imgs[1] ?? $placeholders[1] }}" alt="photo">
            <img class="side" src="{{ $imgs[2] ?? $placeholders[2] }}" alt="photo">
        </div>
    </section>

    {{-- ══════════════════════════════════════════ --}}
    {{-- TIỆC CƯỚI NHÀ TRAI / NHÀ GÁI             --}}
    {{-- ══════════════════════════════════════════ --}}
    <section class="reveal" style="padding: 28px 16px 36px; background: #fff;" data-aos="fade-up">

        <div class="events-grid">
            {{-- Nhà trai --}}
            <div class="ev-card">
                <h3>TIỆC CƯỚI NHÀ TRAI</h3>
                <p class="ev-day">{{ $groomReceptionDow }} | {{ $groomReceptionTime ?? '18:00' }}</p>
                <p class="ev-date">{{ $groomReceptionCarbon->format('d . m . Y') }}</p>
                @if($lunarStr)<p class="ev-lunar">({{ $lunarStr }})</p>@endif
                @if($groomReceptionTime2)
                <p class="ev-day" style="margin-top:10px;padding-top:10px;border-top:1px dashed #dde8f0;">
                    {{ $groomReceptionDay2 ? $dowLabels[\Carbon\Carbon::parse($groomReceptionDay2)->dayOfWeek] : $dayOfWeek }} | {{ $groomReceptionTime2 }}
                </p>
                @if($groomReceptionDay2)<p class="ev-date">{{ \Carbon\Carbon::parse($groomReceptionDay2)->format('d . m . Y') }}</p>@endif
                @endif
                @if($wedding->groom_reception_venue)
                <p class="ev-venue">{{ $wedding->groom_reception_venue }}</p>
                @endif
                @if($wedding->groom_address)
                <p class="ev-addr">{{ $wedding->groom_address }}</p>
                @endif
                <button class="btn-outline w-full" onclick="openRsvp('Tiệc Nhà Trai')">XÁC NHẬN THAM DỰ</button>
                <button class="btn-solid w-full" onclick="window.location.href='#guestbook'">GỬI MỪNG CƯỚI</button>

                {{-- Countdown --}}
                @if($wedding->event_date && $wedding->event_date->isFuture())
                <div x-data="countdown('{{ $wedding->event_date->format('Y-m-d') }}')" class="countdown-grid" style="margin-top:14px;">
                    <div class="cnt-box"><div class="cnt-num" x-text="days">00</div><div class="cnt-lbl">Ngày</div></div>
                    <div class="cnt-box"><div class="cnt-num" x-text="hours">00</div><div class="cnt-lbl">Giờ</div></div>
                    <div class="cnt-box"><div class="cnt-num" x-text="minutes">00</div><div class="cnt-lbl">Phút</div></div>
                    <div class="cnt-box"><div class="cnt-num" x-text="seconds">00</div><div class="cnt-lbl">Giây</div></div>
                </div>
                @endif
            </div>

            {{-- Nhà gái --}}
            <div class="ev-card">
                <h3>TIỆC CƯỚI NHÀ GÁI</h3>
                <p class="ev-day">{{ $brideReceptionDow }} | {{ $brideReceptionTime ?? '18:00' }}</p>
                <p class="ev-date">{{ $brideReceptionCarbon->format('d . m . Y') }}</p>
                @if($lunarStr)<p class="ev-lunar">({{ $lunarStr }})</p>@endif
                @if($brideReceptionTime2)
                <p class="ev-day" style="margin-top:10px;padding-top:10px;border-top:1px dashed #dde8f0;">
                    {{ $brideReceptionDay2 ? $dowLabels[\Carbon\Carbon::parse($brideReceptionDay2)->dayOfWeek] : $dayOfWeek }} | {{ $brideReceptionTime2 }}
                </p>
                @if($brideReceptionDay2)<p class="ev-date">{{ \Carbon\Carbon::parse($brideReceptionDay2)->format('d . m . Y') }}</p>@endif
                @endif
                @if($wedding->bride_reception_venue)
                <p class="ev-venue">{{ $wedding->bride_reception_venue }}</p>
                @endif
                @if($wedding->bride_address)
                <p class="ev-addr">{{ $wedding->bride_address }}</p>
                @endif
                <button class="btn-outline w-full" onclick="openRsvp('Tiệc Nhà Gái')">XÁC NHẬN THAM DỰ</button>
                <button class="btn-solid w-full" onclick="window.location.href='#guestbook'">GỬI MỪNG CƯỚI</button>

                {{-- Countdown --}}
                @if($wedding->event_date && $wedding->event_date->isFuture())
                <div x-data="countdown('{{ $wedding->event_date->format('Y-m-d') }}')" class="countdown-grid" style="margin-top:14px;">
                    <div class="cnt-box"><div class="cnt-num" x-text="days">00</div><div class="cnt-lbl">Ngày</div></div>
                    <div class="cnt-box"><div class="cnt-num" x-text="hours">00</div><div class="cnt-lbl">Giờ</div></div>
                    <div class="cnt-box"><div class="cnt-num" x-text="minutes">00</div><div class="cnt-lbl">Phút</div></div>
                    <div class="cnt-box"><div class="cnt-num" x-text="seconds">00</div><div class="cnt-lbl">Giây</div></div>
                </div>
                @endif
            </div>
        </div>
    </section>

    {{-- ══ RSVP MODAL ══ --}}
    <div id="rsvp-modal" x-data="rsvpModal()" x-show="open" x-cloak
         @open-rsvp.window="title=$event.detail.type; form.event_type=$event.detail.type; open=true;"
         style="position:fixed;inset:0;z-index:9999;display:flex;align-items:center;justify-content:center;padding:16px;"
         @click.self="close()">
        <div style="position:absolute;inset:0;background:rgba(0,0,0,.55);" @click="close()"></div>
        <div style="background:#fff;border-radius:16px;padding:24px 20px;max-width:360px;width:100%;position:relative;max-height:90vh;overflow-y:auto;">
            <button @click="close()" style="position:absolute;top:12px;right:14px;background:none;border:none;font-size:1.3rem;color:#aaa;cursor:pointer;">✕</button>
            <p style="font-family:'Philosopher',serif;font-size:10px;font-weight:700;letter-spacing:.2em;text-transform:uppercase;color:var(--blue);text-align:center;margin-bottom:4px;">XÁC NHẬN THAM DỰ</p>
            <p x-text="title" style="font-family:'Great Vibes',cursive;font-size:1.6rem;color:var(--navy);text-align:center;margin-bottom:20px;"></p>

            <div x-show="success" style="background:#f0fdf4;border:1px solid #86efac;border-radius:10px;padding:16px;text-align:center;margin-bottom:16px;">
                <p style="color:#16a34a;font-weight:700;">✅ Đã gửi thành công!</p>
                <p style="font-size:12px;color:#4ade80;margin-top:4px;">Cảm ơn bạn đã xác nhận.</p>
            </div>

            <form @submit.prevent="submit()" x-show="!success">
                <div style="margin-bottom:12px;">
                    <label style="font-size:11px;font-weight:700;color:var(--navy);display:block;margin-bottom:4px;">Họ và tên *</label>
                    <input x-model="form.name" type="text" required placeholder="Nhập tên của bạn"
                        style="width:100%;border:1.5px solid #d0e4f0;border-radius:8px;padding:9px 12px;font-size:14px;outline:none;font-family:inherit;">
                </div>
                <div style="margin-bottom:12px;">
                    <label style="font-size:11px;font-weight:700;color:var(--navy);display:block;margin-bottom:4px;">Số người tham dự</label>
                    <select x-model="form.guests" style="width:100%;border:1.5px solid #d0e4f0;border-radius:8px;padding:9px 12px;font-size:14px;outline:none;background:#fff;">
                        <option value="1">1 người</option>
                        <option value="2" selected>2 người</option>
                        <option value="3">3 người</option>
                        <option value="4">4 người</option>
                        <option value="5+">5+ người</option>
                    </select>
                </div>
                <div style="margin-bottom:20px;">
                    <label style="font-size:11px;font-weight:700;color:var(--navy);display:block;margin-bottom:8px;">Trạng thái</label>
                    <div style="display:flex;gap:8px;">
                        <label style="flex:1;border:1.5px solid #d0e4f0;border-radius:8px;padding:9px;text-align:center;cursor:pointer;font-size:13px;" :style="form.attendance==='yes' ? 'border-color:var(--blue);background:#eaf4fb;' : ''">
                            <input type="radio" x-model="form.attendance" value="yes" style="display:none;"> ✅ Sẽ đến
                        </label>
                        <label style="flex:1;border:1.5px solid #d0e4f0;border-radius:8px;padding:9px;text-align:center;cursor:pointer;font-size:13px;" :style="form.attendance==='no' ? 'border-color:#f87171;background:#fff5f5;' : ''">
                            <input type="radio" x-model="form.attendance" value="no" style="display:none;"> ❌ Không đến
                        </label>
                    </div>
                </div>
                <p x-show="error" x-text="error" style="color:#ef4444;font-size:12px;margin-bottom:10px;text-align:center;"></p>
                <button type="submit" class="btn-solid w-full" :disabled="submitting">
                    <span x-show="!submitting">GỬI XÁC NHẬN</span>
                    <span x-show="submitting">Đang gửi...</span>
                </button>
            </form>
        </div>
    </div>

    {{-- ══════════════════════════════════════════ --}}
    {{-- LỄ VU QUY / LỄ THÀNH HÔN                 --}}
    {{-- ══════════════════════════════════════════ --}}
    <section class="reveal" style="padding: 32px 16px; background: #fff;">
        <div class="divider" style="margin-bottom:20px;"><span style="color:var(--blue); font-size:.9rem;">✦</span></div>
        <div class="ceremony-row">
            {{-- Lễ Vu Quy --}}
            <div class="cer-box" style="text-align:center;">
                <h4>Lễ Vu Quy</h4>
                <p class="cer-time">Vào {{ $brideDow }}{{ $brideCeremonyTime ? ' - ' . $brideCeremonyTime : '' }}</p>
                <div class="cer-month-year" style="margin-top:8px;">
                    <span>Tháng {{ $brideCeremonyCarbon->format('n') }}</span>
                    <div class="sep"></div>
                    <span class="cer-date-num">{{ $brideCeremonyCarbon->format('j') }}</span>
                    <div class="sep"></div>
                    <span>{{ $brideCeremonyCarbon->format('Y') }}</span>
                </div>
                @if($lunarStr)<p class="cer-lunar">({{ $lunarStr }})</p>@endif
            </div>
            <div class="divider" style="margin: 12px 0;"><span style="color:var(--blue); font-size:.7rem;">✦</span></div>
            {{-- Lễ Thành Hôn --}}
            <div class="cer-box" style="text-align:center;">
                <h4>Lễ Thành Hôn</h4>
                <p class="cer-time">Vào {{ $groomDow }}{{ $groomCeremonyTime ? ' - ' . $groomCeremonyTime : '' }}</p>
                <div class="cer-month-year" style="margin-top:8px;">
                    <span>Tháng {{ $groomCeremonyCarbon->format('n') }}</span>
                    <div class="sep"></div>
                    <span class="cer-date-num">{{ $groomCeremonyCarbon->format('j') }}</span>
                    <div class="sep"></div>
                    <span>{{ $groomCeremonyCarbon->format('Y') }}</span>
                </div>
                @if($lunarStr)<p class="cer-lunar">({{ $lunarStr }})</p>@endif
            </div>
        </div>
        <div class="divider" style="margin-top:20px;"><span style="color:var(--blue); font-size:.9rem;">✦</span></div>
    </section>

    {{-- ══════════════════════════════════════════ --}}
    {{-- SAVE THE DATE + CALENDAR                   --}}
    {{-- ══════════════════════════════════════════ --}}
    <section class="save-section reveal">
        {{-- Save the date image --}}
        <img src="{{ asset('images/save-the-date.png') }}" alt="Save the Date"
             style="max-width:260px; width:100%; height:auto; margin: 0 auto 20px; display:block;">

        {{-- Calendar title --}}
        <p style="font-family:var(--phil); font-weight:700; font-size:16px; color:var(--navy); margin-bottom:16px;">Tháng {{ $solar->format('n') }} / {{ $solar->format('Y') }}</p>

        {{-- Calendar table --}}
        <div style="max-width:340px; margin:0 auto; overflow-x:auto;">
        <div style="min-width:280px; background:#fff; border-radius:16px; padding:16px 12px; border:1px solid var(--blue-lt); box-shadow:0 4px 16px rgba(74,127,165,.08);">
            <table class="cal-table">
                <thead>
                    <tr>
                        @foreach(['Thứ 2','Thứ 3','Thứ 4','Thứ 5','Thứ 6','Thứ 7','CN'] as $d)
                        <th>{{ $d }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                @php
                    // Week starts Monday (1=Mon...0=Sun → 6)
                    $monStart = ($firstOfMonth->dayOfWeek + 6) % 7;
                    $cells = array_merge(array_fill(0, $monStart, null), range(1, $daysInMonth));
                    $rows  = array_chunk(array_pad($cells, (int)ceil(count($cells)/7)*7, null), 7);
                @endphp
                @foreach($rows as $row)
                <tr>
                    @foreach($row as $d)
                    <td class="{{ $d === null ? 'cal-empty' : ($d === $eventDay ? 'cal-wed' : ($d === $eventDay2 ? 'cal-reception' : '')) }}">
                        @if($d === $eventDay)
                        <div class="cal-wed-inner">
                            <svg class="heart-svg" viewBox="0 0 90 90" fill="#c0392b" xmlns="http://www.w3.org/2000/svg">
                                <path d="M45 75 C45 75 10 50 10 28 C10 18 18 10 28 10 C34 10 40 13 45 18 C50 13 56 10 62 10 C72 10 80 18 80 28 C80 50 45 75 45 75Z"/>
                            </svg>
                            <span class="day-num">{{ $d }}</span>
                        </div>
                        @elseif($d === $eventDay2)
                        <div class="cal-wed-inner">
                            <svg class="heart-svg" viewBox="0 0 90 90" fill="#e91e8c" xmlns="http://www.w3.org/2000/svg">
                                <path d="M45 75 C45 75 10 50 10 28 C10 18 18 10 28 10 C34 10 40 13 45 18 C50 13 56 10 62 10 C72 10 80 18 80 28 C80 50 45 75 45 75Z"/>
                            </svg>
                            <span class="day-num">{{ $d }}</span>
                        </div>
                        @elseif($d !== null)
                        {{ $d }}
                        @endif
                    </td>
                    @endforeach
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        </div>
    </section>

    {{-- ══════════════════════════════════════════ --}}
    {{-- ĐỊA ĐIỂM TỔ CHỨC                          --}}
    {{-- ══════════════════════════════════════════ --}}
    <section class="reveal" style="padding: 32px 0 40px;">
        <div class="location-arch">
            {{-- Heart icon top --}}
            <div style="font-size:1.6rem; margin-bottom:10px;">❤️</div>

            {{-- Title --}}
            <p style="font-family:'Great Vibes',cursive; font-size:2rem; color:var(--navy); margin-bottom:20px;">Địa điểm tổ chức</p>

            {{-- Nhà Trai --}}
            <div class="loc-item">
                <svg width="18" height="18" fill="var(--blue-dk)" viewBox="0 0 24 24" style="flex-shrink:0; margin-top:2px;"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/></svg>
                <div style="flex:1; text-align:left;">
                    <h4>Nhà Trai</h4>
                    @if($wedding->groom_reception_venue)<p>{{ $wedding->groom_reception_venue }}</p>@endif
                    @if($wedding->groom_address)<p>{{ $wedding->groom_address }}</p>@endif
                </div>
                @php $groomMapUrl = $wedding->groom_map_url ?: ('https://maps.google.com/?q='.urlencode(trim(($wedding->groom_reception_venue ?? '').' '.($wedding->groom_address ?? '')))); @endphp
                <a href="{{ $groomMapUrl }}" target="_blank" class="btn-dir" style="flex-shrink:0;">Xem Chỉ Đường</a>
            </div>

            <div class="loc-divider"></div>

            {{-- Nhà Gái --}}
            <div class="loc-item">
                <svg width="18" height="18" fill="var(--blue-dk)" viewBox="0 0 24 24" style="flex-shrink:0; margin-top:2px;"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/></svg>
                <div style="flex:1; text-align:left;">
                    <h4>Nhà Gái</h4>
                    @if($wedding->bride_reception_venue)<p>{{ $wedding->bride_reception_venue }}</p>@endif
                    @if($wedding->bride_address)<p>{{ $wedding->bride_address }}</p>@endif
                </div>
                @php $brideMapUrl = $wedding->bride_map_url ?: ('https://maps.google.com/?q='.urlencode(trim(($wedding->bride_reception_venue ?? '').' '.($wedding->bride_address ?? '')))); @endphp
                <a href="{{ $brideMapUrl }}" target="_blank" class="btn-dir" style="flex-shrink:0;">Xem Chỉ Đường</a>
            </div>

            <div style="height:1px; background:rgba(74,127,165,.2); margin:16px 0;"></div>

            {{-- Couple names --}}
            <p style="font-family:var(--photo); font-size:1.5rem; color:var(--navy); margin-bottom:16px;">{{ $wedding->groom_name }} <span style="color:#c0392b; font-size:1rem;">♥</span> {{ $wedding->bride_name }}</p>

            {{-- CTA button --}}
            <button onclick="document.getElementById('guestbook').scrollIntoView({behavior:'smooth'})"
                class="btn-outline" style="max-width:240px; margin:0 auto; display:block;">
                Gửi Lời Chúc Mừng Cưới
            </button>
        </div>
    </section>

    {{-- ══════════════════════════════════════════ --}}
    {{-- ALBUM ẢNH CƯỚI                            --}}
    {{-- ══════════════════════════════════════════ --}}
    <section class="reveal" style="padding: 36px 16px; background:#fff;">
        <div style="display:flex; align-items:center; gap:10px; margin-bottom:20px;">
            <p style="font-family:'Great Vibes',cursive; font-size:2.4rem; color:var(--navy); white-space:nowrap; line-height:1;">Album ảnh cưới</p>
            <span style="color:var(--navy); font-size:1rem; flex-shrink:0;">♥</span>
            <div style="flex:1; height:1px; background: linear-gradient(to right, var(--blue-dk), var(--blue-lt), transparent);"></div>
        </div>

        {{-- Gallery Masonry --}}
        <div class="gallery-masonry">
            @if($galleryImages->isNotEmpty())
                @foreach($galleryImages as $m)
                <a href="{{ $m->getUrl() }}" class="gal-item glightbox" data-gallery="wedding-album" data-description="">
                    <img src="{{ $m->getUrl('thumb') ?: $m->getUrl() }}" alt="ảnh cưới" loading="lazy">
                </a>
                @endforeach
            @else
                @foreach($placeholders as $ph)
                <a href="{{ $ph }}" class="gal-item glightbox" data-gallery="wedding-album">
                    <img src="{{ $ph }}" alt="ảnh cưới" loading="lazy">
                </a>
                @endforeach
            @endif
        </div>
    </section>

    <div id="guestbook" class="reveal" style="position:relative; overflow:hidden; min-height:520px;">
        {{-- Background: hero image --}}
        <img src="{{ $shareUrl }}" alt="" style="position:absolute; inset:0; width:100%; height:100%; object-fit:cover; object-position:center;">
        <div style="position:absolute; inset:0; background:rgba(15,30,50,.62);"></div>

        {{-- Content --}}
        <div style="position:relative; z-index:2; padding:40px 20px 48px;">
            {{-- Header --}}
            <p style="font-family:'Great Vibes',cursive; font-size:2.8rem; color:#fff; text-align:center; line-height:1.2; margin-bottom:6px; text-shadow:0 2px 12px rgba(0,0,0,.4);">Gửi lời chúc mừng cưới!</p>
            <p style="font-family:'Philosopher',serif; font-size:13px; color:rgba(255,255,255,.8); text-align:center; margin-bottom:28px; text-shadow:0 1px 6px rgba(0,0,0,.3);">Cảm ơn bạn vì những lời chúc tốt đẹp!</p>

            {{-- Inline guestbook form --}}
            @php $wishes = $wedding->approvedWishes()->latest()->take(20)->get(); @endphp

            <div x-data="{
                name: '',
                message: '',
                submitting: false,
                success: false,
                error: null,
                async submit() {
                    this.submitting = true; this.error = null;
                    try {
                        const res = await fetch('{{ route('wedding.wish.store', $wedding->slug) }}', {
                            method:'POST',
                            headers:{'Content-Type':'application/json','X-CSRF-TOKEN':document.querySelector('meta[name=csrf-token]').content,'Accept':'application/json'},
                            body: JSON.stringify({name: this.name, message: this.message})
                        });
                        if(res.ok){ this.success=true; this.name=''; this.message=''; setTimeout(()=>this.success=false,4000); }
                        else { const d=await res.json(); this.error=d.message||'Có lỗi xảy ra.'; }
                    } catch(e){ this.error='Lỗi kết nối.'; }
                    finally { this.submitting=false; }
                }
            }">
                {{-- Success --}}
                <div x-show="success" style="background:rgba(255,255,255,.9);border-radius:12px;padding:16px;text-align:center;margin-bottom:16px;color:#16a34a;font-weight:700;">
                    ✅ Đã gửi lời chúc thành công!
                </div>

                {{-- Form --}}
                <form @submit.prevent="submit()" x-show="!success">
                    <input x-model="name" type="text" required placeholder="Tên của bạn *"
                        style="width:100%;background:rgba(255,255,255,.9);border:none;border-radius:10px;padding:12px 16px;font-size:14px;font-family:inherit;outline:none;margin-bottom:10px;box-sizing:border-box;">
                    <textarea x-model="message" required placeholder="Lời chúc của bạn *" rows="4"
                        style="width:100%;background:rgba(255,255,255,.9);border:none;border-radius:10px;padding:12px 16px;font-size:14px;font-family:inherit;outline:none;resize:none;margin-bottom:10px;box-sizing:border-box;"></textarea>
                    <p x-show="error" x-text="error" style="color:#fca5a5;font-size:12px;margin-bottom:8px;"></p>
                    <button type="submit" :disabled="submitting"
                        style="width:100%;background:#2e9e6b;color:#fff;border:none;border-radius:10px;padding:13px;font-size:14px;font-weight:700;font-family:'Philosopher',serif;cursor:pointer;letter-spacing:.05em;">
                        <span x-show="!submitting">Gửi lời chúc</span>
                        <span x-show="submitting">Đang gửi...</span>
                    </button>
                </form>
            </div>

            {{-- Messages list --}}
            @if($wishes->count() > 0)
            <div style="margin-top:20px;">
                @foreach($wishes as $wish)
                <div style="background:rgba(255,255,255,.92);border-radius:12px;padding:14px 16px;margin-bottom:10px;">
                    <p style="font-weight:700;font-size:13px;color:#1e3a4f;margin-bottom:4px;">{{ $wish->name }}</p>
                    <p style="font-size:13px;color:#4a5568;line-height:1.6;">{{ $wish->message }}</p>
                </div>
                @endforeach
            </div>
            @endif
        </div>
    </div>

    {{-- Gift box --}}
    <div class="reveal" style="padding: 32px 16px; background:#fff;">
        <x-wedding.gift-box :wedding="$wedding">
            <div style="background: #f0f8ff; border-radius:20px; padding:28px 20px; text-align:center; border:1.5px dashed var(--blue-lt);">
                <p class="font-script" style="font-size:2rem; color:var(--navy); margin-bottom:14px;">Hộp Mừng Cưới</p>
                <div style="display:flex; gap:12px; justify-content:center;">
                    <button @click="showQr='groom'" class="btn-solid" style="max-width:120px; display:inline-block; margin:0;">Nhà Trai</button>
                    <button @click="showQr='bride'"  class="btn-solid" style="max-width:120px; display:inline-block; margin:0;">Nhà Gái</button>
                </div>
            </div>
        </x-wedding.gift-box>
    </div>

    {{-- ══════════════════════════════════════════ --}}
    {{-- THANK YOU                                  --}}
    {{-- ══════════════════════════════════════════ --}}
    <section class="ty-wrap">
        <img class="ty-bg" src="{{ $heroUrl }}" alt="thank you">
        <div class="ty-ovl"></div>
        <div class="ty-txt">
            <p style="font-family:var(--phil); font-size:11px; font-weight:700; letter-spacing:.3em; text-transform:uppercase; color:rgba(255,255,255,.7); margin-bottom:14px;">Thank You</p>
        <div class="divider" style="margin-bottom:20px;"></div>
            <h2 class="font-script" style="font-size:2.4rem; color:#fff; line-height:1.4; margin-bottom:14px;">Rất hân hạnh<br>được đón tiếp</h2>
            <p style="font-size:13px; color:rgba(255,255,255,.8); line-height:1.8; margin-bottom:18px;">Sự hiện diện của bạn là<br>món quà quý giá nhất với chúng tôi.</p>
            <p class="font-script" style="font-size:2.2rem; color:rgba(255,255,255,.95);">{{ $wedding->groom_name }} &amp; {{ $wedding->bride_name }}</p>
            <p style="font-size:11px; color:rgba(255,255,255,.5); margin-top:8px; letter-spacing:.2em;">{{ $solar->format('d . m . Y') }}</p>
            <div style="font-size:1.5rem; margin-top:14px; animation: heartbeat 2s ease-in-out infinite;">❤️</div>
            <style>@keyframes heartbeat{0%,100%{transform:scale(1)}50%{transform:scale(1.2)}}</style>
        </div>
    </section>

</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const io = new IntersectionObserver(entries => {
        entries.forEach(e => { if (e.isIntersecting) { e.target.classList.add('on'); io.unobserve(e.target); } });
    }, { threshold: .1 });
    document.querySelectorAll('.reveal').forEach(el => io.observe(el));

    if (typeof GLightbox !== 'undefined') {
        GLightbox({ selector: '.glightbox', touchNavigation: true, loop: true, autoplayVideos: false });
    }
});

function openRsvp(eventType) {
    window.dispatchEvent(
        new CustomEvent('open-rsvp', { detail: { type: eventType } })
    );
    document.body.style.overflow = 'hidden';
}

function rsvpModal() {
    return {
        open: false,
        title: '',
        submitting: false,
        success: false,
        error: null,
        form: { name: '', guests: '2', attendance: 'yes', event_type: '' },
        close() { this.open = false; document.body.style.overflow = ''; },
        async submit() {
            this.submitting = true; this.error = null;
            try {
                const res = await fetch('{{ route('wedding.rsvp.store', $wedding->slug) }}', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content, 'Accept': 'application/json' },
                    body: JSON.stringify(this.form)
                });
                if (res.ok) { this.success = true; setTimeout(() => this.close(), 3000); }
                else { const d = await res.json(); this.error = d.message || 'Có lỗi xảy ra.'; }
            } catch(e) { this.error = 'Lỗi kết nối.'; }
            finally { this.submitting = false; }
        }
    };
}
</script>

@push('scripts')
    <x-wedding.countdown-script />
@endpush
@endsection

