# 📚 DACS — Website bán sách (Laravel)

Đồ án cơ sở: website bán sách xây dựng bằng **Laravel 12**, giao diện **Bootstrap 5** (qua Vite), xác thực bằng **laravel/ui**.

> Trạng thái: đang phát triển — đã có trang chủ, đăng ký/đăng nhập, khung dashboard user & admin.

---

## ✨ Chức năng hiện có

| Chức năng | Route | Controller / View |
| --- | --- | --- |
| Trang chủ (banner slider, danh mục sách, khối sách nổi bật) | `GET /` | `HomeController@index` → `views/index.blade.php` |
| Đăng ký / Đăng nhập / Quên mật khẩu | `/login`, `/register`, `/password/*` | `laravel/ui` (Auth::routes) |
| Dashboard người dùng | `GET /account-dashboard` (cần đăng nhập) | `UserController@index` → `views/user/index.blade.php` |
| Dashboard quản trị | `GET /admin` (cần đăng nhập + quyền admin) | `UserController@index` → `views/admin/index.blade.php` |
| Trang chào mặc định | `GET /welcome` | closure trả về `welcome` |

Phân quyền admin dùng middleware `App\Http\Middleware\AuthAdmin`, kiểm tra `Auth::user()->utype === 'ADM'`.

> ⚠️ **Lưu ý khi tiếp tục phát triển:** cột `utype` chưa có trong migration `create_users_table` và chưa nằm trong `User::$fillable`, nên cần bổ sung (thêm cột + cho phép mass assignment) trước khi middleware `AuthAdmin` hoạt động đúng.

---

## 🏗️ Công nghệ

| Thành phần | Công nghệ |
| --- | --- |
| Backend | PHP ^8.2, Laravel ^12.0 |
| Auth scaffolding | `laravel/ui` ^4.6 (Bootstrap) |
| Frontend | Blade, Bootstrap 5, Vite 7 |
| CSS tooling | Tailwind CSS 4 (cài sẵn, giao diện chính vẫn dùng Bootstrap) |
| Database | MySQL / SQLite (cấu hình trong `.env`) |

---

## 📁 Cấu trúc chính

```
dacs/web/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── HomeController.php     # trang chủ
│   │   │   ├── UserController.php     # dashboard user & admin
│   │   │   ├── AdminController.php    # dashboard admin
│   │   │   └── Auth/                  # controller do laravel/ui sinh ra
│   │   └── Middleware/AuthAdmin.php   # kiểm tra quyền admin (utype = ADM)
│   └── Models/User.php
├── database/migrations/               # users, cache, jobs
├── resources/
│   ├── views/
│   │   ├── index.blade.php            # trang chủ bán sách
│   │   ├── home.blade.php
│   │   ├── admin/index.blade.php
│   │   ├── user/index.blade.php
│   │   ├── auth/                      # login, register, verify, passwords
│   │   └── layouts/app.blade.php
│   ├── css/app.css
│   └── js/app.js
├── routes/
│   ├── web.php
│   └── console.php
├── public/
├── composer.json
├── package.json
└── vite.config.js
```

---

## 🚀 Cài đặt & chạy

### Yêu cầu
- PHP >= 8.2, Composer
- Node.js >= 18
- MySQL (hoặc dùng SQLite cho nhanh)

### Các bước

```bash
# 1. Cài dependency
composer install
npm install

# 2. Tạo file môi trường
cp .env.example .env
php artisan key:generate

# 3. Cấu hình DB trong .env (ví dụ MySQL)
#    DB_CONNECTION=mysql
#    DB_DATABASE=dacs
#    DB_USERNAME=root
#    DB_PASSWORD=

# 4. Tạo bảng
php artisan migrate

# 5. Chạy (2 terminal)
npm run dev
php artisan serve
```

Mở http://127.0.0.1:8000

Hoặc chạy tất cả bằng một lệnh:

```bash
composer run dev
```

### Tạo tài khoản admin

Sau khi migrate, thêm cột `utype` cho bảng `users` và đặt giá trị `ADM` cho tài khoản admin, ví dụ:

```bash
php artisan tinker
```

```php
// sau khi đã thêm cột utype
User::where('email', 'admin@example.com')->update(['utype' => 'ADM']);
```

---

## 🔐 Bảo mật

- File `.env` (chứa `APP_KEY`, thông tin DB, mail) **không** được commit — đã có trong `.gitignore`.
- Không commit `vendor/`, `node_modules/`, `public/build`, `storage/logs`.

---

## 📄 Giấy phép

Dự án phục vụ mục đích học tập (đồ án cơ sở).
