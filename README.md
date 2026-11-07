# Portofolio Pribadi & CMS Admin

Website Portofolio Pribadi modern berkonsep **Futuristic Dark Forest** yang dilengkapi dengan **Content Management System (CMS) Admin** terintegrasi secara dinamis.

---

## 🚀 Tech Stack

- **Backend**: [Laravel 11](https://laravel.com) (RESTful API, Sanctum Token Authentication, Eloquent ORM)
- **Database**: [MySQL / MariaDB](https://mariadb.org) (Collation: `utf8mb4_unicode_ci`)
- **Frontend**: [Vue 3](https://vuejs.org) (Composition API, `<script setup>`), [Vue Router 4](https://router.vuejs.org)
- **Styling**: [Tailwind CSS 3.4](https://tailwindcss.com) (Custom Palette & Glassmorphism)
- **Bundler**: [Vite 5](https://vitejs.dev)

---

## 🎨 Palet Warna Wajib (Dark Forest & Sage Green)

| Warna | Hex Code | Peruntukan & Kegunaan |
| :--- | :--- | :--- |
| `forest-950` | `#051F20` | Background utama paling gelap (Landing page & Dashboard base) |
| `forest-900` | `#0B2B26` | Background sekunder, base kartu gelap, & sidebar |
| `forest-800` | `#163832` | Surface kartu glassmorphism & background input form |
| `forest-700` | `#235347` | Border kartu, tombol sekunder, & state hover |
| `sage-400` | `#8EB69B` | Aksen utama, neon glow (`shadow-sage-glow`), progress bar, & indikator aktif |
| `mint-100` | `#DAF1DE` | Warna teks utama / heading & highlight terang |

---

## 🌟 Fitur Utama

### 1. Halaman Public Portfolio (`/`)
- **Background Ornaments**: Ornamen geometris 3D wireframe heksagonal & garis isometric halus berlatar belakang gradasi gelap.
- **Floating Vertical Pill Sidebar**: Navigasi mengambang di sisi kiri dengan indikator dot bulat menyala `#8EB69B` dan pelacak posisi scroll otomatis (*scroll spy*).
- **Hero Section**: Foto profil bulat dengan glow hijau sage, status ketersediaan freelance dengan animasi pulsating dot, efek ketik dinamis (*typing effect*) pada role, deskripsi bio, serta tombol CTA *"View My Work"* dan *"Download CV"*.
- **About Me & Technical Skills (Layout 2 Kolom)**:
  - *Kiri*: Kartu glassmorphism cerita tentang diri dan tombol *"LEARN MORE"* modal.
  - *Kanan*: Grid kartu persegi kecil teknologi (Laravel, Vue 3, Tailwind, MySQL, PHP, JS, Git, Docker).
- **Featured Projects & Services (Layout 2 Kolom)**:
  - *Kiri*: Carousel slider proyek pilihan dengan dot indicator menyala.
  - *Kanan*: 3 Kartu layanan vertikal (Web Development, UI/UX Design, RESTful API).
- **My Skills & My Portfolio (Grid 3x2)**:
  - *My Skills*: Horizontal progress bar penguasaan teknologi di atas track gelap berilustrasi editor kode.
  - *My Portfolio*: Showcase proyek 3x2 dengan filter kategori interaktif (All, Web App, E-Commerce, dsb.) dan modal detail.
- **Education & Certifications (Layout 2 Kolom)**: Timeline pendidikan akademik di kiri dan sertifikasi resmi di kanan.
- **Contact Section & Footer**: Form kontak pengunjung terhubung langsung ke backend, tombol ganda *"SEND MESSAGE"* & *"DOWNLOAD CV"*, serta footer elegan.

---

### 2. CMS Admin Dashboard (`/admin/dashboard`)
- **Login Admin Sanctum (`/admin/login`)**: Autentikasi aman berbasis Bearer Token dan Navigation Guard.
- **Fixed Left Sidebar**:
  - Profil dan identitas Admin.
  - Menu navigasi dengan state aktif `bg-[#235347]` dan border kiri `#8EB69B`.
  - Kartu gradasi status *"Available for Freelance"* dengan **Toggle Switch** interaktif.
  - Area unggah & kelola file CV (PDF).
  - Akses modal pengaturan Social Media Links.
- **Dashboard Utama**:
  - Top Bar dengan tombol cepat *"Preview Website"*.
  - **Hero Summary Card**: Ringkasan profil aktif, badge *"Years of Experience"*, dan modal edit biodata lengkap.
  - **Gradient Stats Banner**: Banner horizontal gradasi (`from-[#163832] via-[#235347] to-[#8EB69B]`) dengan 4 metrik (*Happy Clients*, *Projects Completed*, *Years Experience*, *Awards Received*) yang dapat diubah angkanya secara langsung (*inline edit*).
- **Modul CRUD Lengkap**:
  - **CRUD Services**: Grid 4 kolom layanan dengan form modal, upload ikon, dan urutan tampilan.
  - **CRUD Projects**: Grid 4 kolom proyek dengan upload gambar thumbnail, tag teknologi (*chips*), URL demo/repo, dan toggle *Featured*.
  - **CRUD Skills**: Pengaturan skill untuk tipe *Grid Icon* maupun *Progress Bar* (slider persentase 0–100%).
  - **CRUD Education & Certifications**: Pengaturan riwayat pendidikan akademik dan sertifikasi industri.
- **Contact Messages Inbox**:
  - Kotak masuk pesan dari pengunjung website dengan filter pesan belum dibaca (*unread*).
  - Fitur toggle status *Read/Unread*, hapus pesan, dan tombol balas email langsung (`mailto:`).
  - Form pembaharuan informasi kontak publik (Email, Telepon, Lokasi).

---

## 🔐 Kredensial Default Admin

- **URL Login**: `http://127.0.0.1:8000/admin/login`
- **Email**: `admin@portofolio.test`
- **Password**: `password123`

---

## 🛠️ Instalasi & Menjalankan Project

### 1. Prasyarat Sistem
- PHP >= 8.2 (dengan ekstensi `pdo_mysql`, `fileinfo`, `mbstring`, `curl`)
- Composer >= 2.0
- Node.js >= 18.0 & npm
- MySQL / MariaDB Server

### 2. Langkah Setup
```bash
# Clone repository
git clone https://github.com/Tiannn-r/Portofolio.git
cd Portofolio

# Salin file environment
cp .env.example .env

# Generate Application Key
php artisan key:generate

# Konfigurasi database di file .env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=portofolio
DB_USERNAME=root
DB_PASSWORD=
DB_COLLATION=utf8mb4_unicode_ci

# Jalankan migrasi dan seeder awal
php artisan migrate:fresh --seed

# Buat symbolic link storage untuk file avatar dan CV
php artisan storage:link

# Jalankan build frontend
npm install
npm run build
```

### 3. Menjalankan Server Lokal
```bash
# Terminal 1: Backend Server
php artisan serve

# Terminal 2 (Opsional untuk Hot Module Replacement Frontend):
npm run dev
```

Buka browser Anda di `http://127.0.0.1:8000`.

---

## 🧪 Pengujian Otomatis (Automated Tests)

Semua endpoint API dan integrasi Sanctum telah diuji menggunakan Feature Test:
```bash
php artisan test
```

Hasil pengujian mencakup verifikasi:
- Endpoint publik `/api/portfolio`
- Pengiriman pesan kontak `/api/contact`
- Autentikasi login admin `/api/admin/login`
- Akses metrik dashboard admin `/api/admin/stats`

---

## 📄 Lisensi
Proyek ini dilisensikan di bawah lisensi [MIT](LICENSE).
