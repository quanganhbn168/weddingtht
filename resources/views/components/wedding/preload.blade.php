{{--
    Preload Animation Component
    Supports variants: 'traditional', 'heartbeat', 'rings', 'split_botanical'
    Usage: @include('components.wedding.preload', ['wedding' => $wedding, 'variant' => 'heartbeat'])
--}}

@if($wedding->show_preload && \App\Services\FeatureGate::can($wedding, 'preload'))
@php
    // Determine variant based on input or default to 'heartbeat' for modern feel if not specified
    // Ideally this could come from $wedding->preload_style if added to DB
    // Determine variant based on DB setting, then input, then default
    $variant = $wedding->preload_variant ?? $variant ?? 'heartbeat';
@endphp

<div class="preload-container" id="preloadContainer">

    {{-- VARIANT: SPLIT BOTANICAL (two distinct image doors, click to open) --}}
    @if($variant === 'split_botanical')
        <div class="preload-split-stage">
            <div class="preload-split-panel preload-split-panel--left">
                <img src="{{ asset('images/preload/left.png') }}" alt="" aria-hidden="true">
            </div>
            <div class="preload-split-panel preload-split-panel--right">
                <img src="{{ asset('images/preload/right.png') }}" alt="" aria-hidden="true">
            </div>

            <button class="preload-split-trigger" type="button" aria-label="Mở thiệp cưới">
                <span>Chạm để mở thiệp</span>
            </button>
        </div>
    @endif

    {{-- VARIANT: TRADITIONAL (Sliding Doors) --}}
    @if($variant === 'traditional')
        <!-- Decorative Ornaments -->
        <div class="preload-ornament preload-tl">❀</div>
        <div class="preload-ornament preload-tr">❀</div>
        <div class="preload-ornament preload-bl">❀</div>
        <div class="preload-ornament preload-br">❀</div>

        <!-- Left Door -->
        <div class="preload-door-left">
            <span class="song-hy song-hy-left">囍</span>
        </div>

        <!-- Right Door -->
        <div class="preload-door-right">
            <span class="song-hy song-hy-right">囍</span>
        </div>
    @endif

    {{-- VARIANT: HEARTBEAT (Modern/Minimal) --}}
    @if($variant === 'heartbeat')
        <div class="absolute inset-0 bg-white flex flex-col items-center justify-center z-50">
            <div class="relative w-24 h-24 mb-8">
                <div class="absolute inset-0 rounded-full opacity-20 animate-ping" style="background-color: var(--color-primary);"></div>
                <div class="absolute inset-4 rounded-full opacity-40 animate-pulse" style="background-color: var(--color-primary);"></div>
                <svg class="absolute inset-0 w-full h-full animate-heartbeat p-6" style="color: var(--color-primary);" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                </svg>
            </div>
            <p class="uppercase tracking-[0.3em] font-light text-sm animate-pulse" style="color: var(--color-primary);">Loading Love...</p>
        </div>
    @endif

    {{-- VARIANT: RINGS (Elegant/Luxury) --}}
    @if($variant === 'rings')
        <div class="absolute inset-0 bg-[#fdfbf7] flex flex-col items-center justify-center z-50">
            <div class="relative w-32 h-32 mb-6">
                <!-- Ring 1 -->
                <div class="absolute inset-0 border-[6px] border-[#d4af37] rounded-full shadow-[0_4px_10px_rgba(212,175,55,0.4)] animate-[spin_3s_linear_infinite]"
                     style="border-right-color: transparent; transform: rotate(-45deg);"></div>

                <!-- Ring 2 (Interlocked) -->
                <div class="absolute inset-0 border-[6px] border-[#f3e5ab] rounded-full shadow-[0_4px_10px_rgba(212,175,55,0.2)] animate-[spin_4s_reverse_infinite]"
                     style="border-left-color: transparent; width: 80%; height: 80%; top: 10%; left: 10%;"></div>

                <!-- Diamond Shine -->
                <div class="absolute top-0 right-0 w-4 h-4 bg-white rotate-45 animate-ping opacity-75 shadow-[0_0_15px_#d4af37]"></div>
            </div>

            <div class="text-center space-y-2">
                <p class="text-[#d4af37] font-serif text-2xl tracking-widest uppercase">Wedding</p>
                <div class="w-12 h-[1px] bg-[#d4af37]/50 mx-auto"></div>
                <p class="text-[#8c8c88] text-xs font-sans tracking-[0.3em] animate-pulse">LOADING...</p>
            </div>
        </div>
    @endif

    {{-- COMMON: Couple Names & Guest (Overlay on top of animations if needed, or specific to traditional) --}}
    @if($variant === 'traditional')
    <div class="preload-names">
        @php $guestName = $wedding->getGuestName(); @endphp
        @if($guestName)
        <div class="preload-envelope">
            <div class="envelope-label">Kính mời</div>
            <div class="envelope-name">{{ urldecode($guestName) }}</div>
        </div>
        @endif
        <h1>{{ $sideData->firstName }}</h1>

