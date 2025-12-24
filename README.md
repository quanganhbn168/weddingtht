# WeddingTHT - Nền tảng Thiệp Cưới Online

WeddingTHT là một nền tảng SaaS (Software as a Service) mạnh mẽ và hiện đại, cho phép người dùng tạo và quản lý thiệp cưới kỹ thuật số một cách dễ dàng và chuyên nghiệp.

## 🚀 Tính năng nổi bật

-   **Kho giao diện đa dạng:** Cung cấp nhiều mẫu thiệp cưới đẹp mắt, từ phong cách tối giản (Minimal) đến hiện đại (Modern).
-   **Quản lý khách mời:** Dễ dàng thêm, sửa, xóa và phân nhóm khách mời.
-   **RSVP Online:** Cho phép khách mời xác nhận tham dự trực tuyến, giúp cô dâu chú rể quản lý số lượng khách chính xác.
-   **Tùy chỉnh linh hoạt:** Người dùng có thể tùy chỉnh nội dung, hình ảnh, âm nhạc và bản đồ cho thiệp cưới.
-   **Giao diện Admin mạnh mẽ:** Sử dụng FilamentPHP để quản lý toàn bộ hệ thống, từ người dùng, đơn hàng đến các thiết lập giao diện.
-   **Responsive:** Hiển thị hoàn hảo trên mọi thiết bị (Mobile, Tablet, Desktop).

## 🛠 Công nghệ sử dụng

Dự án được xây dựng dựa trên các công nghệ hiện đại:

-   **Backend:** [Laravel](https://laravel.com/) (Framework PHP hàng đầu)
-   **Admin Panel:** [FilamentPHP](https://filamentphp.com/) (TALL Stack admin panel)
-   **Frontend:** Blade Templates, [Livewire](https://livewire.laravel.com/), [Alpine.js](https://alpinejs.dev/), [Tailwind CSS](https://tailwindcss.com/)
-   **Database:** MySQL

## 📦 Cài đặt và Triển khai

Để cài đặt dự án trên máy cục bộ, làm theo các bước sau:

1.  **Clone repository:**
    ```bash
    git clone https://github.com/quanganhbn168/weddingtht.git
    cd weddingtht
    ```

2.  **Cài đặt dependencies:**
    ```bash
    composer install
    npm install
    ```

3.  **Cấu hình môi trường:**
    -   Copy file `.env.example` thành `.env`
    -   Cấu hình thông tin database và các keys cần thiết.

4.  **Tạo key và migrate database:**
    ```bash
    php artisan key:generate
    php artisan migrate
    php artisan db:seed --class=AdminUserSeeder # (Tùy chọn: tạo tài khoản admin mẫu)
    ```

5.  **Build assets:**
    ```bash
    npm run build
    ```

6.  **Chạy server:**
    ```bash
    php artisan serve
    ```

## 📝 Đóng góp

Mọi đóng góp đều được hoan nghênh. Vui lòng tạo Pull Request hoặc gửi Issue nếu bạn tìm thấy lỗi hoặc muốn đề xuất tính năng mới.

## 📄 License

Dự án này là software proprietary. Vui lòng liên hệ tác giả để biết thêm chi tiết về quyền sử dụng.
