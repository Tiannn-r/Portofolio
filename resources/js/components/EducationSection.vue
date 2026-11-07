<template>
  <section id="education" class="relative py-20 z-10">
    <!-- Section Heading -->
    <div class="text-center mb-12">
      <span class="inline-block px-3 py-1 text-xs font-semibold tracking-widest text-sage-400 uppercase bg-forest-900 border border-forest-700 rounded-full mb-3 shadow-[0_0_10px_rgba(142,182,155,0.15)]">
        Academic & Credentials
      </span>
      <h2 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-mint-100">
        Education & <span class="text-sage-400">Certifications</span>
      </h2>
      <p class="mt-3 text-sage-400/80 max-w-xl mx-auto text-sm sm:text-base">
        Formal academic foundations and professional certifications backing up practical craftsmanship.
      </p>
    </div>

    <!-- Full Glassmorphism Card with 2-Column Layout -->
    <div class="bg-forest-800/60 backdrop-blur-md border border-sage-400/25 rounded-2xl p-6 sm:p-10 shadow-[0_10px_35px_rgba(5,31,32,0.6)] relative overflow-hidden">
      <!-- Background Ambient Glow -->
      <div class="absolute -bottom-24 -right-24 w-80 h-80 bg-sage-400/10 rounded-full blur-3xl pointer-events-none"></div>

      <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12 relative z-10">
        <!-- Left Column: Education -->
        <div class="flex flex-col">
          <!-- Column Header -->
          <div class="flex items-center gap-3 mb-6 pb-3 border-b border-forest-700/60">
            <div class="w-10 h-10 rounded-xl bg-forest-900 border border-sage-400/40 flex items-center justify-center text-sage-400 shadow-[0_0_12px_rgba(142,182,155,0.2)]">
              <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5" />
              </svg>
            </div>
            <div>
              <h3 class="text-xl sm:text-2xl font-bold text-mint-100">
                Formal Education
              </h3>
              <span class="text-xs text-sage-400">Academic Degrees & Majors</span>
            </div>
          </div>

          <!-- Vertical List of Education Cards -->
          <div class="space-y-4">
            <div
              v-for="(item, idx) in educationList"
              :key="item.id || idx"
              class="group bg-forest-900 border border-forest-700 hover:border-sage-400 rounded-xl p-5 hover:bg-forest-800/80 transition-all duration-300 hover:shadow-[0_0_18px_rgba(142,182,155,0.2)] relative pl-14"
            >
              <!-- Icon Indicator with Sage Glow -->
              <div class="w-8 h-8 rounded-full bg-forest-800 border border-sage-400 flex items-center justify-center text-sage-400 absolute left-4 top-5 shadow-[0_0_8px_#8EB69B] group-hover:scale-110 transition-transform">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                </svg>
              </div>

              <!-- Content -->
              <span class="inline-block px-2 py-0.5 rounded text-[11px] font-mono font-semibold bg-forest-950 text-sage-400 border border-forest-700 mb-1.5">
                {{ item.period }}
              </span>
              <h4 class="text-base sm:text-lg font-bold text-mint-100 group-hover:text-sage-400 transition-colors">
                {{ item.title }}
              </h4>
              <p class="text-xs font-semibold text-sage-400 mb-2">
                {{ item.institution }}
              </p>
              <p class="text-xs sm:text-sm text-mint-100/75 leading-relaxed">
                {{ item.description }}
              </p>
            </div>
          </div>
        </div>

        <!-- Right Column: Certifications -->
        <div class="flex flex-col">
          <!-- Column Header -->
          <div class="flex items-center gap-3 mb-6 pb-3 border-b border-forest-700/60">
            <div class="w-10 h-10 rounded-xl bg-forest-900 border border-sage-400/40 flex items-center justify-center text-sage-400 shadow-[0_0_12px_rgba(142,182,155,0.2)]">
              <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
              </svg>
            </div>
            <div>
              <h3 class="text-xl sm:text-2xl font-bold text-mint-100">
                Certifications
              </h3>
              <span class="text-xs text-sage-400">Industry & Professional Badges</span>
            </div>
          </div>

          <!-- Vertical List of Certification Cards -->
          <div class="space-y-4">
            <div
              v-for="(item, idx) in certificationList"
              :key="item.id || idx"
              class="group bg-forest-900 border border-forest-700 hover:border-sage-400 rounded-xl p-5 hover:bg-forest-800/80 transition-all duration-300 hover:shadow-[0_0_18px_rgba(142,182,155,0.2)] relative pl-14"
            >
              <!-- Icon Indicator with Sage Glow -->
              <div class="w-8 h-8 rounded-full bg-forest-800 border border-sage-400 flex items-center justify-center text-sage-400 absolute left-4 top-5 shadow-[0_0_8px_#8EB69B] group-hover:scale-110 transition-transform">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
              </div>

              <!-- Content -->
              <span class="inline-block px-2 py-0.5 rounded text-[11px] font-mono font-semibold bg-forest-950 text-sage-400 border border-forest-700 mb-1.5">
                {{ item.period }}
              </span>
              <h4 class="text-base sm:text-lg font-bold text-mint-100 group-hover:text-sage-400 transition-colors">
                {{ item.title }}
              </h4>
              <p class="text-xs font-semibold text-sage-400 mb-2">
                {{ item.institution }}
              </p>
              <p class="text-xs sm:text-sm text-mint-100/75 leading-relaxed">
                {{ item.description }}
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
import { computed } from 'vue';

const props = defineProps({
  educations: {
    type: Array,
    default: () => [],
  },
  certifications: {
    type: Array,
    default: () => [],
  },
});

const defaultEducation = [
  {
    title: 'S1 Teknik Informatika',
    institution: 'Universitas Bina Nusantara',
    period: '2020 - 2024',
    description: 'Fokus spesialisasi pada Rekayasa Perangkat Lunak, Arsitektur Sistem Terdistribusi, dan Pengembangan Aplikasi Web Modern. Lulus dengan predikat Cum Laude (IPK 3.85).',
  },
  {
    title: 'Pendidikan Menengah Atas (MIPA)',
    institution: 'SMA Negeri Unggulan',
    period: '2017 - 2020',
    description: 'Aktif dalam olimpiade sains bidang informatika dan dasar logika algoritma pemrograman komputer.',
  },
];

const defaultCertifications = [
  {
    title: 'Google Certified Cloud Digital Leader',
    institution: 'Google Cloud',
    period: '2024',
    description: 'Sertifikasi kompetensi global dalam memahami kapabilitas arsitektur komputasi awan, infrastruktur modern, dan model keamanan data.',
  },
  {
    title: 'Full-Stack Web Development Professional',
    institution: 'Dicoding Indonesia',
    period: '2023',
    description: 'Sertifikasi keahlian dalam perancangan RESTful API, arsitektur single-page application (SPA), Progressive Web Apps (PWA), dan automated testing.',
  },
];

const educationList = computed(() => {
  if (props.educations && props.educations.length > 0) {
    return props.educations;
  }
  return defaultEducation;
});

const certificationList = computed(() => {
  if (props.certifications && props.certifications.length > 0) {
    return props.certifications;
  }
  return defaultCertifications;
});
</script>

