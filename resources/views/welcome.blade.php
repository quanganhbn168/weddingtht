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
        @keyframes fadeInScale { from { opacity: 0; transform: scale(0.9); } to { opacity: 1; transform: scale(1); } }
        
        .animate-float { animation: float 6s ease-in-out infinite; }
        .animate-float-delay { animation: float 6s ease-in-out infinite 2s; }
        .animate-pulse-glow { animation: pulse-glow 2s ease-in-out infinite; }
        .animate-shimmer { background: linear-gradient(90deg, transparent, rgba(255,255,255,0.4), transparent); background-size: 200% 100%; animation: shimmer 2s infinite; }
        .animate-heartbeat { animation: heartbeat 1.5s ease-in-out infinite; }
        .animate-slide-up { animation: slideUp 0.8s ease-out forwards; }
        .animate-fade-scale { animation: fadeInScale 0.6s ease-out forwards; }
        
        /* Glassmorphism */
        .glass { background: rgba(255,255,255,0.1); backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.2); }
        .glass-dark { background: rgba(0,0,0,0.2); backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.1); }
        
        /* Gradient Text */
        .text-gradient { background: linear-gradient(135deg, #D4AF37 0%, #f59e0b 50%, #D4AF37 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; }
        
        /* Floating Hearts */
        .floating-heart { position: absolute; color: rgba(236,72,153,0.3); font-size: 24px; animation: float 8s ease-in-out infinite; }
        
        /* Badge Shine */
        .badge-shine { position: relative; overflow: hidden; }
        .badge-shine::after { content: ''; position: absolute; top: 0; left: -100%; width: 100%; height: 100%; background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent); animation: shimmer 3s infinite; }
        
        /* Card Hover Effect */
        .card-hover { transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1); }
        .card-hover:hover { transform: translateY(-8px) scale(1.02); }
        
        /* Sticky Mobile CTA */
        .sticky-cta { position: fixed; bottom: 0; left: 0; right: 0; z-index: 40; transform: translateY(100%); transition: transform 0.3s ease; }
        .sticky-cta.visible { transform: translateY(0); }
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
            <a href="tel:0965625210" class="hidden md:inline-flex items-center gap-2 px-5 py-2.5 rounded-full gradient-gold text-white font-semibold text-sm hover:opacity-90 transition shadow-lg shadow-amber-200">
                <i class="fas fa-phone"></i>
                <span>Gọi ngay</span>
            </a>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="min-h-screen flex items-center relative overflow-hidden pt-24 pb-16 bg-gradient-to-br from-amber-50 via-white to-rose-50">
        <!-- Floating Elements -->
        <div class="absolute top-20 right-10 w-72 h-72 bg-amber-100 rounded-full blur-3xl opacity-50 animate-float"></div>
        <div class="absolute bottom-20 left-10 w-96 h-96 bg-rose-100 rounded-full blur-3xl opacity-50 animate-float-delay"></div>
        <div class="floating-heart" style="top:15%; left:10%;">💕</div>
        <div class="floating-heart" style="top:25%; right:15%; animation-delay:1s;">💗</div>
        <div class="floating-heart" style="bottom:30%; left:20%; animation-delay:2s;">💖</div>
        <div class="floating-heart" style="bottom:20%; right:25%; animation-delay:3s;">💕</div>
        
        <div class="max-w-6xl mx-auto px-6 relative z-10 w-full">
            <div class="grid md:grid-cols-2 gap-12 items-center">
                <div>
                    <!-- Limited Time Offer Banner -->
                    <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-gradient-to-r from-rose-500 to-pink-500 text-white font-semibold text-sm mb-4 animate-pulse-glow badge-shine" data-aos="fade-up">
                        🔥 Ưu đãi Tết 2025 - Giảm 30%
                    </div>
                    
                    <span class="inline-block px-4 py-2 rounded-full bg-amber-100 text-amber-800 font-semibold text-sm mb-6" data-aos="fade-up" data-aos-delay="50">
                        ✨ Được tin tưởng bởi 500+ cặp đôi
                    </span>
                    
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
                    
                    <div class="flex gap-8 pt-8 border-t border-gray-200" data-aos="fade-up" data-aos-delay="400">
                        <div class="text-center">
                            <div class="text-3xl font-bold text-gradient">500+</div>
                            <div class="text-sm text-gray-500 mt-1">Thiệp đã tạo</div>
                        </div>
                        <div class="text-center">
                            <div class="text-3xl font-bold text-gradient">⭐ 5.0</div>
                            <div class="text-sm text-gray-500 mt-1">Đánh giá</div>
                        </div>
                        <div class="text-center">
                            <div class="text-3xl font-bold text-gradient">24h</div>
                            <div class="text-sm text-gray-500 mt-1">Hoàn thành</div>
                        </div>
                    </div>
                </div>
                
                <div class="relative" data-aos="fade-left" data-aos-duration="1000">
                    <!-- Phone Mockup with Template Preview -->
                    <div class="absolute inset-0 gradient-gold rounded-3xl blur-3xl opacity-20 animate-float"></div>
                    <div class="relative">
                        <img src="https://images.unsplash.com/photo-1519741497674-611481863552?q=80&w=800&auto=format&fit=crop" 
                             alt="Mẫu thiệp cưới online đẹp" 
                             class="relative rounded-3xl shadow-2xl w-full object-cover aspect-[4/5] card-hover">
                        <!-- Floating Badge -->
                        <div class="absolute -bottom-4 -right-4 bg-white rounded-2xl shadow-xl p-4 animate-float-delay">
                            <div class="flex items-center gap-3">
                                <div class="w-12 h-12 rounded-full gradient-gold flex items-center justify-center text-white text-xl">💒</div>
                                <div>
                                    <div class="font-bold text-gray-900">Mẫu HOT 2025</div>
                                    <div class="text-sm text-gray-500">Modern Style</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section id="services" class="py-24 bg-white">
        <div class="max-w-6xl mx-auto px-6">
            <div class="text-center mb-16">
                <span class="text-gold font-semibold uppercase tracking-widest text-sm" data-aos="fade-up">Dịch vụ của chúng tôi</span>
                <h2 class="text-3xl md:text-4xl font-serif font-bold mt-4" data-aos="fade-up" data-aos-delay="100">Giải Pháp Thiết Kế Toàn Diện</h2>
            </div>
            
            <div class="grid md:grid-cols-2 gap-8">
                <div class="bg-gradient-to-br from-rose-50 to-amber-50 rounded-3xl p-10 hover:shadow-xl transition duration-500" data-aos="fade-up">
                    <div class="w-16 h-16 rounded-2xl gradient-gold flex items-center justify-center text-3xl mb-6">💒</div>
                    <h3 class="text-2xl font-bold mb-4">Thiệp Cưới Online</h3>
                    <p class="text-gray-600 leading-relaxed mb-6">
                        Thiệp cưới điện tử đẹp mắt, hiển thị thông tin đầy đủ, hỗ trợ ngày âm lịch/dương lịch, quản lý khách mời, chia sẻ dễ dàng qua link hoặc QR Code.
                    </p>
                    <ul class="space-y-3 text-sm text-gray-600">
                        <li class="flex items-center gap-3"><i class="fas fa-check text-green-500"></i><span>Nhiều mẫu thiết kế độc quyền</span></li>
                        <li class="flex items-center gap-3"><i class="fas fa-check text-green-500"></i><span>Responsive trên mọi thiết bị</span></li>
                        <li class="flex items-center gap-3"><i class="fas fa-check text-green-500"></i><span>Tích hợp QR Code & bản đồ</span></li>
                        <li class="flex items-center gap-3"><i class="fas fa-check text-green-500"></i><span>Hỗ trợ chỉnh sửa không giới hạn</span></li>
                    </ul>
                </div>

                <div class="bg-gradient-to-br from-slate-900 to-slate-800 text-white rounded-3xl p-10 hover:shadow-xl transition duration-500" data-aos="fade-up" data-aos-delay="100">
                    <div class="w-16 h-16 rounded-2xl bg-white/10 flex items-center justify-center text-3xl mb-6">💼</div>
                    <h3 class="text-2xl font-bold mb-4">Danh Thiếp Số (Digital Business Card)</h3>
                    <p class="text-gray-300 leading-relaxed mb-6">
                        Landing page cá nhân chuyên nghiệp thay thế name card truyền thống. Nhiều giao diện cao cấp, thể hiện đẳng cấp và chuyên môn của bạn.
                    </p>
                    <ul class="space-y-3 text-sm text-gray-300">
                        <li class="flex items-center gap-3"><i class="fas fa-check text-gold"></i><span>7+ mẫu giao diện Landing Page</span></li>
                        <li class="flex items-center gap-3"><i class="fas fa-check text-gold"></i><span>Hiển thị dịch vụ, kinh nghiệm</span></li>
                        <li class="flex items-center gap-3"><i class="fas fa-check text-gold"></i><span>Tích hợp liên kết mạng xã hội</span></li>
                        <li class="flex items-center gap-3"><i class="fas fa-check text-gold"></i><span>Chia sẻ bằng link/QR Code</span></li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- Portfolio Section - Templates Preview -->
    <section id="portfolio" class="py-24 bg-gray-50">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center mb-16">
                <span class="text-gold font-semibold uppercase tracking-widest text-sm" data-aos="fade-up">Portfolio</span>
                <h2 class="text-3xl md:text-4xl font-serif font-bold mt-4" data-aos="fade-up" data-aos-delay="100">Tất Cả Mẫu Thiết Kế</h2>
            </div>

            <!-- Wedding Templates -->
            <div class="mb-16">
                <h3 class="text-2xl font-bold mb-8 flex items-center gap-3" data-aos="fade-up">
                    <span class="w-10 h-10 rounded-full gradient-gold flex items-center justify-center text-white text-lg">💒</span>
                    <span>Thiệp Cưới Online</span>
                </h3>
                <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
                    @forelse($demoWeddings as $index => $wedding)
                    <a href="{{ url($wedding->slug) }}" class="group relative bg-white rounded-2xl overflow-hidden shadow-lg hover:shadow-2xl transition duration-500" data-aos="fade-up" data-aos-delay="{{ $index * 50 }}">
                        <div class="aspect-[3/4] relative overflow-hidden bg-gray-100">
                            @if($wedding->template && $wedding->template->thumbnail_url)
                                <img src="{{ $wedding->template->thumbnail_url }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-700" alt="{{ $wedding->template->name }}">
                            @else
                                <div class="w-full h-full flex items-center justify-center bg-gray-200">
                                    <span class="text-gray-400">No Image</span>
                                </div>
                            @endif
                            <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent opacity-60"></div>
                            <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition flex items-center justify-center">
                                <span class="px-6 py-3 bg-white text-gray-900 rounded-full font-bold text-sm">Xem Demo</span>
                            </div>
                        </div>
                        <div class="p-5">
                            <h4 class="font-bold text-lg truncate">{{ $wedding->template->name ?? 'Mẫu thiệp cưới' }}</h4>
                            <p class="text-sm text-gray-500 truncate">{{ $wedding->groom_name }} & {{ $wedding->bride_name }}</p>
                        </div>
                    </a>
                    @empty
                    <div class="col-span-full text-center py-10">
                        <p class="text-gray-500">Đang cập nhật các mẫu demo...</p>
                    </div>
                    @endforelse
                </div>
            </div>

            <!-- Business Card Templates -->
            <div>
                <h3 class="text-2xl font-bold mb-8 flex items-center gap-3" data-aos="fade-up">
                    <span class="w-10 h-10 rounded-full bg-slate-900 flex items-center justify-center text-white text-lg">💼</span>
                    <span>Danh Thiếp Số (Business Card)</span>
                </h3>
                <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
                    @forelse($demoBusinessCards as $index => $card)
                    <a href="{{ url('p/' . $card->slug) }}" class="group relative bg-white rounded-2xl overflow-hidden shadow-lg hover:shadow-2xl transition duration-500" data-aos="fade-up" data-aos-delay="{{ $index * 50 }}">
                        <div class="aspect-[3/4] relative overflow-hidden bg-slate-900">
                            @if($card->template && $card->template->thumbnail_url)
                                <img src="{{ $card->template->thumbnail_url }}" class="w-full h-full object-cover opacity-80 group-hover:scale-110 transition duration-700" alt="{{ $card->template->name }}">
                            @else
                                <div class="w-full h-full flex items-center justify-center bg-gray-800">
                                    <span class="text-gray-400">No Image</span>
                                </div>
                            @endif
                            <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition flex items-center justify-center">
                                <span class="px-6 py-3 bg-white text-gray-900 rounded-full font-bold text-sm">Xem Demo</span>
                            </div>
                            @if($index < 2)
                            <div class="absolute top-4 right-4 px-3 py-1 bg-amber-500 text-black text-xs font-bold rounded-full">HOT</div>
                            @endif
                        </div>
                        <div class="p-5">
                            <h4 class="font-bold text-lg truncate">{{ $card->template->name ?? 'Mẫu danh thiếp' }}</h4>
                            <p class="text-sm text-gray-500 truncate">{{ $card->name }}</p>
                        </div>
                    </a>
                    @empty
                    <div class="col-span-full text-center py-10">
                        <p class="text-gray-500">Đang cập nhật các mẫu demo...</p>
                    </div>
                    @endforelse
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
                <p class="text-gray-400 mt-4 max-w-2xl mx-auto" data-aos="fade-up" data-aos-delay="150">
                    Chọn gói phù hợp với nhu cầu của bạn. Hỗ trợ chỉnh sửa miễn phí không giới hạn.
                </p>
            </div>
            
            <div class="grid md:grid-cols-2 gap-8 max-w-4xl mx-auto">
                <!-- STANDARD -->
                <div class="bg-white/5 backdrop-blur-sm border border-white/10 rounded-3xl p-8 card-hover" data-aos="fade-up">
                    <div class="text-center mb-8">
                        <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-rose-400 to-pink-500 flex items-center justify-center text-3xl mx-auto mb-4">�</div>
                        <h3 class="text-xl font-bold mb-2">STANDARD</h3>
                        <div class="text-4xl font-bold text-white mb-1">299K</div>
                        <div class="text-gray-400 text-sm">VNĐ / thiệp</div>
                    </div>
                    <ul class="space-y-4 mb-8 text-gray-300 text-sm">
                        <li class="flex items-center gap-3"><i class="fas fa-check text-green-400"></i>3 mẫu thiệp đẹp</li>
                        <li class="flex items-center gap-3"><i class="fas fa-check text-green-400"></i>Thông tin cô dâu chú rể</li>
                        <li class="flex items-center gap-3"><i class="fas fa-check text-green-400"></i>QR Code mừng cưới</li>
                        <li class="flex items-center gap-3"><i class="fas fa-check text-green-400"></i>RSVP xác nhận tham dự</li>
                        <li class="flex items-center gap-3"><i class="fas fa-check text-green-400"></i>Nhạc nền tùy chọn</li>
                        <li class="flex items-center gap-3"><i class="fas fa-check text-green-400"></i>Hiệu ứng Tim/Hoa đẹp</li>
                        <li class="flex items-center gap-3"><i class="fas fa-check text-green-400"></i>Countdown đếm ngược</li>
                        <li class="flex items-center gap-3"><i class="fas fa-check text-green-400"></i>Google Maps chỉ đường</li>
                        <li class="flex items-center gap-3"><i class="fas fa-check text-green-400"></i>Gallery tối đa 20 ảnh</li>
                        <li class="flex items-center gap-3"><i class="fas fa-check text-green-400"></i>Sử dụng trong 1 năm</li>
                        <li class="flex items-center gap-3 text-gray-500"><i class="fas fa-times"></i>Tên khách mời riêng</li>
                        <li class="flex items-center gap-3 text-gray-500"><i class="fas fa-times"></i>Custom domain</li>
                    </ul>
                    <a href="#contact" class="block w-full py-4 text-center rounded-full border border-white/30 font-bold hover:bg-white/10 transition">Chọn gói này</a>
                </div>
                
                <!-- PRO -->
                <div class="bg-gradient-to-br from-amber-500/20 to-orange-500/20 border-2 border-gold rounded-3xl p-8 relative card-hover scale-105" data-aos="fade-up" data-aos-delay="100">
                    <div class="absolute -top-4 left-1/2 -translate-x-1/2 px-4 py-1 rounded-full gradient-gold text-white text-sm font-bold animate-pulse-glow">
                        🔥 Phổ biến nhất
                    </div>
                    <div class="text-center mb-8">
                        <div class="w-16 h-16 rounded-2xl gradient-gold flex items-center justify-center text-3xl mx-auto mb-4">�</div>
                        <h3 class="text-xl font-bold mb-2">PRO</h3>
                        <div class="text-4xl font-bold text-gold mb-1">499K</div>
                        <div class="text-gray-400 text-sm line-through">799K</div>
                    </div>
                    <ul class="space-y-4 mb-8 text-gray-300 text-sm">
                        <li class="flex items-center gap-3"><i class="fas fa-check text-gold"></i><strong>6+ mẫu thiệp Premium</strong></li>
                        <li class="flex items-center gap-3"><i class="fas fa-check text-gold"></i>Tất cả tính năng Standard</li>
                        <li class="flex items-center gap-3"><i class="fas fa-check text-gold"></i>Gallery <strong>không giới hạn</strong> ảnh</li>
                        <li class="flex items-center gap-3"><i class="fas fa-check text-gold"></i>Sử dụng <strong>vĩnh viễn</strong></li>
                        <li class="flex items-center gap-3"><i class="fas fa-check text-gold"></i><strong>Animation "囍" mở cửa</strong></li>
                        <li class="flex items-center gap-3"><i class="fas fa-check text-gold"></i><strong>Hiệu ứng tùy chọn</strong> (Tim/Hoa/Tuyết/Lá)</li>
                        <li class="flex items-center gap-3"><i class="fas fa-check text-gold"></i><strong>Tên khách mời riêng</strong> (URL riêng)</li>
                        <li class="flex items-center gap-3"><i class="fas fa-check text-gold"></i><strong>Custom domain</strong> (vd: cuoi.ten.vn)</li>
                        <li class="flex items-center gap-3"><i class="fas fa-check text-gold"></i>Hỗ trợ ưu tiên 24/7</li>
                    </ul>
                    <a href="#contact" class="block w-full py-4 text-center rounded-full gradient-gold text-white font-bold hover:opacity-90 transition animate-pulse-glow">Chọn gói này</a>
                </div>
            </div>
            
            <!-- Trust badges -->
            <div class="mt-16 text-center" data-aos="fade-up">
                <p class="text-gray-400 text-sm mb-4">Thanh toán an toàn & bảo mật</p>
                <div class="flex justify-center gap-6 items-center opacity-60">
                    <span class="text-2xl">💳</span>
                    <span class="font-bold">MoMo</span>
                    <span class="font-bold">Chuyển khoản</span>
                    <span class="font-bold">Tiền mặt</span>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="py-24 bg-gradient-to-br from-rose-50 to-amber-50">
        <div class="max-w-6xl mx-auto px-6">
            <div class="text-center mb-16">
                <span class="text-gold font-semibold uppercase tracking-widest text-sm" data-aos="fade-up">Đánh giá</span>
                <h2 class="text-3xl md:text-4xl font-serif font-bold mt-4" data-aos="fade-up" data-aos-delay="100">
                    Khách Hàng <span class="text-gold">Nói Gì?</span>
                </h2>
            </div>
            
            <div class="grid md:grid-cols-3 gap-8">
                <div class="bg-white rounded-3xl p-8 shadow-lg card-hover" data-aos="fade-up">
                    <div class="flex gap-1 text-amber-400 mb-4">⭐⭐⭐⭐⭐</div>
                    <p class="text-gray-600 mb-6 italic">"Thiệp đẹp xuất sắc, bạn bè khen nhiều lắm! Team làm nhanh, support nhiệt tình. Recommend 100%!"</p>
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-full bg-gradient-to-br from-rose-400 to-pink-500 flex items-center justify-center text-white font-bold">TL</div>
                        <div><div class="font-bold">Thuỳ Linh</div><div class="text-sm text-gray-500">Cưới 12/2024</div></div>
                    </div>
                </div>
                
                <div class="bg-white rounded-3xl p-8 shadow-lg card-hover" data-aos="fade-up" data-aos-delay="100">
                    <div class="flex gap-1 text-amber-400 mb-4">⭐⭐⭐⭐⭐</div>
                    <p class="text-gray-600 mb-6 italic">"Thiệp cưới rất sang trọng và tiện lợi. Khách chỉ cần scan QR là thấy tất cả thông tin. Chức năng RSVP cũng rất hay!"</p>
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-full bg-gradient-to-br from-blue-400 to-indigo-500 flex items-center justify-center text-white font-bold">MH</div>
                        <div><div class="font-bold">Minh Hùng</div><div class="text-sm text-gray-500">Cưới 01/2025</div></div>
                    </div>
                </div>
                
                <div class="bg-white rounded-3xl p-8 shadow-lg card-hover" data-aos="fade-up" data-aos-delay="200">
                    <div class="flex gap-1 text-amber-400 mb-4">⭐⭐⭐⭐⭐</div>
                    <p class="text-gray-600 mb-6 italic">"Ban đầu định làm thiệp giấy nhưng thấy thiệp online đẹp và tiện hơn. Giá cũng hợp lý, tiết kiệm được nhiều!"</p>
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-full bg-gradient-to-br from-amber-400 to-orange-500 flex items-center justify-center text-white font-bold">NA</div>
                        <div><div class="font-bold">Ngọc Ánh</div><div class="text-sm text-gray-500">Cưới 11/2024</div></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="about" class="py-24 bg-white">
        <div class="max-w-6xl mx-auto px-6">
            <div class="grid md:grid-cols-2 gap-16 items-center">
                <div data-aos="fade-right">
                    <img src="https://images.unsplash.com/photo-1522202176988-66273c2fd55f?q=80&w=2071&auto=format&fit=crop" 
                         alt="Our Team" 
                         class="rounded-3xl shadow-xl w-full">
                </div>
                <div data-aos="fade-left">
                    <span class="text-gold font-semibold uppercase tracking-widest text-sm">Về chúng tôi</span>
                    <h2 class="text-3xl md:text-4xl font-serif font-bold mt-4 mb-6">
                        Đội Ngũ Thiết Kế <span class="text-gold">Tâm Huyết</span>
                    </h2>
                    <p class="text-gray-600 leading-relaxed mb-8">
                        THT Media là đơn vị chuyên cung cấp giải pháp thiết kế thiệp cưới online và danh thiếp số chuyên nghiệp. Với hơn 5 năm kinh nghiệm, chúng tôi cam kết mang đến sản phẩm chất lượng cao với giá cả hợp lý.
                    </p>
                    
                    <div class="space-y-6">
                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 rounded-full gradient-gold flex items-center justify-center text-white flex-shrink-0">
                                <i class="fas fa-medal"></i>
                            </div>
                            <div>
                                <h4 class="font-bold mb-1">Thiết kế độc quyền</h4>
                                <p class="text-sm text-gray-500">Mỗi mẫu được thiết kế riêng, không trùng lặp</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 rounded-full gradient-gold flex items-center justify-center text-white flex-shrink-0">
                                <i class="fas fa-clock"></i>
                            </div>
                            <div>
                                <h4 class="font-bold mb-1">Hoàn thành nhanh chóng</h4>
                                <p class="text-sm text-gray-500">Nhận bản thiết kế trong 24-48 giờ</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 rounded-full gradient-gold flex items-center justify-center text-white flex-shrink-0">
                                <i class="fas fa-headset"></i>
                            </div>
                            <div>
                                <h4 class="font-bold mb-1">Hỗ trợ tận tâm</h4>
                                <p class="text-sm text-gray-500">Chỉnh sửa miễn phí đến khi hài lòng</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA / Contact Section -->
    <section id="contact" class="py-24 bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900 text-white relative overflow-hidden">
        <div class="absolute top-0 right-0 w-96 h-96 bg-amber-500/10 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 left-0 w-96 h-96 bg-rose-500/10 rounded-full blur-3xl"></div>
        
        <div class="max-w-4xl mx-auto px-6 text-center relative z-10">
            <span class="text-gold font-semibold uppercase tracking-widest text-sm" data-aos="fade-up">Liên hệ ngay</span>
            <h2 class="text-3xl md:text-5xl font-serif font-bold mt-4 mb-8" data-aos="fade-up" data-aos-delay="100">
                Sẵn Sàng Tạo Thiệp Cưới <span class="text-gold">Độc Đáo</span>?
            </h2>
            <p class="text-xl text-gray-300 mb-12 max-w-2xl mx-auto leading-relaxed" data-aos="fade-up" data-aos-delay="200">
                Liên hệ ngay để được tư vấn miễn phí và nhận báo giá chi tiết cho dự án của bạn.
            </p>
            
            <div class="flex flex-col sm:flex-row justify-center gap-4 mb-12" data-aos="fade-up" data-aos-delay="300">
                <a href="tel:0965625210" class="inline-flex items-center justify-center gap-3 px-10 py-5 rounded-full gradient-gold text-white font-bold text-lg hover:opacity-90 transition shadow-xl">
                    <i class="fas fa-phone"></i>
                    <span>0965 625 210</span>
                </a>
                <a href="https://zalo.me/0965625210" target="_blank" class="inline-flex items-center justify-center gap-3 px-10 py-5 rounded-full bg-white/10 border border-white/20 font-bold text-lg hover:bg-white/20 transition">
                    <i class="fas fa-comment-dots"></i>
                    <span>Chat Zalo</span>
                </a>
            </div>
            
            <div class="flex flex-wrap justify-center gap-8 text-gray-400" data-aos="fade-up" data-aos-delay="400">
                <div class="flex items-center gap-2">
                    <i class="fas fa-envelope text-gold"></i>
                    <span>contact@thtmedia.com.vn</span>
                </div>
                <div class="flex items-center gap-2">
                    <i class="fas fa-globe text-gold"></i>
                    <span>thtmedia.com.vn</span>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="py-8 bg-slate-950 border-t border-white/5">
        <div class="max-w-6xl mx-auto px-6">
            <div class="flex flex-col md:flex-row justify-between items-center gap-4">
                <a href="https://thtmedia.com.vn" target="_blank" class="flex items-center gap-3">
                    <img src="https://thtmedia.com.vn/wp-content/uploads/2023/01/THT-media-logo-2023-261x300.png" alt="THT Media" class="h-10 w-auto">
                    <span class="text-gray-500 text-sm italic">một dịch vụ thuộc hệ sinh thái THT Media</span>
                </a>
                <div class="text-gray-500 text-sm text-center">
                    © {{ date('Y') }} <a href="https://thtmedia.com.vn" target="_blank" class="hover:text-rose-500">THT Media</a>. Tất cả bản quyền được bảo lưu.
                </div>
            </div>
        </div>
    </footer>

    <!-- Zalo Chat Widget -->
    <a href="https://zalo.me/0965625210" target="_blank" 
       class="fixed bottom-24 right-6 md:bottom-8 w-14 h-14 rounded-full bg-blue-500 text-white flex items-center justify-center shadow-xl hover:scale-110 transition z-50 animate-float">
        <svg class="w-7 h-7" viewBox="0 0 48 48" fill="currentColor"><path d="M24 4C12.954 4 4 12.954 4 24s8.954 20 20 20 20-8.954 20-20S35.046 4 24 4zm-4 31h-4v-4h4v4zm0-6h-4V15h4v14zm8 6h-4v-6h4v6zm0-8h-4V15h4v12z"/></svg>
    </a>
    
    <!-- Sticky Mobile CTA -->
    <div id="stickyCta" class="sticky-cta md:hidden bg-white border-t border-gray-100 shadow-2xl px-4 py-3 safe-area-bottom">
        <div class="flex gap-3">
            <a href="tel:0965625210" class="flex-1 py-3 text-center rounded-full bg-gray-100 font-bold text-gray-700">
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
        
        // Sticky CTA visibility on scroll
        const stickyCta = document.getElementById('stickyCta');
        let lastScroll = 0;
        window.addEventListener('scroll', () => {
            const currentScroll = window.pageYOffset;
            if (currentScroll > 500) {
                stickyCta.classList.add('visible');
            } else {
                stickyCta.classList.remove('visible');
            }
            lastScroll = currentScroll;
        });
    </script>
</body>
</html>
