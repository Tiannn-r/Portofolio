<?php

namespace Database\Seeders;

use App\Models\ContactMessage;
use App\Models\Education;
use App\Models\Profile;
use App\Models\Project;
use App\Models\Service;
use App\Models\Skill;
use App\Models\Story;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database with complete dummy data.
     */
    public function run(): void
    {
        // 1. Admin Users
        User::updateOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'Admin Portofolio',
                'password' => Hash::make('admin123'),
            ]
        );

        User::firstOrCreate(
            ['email' => 'admin@portofolio.test'],
            [
                'name' => 'Admin Portofolio',
                'password' => Hash::make('password123'),
            ]
        );

        // 2. Profile
        Profile::updateOrCreate(
            ['id' => 1],
            [
                'name' => 'Muhamad Ibnhu',
                'roles' => [
                    'Full-Stack Developer',
                    'Backend Specialist',
                    'UI/UX Enthusiast',
                    'Cloud & System Architect',
                ],
                'short_bio' => 'Passionate Full-Stack Developer with deep experience crafting scalable web applications, sleek user experiences, and robust RESTful APIs using Laravel and Vue.js.',
                'about_me' => "Halo! Saya adalah seorang Full-Stack Developer yang berdedikasi dalam membangun produk digital modern, cepat, dan terukur. Berpengalaman dalam merancang arsitektur backend berbasis Laravel, relational database MySQL, serta antarmuka interaktif dengan Vue 3 dan Tailwind CSS.\n\nSaya mengedepankan performa, keamanan, dan clean code pada setiap aplikasi yang saya bangun, serta senantiasa antusias untuk memecahkan tantangan rekayasa perangkat lunak berskala besar.",
                'avatar' => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=600&q=80',
                'cv_file' => null,
                'is_available' => true,
                'email' => 'ibnhu.work@gmail.com',
                'phone' => '+62 812-3456-7890',
                'location' => 'Jakarta, Indonesia',
                'social_links' => [
                    'github' => 'https://github.com/Tiannn-r',
                    'linkedin' => 'https://linkedin.com/in/muhamad-ibnhu',
                    'instagram' => 'https://instagram.com/tiannn',
                    'twitter' => 'https://x.com/tiannn',
                ],
                'happy_clients' => 18,
                'projects_completed' => 24,
                'years_experience' => 3,
                'awards_received' => 5,
                'skills_overview' => [
                    'title' => 'Engineering Scalable & Resilient Systems',
                    'description' => 'Fokus pada rekayasa perangkat lunak yang andal, pemeliharaan kode bersih, serta antarmuka interaktif yang cepat dan terukur.',
                    'highlights' => [
                        ['title' => 'Modern Backend', 'subtitle' => 'Laravel, MySQL, REST API'],
                        ['title' => 'Reactive Frontend', 'subtitle' => 'Vue 3, Tailwind CSS'],
                    ],
                ],
            ]
        );

        // 3. Skills
        // Clear previous skills for clean seed state if re-run
        Skill::truncate();

        $skills = [
            // Technical Skills (grid_icon)
            [
                'name' => 'Laravel',
                'icon' => 'https://cdn.jsdelivr.net/gh/devicons/devicon/icons/laravel/laravel-original.svg',
                'percentage' => 92,
                'type' => 'grid_icon',
                'order' => 1,
            ],
            [
                'name' => 'Vue.js 3',
                'icon' => 'https://cdn.jsdelivr.net/gh/devicons/devicon/icons/vuejs/vuejs-original.svg',
                'percentage' => 88,
                'type' => 'grid_icon',
                'order' => 2,
            ],
            [
                'name' => 'Tailwind CSS',
                'icon' => 'https://cdn.jsdelivr.net/gh/devicons/devicon/icons/tailwindcss/tailwindcss-original.svg',
                'percentage' => 95,
                'type' => 'grid_icon',
                'order' => 3,
            ],
            [
                'name' => 'MySQL',
                'icon' => 'https://cdn.jsdelivr.net/gh/devicons/devicon/icons/mysql/mysql-original.svg',
                'percentage' => 85,
                'type' => 'grid_icon',
                'order' => 4,
            ],
            [
                'name' => 'PHP (8+)',
                'icon' => 'https://cdn.jsdelivr.net/gh/devicons/devicon/icons/php/php-original.svg',
                'percentage' => 90,
                'type' => 'grid_icon',
                'order' => 5,
            ],
            [
                'name' => 'JavaScript (ES6+)',
                'icon' => 'https://cdn.jsdelivr.net/gh/devicons/devicon/icons/javascript/javascript-original.svg',
                'percentage' => 89,
                'type' => 'grid_icon',
                'order' => 6,
            ],
            [
                'name' => 'Git & GitHub',
                'icon' => 'https://cdn.jsdelivr.net/gh/devicons/devicon/icons/git/git-original.svg',
                'percentage' => 87,
                'type' => 'grid_icon',
                'order' => 7,
            ],
            [
                'name' => 'Docker',
                'icon' => 'https://cdn.jsdelivr.net/gh/devicons/devicon/icons/docker/docker-original.svg',
                'percentage' => 76,
                'type' => 'grid_icon',
                'order' => 8,
            ],

            // My Skills (progress_bar)
            [
                'name' => 'Backend Architecture & API Development',
                'icon' => null,
                'percentage' => 92,
                'type' => 'progress_bar',
                'order' => 1,
            ],
            [
                'name' => 'Frontend UI/UX Implementation',
                'icon' => null,
                'percentage' => 88,
                'type' => 'progress_bar',
                'order' => 2,
            ],
            [
                'name' => 'Relational Database Design & Query Tuning',
                'icon' => null,
                'percentage' => 85,
                'type' => 'progress_bar',
                'order' => 3,
            ],
            [
                'name' => 'Responsive Design & Accessibility',
                'icon' => null,
                'percentage' => 95,
                'type' => 'progress_bar',
                'order' => 4,
            ],
            [
                'name' => 'System Security & Authentication (Sanctum/OAuth)',
                'icon' => null,
                'percentage' => 86,
                'type' => 'progress_bar',
                'order' => 5,
            ],
        ];

        foreach ($skills as $skill) {
            Skill::create($skill);
        }

        // 4. Services
        Service::truncate();

        $services = [
            [
                'title' => 'Web Development',
                'description' => 'Membangun aplikasi web kustom yang responsif, berkinerja tinggi, dan scalable menggunakan ekosistem modern Laravel 11 dan Vue 3.',
                'icon' => 'https://api.iconify.design/heroicons:code-bracket-solid.svg',
                'order' => 1,
            ],
            [
                'title' => 'UI/UX Design & Implementation',
                'description' => 'Menerjemahkan ide produk ke dalam antarmuka visual yang memukau, intuitif, dan responsif dengan Tailwind CSS dan user-centric design.',
                'icon' => 'https://api.iconify.design/heroicons:paint-brush-solid.svg',
                'order' => 2,
            ],
            [
                'title' => 'RESTful API & Integration',
                'description' => 'Merancang arsitektur API yang aman, berkecepatan tinggi, terstandarisasi, dan terintegrasi dengan payment gateway maupun layanan pihak ketiga.',
                'icon' => 'https://api.iconify.design/heroicons:circle-stack-solid.svg',
                'order' => 3,
            ],
            [
                'title' => 'Database & Performance Tuning',
                'description' => 'Optimalisasi relasi database MySQL, query indexing, caching Redis, dan peningkatan kecepatan loading aplikasi web.',
                'icon' => 'https://api.iconify.design/heroicons:server-solid.svg',
                'order' => 4,
            ],
        ];

        foreach ($services as $service) {
            Service::create($service);
        }

        // 5. Projects
        Project::truncate();

        $projects = [
            [
                'title' => 'Enterprise Resource Planning (ERP) System',
                'slug' => 'enterprise-resource-planning-system',
                'category' => 'Web Application',
                'description' => 'Platform ERP modern untuk enterprise dengan manajemen inventaris realtime, pelaporan akuntansi otomatis, manajemen multi-cabang, dan role-based access control yang aman.',
                'thumbnail' => 'https://images.unsplash.com/photo-1460925895917-afdab827c52f?auto=format&fit=crop&w=800&q=80',
                'tech_stack' => ['Laravel 11', 'Vue 3', 'Tailwind CSS', 'MySQL', 'Chart.js'],
                'url_demo' => 'https://erp.demo.portofolio.id',
                'url_repo' => 'https://github.com/Tiannn-r/Portofolio',
                'is_featured' => true,
                'order' => 1,
            ],
            [
                'title' => 'Multi-Vendor Marketplace & Checkout Platform',
                'slug' => 'multi-vendor-marketplace-checkout-platform',
                'category' => 'E-Commerce',
                'description' => 'Aplikasi e-commerce lengkap dengan cart realtime, integrasi pembayaran digital, pelacakan kurir otomatis, serta dashboard analitik penjualan bagi merchant.',
                'thumbnail' => 'https://images.unsplash.com/photo-1557821552-17105176677c?auto=format&fit=crop&w=800&q=80',
                'tech_stack' => ['Laravel 11', 'Vue 3', 'Pinia', 'Tailwind CSS', 'Midtrans API'],
                'url_demo' => 'https://shop.demo.portofolio.id',
                'url_repo' => 'https://github.com/Tiannn-r/Portofolio',
                'is_featured' => true,
                'order' => 2,
            ],
            [
                'title' => 'Personal Portfolio & Admin CMS Engine',
                'slug' => 'personal-portfolio-admin-cms-engine',
                'category' => 'Full-Stack Web',
                'description' => 'Sistem website portofolio interaktif yang terhubung langsung ke Content Management System (CMS) Admin dengan autentikasi Sanctum dan manajemen pesan kontak.',
                'thumbnail' => 'https://images.unsplash.com/photo-1507238691740-187a5b1d37b8?auto=format&fit=crop&w=800&q=80',
                'tech_stack' => ['Laravel 11', 'Sanctum', 'Vue 3', 'Tailwind CSS', 'MySQL'],
                'url_demo' => 'https://portofolio.id',
                'url_repo' => 'https://github.com/Tiannn-r/Portofolio',
                'is_featured' => true,
                'order' => 3,
            ],
            [
                'title' => 'Healthcare Clinic Appointment & Electronic Medical Record',
                'slug' => 'healthcare-clinic-appointment-emr',
                'category' => 'HealthTech',
                'description' => 'Aplikasi booking janji temu dokter online dengan notifikasi pengingat via WhatsApp dan rekam medis elektronik terenkripsi.',
                'thumbnail' => 'https://images.unsplash.com/photo-1576091160399-112ba8d25d1d?auto=format&fit=crop&w=800&q=80',
                'tech_stack' => ['Laravel 11', 'Vue.js', 'MySQL', 'Tailwind CSS'],
                'url_demo' => 'https://clinic.demo.portofolio.id',
                'url_repo' => 'https://github.com/Tiannn-r/Portofolio',
                'is_featured' => false,
                'order' => 4,
            ],
        ];

        foreach ($projects as $project) {
            Project::create($project);
        }

        // 6. Stories & News (Berita / Informasi Tentang Saya)
        Story::truncate();

        $stories = [
            [
                'title' => 'Juara 1 Lomba Inovasi Rekayasa Perangkat Lunak Nasional 2026',
                'slug' => 'juara-1-inovasi-perangkat-lunak-2026',
                'category' => 'Pencapaian',
                'event_date' => 'Oktober 2026',
                'summary' => 'Meraih peringkat pertama dalam kompetisi arsitektur enterprise berskala nasional atas solusi microservices yang hemat resource dan berkecepatan tinggi.',
                'content' => "Dalam kompetisi bergengsi tingkat nasional ini, solusi yang dibangun berfokus pada integrasi arsitektur cloud terdistribusi menggunakan Laravel 11 dan Vue 3.\n\nTim juri mengapresiasi kecepatan respon API yang konsisten di bawah 50ms di bawah beban simulasi 50.000 concurrent user, serta struktur kode berbasis modular clean architecture yang sangat rapi dan siap produksi.",
                'thumbnail' => 'https://images.unsplash.com/photo-1531482615713-2afd69097998?auto=format&fit=crop&w=1000&q=80',
                'tags' => ['National Award', 'Cloud Architecture', 'Laravel 11', 'Microservices'],
                'url' => 'https://github.com/Tiannn-r',
                'is_featured' => true,
                'order' => 1,
            ],
            [
                'title' => 'Pembicara di Tech Meetup: Membangun Web Skalabilitas Tinggi Tanpa Bottleneck',
                'slug' => 'pembicara-tech-meetup-skalabilitas-tinggi',
                'category' => 'Kegiatan & Berbagi',
                'event_date' => 'Agustus 2026',
                'summary' => 'Berbagi wawasan bersama 200+ software engineer mengenai best practices Clean Architecture, State Management, dan optimasi performa database MySQL.',
                'content' => "Sesi webinar dan hands-on workshop ini mengupas tuntas pengalaman nyata dalam menangani lonjakan traffic, perancangan indexing database yang efisien, implementasi caching berjenjang dengan Redis, serta pembuatan antarmuka reactive yang mulus dan bebas lag.",
                'thumbnail' => 'https://images.unsplash.com/photo-1475721027785-f74eccf877e2?auto=format&fit=crop&w=1000&q=80',
                'tags' => ['Tech Talk', 'Community', 'Vue.js', 'Clean Code'],
                'url' => 'https://linkedin.com/in/muhamad-ibnhu',
                'is_featured' => true,
                'order' => 2,
            ],
            [
                'title' => 'Rilis Framework Boilerplate Enterprise untuk Pengembang Web Modern',
                'slug' => 'rilis-framework-boilerplate-enterprise',
                'category' => 'Inovasi & Open Source',
                'event_date' => 'Mei 2026',
                'summary' => 'Meluncurkan open-source starter kit terintegrasi yang memangkas waktu setup proyek full-stack hingga 70% dengan keamanan enterprise-ready.',
                'content' => "Starter kit ini dirancang untuk menjawab tantangan pengembang dalam membangun sistem web modern: dilengkapi autentikasi Sanctum, dashboard admin Filament v3, preset styling Tailwind CSS eksklusif, serta automated test suite yang lengkap sejak hari pertama.",
                'thumbnail' => 'https://images.unsplash.com/photo-1504384308090-c894fdcc538d?auto=format&fit=crop&w=1000&q=80',
                'tags' => ['Open Source', 'Tooling', 'Productivity', 'Filament v3'],
                'url' => 'https://github.com/Tiannn-r/Portofolio',
                'is_featured' => true,
                'order' => 3,
            ],
        ];

        foreach ($stories as $story) {
            Story::create($story);
        }

        // 7. Educations & Certifications
        Education::truncate();

        $educations = [
            [
                'title' => 'S1 Teknik Informatika',
                'institution' => 'Universitas Bina Nusantara',
                'period' => '2020 - 2024',
                'description' => 'Fokus spesialisasi pada Rekayasa Perangkat Lunak, Arsitektur Sistem Terdistribusi, dan Pengembangan Aplikasi Web Modern. Lulus dengan predikat Cum Laude.',
                'type' => 'education',
                'order' => 1,
            ],
            [
                'title' => 'Google Certified Cloud Digital Leader',
                'institution' => 'Google Cloud',
                'period' => '2024',
                'description' => 'Sertifikasi kompetensi global dalam memahami kapabilitas arsitektur komputasi awan, infrastruktur modern, dan model keamanan data.',
                'type' => 'certification',
                'certificate_image' => 'https://images.unsplash.com/photo-1589330694653-dad6d3240a2b?auto=format&fit=crop&w=800&q=80',
                'event_name' => 'Google Cloud Global Examination 2024',
                'history' => 'Menyelesaikan modul komprehensif arsitektur cloud terdistribusi, evaluasi risiko keamanan infrastruktur, dan lulus ujian proctored internasional dengan skor memuaskan.',
                'credential_url' => 'https://cloud.google.com/certification',
                'order' => 1,
            ],
            [
                'title' => 'Full-Stack Web Development Professional',
                'institution' => 'Dicoding Indonesia',
                'period' => '2023',
                'description' => 'Sertifikasi keahlian dalam perancangan RESTful API, arsitektur single-page application (SPA), Progressive Web Apps (PWA), dan automated unit testing.',
                'type' => 'certification',
                'certificate_image' => 'https://images.unsplash.com/photo-1546410531-bb4caa6b424d?auto=format&fit=crop&w=800&q=80',
                'event_name' => 'Indonesia Developer Academy 2023',
                'history' => 'Menyelesaikan program intensif 6 bulan dengan submission proyek akhir portal e-commerce realtime yang dinilai langsung oleh code reviewer profesional industri.',
                'credential_url' => 'https://www.dicoding.com/certificates',
                'order' => 2,
            ],
            [
                'title' => 'Laravel Architecture & Enterprise API Specialist',
                'institution' => 'Laravel LLC',
                'period' => '2025',
                'description' => 'Sertifikasi penguasaan konsep clean architecture, service-repository patterns, queue optimization, dan event-driven design.',
                'type' => 'certification',
                'certificate_image' => 'https://images.unsplash.com/photo-1607969892198-8994a50d4d42?auto=format&fit=crop&w=800&q=80',
                'event_name' => 'Laravel Certified Developer Benchmark 2025',
                'history' => 'Ujian sertifikasi komprehensif yang menguji pembuatan API berkinerja tinggi, manajemen transaksi database ACID, dan implementasi caching canggih.',
                'credential_url' => 'https://laravel.com',
                'order' => 3,
            ],
        ];

        foreach ($educations as $education) {
            Education::create($education);
        }

        // 8. Contact Messages
        ContactMessage::truncate();

        $messages = [
            [
                'name' => 'Sarah Jenkins',
                'email' => 'sarah.j@techcorp.io',
                'message' => 'Halo Muhamad! Kami sangat terkesan dengan portofolio proyek Anda. Apakah Anda bersedia mendiskusikan peluang kolaborasi pengembangan produk SaaS kami?',
                'is_read' => false,
            ],
            [
                'name' => 'Budi Santoso',
                'email' => 'budi.santoso@startup.co.id',
                'message' => 'Selamat siang, kami memerlukan konsultasi teknis arsitektur sistem berbasis Laravel dan MySQL untuk mendukung lonjakan traffic marketplace kami. Mohon informasi ketersediaan jadwal diskusi.',
                'is_read' => true,
            ],
        ];

        foreach ($messages as $message) {
            ContactMessage::create($message);
        }
    }
}
