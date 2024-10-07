# Project Laravel Admin Panel

## Deskripsi Proyek

Ini adalah project Laravel berbasis Admin Panel sederhana yang mengelola **Categories** dan **Products**. Project ini menggunakan **Laravel 10**, **Sanctum** untuk autentikasi, dan REST API untuk komunikasi dengan aplikasi frontend atau client.

Fitur utama dari aplikasi ini meliputi:
- CRUD Categories (Create, Read, Update, Delete)
- CRUD Products (Create, Read, Update, Delete)
- Login, Logout, dan informasi user yang terautentikasi
- API berbasis REST menggunakan JSON

## Requirements

Pastikan Anda sudah menginstal dependensi berikut sebelum menjalankan project ini:

- PHP 8.1 atau versi yang lebih baru
- Composer 2.0 atau versi yang lebih baru
- MySQL 5.7 atau yang lebih baru
- Node.js & NPM untuk pengelolaan frontend
  
## Dependency

Project ini memiliki beberapa dependency utama yang perlu diinstall. Pastikan menjalankan perintah di bawah ini untuk menginstall dependency:

```bash
composer install
npm install
```

Pastikan juga untuk melakukan kompilasi assets:

```bash
npm run dev
```
## Informasi Tambahan
- Autentikasi: Project ini menggunakan Laravel Sanctum untuk autentikasi berbasis token. Setelah login, token harus dikirim di setiap permintaan API menggunakan header Authorization: Bearer {token}.
- Error Handling: Semua endpoint API menangani error dengan baik, dengan mengembalikan response JSON yang sesuai.
