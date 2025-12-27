<!DOCTYPE html>
<html lang="vi" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>THT Media - Thiết Kế Thiệp Cưới & Danh Thiếp Số Cao Cấp</title>
    <meta name="description" content="Dịch vụ thiết kế thiệp cưới online và danh thiếp số chuyên nghiệp bởi THT Media. Mẫu thiết kế độc quyền, sang trọng, giá hợp lý.">
    
    <!-- Vite Compiled Assets (Static Tailwind CSS) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&family=Be+Vietnam+Pro:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    
    <style>
        body { font-family: 'Be Vietnam Pro', sans-serif; }
        .font-serif { font-family: 'Playfair Display', serif; }
        .gradient-gold { background: linear-gradient(135deg, #D4AF37 0%, #AA8C2C 100%); }
        .text-gold { color: #D4AF37; }
        .gradient-rose { background: linear-gradient(135deg, #ec4899 0%, #f43f5e 100%); }
        
        /* Premium Animations */
        @keyframes float { 0%, 100% { transform: translateY(0px) rotate(0deg); } 50% { transform: translateY(-20px) rotate(5deg); } }
        @keyframes pulse-glow { 0%, 100% { box-shadow: 0 0 20px rgba(212,175,55,0.4); } 50% { box-shadow: 0 0 40px rgba(212,175,55,0.8); } }
        @keyframes shimmer { 0% { background-position: -200% 0; } 100% { background-position: 200% 0; } }
        @keyframes heartbeat { 0%, 100% { transform: scale(1); } 50% { transform: scale(1.1); } }
        @keyframes slideUp { from { opacity: 0; transform: translateY(30px); } to { opacity: 1; transform: translateY(0); } }
        
        .animate-float { animation: float 6s ease-in-out infinite; }
        .animate-float-delay { animation: float 6s ease-in-out infinite 2s; }
        .animate-pulse-glow { animation: pulse-glow 2s ease-in-out infinite; }
        .animate-shimmer { background: linear-gradient(90deg, transparent, rgba(255,255,255,0.4), transparent); background-size: 200% 100%; animation: shimmer 2s infinite; }
        .animate-heartbeat { animation: heartbeat 1.5s ease-in-out infinite; }
        
        /* Card Hover Effect */
        .card-hover { transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1); }
        .card-hover:hover { transform: translateY(-8px) scale(1.02); }
        
        /* Sticky Mobile CTA */
        .sticky-cta { position: fixed; bottom: 0; left: 0; right: 0; z-index: 40; transform: translateY(100%); transition: transform 0.3s ease; }
        .sticky-cta.visible { transform: translateY(0); }
        
        .text-gradient { background: linear-gradient(135deg, #D4AF37 0%, #f59e0b 50%, #D4AF37 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; }
    </style>
</head>
<body class="bg-white text-gray-900 antialiased">

    <!-- Navbar -->
    <nav class="fixed top-0 w-full z-50 bg-white/95 backdrop-blur-md border-b border-gray-100 shadow-sm">
        <div class="max-w-6xl mx-auto px-6 py-3 flex justify-between items-center">
            <a href="/" class="flex items-center">
                <img src="https://thtmedia.com.vn/wp-content/uploads/2023/01/THT-media-logo-2023-261x300.png" alt="THT Media" class="h-12 w-auto">
            </a>
            <div class="hidden md:flex items-center gap-8 text-sm font-medium text-gray-600">
                <a href="#services" class="hover:text-gray-900 transition">Dịch vụ</a>
                <a href="#portfolio" class="hover:text-gray-900 transition">Mẫu thiết kế</a>
                <a href="#about" class="hover:text-gray-900 transition">Về chúng tôi</a>
                <a href="#contact" class="hover:text-gray-900 transition">Liên hệ</a>
            </div>
            <a href="tel:0375433678" class="hidden md:inline-flex items-center gap-2 px-5 py-2.5 rounded-full gradient-gold text-white font-semibold text-sm hover:opacity-90 transition shadow-lg shadow-amber-200">
                <i class="fas fa-phone"></i>
                <span>0375 433 678</span>
            </a>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="min-h-screen flex items-center relative overflow-hidden pt-24 pb-16 bg-gradient-to-br from-amber-50 via-white to-rose-50">
        <!-- Floating Elements -->
        <div class="absolute top-20 right-10 w-72 h-72 bg-amber-100 rounded-full blur-3xl opacity-50 animate-float"></div>
        <div class="absolute bottom-20 left-10 w-96 h-96 bg-rose-100 rounded-full blur-3xl opacity-50 animate-float-delay"></div>
        
        <div class="max-w-6xl mx-auto px-6 relative z-10 w-full">
            <div class="grid md:grid-cols-2 gap-12 items-center">
                <div>
                     <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-gradient-to-r from-rose-500 to-pink-500 text-white font-semibold text-sm mb-4 animate-pulse-glow" data-aos="fade-up">
                        🔥 Ưu đãi Tết 2025 - Giảm 30%
                    </div>
                    
                    <h1 class="text-4xl md:text-5xl lg:text-6xl font-serif font-bold leading-tight mb-6" data-aos="fade-up" data-aos-delay="100">
                        Thiệp Cưới Online<br>
                        <span class="text-gradient">Sang Trọng</span><br>
                        <span class="text-gold">Độc Đáo</span>
                    </h1>
                    
                    <p class="text-lg text-gray-600 mb-8 leading-relaxed max-w-lg" data-aos="fade-up" data-aos-delay="200">
                        THT Media mang đến thiệp cưới điện tử <strong>đẹp nhất Việt Nam</strong>. Design độc quyền, RSVP thông minh, chia sẻ dễ dàng qua Zalo/Facebook.
                    </p>
                    
                    <div class="flex flex-wrap gap-4 mb-10" data-aos="fade-up" data-aos-delay="300">
                        <a href="#pricing" class="inline-flex items-center gap-2 px-8 py-4 rounded-full gradient-gold text-white font-bold hover:opacity-90 transition shadow-xl shadow-amber-200 animate-pulse-glow">
                            <span>Xem bảng giá</span>
                            <i class="fas fa-arrow-right"></i>
                        </a>
                        <a href="#portfolio" class="inline-flex items-center gap-2 px-8 py-4 rounded-full bg-white border-2 border-gray-200 font-bold hover:border-gold hover:text-gold transition group">
                            <i class="fas fa-play-circle text-rose-500 group-hover:animate-heartbeat"></i>
                            <span>Xem mẫu thiết kế</span>
                        </a>
                    </div>
                </div>
                
                <div class="relative" data-aos="fade-left" data-aos-duration="1000">
                    <div class="absolute inset-0 gradient-gold rounded-3xl blur-3xl opacity-20 animate-float"></div>
                    <img src="https://images.unsplash.com/photo-1519741497674-611481863552?q=80&w=800&auto=format&fit=crop" 
                         alt="Mẫu thiệp cưới online đẹp" 
                         class="relative rounded-3xl shadow-2xl w-full object-cover aspect-[4/5] card-hover">
                </div>
            </div>
        </div>
    </section>
    
    @php
        $standardWeddings = $demoWeddings->filter(fn($w) => $w->tier === 'standard' || $w->tier === \App\Enums\WeddingTier::STANDARD);
        $proWeddings = $demoWeddings->filter(fn($w) => $w->tier === 'pro' || $w->tier === \App\Enums\WeddingTier::PRO);
    @endphp

    <!-- Portfolio Section - Templates Preview -->
    <section id="portfolio" class="py-24 bg-gray-50">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center mb-16">
                <span class="text-gold font-semibold uppercase tracking-widest text-sm" data-aos="fade-up">Portfolio</span>
                <h2 class="text-3xl md:text-4xl font-serif font-bold mt-4" data-aos="fade-up" data-aos-delay="100">Bộ Sưu Tập Thiệp Cưới</h2>
            </div>

            <!-- PRO Collection -->
            <div class="mb-20">
                 <div class="flex items-center justify-between mb-8" data-aos="fade-up">
                    <h3 class="text-2xl font-bold flex items-center gap-3">
                        <span class="w-10 h-10 rounded-full gradient-gold flex items-center justify-center text-white text-lg"><i class="fas fa-crown"></i></span>
                        <span class="text-gradient">BST Premium (PRO)</span>
                    </h3>
                    <div class="h-px flex-1 bg-gradient-to-r from-amber-200 to-transparent ml-6"></div>
                </div>
                
                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @forelse($proWeddings as $index => $wedding)
                    <a href="{{ url($wedding->slug) }}" class="group relative bg-slate-900 rounded-3xl overflow-hidden shadow-2xl hover:shadow-gold/50 transition duration-500 border border-amber-500/30" data-aos="fade-up" data-aos-delay="{{ $index * 100 }}">
                        <!-- Badge -->
                        <div class="absolute top-4 right-4 z-20 px-3 py-1 rounded-full gradient-gold text-white text-xs font-bold shadow-lg">PREMIUM</div>
                        
                        <div class="aspect-[3/4] relative overflow-hidden">
                            @if($wedding->template && $wedding->template->thumbnail_url)
                                <img src="{{ $wedding->template->thumbnail_url }}" class="w-full h-full object-cover opacity-90 group-hover:scale-105 transition duration-1000" alt="{{ $wedding->template->name }}">
                            @else
                                <div class="w-full h-full flex items-center justify-center bg-slate-800">
                                    <span class="text-gray-500">PRO Template</span>
                                </div>
                            @endif
                            <!-- Overlay -->
                            <div class="absolute inset-0 bg-gradient-to-t from-black via-transparent to-transparent opacity-80"></div>
                            
                            <!-- Content overlay -->
                            <div class="absolute bottom-0 left-0 right-0 p-6 translate-y-2 group-hover:translate-y-0 transition duration-500">
                                <h4 class="font-serif text-2xl font-bold text-white mb-1">{{ $wedding->template->name ?? 'Mẫu Luxury' }}</h4>
                                <div class="text-amber-400 text-sm font-medium mb-3 uppercase tracking-wider">Gói PRO</div>
                                <div class="flex items-center gap-2 opacity-0 group-hover:opacity-100 transition duration-500 delay-100">
                                    <span class="text-white text-sm font-bold border-b border-amber-400 pb-0.5">Xem chi tiết</span>
                                    <i class="fas fa-arrow-right text-amber-400 text-xs"></i>
                                </div>
                            </div>
                        </div>
                    </a>
                    @empty
                    <div class="col-span-full text-center text-gray-400 italic">Đang cập nhật các mẫu Premium...</div>
                    @endforelse
                </div>
            </div>

            <!-- Standard Collection -->
            <div class="mb-16">
                 <div class="flex items-center justify-between mb-8" data-aos="fade-up">
                    <h3 class="text-2xl font-bold flex items-center gap-3">
                        <span class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center text-slate-600 text-lg"><i class="fas fa-heart"></i></span>
                        <span>BST Tiêu Chuẩn (Standard)</span>
                    </h3>
                    <div class="h-px flex-1 bg-gray-200 ml-6"></div>
                </div>

                <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
                    @forelse($standardWeddings as $index => $wedding)
                    <a href="{{ url($wedding->slug) }}" class="group relative bg-white rounded-2xl overflow-hidden shadow-lg hover:shadow-xl transition duration-500" data-aos="fade-up" data-aos-delay="{{ $index * 50 }}">
                        <div class="aspect-[3/4] relative overflow-hidden bg-gray-100">
                            @if($wedding->template && $wedding->template->thumbnail_url)
                                <img src="{{ $wedding->template->thumbnail_url }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-700" alt="{{ $wedding->template->name }}">
                            @else
                                <div class="w-full h-full flex items-center justify-center bg-gray-200">
                                    <span class="text-gray-400">Standard</span>
                                </div>
                            @endif
                            <div class="absolute inset-0 bg-black/20 group-hover:bg-black/40 transition duration-500"></div>
                            <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition duration-500">
                                <span class="bg-white text-gray-900 px-6 py-2 rounded-full font-bold text-sm shadow-lg transform translate-y-4 group-hover:translate-y-0 transition duration-500">Xem Demo</span>
                            </div>
                        </div>
                        <div class="p-5 border-t border-gray-50">
                            <h4 class="font-bold text-gray-900 truncate">{{ $wedding->template->name ?? 'Mẫu Tiêu Chuẩn' }}</h4>
                            <p class="text-sm text-gray-500 truncate mt-1">Gói Standard</p>
                        </div>
                    </a>
                    @empty
                     <div class="col-span-full text-center text-gray-400 italic">Đang cập nhật các mẫu Standard...</div>
                    @endforelse
                </div>
            </div>
            
            <!-- Business Cards (Kept simple below) -->
             <div class="mt-20 pt-16 border-t border-gray-200">
                <div class="text-center mb-12">
                     <span class="bg-slate-100 text-slate-600 px-4 py-1 rounded-full text-xs font-bold uppercase tracking-widest">Dành cho doanh nhân</span>
                    <h3 class="text-2xl font-bold mt-4">Danh Thiếp Số (Business Card)</h3>
                </div>
                <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach($demoBusinessCards as $card)
                    <a href="{{ url('p/' . $card->slug) }}" class="group relative bg-slate-900 rounded-2xl overflow-hidden shadow-lg hover:shadow-2xl transition duration-500 block">
                        <div class="aspect-[16/10] relative overflow-hidden opacity-90 group-hover:opacity-100 transition">
                            <!-- Placeholder specific for business cards if no image -->
                             @if($card->template && $card->template->thumbnail_url)
                                <img src="{{ $card->template->thumbnail_url }}" class="w-full h-full object-cover" alt="{{ $card->name }}">
                            @else
                                <div class="w-full h-full bg-slate-800 flex items-center justify-center text-slate-500 text-xs">Business Card</div>
                            @endif
                        </div>
                        <div class="p-4 bg-white">
                            <h4 class="font-bold text-sm text-gray-900">{{ $card->name }}</h4>
                            <p class="text-xs text-gray-500">{{ $card->title }}</p>
                        </div>
                    </a>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <!-- Pricing Section -->
    <section id="pricing" class="py-24 bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900 text-white relative overflow-hidden">
        <div class="absolute top-0 right-0 w-96 h-96 bg-amber-500/10 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 left-0 w-96 h-96 bg-rose-500/10 rounded-full blur-3xl"></div>
        
        <div class="max-w-5xl mx-auto px-6 relative z-10">
            <div class="text-center mb-16">
                <span class="text-gold font-semibold uppercase tracking-widest text-sm" data-aos="fade-up">Bảng giá</span>
                <h2 class="text-3xl md:text-4xl font-serif font-bold mt-4" data-aos="fade-up" data-aos-delay="100">
                    Gói Dịch Vụ <span class="text-gold">Thiệp Cưới Online</span>
                </h2>
            </div>
            
            <div class="grid md:grid-cols-2 gap-8 max-w-4xl mx-auto">
                <!-- STANDARD -->
                <div class="bg-white/5 backdrop-blur-sm border border-white/10 rounded-3xl p-8 card-hover" data-aos="fade-up">
                    <div class="text-center mb-8">
                        <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-rose-400 to-pink-500 flex items-center justify-center text-white text-3xl mx-auto mb-4"><i class="fas fa-heart"></i></div>
                        <h3 class="text-xl font-bold mb-2">STANDARD</h3>
                        <div class="text-4xl font-bold text-white mb-1">299K</div>
                        <div class="text-gray-400 text-sm">VNĐ / trọn gói</div>
                    </div>
                    <ul class="space-y-4 mb-8 text-gray-300 text-sm">
                        <li class="flex items-center gap-3"><i class="fas fa-check text-green-400"></i>Các mẫu thiệp Standard đẹp</li>
                        <li class="flex items-center gap-3"><i class="fas fa-check text-green-400"></i>Đầy đủ tính năng cơ bản</li>
                        <li class="flex items-center gap-3"><i class="fas fa-check text-green-400"></i>RSVP & Guestbook</li>
                        <li class="flex items-center gap-3"><i class="fas fa-check text-green-400"></i>Bản đồ & QR Code</li>
                        <li class="flex items-center gap-3"><i class="fas fa-check text-green-400"></i>Lưu trữ 1 năm</li>
                    </ul>
                    <a href="#contact" class="block w-full py-4 text-center rounded-full border border-white/30 font-bold hover:bg-white/10 transition">Liên hệ đăng ký</a>
                </div>
                
                <!-- PRO -->
                <div class="bg-gradient-to-br from-amber-500/20 to-orange-500/20 border-2 border-gold rounded-3xl p-8 relative card-hover scale-105" data-aos="fade-up" data-aos-delay="100">
                    <div class="absolute -top-4 left-1/2 -translate-x-1/2 px-4 py-1 rounded-full gradient-gold text-white text-sm font-bold animate-pulse-glow">
                        🔥 Phổ biến nhất
                    </div>
                    <div class="text-center mb-8">
                        <div class="w-16 h-16 rounded-2xl gradient-gold flex items-center justify-center text-white text-3xl mx-auto mb-4"><i class="fas fa-crown"></i></div>
                        <h3 class="text-xl font-bold mb-2">PRO / PREMIUM</h3>
                         <div class="text-4xl font-bold text-gold mb-1">499K</div>
                        <div class="text-gray-400 text-sm line-through">799K</div>
                    </div>
                    <ul class="space-y-4 mb-8 text-gray-300 text-sm">
                        <li class="flex items-center gap-3"><i class="fas fa-check text-gold"></i><strong>Truy cập kho mẫu Premium (Luxury, Galaxy...)</strong></li>
                        <li class="flex items-center gap-3"><i class="fas fa-check text-gold"></i><strong>Hiệu ứng rơi (Hoa/Tim/Sao)</strong></li>
                        <li class="flex items-center gap-3"><i class="fas fa-check text-gold"></i><strong>Màn hình mời mở phong bì 3D</strong></li>
                        <li class="flex items-center gap-3"><i class="fas fa-check text-gold"></i>Gallery ảnh không giới hạn</li>
                        <li class="flex items-center gap-3"><i class="fas fa-check text-gold"></i><strong>Lưu trữ vĩnh viễn</strong></li>
                        <li class="flex items-center gap-3"><i class="fas fa-check text-gold"></i>Hỗ trợ ưu tiên 1-1</li>
                    </ul>
                    <a href="#contact" class="block w-full py-4 text-center rounded-full gradient-gold text-white font-bold hover:opacity-90 transition animate-pulse-glow">Đăng ký ngay</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="py-24 bg-white">
        <div class="max-w-4xl mx-auto px-6 text-center">
            <span class="text-gold font-semibold uppercase tracking-widest text-sm" data-aos="fade-up">Liên hệ tư vấn</span>
            <h2 class="text-3xl md:text-5xl font-serif font-bold mt-4 mb-8" data-aos="fade-up" data-aos-delay="100">
                THT Media
            </h2>
            
            <div class="grid md:grid-cols-3 gap-8 mt-12 text-left">
                <div class="p-6 rounded-2xl bg-gray-50 text-center" data-aos="fade-up">
                    <div class="w-12 h-12 rounded-full bg-amber-100 text-amber-600 flex items-center justify-center mx-auto mb-4 text-xl"><i class="fas fa-phone"></i></div>
                    <div class="font-bold text-gray-900 mb-1">Hotline / Zalo</div>
                    <a href="tel:0375433678" class="text-lg font-bold text-gold hover:text-amber-600 transition">0375 433 678</a>
                </div>
                
                 <div class="p-6 rounded-2xl bg-gray-50 text-center" data-aos="fade-up" data-aos-delay="100">
                    <div class="w-12 h-12 rounded-full bg-rose-100 text-rose-600 flex items-center justify-center mx-auto mb-4 text-xl"><i class="fas fa-envelope"></i></div>
                    <div class="font-bold text-gray-900 mb-1">Email</div>
                    <a href="mailto:thtmediaqvm@gmail.com" class="text-gray-600 hover:text-rose-600 transition">thtmediaqvm@gmail.com</a>
                </div>
                
                 <div class="p-6 rounded-2xl bg-gray-50 text-center" data-aos="fade-up" data-aos-delay="200">
                    <div class="w-12 h-12 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center mx-auto mb-4 text-xl"><i class="fas fa-map-marker-alt"></i></div>
                    <div class="font-bold text-gray-900 mb-1">Trụ sở chính</div>
                    <p class="text-gray-600 text-sm">Số 263 đường Bình Than, phường Đại Phúc, thành phố Bắc Ninh</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="py-8 bg-slate-950 border-t border-white/5 text-gray-500">
        <div class="max-w-6xl mx-auto px-6 text-center">
            <p class="text-sm">
                © {{ date('Y') }} <strong>THT Media</strong>. Số 263 đường Bình Than, phường Đại Phúc, TP. Bắc Ninh.
            </p>
        </div>
    </footer>

    <!-- Zalo Widget -->
    <a href="https://zalo.me/0375433678" target="_blank" 
       class="fixed bottom-24 right-6 md:bottom-8 w-14 h-14 rounded-full bg-blue-500 text-white flex items-center justify-center shadow-xl hover:scale-110 transition z-50 animate-float border-2 border-white">
        <span class="font-bold text-xs">Zalo</span>
    </a>
    
    <!-- Sticky Mobile CTA -->
    <div id="stickyCta" class="sticky-cta md:hidden bg-white border-t border-gray-100 shadow-2xl px-4 py-3 safe-area-bottom">
        <div class="flex gap-3">
            <a href="tel:0375433678" class="flex-1 py-3 text-center rounded-full bg-gray-100 font-bold text-gray-700">
                <i class="fas fa-phone mr-2"></i>Gọi ngay
            </a>
            <a href="#pricing" class="flex-1 py-3 text-center rounded-full gradient-gold text-white font-bold animate-pulse-glow">
                Xem giá 🔥
            </a>
        </div>
    </div>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({ duration: 800, once: true, offset: 50 });
        
        // Sticky CTA visibility
        const stickyCta = document.getElementById('stickyCta');
        window.addEventListener('scroll', () => {
            if (window.pageYOffset > 500) {
                stickyCta.classList.add('visible');
            } else {
                stickyCta.classList.remove('visible');
            }
        });
    </script>
</body>
</html>
