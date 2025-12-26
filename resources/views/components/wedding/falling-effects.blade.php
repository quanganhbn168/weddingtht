{{-- 
Premium Falling Effects - Visual Teaser for All + Full for Pro
Standard: Shows preview with upgrade prompt
Pro: Full effects without restrictions
--}}

@php
    $effectRaw = $wedding->falling_effect ?? 'hearts';
    $effect = is_object($effectRaw) ? $effectRaw->value : (string)$effectRaw;
    $isPro = ($wedding->tier ?? 'standard') === 'pro';
    
    // Show effects for everyone (teaser for Standard, full for Pro)
    $showEffect = $effect !== 'none';
@endphp

@if($showEffect)
<style>
/* ================================================
   PREMIUM FALLING EFFECTS
   Clean SVG-based particles with smooth animations
   ================================================ */

.falling-canvas {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    pointer-events: none;
    z-index: 100;
    overflow: hidden;
}

.fall-item {
    position: absolute;
    top: -60px;
    opacity: 0;
    animation: fallAnimation linear infinite;
}

/* Main falling animation - continuous from top to bottom */
@keyframes fallAnimation {
    0% {
        transform: translateY(0) rotate(0deg) scale(1);
        opacity: 0;
    }
    5% {
        opacity: 1;
    }
    95% {
        opacity: 0.8;
    }
    100% {
        transform: translateY(calc(100vh + 100px)) rotate(360deg) scale(0.8);
        opacity: 0;
    }
}

/* Gentle horizontal sway */
.fall-item.sway {
    animation: fallAnimation linear infinite, sideToSide ease-in-out infinite alternate;
}

@keyframes sideToSide {
    0% { margin-left: -20px; }
    100% { margin-left: 20px; }
}

