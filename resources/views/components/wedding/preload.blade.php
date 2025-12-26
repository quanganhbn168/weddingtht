{{-- 
Preload Animation Component - "Song Hỷ" (囍) Sliding Door Effect
Only for PRO tier weddings

Usage: @include('components.wedding.preload', ['wedding' => $wedding])
--}}

@if($wedding->show_preload && $wedding->tier === 'pro')
<style>
    /* Preload Container */
    .preload-container {
        position: fixed;
        inset: 0;
        z-index: 9999;
        display: flex;
        pointer-events: none;
    }
    
    /* Left Door */
    .preload-door-left {
        width: 50%;
        height: 100%;
        background: linear-gradient(135deg, #8b0000 0%, #cc0033 50%, #8b0000 100%);
        display: flex;
        justify-content: flex-end;
        align-items: center;
        animation: slideLeft 1.5s ease-in-out 2s forwards;
        box-shadow: 5px 0 30px rgba(0,0,0,0.5);
    }
    
    /* Right Door */
    .preload-door-right {
        width: 50%;
        height: 100%;
        background: linear-gradient(225deg, #8b0000 0%, #cc0033 50%, #8b0000 100%);
        display: flex;
        justify-content: flex-start;
        align-items: center;
        animation: slideRight 1.5s ease-in-out 2s forwards;
        box-shadow: -5px 0 30px rgba(0,0,0,0.5);
    }
    
    /* Song Hỷ Character */
    .song-hy {
        font-size: 120px;
        color: #ffd700;
        text-shadow: 0 0 20px rgba(255,215,0,0.5), 0 0 40px rgba(255,215,0,0.3);
        font-family: 'Noto Serif SC', 'SimSun', serif;
        opacity: 1;
        animation: fadeHy 0.5s ease-out 1.5s forwards;
    }
    
    .song-hy-left { padding-right: 10px; }
    .song-hy-right { padding-left: 10px; }
    
    /* Couple Names */
    .preload-names {
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        z-index: 10000;
        text-align: center;
        animation: fadeNames 0.5s ease-out 1.5s forwards;
    }
    
    .preload-names h1 {
        font-size: 28px;
        color: #ffd700;
        font-family: 'Noto Serif SC', 'Playfair Display', serif;
        text-shadow: 0 0 10px rgba(255,215,0,0.5);
        margin: 0;
        white-space: nowrap;
    }
    
    .preload-names .ampersand {
        font-size: 24px;
        color: #fff;
        margin: 10px 0;
        opacity: 0.8;
    }
    
    /* Guest Name Envelope */
    .preload-envelope {
        margin-bottom: 20px;
        padding: 15px 30px;
        background: linear-gradient(135deg, rgba(255,215,0,0.2), rgba(255,215,0,0.1));
        border: 2px solid #ffd700;
        border-radius: 10px;
    }
    .preload-envelope .envelope-label {
        font-size: 14px;
        color: #fff;
        opacity: 0.8;
        margin-bottom: 5px;
    }
    .preload-envelope .envelope-name {
        font-size: 24px;
        color: #ffd700;
        font-weight: bold;
        text-shadow: 0 0 10px rgba(255,215,0,0.5);
    }
    
    /* Decorative Elements */
    .preload-ornament {
        position: absolute;
        font-size: 24px;
        color: #ffd700;
        opacity: 0.6;
        animation: pulse 1s ease-in-out infinite;
    }
    .preload-tl { top: 20%; left: 20%; }
    .preload-tr { top: 20%; right: 20%; }
    .preload-bl { bottom: 20%; left: 20%; }
    .preload-br { bottom: 20%; right: 20%; }
    
    /* Animations */
    @keyframes slideLeft {
        0% { transform: translateX(0); }
        100% { transform: translateX(-100%); pointer-events: none; }
    }
    
    @keyframes slideRight {
        0% { transform: translateX(0); }
        100% { transform: translateX(100%); pointer-events: none; }
    }
    
    @keyframes fadeHy {
        0% { opacity: 1; }
        100% { opacity: 0; }
    }
    
    @keyframes fadeNames {
        0% { opacity: 1; }
        100% { opacity: 0; visibility: hidden; }
    }
    
    @keyframes pulse {
        0%, 100% { transform: scale(1); opacity: 0.6; }
        50% { transform: scale(1.1); opacity: 1; }
    }
    
    /* Hide container after animation */
    .preload-container.hidden {
        display: none;
    }
</style>

<div class="preload-container" id="preloadContainer">
    <!-- Decorative Ornaments -->
    <div class="preload-ornament preload-tl">❀</div>
    <div class="preload-ornament preload-tr">❀</div>
    <div class="preload-ornament preload-bl">❀</div>
    <div class="preload-ornament preload-br">❀</div>
    
    <!-- Left Door with half Song Hy -->
    <div class="preload-door-left">
        <span class="song-hy song-hy-left">囍</span>
    </div>
    
    <!-- Right Door with half Song Hy -->
    <div class="preload-door-right">
        <span class="song-hy song-hy-right">囍</span>
    </div>
    
    <!-- Couple Names in Center -->
    <div class="preload-names">
        @php $guestName = $wedding->getGuestName(); @endphp
        @if($guestName)
        <div class="preload-envelope">
            <div class="envelope-label">Kính mời</div>
            <div class="envelope-name">{{ urldecode($guestName) }}</div>
        </div>
        @endif
        <h1>{{ $wedding->groom_name }}</h1>
        <div class="ampersand">&</div>
        <h1>{{ $wedding->bride_name }}</h1>
    </div>
</div>

<script>
    // Hide preload container after animation completes
    setTimeout(function() {
        const container = document.getElementById('preloadContainer');
        if (container) {
            container.classList.add('hidden');
        }
    }, 3500); // 2s delay + 1.5s animation
</script>
@endif