<div class="ampersand">&</div>

<h1>{{ $sideData->secondName }}</h1>
    </div>
    @endif
    {{-- VARIANT: ENVELOPE 2 - PREMIUM INVITATION --}}
@if($variant === 'envelope-2')
    @php
        $guestName = $wedding->getGuestName();
    @endphp

    <div class="preload-envelope-2">

        {{-- Couple --}}
        <div class="preload-envelope-2__heading">
            <div class="preload-envelope-2__name">
        {{ $sideData->firstName }}
    </div>

    <div class="preload-envelope-2__ampersand">
        &
    </div>

    <div class="preload-envelope-2__name">
        {{ $sideData->secondName }}
    </div>

            @if($guestName)
                <div class="preload-envelope-2__guest">
                    <span>Trân trọng kính mời</span>
                    <strong>{{ urldecode($guestName) }}</strong>
                </div>
            @endif
        </div>

        {{-- Envelope --}}
        <button
            type="button"
            class="envelope-image"
            aria-label="Mở thiệp cưới"
        >
            <img
                class="envelope-image__img"
                src="{{ asset('images/templates/tht-e-wedding-19/envelope.png') }}"
                alt="Thiệp cưới {{ $wedding->groom_name }} và {{ $wedding->bride_name }}"
            >

            <img
                class="envelope-image__hand"
                src="{{ asset('images/templates/tht-e-wedding-19/hand.png') }}"
                alt=""
                aria-hidden="true"
            >
        </button>

        {{-- Wedding date --}}
        @if($wedding->event_date)
            <div class="preload-envelope-2__date">
                {{ $wedding->event_date->format('d.m.Y') }}
            </div>
        @endif

    </div>
@endif
</div>

