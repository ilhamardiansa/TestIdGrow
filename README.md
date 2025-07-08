
# 🚀 Laravel API Project

Panduan lengkap untuk instalasi, konfigurasi, dan menjalankan proyek Laravel API ini.

---

## 🚀 POSTMAN LINK

Link Postman : https://www.postman.com/orange-flare-718608/workspace/ilham/collection/34062565-c5e87629-1921-45b4-a306-dc84266fb354?action=share&creator=34062565

## 📦 Requirements

Sebelum memulai, pastikan Anda sudah menginstal:

- **PHP >= 8.x**
- **Composer**
- **MySQL/MariaDB**
- **Node.js & NPM** (jika ada frontend)
- **Git** (opsional)
- **Laravel 10.x** (akan otomatis terinstall via Composer)

---

## 🔥 Installation Guide

### 1️⃣ Clone Repository
Clone project ke dalam folder lokal Anda:
```bash
git clone https://github.com/ilhamardiansa/TestIdGrow
cd project-name
```

2️⃣ Install PHP Dependencies
Jalankan perintah berikut untuk menginstal dependency Laravel:

```bash
composer install
```

3️⃣ Copy File Environment
Buat salinan file .env.example menjadi .env:

4️⃣ Generate App Key
Generate key aplikasi Laravel:

```bash
php artisan key:generate
```

5️⃣ Jalankan Migrasi dan Seeder
Buat struktur database dan isi data awal dengan:

```bash
php artisan migrate --seed
```

6️⃣ Start Development Server
Jalankan server lokal Laravel:

```bash
php artisan serve
```
Aplikasi akan berjalan di http://127.0.0.1:8000