/* ===== SVG HEART ===== */
.svg-heart {
    fill: url(#heartGradient);
    filter: drop-shadow(0 2px 4px rgba(255, 100, 130, 0.4));
}

/* ===== SVG PETAL ===== */
.svg-petal {
    fill: url(#petalGradient);
    filter: drop-shadow(0 2px 3px rgba(255, 180, 200, 0.3));
}

/* ===== SVG SNOWFLAKE ===== */
.svg-snow {
    fill: #fff;
    filter: drop-shadow(0 0 6px rgba(255, 255, 255, 0.9));
}

/* ===== SVG LEAF ===== */
.svg-leaf {
    fill: url(#leafGradient);
    filter: drop-shadow(0 2px 3px rgba(139, 90, 43, 0.3));
}

/* ===== SVG STAR ===== */
.svg-star {
    fill: url(#starGradient);
    filter: drop-shadow(0 0 8px rgba(255, 215, 0, 0.7));
}

/* Standard tier overlay - subtle blur suggestion */
@if(!$isPro)
.falling-canvas::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    height: 150px;
    background: linear-gradient(to top, rgba(255,255,255,0.9), transparent);
    pointer-events: none;
}
@endif

/* Reduce motion for accessibility */
@media (prefers-reduced-motion: reduce) {
    .fall-item { display: none; }
}
</style>

<!-- SVG Definitions -->
<svg style="position:absolute;width:0;height:0;">
    <defs>
        <!-- Heart Gradient -->
        <linearGradient id="heartGradient" x1="0%" y1="0%" x2="100%" y2="100%">
            <stop offset="0%" style="stop-color:#ff6b8a"/>
            <stop offset="50%" style="stop-color:#ff4d6d"/>
            <stop offset="100%" style="stop-color:#e91e63"/>
        </linearGradient>
        
        <!-- Petal Gradient -->
        <linearGradient id="petalGradient" x1="0%" y1="0%" x2="0%" y2="100%">
            <stop offset="0%" style="stop-color:#ffc0cb"/>
            <stop offset="100%" style="stop-color:#ff91a4"/>
        </linearGradient>
        
        <!-- Leaf Gradient -->
        <linearGradient id="leafGradient" x1="0%" y1="0%" x2="100%" y2="100%">
            <stop offset="0%" style="stop-color:#d4a574"/>
            <stop offset="100%" style="stop-color:#a67c52"/>
        </linearGradient>
        
        <!-- Star Gradient -->
        <linearGradient id="starGradient" x1="0%" y1="0%" x2="100%" y2="100%">
            <stop offset="0%" style="stop-color:#ffd700"/>
            <stop offset="100%" style="stop-color:#ffb700"/>
        </linearGradient>
    </defs>
</svg>

<div class="falling-canvas" id="fallingCanvas"></div>

<script>
(function() {
    'use strict';
    
    const effect = '{{ $effect }}';
    const isPro = {{ $isPro ? 'true' : 'false' }};
    const canvas = document.getElementById('fallingCanvas');
    if (!canvas) return;
    
    // Particle count - less for Standard (teaser), more for Pro
    const count = isPro ? 25 : 8;
    
    // SVG templates for each effect
    const svgTemplates = {
        hearts: `<svg viewBox="0 0 32 32" class="svg-heart"><path d="M16 28s-11-7.5-11-14c0-4 3-7 7-7 2.5 0 4.5 1.5 4.5 1.5S18.5 7 21 7c4 0 7 3 7 7 0 6.5-11 14-11 14z"/></svg>`,
        
        petals: `<svg viewBox="0 0 24 32" class="svg-petal"><ellipse cx="12" cy="16" rx="8" ry="14"/></svg>`,
        
        snow: `<svg viewBox="0 0 24 24" class="svg-snow"><circle cx="12" cy="12" r="4"/><line x1="12" y1="2" x2="12" y2="6" stroke="#fff" stroke-width="2"/><line x1="12" y1="18" x2="12" y2="22" stroke="#fff" stroke-width="2"/><line x1="2" y1="12" x2="6" y2="12" stroke="#fff" stroke-width="2"/><line x1="18" y1="12" x2="22" y2="12" stroke="#fff" stroke-width="2"/></svg>`,
        
        leaves: `<svg viewBox="0 0 24 32" class="svg-leaf"><path d="M12 2C6 8 4 16 4 24c0 2 8 6 8 6s8-4 8-6c0-8-2-16-8-22z"/><line x1="12" y1="8" x2="12" y2="28" stroke="#8b5a2b" stroke-width="1.5"/></svg>`,
        
        stars: `<svg viewBox="0 0 24 24" class="svg-star"><polygon points="12,2 15,9 22,9 16,14 18,22 12,17 6,22 8,14 2,9 9,9"/></svg>`
    };
    
    const template = svgTemplates[effect] || svgTemplates.hearts;
    
    function createParticle() {
        const item = document.createElement('div');
        item.className = 'fall-item sway';
        item.innerHTML = template;
        
        // Random positioning and timing
        const left = Math.random() * 95 + 2.5; // 2.5% - 97.5%
        const size = 16 + Math.random() * 16; // 16px - 32px
        const duration = 8 + Math.random() * 6; // 8s - 14s
        const delay = Math.random() * 12;
        const swayDuration = 2 + Math.random() * 2;
        
        item.style.cssText = `
            left: ${left}%;
            width: ${size}px;
            height: ${size}px;
            animation-duration: ${duration}s, ${swayDuration}s;
            animation-delay: ${delay}s, 0s;
        `;
        
        canvas.appendChild(item);
    }
    
    // Create particles
    for (let i = 0; i < count; i++) {
        createParticle();
    }
    
    // Pause when tab not visible
    document.addEventListener('visibilitychange', function() {
        canvas.style.animationPlayState = document.hidden ? 'paused' : 'running';
    });
})();
</script>

@if(!$isPro)
<!-- Upgrade prompt for Standard users -->
<div style="position:fixed;bottom:20px;left:50%;transform:translateX(-50%);z-index:101;background:linear-gradient(135deg,#ff6b8a,#e91e63);color:#fff;padding:10px 24px;border-radius:30px;font-size:14px;box-shadow:0 4px 20px rgba(233,30,99,0.4);cursor:pointer;" 
     onclick="window.location.href='{{ route('dashboard.pricing') }}'">
    ⭐ Nâng cấp Pro để có hiệu ứng đầy đủ
</div>
@endif
@endif

{{-- Demo Watermark --}}
@if($wedding->is_demo ?? false)
<div style="position:fixed;top:50%;left:50%;transform:translate(-50%,-50%) rotate(-30deg);font-size:80px;font-weight:bold;color:rgba(255,0,0,0.12);pointer-events:none;z-index:1000;white-space:nowrap;letter-spacing:20px;">DEMO</div>
@endif