<style>
    /* Base Container */
    .preload-container {
        position: fixed;
        inset: 0;
        z-index: 9999;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    /* Animations */
    @keyframes slideLeft { 0% { transform: translateX(0); } 100% { transform: translateX(-100%); } }
    @keyframes slideRight { 0% { transform: translateX(0); } 100% { transform: translateX(100%); } }
    @keyframes heartbeat { 0% { transform: scale(1); } 50% { transform: scale(1.1); } 100% { transform: scale(1); } }
    @keyframes spin-reverse { from { transform: rotate(360deg); } to { transform: rotate(0deg); } }

    .animate-heartbeat { animation: heartbeat 1.5s ease-in-out infinite; }
    .animate-spin-reverse { animation: spin-reverse 3s linear infinite; }

    /* Split Botanical: left.png and right.png are intentionally different assets. */
    .preload-split-stage { position: absolute; inset: 0; height: 100dvh; overflow: hidden; background: #273d2f; }
    .preload-split-panel { position: absolute; top: 0; bottom: 0; height: 100%; min-height: 100dvh; overflow: hidden; transition: transform 1.15s cubic-bezier(.76, 0, .24, 1); will-change: transform; }
    .preload-split-panel img { display: block; width: 100%; height: 100%; max-width: none; object-fit: fill; }
    .preload-split-panel--left { left: 0; z-index: 3; }
    .preload-split-panel--left img { object-position: right top; }
    .preload-split-panel--right { right: 0; z-index: 1; }
    .preload-split-panel--right img { object-position: left top; }
    .preload-split-trigger { position: absolute; z-index: 3; inset: 0; display: flex; align-items: flex-end; justify-content: center; padding: 0 20px 8vh; border: 0; color: #fff; background: transparent; cursor: pointer; }
    .preload-split-trigger span { padding: 11px 20px; border: 1px solid rgba(255,255,255,.72); border-radius: 999px; background: rgba(25,45,32,.62); box-shadow: 0 8px 26px rgba(0,0,0,.18); backdrop-filter: blur(5px); font: 500 11px/1.2 sans-serif; letter-spacing: .18em; text-transform: uppercase; transition: opacity .3s, transform .3s; }
    .preload-container.is-opening .preload-split-panel--left { transform: translate3d(-101%, 0, 0); }
    .preload-container.is-opening .preload-split-panel--right { transform: translate3d(101%, 0, 0); }
    .preload-container.is-opening .preload-split-trigger { pointer-events: none; }
    .preload-container.is-opening .preload-split-trigger span { opacity: 0; transform: translateY(10px); }

    @media (prefers-reduced-motion: reduce) {
        .preload-split-panel { transition-duration: .3s; }
    }

    @media (orientation: portrait) {
        .preload-split-panel img { object-fit: cover; }
    }

    /* Traditional Styles (Scoped) */
    .preload-door-left { width: 50%; height: 100%; position: absolute; left:0; background: linear-gradient(135deg, #8b0000 0%, #cc0033 50%, #8b0000 100%); display: flex; justify-content: flex-end; align-items: center; animation: slideLeft 1.5s ease-in-out 2.5s forwards; z-index: 10; }
    .preload-door-right { width: 50%; height: 100%; position: absolute; right:0; background: linear-gradient(225deg, #8b0000 0%, #cc0033 50%, #8b0000 100%); display: flex; justify-content: flex-start; align-items: center; animation: slideRight 1.5s ease-in-out 2.5s forwards; z-index: 10; }
    .song-hy { font-size: 100px; color: #ffd700; opacity: 1; animation: fadeHy 0.5s ease-out 2s forwards; }
    .song-hy-left { padding-right: 10px; }
    .song-hy-right { padding-left: 10px; }
    .preload-names { position: relative; z-index: 20; text-align: center; color: #ffd700; opacity: 0; animation: fadeNamesIn 1s ease-out 0.5s forwards, fadeNamesOut 0.5s ease-out 2s forwards; }

    @keyframes fadeNamesIn { to { opacity: 1; } }
    @keyframes fadeNamesOut { to { opacity: 0; } }
    @keyframes fadeHy { to { opacity: 0; } }
    /* =========================================================
   ENVELOPE 2 - PREMIUM WEDDING INVITATION
   ========================================================= */

.preload-envelope-2 {
    --envelope-ink: #776e50;
    --envelope-bg: #faf9f4;

    position: absolute;
    inset: 0;
    z-index: 20;

    min-height: 100vh;
    min-height: 100dvh;

    display: grid;
    grid-template-rows: auto minmax(0, 1fr) auto;

    padding:
        clamp(58px, 9vh, 105px)
        20px
        clamp(55px, 8vh, 90px);

    overflow: hidden;

    text-align: center;
    color: var(--envelope-ink);

    /*
     * Paper-like background.
     * Không cần thêm ảnh texture.
     */
    background:
        radial-gradient(
            circle at 20% 30%,
            rgba(120, 108, 75, 0.022) 0,
            rgba(120, 108, 75, 0.022) 1px,
            transparent 1.4px
        ) 0 0 / 5px 5px,
        radial-gradient(
            circle at 70% 60%,
            rgba(100, 90, 65, 0.018) 0,
            rgba(100, 90, 65, 0.018) 1px,
            transparent 1.5px
        ) 2px 2px / 7px 7px,
        linear-gradient(
            180deg,
            #fdfcf9 0%,
            #faf9f4 50%,
            #f9f8f2 100%
        );

    transition:
        opacity .8s ease,
        transform 1s cubic-bezier(.22, 1, .36, 1);
}


/* =========================
   Couple names
   ========================= */

.preload-envelope-2__heading {
    position: relative;
    z-index: 5;

    transition:
        opacity .5s ease,
        transform .7s cubic-bezier(.22, 1, .36, 1);
}

.preload-envelope-2__name {
    font-family:
        "SVN Saudagar",
        Arial,
        sans-serif;

    font-size: clamp(31px, 8vw, 54px);
    font-weight: 600;
    line-height: 1.06;

    letter-spacing: -0.035em;

    text-transform: uppercase;

    color: var(--envelope-ink);
}

.preload-envelope-2__ampersand {
    margin:
        clamp(18px, 2.6vh, 30px)
        0
        clamp(20px, 3vh, 34px);

    font-family:
        "SVN Saudagar",
        Georgia,
        "Times New Roman",
        serif;

    font-size: clamp(40px, 9vw, 65px);
    font-weight: 600;
    font-style: italic;
    line-height: .75;

    color: var(--envelope-ink);
}


/* =========================
   Guest
   ========================= */

.preload-envelope-2__guest {
    margin-top: 16px;

    font-family: "Montserrat", Arial, sans-serif;

    color: var(--envelope-ink);

    animation: envelopeGuestFade 1s ease .4s both;
}

.preload-envelope-2__guest span {
    display: block;

    font-size: 9px;
    font-weight: 400;

    letter-spacing: .2em;
    text-transform: uppercase;

    opacity: .68;
}

.preload-envelope-2__guest strong {
    display: block;

    margin-top: 5px;

    font-family:
        "SVN-Glamour",
        Georgia,
        serif;

    font-size: 15px;
    font-weight: 500;

    letter-spacing: .03em;
}


/* =========================
   Envelope
   ========================= */

.envelope-image {
    position: relative;

    align-self: center;
    justify-self: center;

    display: block;

    width: min(82vw, 510px);

    margin: clamp(15px, 3vh, 35px) auto;

    padding: 0;
    border: 0;
    outline: 0;

    background: transparent;

    cursor: pointer;

    -webkit-tap-highlight-color: transparent;
    appearance: none;

    animation:
        envelopeAppear 1.1s cubic-bezier(.22, 1, .36, 1) both,
        envelopeFloat 4s ease-in-out 1.1s infinite;

    transform-origin: center center;

    transition:
        opacity .65s ease,
        transform .95s cubic-bezier(.22, 1, .36, 1);
}

.envelope-image__img {
    display: block;

    width: 100%;
    height: auto;

    pointer-events: none;
    user-select: none;

    filter:
        drop-shadow(0 18px 18px rgba(64, 53, 33, .16))
        drop-shadow(0 5px 5px rgba(64, 53, 33, .10));
}


/* =========================
   Hand click icon
   ========================= */

.envelope-image__hand {
    position: absolute;

    /*
     * Đặt tay đúng vị trí seal.
     * Nếu PNG envelope sau này đổi crop,
     * chỉ cần chỉnh left/top ở đây.
     */
    left: 49%;
    top: 53%;

    width: clamp(58px, 15vw, 92px);
    height: auto;

    z-index: 10;

    pointer-events: none;
    user-select: none;
    transform: rotate(18deg);
    transform-origin: 30% 20%;

    filter:
        drop-shadow(0 2px 5px rgba(0, 0, 0, .18));

    animation: envelopeHandTap 1.6s ease-in-out infinite;
}


/* =========================
   Wedding date
   ========================= */

.preload-envelope-2__date {
    position: relative;
    z-index: 4;

    font-family:
        "SVN-Glamour",
        Georgia,
        "Times New Roman",
        serif;

    font-size: clamp(29px, 7vw, 46px);
    font-weight: 400;
    line-height: 1;

    letter-spacing: -.025em;

    color: var(--envelope-ink);

    transition:
        opacity .45s ease,
        transform .7s cubic-bezier(.22, 1, .36, 1);

    animation: envelopeDateFade 1s ease .65s both;
}


/* =========================================================
   OPENING STATE
   ========================================================= */

.preload-container.is-opening .preload-envelope-2__heading {
    opacity: 0;
    transform: translateY(-18px);
}

.preload-container.is-opening .preload-envelope-2__date {
    opacity: 0;
    transform: translateY(18px);
}

.preload-container.is-opening .envelope-image {
    animation: none;

    opacity: 0;

    transform:
        translateY(-10px)
        scale(1.16)
        rotate(-1deg);
}

.preload-container.is-opening .envelope-image__hand {
    animation: none;
    opacity: 0;
}

.preload-container.is-opening .preload-envelope-2 {
    opacity: 0;
    transform: scale(1.025);
}


/* =========================================================
   ANIMATIONS
   ========================================================= */

@keyframes envelopeAppear {
    from {
        opacity: 0;
        transform: translateY(25px) scale(.96);
    }

    to {
        opacity: 1;
        transform: translateY(0) scale(1);
    }
}

@keyframes envelopeFloat {
    0%,
    100% {
        transform: translateY(0);
    }

    50% {
        transform: translateY(-7px);
    }
}

@keyframes envelopeHandTap {
    0%,
    100% {
        transform:
            translate(-8%, -5%)
            rotate(-30deg)
            scale(1);
    }

    32% {
        transform:
            translate(-8%, -5%)
            rotate(-30deg)
            scale(1);
    }

    46% {
        transform:
            translate(-8%, -5%)
            rotate(-30deg)
            scale(.87);
    }

    62% {
        transform:
            translate(-8%, -5%)
            rotate(-30deg)
            scale(1.06);
    }

    75% {
        transform:
            translate(-8%, -5%)
            rotate(-30deg)
            scale(1);
    }
}

@keyframes envelopeGuestFade {
    from {
        opacity: 0;
        transform: translateY(7px);
    }

    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes envelopeDateFade {
    from {
        opacity: 0;
        transform: translateY(12px);
    }

    to {
        opacity: 1;
        transform: translateY(0);
    }
}


/* =========================================================
   MOBILE
   ========================================================= */

@media (max-width: 480px) {
    .preload-envelope-2 {
        padding:
            clamp(55px, 8vh, 80px)
            16px
            clamp(48px, 7vh, 70px);
    }

    .envelope-image {
        width: min(91vw, 440px);
    }

    .envelope-image__hand {
        left: 49%;
        top: 53%;
    }
}


/* =========================================================
   REDUCED MOTION
   ========================================================= */

@media (prefers-reduced-motion: reduce) {
    .envelope-image,
    .envelope-image__hand,
    .preload-envelope-2__guest,
    .preload-envelope-2__date {
        animation: none !important;
    }

    .preload-envelope-2,
    .envelope-image,
    .preload-envelope-2__heading,
    .preload-envelope-2__date {
        transition-duration: .2s !important;
    }
}
    /* Hide Helper */
    .preload-container.hidden { display: none !important; }
</style>

<script>
    (function () {
        const container = document.getElementById('preloadContainer');

        if (!container) {
            return;
        }

        const lockScroll = function () {
            document.documentElement.style.overflow = 'hidden';

            if (document.body) {
                document.body.style.overflow = 'hidden';
            }
        };

        const unlockScroll = function () {
            document.documentElement.style.overflow = '';

            if (document.body) {
                document.body.style.overflow = '';
            }
        };


        /*
         |--------------------------------------------------------------------------
         | Split Botanical
         |--------------------------------------------------------------------------
         */
        @if($variant === 'split_botanical')

            const trigger = container.querySelector('.preload-split-trigger');

            let isOpening = false;

            lockScroll();

            trigger?.addEventListener('click', function () {
                if (isOpening) {
                    return;
                }

                isOpening = true;

                container.classList.add('is-opening');

                unlockScroll();

                window.dispatchEvent(
                    new CustomEvent('wedding-opened')
                );

                window.setTimeout(function () {
    container.classList.add('hidden');

    window.dispatchEvent(
        new CustomEvent('wedding-content-visible')
    );
}, window.matchMedia('(prefers-reduced-motion: reduce)').matches
    ? 350
    : 1200
);
            });


        /*
         |--------------------------------------------------------------------------
         | Envelope 2
         |--------------------------------------------------------------------------
         */
        @elseif($variant === 'envelope-2')

            const trigger = container.querySelector('.envelope-image');

            let isOpening = false;

            lockScroll();

            const openWedding = function () {
                if (isOpening) {
                    return;
                }

                isOpening = true;

                /*
                 * Trigger CSS animation.
                 */
                container.classList.add('is-opening');

                /*
                 * Cho phép scroll website trở lại.
                 */
                unlockScroll();

                /*
                 * Hook để music / animation / tracking
                 * có thể nghe event này sau này.
                 */
                window.dispatchEvent(
                    new CustomEvent('wedding-opened')
                );

                /*
                 * Đợi animation hoàn tất rồi xoá preload.
                 */
                window.setTimeout(function () {
    container.classList.add('hidden');

    window.dispatchEvent(
        new CustomEvent('wedding-content-visible')
    );
}, window.matchMedia('(prefers-reduced-motion: reduce)').matches
    ? 250
    : 950
);
            };

            trigger?.addEventListener(
                'click',
                openWedding,
                { once: true }
            );


        /*
         |--------------------------------------------------------------------------
         | Other preload variants
         |--------------------------------------------------------------------------
         */
        @else

    window.setTimeout(function () {
        container.classList.add('hidden');

        window.dispatchEvent(
            new CustomEvent('wedding-content-visible')
        );
    }, 4000);

@endif

    })();
</script>
@endif
