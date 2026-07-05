# 🍅 PomoTasky

PomoTasky adalah aplikasi manajemen tugas berbasis web yang menggabungkan **Teknik Pomodoro**, **Task Management**, dan **Gamification** untuk membantu pengguna meningkatkan produktivitas belajar maupun bekerja.

Website ini dibangun menggunakan **Laravel 12**, **Filament Admin Panel**, **Livewire**, **Tailwind CSS**, dan dijalankan menggunakan **Docker**.

---

## ✨ Fitur Utama

### 👤 User

- Registrasi akun
- Login menggunakan Email & Password
- Login menggunakan Google OAuth
- Logout
- Dashboard pengguna
- Manajemen Task
    - Tambah Task
    - Edit Task
    - Hapus Task
    - Menandai Task selesai
- Pomodoro Timer
- Statistik produktivitas
- Badge Achievement
- Challenge harian
- Announcement
- Integrasi Google Calendar
- Reminder Task

---

### 🛠 Admin

Menggunakan **Filament Admin Panel**.

Admin dapat mengelola:

- User
- Task
- Badge
- Challenge
- Announcement
- Reminder
- Activity Log
- Settings
- Pomodoro Session
- Role & Permission (Spatie Permission)

---

## 🚀 Teknologi

- Laravel 12
- PHP 8.3
- Livewire
- Filament v3
- Tailwind CSS
- Vite
- MySQL / MariaDB
- Docker
- Nginx
- Google OAuth (Laravel Socialite)
- Google Calendar API
- Spatie Permission

---

## 📂 Struktur Project

```
pomodotask-2026
│
├── src/
│   ├── app/
│   ├── resources/
│   ├── routes/
│   ├── public/
│   └── database/
│
├── nginx/
├── php/
├── db/
└── docker-compose.yml
```

---

## ⚙️ Instalasi

Clone repository

```bash
git clone https://github.com/adelittt/pomodotask-2026.git

cd pomodotask-2026
```

---

Copy file environment

```bash
cp src/.env.example src/.env
```

---

Jalankan Docker

```bash
docker compose up -d --build
```

---

Masuk ke container

```bash
docker compose exec php bash
```

---

Install dependency

```bash
composer install
```

---

Generate Key

```bash
php artisan key:generate
```

---

Migration Database

```bash
php artisan migrate --seed
```

---

Install Frontend

```bash
npm install
npm run build
```

---

Storage Link

```bash
php artisan storage:link
```

---

Akses Website

```
http://localhost
```

atau

```
https://domain-anda
```

---

## 🔑 Konfigurasi Google OAuth

Tambahkan konfigurasi berikut pada file `.env`

```env
GOOGLE_CLIENT_ID=
GOOGLE_CLIENT_SECRET=
GOOGLE_REDIRECT_URI=https://your-domain/auth/google/callback
```

---

## 📅 Google Calendar

Tambahkan scope berikut pada Google Cloud Console

```
https://www.googleapis.com/auth/calendar
```

Kemudian hubungkan akun Google melalui menu Google Calendar pada aplikasi.

---

## 👥 Role

Project menggunakan package **Spatie Laravel Permission**.

Role yang tersedia:

- User
- Admin
- Super Admin

---

## 📊 Gamification

Fitur gamification meliputi:

- Badge
- Challenge
- Progress
- Statistik Pomodoro
- Produktivitas Harian

---

## 🔐 Authentication

Mendukung dua metode login:

- Email & Password
- Google OAuth

---

## 📦 API & Integrasi

- Google OAuth
- Google Calendar API

---

## 📸 Screenshot

### Landing Page

> Tambahkan screenshot landing page di sini.

### Dashboard User

> Tambahkan screenshot dashboard pengguna.

### Admin Panel

> Tambahkan screenshot Filament Admin.

---

## 📄 License

Project ini dibuat untuk memenuhi tugas mata kuliah **Pemrograman Web** dan dapat digunakan sebagai media pembelajaran.

---

## 👨‍💻 Developer

**Adellita Meliana Putri**

Universitas Singaperbangsa Karawang

2026