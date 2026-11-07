<template>
  <section id="featured" class="relative py-20 z-10">
    <!-- Section Heading -->
    <div class="text-center mb-12">
      <span class="inline-block px-3 py-1 text-xs font-semibold tracking-widest text-sage-400 uppercase bg-forest-900 border border-forest-700 rounded-full mb-3 shadow-[0_0_10px_rgba(142,182,155,0.15)]">
        Showcase & Offerings
      </span>
      <h2 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-mint-100">
        Featured Projects & <span class="text-sage-400">Services</span>
      </h2>
      <p class="mt-3 text-sage-400/80 max-w-xl mx-auto text-sm sm:text-base">
        Selected high-impact client deliverables alongside specialized engineering services I deliver.
      </p>
    </div>

    <!-- 2 Column Layout -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-stretch">
      <!-- Left Column: Featured Projects Slider/Carousel -->
      <div class="lg:col-span-7 flex flex-col">
        <div class="h-full bg-forest-800/60 backdrop-blur-md border border-sage-400/25 rounded-2xl p-6 sm:p-8 flex flex-col justify-between shadow-[0_10px_30px_rgba(5,31,32,0.6)] relative overflow-hidden">
          <!-- Header Bar with Slide Counter & Arrows -->
          <div class="flex items-center justify-between mb-5">
            <div class="flex items-center gap-2">
              <span class="w-2 h-2 rounded-full bg-sage-400 animate-ping"></span>
              <span class="text-xs uppercase tracking-wider text-sage-400 font-semibold">
                Featured Case Studies
              </span>
            </div>
            <!-- Slide Navigation Buttons -->
            <div class="flex items-center gap-2">
              <button
                @click="prevSlide"
                type="button"
                title="Previous Project"
                class="w-8 h-8 rounded-full bg-forest-900 border border-forest-700 text-sage-400 hover:text-mint-100 hover:border-sage-400 flex items-center justify-center transition-colors"
              >
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
              </button>
              <button
                @click="nextSlide"
                type="button"
                title="Next Project"
                class="w-8 h-8 rounded-full bg-forest-900 border border-forest-700 text-sage-400 hover:text-mint-100 hover:border-sage-400 flex items-center justify-center transition-colors"
              >
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
              </button>
            </div>
          </div>

          <!-- Carousel Slide Content -->
          <div
            v-if="currentProject"
            class="flex-1 flex flex-col md:flex-row gap-6 items-center transition-opacity duration-300"
          >
            <!-- Preview Image on the left -->
            <div class="relative w-full md:w-1/2 h-52 sm:h-64 rounded-xl overflow-hidden shrink-0 border border-forest-700 group/img">
              <img
                :src="currentProject.thumbnail_url || currentProject.thumbnail || 'https://images.unsplash.com/photo-1460925895917-afdab827c52f?auto=format&fit=crop&w=800&q=80'"
                :alt="currentProject.title"
                class="w-full h-full object-cover transition-transform duration-700 group-hover/img:scale-105"
              />
              <div class="absolute inset-0 bg-gradient-to-t from-forest-950/80 via-transparent to-transparent"></div>
              <span class="absolute top-3 left-3 px-2.5 py-1 text-[11px] font-semibold bg-forest-900/90 text-sage-400 border border-forest-700 rounded-md backdrop-blur-md">
                {{ currentProject.category }}
              </span>
            </div>

            <!-- Project Details on the right -->
            <div class="flex-1 flex flex-col justify-between h-full">
              <div>
                <h3 class="text-xl sm:text-2xl font-bold text-mint-100 mb-2.5 leading-snug">
                  {{ currentProject.title }}
                </h3>
                <p class="text-xs sm:text-sm text-mint-100/80 line-clamp-4 leading-relaxed mb-4">
                  {{ currentProject.description }}
                </p>

                <!-- Tech Stack Badges -->
                <div class="flex flex-wrap gap-1.5 mb-5">
                  <span
                    v-for="(tech, i) in currentProject.tech_stack"
                    :key="i"
                    class="px-2.5 py-0.5 text-[11px] font-medium bg-forest-700 text-mint-100 rounded-md border border-forest-700"
                  >
                    {{ tech }}
                  </span>
                </div>
              </div>

              <!-- Action Buttons -->
              <div class="flex items-center gap-3 pt-2">
                <button
                  @click="openProjectModal(currentProject)"
                  type="button"
                  class="inline-flex items-center gap-2 px-5 py-2 rounded-full bg-forest-900 text-mint-100 font-semibold text-xs tracking-wider uppercase border border-sage-400 shadow-[0_0_15px_rgba(142,182,155,0.3)] hover:bg-forest-700 hover:shadow-[0_0_20px_rgba(142,182,155,0.5)] transition-all"
                >
                  <span>LEARN MORE</span>
                  <svg class="w-3.5 h-3.5 text-sage-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                  </svg>
                </button>

                <a
                  v-if="currentProject.url_demo"
                  :href="currentProject.url_demo"
                  target="_blank"
                  class="inline-flex items-center gap-1.5 px-4 py-2 rounded-full bg-forest-800 text-sage-400 hover:text-mint-100 text-xs font-medium border border-forest-700 hover:border-sage-400 transition-colors"
                >
                  <span>Live Demo</span>
                  <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                  </svg>
                </a>
              </div>
            </div>
          </div>

          <!-- Bottom Dot Indicators -->
          <div class="flex items-center justify-center gap-2 mt-6 pt-3 border-t border-forest-700/40">
            <button
              v-for="(p, index) in featuredProjects"
              :key="'dot-' + (p.id || index)"
              @click="currentSlide = index"
              :title="p.title"
              type="button"
              class="h-2 rounded-full transition-all duration-300"
              :class="currentSlide === index ? 'w-8 bg-sage-400 shadow-[0_0_10px_#8EB69B]' : 'w-2 bg-forest-700 hover:bg-sage-400/60'"
            ></button>
          </div>
        </div>
      </div>

      <!-- Right Column: 3 Vertical Service Cards -->
      <div class="lg:col-span-5 flex flex-col justify-between gap-4">
        <div
          v-for="(service, idx) in displayServices"
          :key="service.id || idx"
          class="group bg-forest-900/90 border border-forest-700 hover:border-sage-400 rounded-2xl p-5 hover:bg-forest-800/80 transition-all duration-300 hover:scale-[1.01] hover:shadow-[0_0_20px_rgba(142,182,155,0.2)] flex items-start gap-4"
        >
          <!-- Service Icon Container -->
          <div class="w-12 h-12 rounded-xl bg-forest-800 border border-forest-700 group-hover:border-sage-400/50 p-2.5 flex items-center justify-center shrink-0 shadow-[0_0_10px_rgba(142,182,155,0.15)] group-hover:scale-105 transition-all">
            <img
              v-if="service.icon_url || (service.icon && !service.icon.startsWith('<svg'))"
              :src="service.icon_url || service.icon"
              :alt="service.title"
              class="w-full h-full object-contain"
            />
            <!-- Fallback Service Icons -->
            <svg v-else-if="idx === 0" class="w-6 h-6 text-sage-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" />
            </svg>
            <svg v-else-if="idx === 1" class="w-6 h-6 text-sage-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01" />
            </svg>
            <svg v-else class="w-6 h-6 text-sage-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
            </svg>
          </div>

          <!-- Service Text -->
          <div class="flex-1">
            <h4 class="text-lg font-bold text-mint-100 group-hover:text-sage-400 transition-colors mb-1">
              {{ service.title }}
            </h4>
            <p class="text-xs sm:text-sm text-sage-400/80 leading-relaxed">
              {{ service.description }}
            </p>
          </div>
        </div>
      </div>
    </div>

    <!-- Project Detail Modal -->
    <div
      v-if="selectedModalProject"
      class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-forest-950/80 backdrop-blur-md animate-fade-in"
      @click.self="selectedModalProject = null"
    >
      <div class="relative w-full max-w-2xl bg-forest-900 border border-sage-400/40 rounded-2xl p-6 sm:p-8 shadow-[0_0_40px_rgba(142,182,155,0.3)] max-h-[90vh] overflow-y-auto">
        <button
          @click="selectedModalProject = null"
          type="button"
          class="absolute top-5 right-5 w-8 h-8 rounded-full bg-forest-800 text-sage-400 hover:text-mint-100 hover:bg-forest-700 flex items-center justify-center transition-colors border border-forest-700"
        >
          <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
          </svg>
        </button>

        <span class="text-xs uppercase tracking-wider text-sage-400 font-semibold font-mono">
          {{ selectedModalProject.category }}
        </span>
        <h3 class="text-2xl font-bold text-mint-100 mb-3 mt-1">
          {{ selectedModalProject.title }}
        </h3>

        <div class="rounded-xl overflow-hidden mb-5 border border-forest-700 max-h-72">
          <img
            :src="selectedModalProject.thumbnail_url || selectedModalProject.thumbnail"
            :alt="selectedModalProject.title"
            class="w-full h-full object-cover"
          />
        </div>

        <p class="text-sm text-mint-100/90 leading-relaxed mb-6 whitespace-pre-line">
          {{ selectedModalProject.description }}
        </p>

        <div class="mb-6">
          <span class="text-xs uppercase text-sage-400 font-semibold block mb-2">Technologies Used:</span>
          <div class="flex flex-wrap gap-2">
            <span
              v-for="(tech, i) in selectedModalProject.tech_stack"
              :key="i"
              class="px-3 py-1 rounded-md text-xs font-mono bg-forest-800 text-mint-100 border border-forest-700"
            >
              {{ tech }}
            </span>
          </div>
        </div>

        <div class="flex items-center gap-3 pt-4 border-t border-forest-700">
          <a
            v-if="selectedModalProject.url_demo"
            :href="selectedModalProject.url_demo"
            target="_blank"
            class="px-5 py-2.5 rounded-full bg-forest-700 text-mint-100 font-semibold text-xs border border-sage-400 shadow-[0_0_15px_rgba(142,182,155,0.3)] hover:bg-forest-700/80 transition-all inline-flex items-center gap-2"
          >
            <span>Visit Live Demo</span>
            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
            </svg>
          </a>
          <a
            v-if="selectedModalProject.url_repo"
            :href="selectedModalProject.url_repo"
            target="_blank"
            class="px-5 py-2.5 rounded-full bg-forest-800 text-sage-400 hover:text-mint-100 font-medium text-xs border border-forest-700 hover:border-sage-400 transition-colors inline-flex items-center gap-2"
          >
            <span>Source Code</span>
            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24">
              <path fill-rule="evenodd" clip-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.53 1.032 1.53 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z" />
            </svg>
          </a>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
import { ref, computed, onMounted, onUnmounted } from 'vue';

const props = defineProps({
  projects: {
    type: Array,
    default: () => [],
  },
  featuredProjects: {
    type: Array,
    default: () => [],
  },
  services: {
    type: Array,
    default: () => [],
  },
});

const currentSlide = ref(0);
const selectedModalProject = ref(null);
let autoSlideInterval = null;

const defaultFeatured = [
  {
    title: 'Enterprise Resource Planning (ERP) System',
    category: 'Web Application',
    description: 'Platform ERP modern untuk enterprise dengan manajemen inventaris realtime, pelaporan akuntansi otomatis, manajemen multi-cabang, dan role-based access control yang aman.',
    thumbnail_url: 'https://images.unsplash.com/photo-1460925895917-afdab827c52f?auto=format&fit=crop&w=800&q=80',
    tech_stack: ['Laravel 11', 'Vue 3', 'Tailwind CSS', 'MySQL', 'Chart.js'],
    url_demo: 'https://erp.demo.portofolio.id',
    url_repo: 'https://github.com/Tiannn-r/Portofolio',
  },
  {
    title: 'Multi-Vendor Marketplace & Checkout Platform',
    category: 'E-Commerce',
    description: 'Aplikasi e-commerce lengkap dengan cart realtime, integrasi pembayaran digital, pelacakan kurir otomatis, serta dashboard analitik penjualan bagi merchant.',
    thumbnail_url: 'https://images.unsplash.com/photo-1557821552-17105176677c?auto=format&fit=crop&w=800&q=80',
    tech_stack: ['Laravel 11', 'Vue 3', 'Pinia', 'Tailwind CSS', 'Midtrans API'],
    url_demo: 'https://shop.demo.portofolio.id',
    url_repo: 'https://github.com/Tiannn-r/Portofolio',
  },
  {
    title: 'Personal Portfolio & Admin CMS Engine',
    category: 'Full-Stack Web',
    description: 'Sistem website portofolio interaktif yang terhubung langsung ke Content Management System (CMS) Admin dengan autentikasi Sanctum dan manajemen pesan kontak.',
    thumbnail_url: 'https://images.unsplash.com/photo-1507238691740-187a5b1d37b8?auto=format&fit=crop&w=800&q=80',
    tech_stack: ['Laravel 11', 'Sanctum', 'Vue 3', 'Tailwind CSS', 'MySQL'],
    url_demo: 'https://portofolio.id',
    url_repo: 'https://github.com/Tiannn-r/Portofolio',
  },
];

const featuredProjects = computed(() => {
  if (props.featuredProjects && props.featuredProjects.length > 0) {
    return props.featuredProjects;
  }
  return defaultFeatured;
});

const currentProject = computed(() => {
  return featuredProjects.value[currentSlide.value % featuredProjects.value.length];
});

const defaultServices = [
  {
    title: 'Web Development',
    description: 'Membangun aplikasi web kustom yang responsif, berkinerja tinggi, dan scalable menggunakan ekosistem modern Laravel 11 dan Vue 3.',
  },
  {
    title: 'UI/UX Design & Implementation',
    description: 'Menerjemahkan ide produk ke dalam antarmuka visual yang memukau, intuitif, dan responsif dengan Tailwind CSS dan user-centric design.',
  },
  {
    title: 'RESTful API & Integration',
    description: 'Merancang arsitektur API yang aman, berkecepatan tinggi, terstandarisasi, dan terintegrasi dengan payment gateway maupun layanan pihak ketiga.',
  },
];

const displayServices = computed(() => {
  if (props.services && props.services.length > 0) {
    return props.services.slice(0, 3);
  }
  return defaultServices;
});

const nextSlide = () => {
  currentSlide.value = (currentSlide.value + 1) % featuredProjects.value.length;
};

const prevSlide = () => {
  currentSlide.value = (currentSlide.value - 1 + featuredProjects.value.length) % featuredProjects.value.length;
};

const openProjectModal = (project) => {
  selectedModalProject.value = project;
};

onMounted(() => {
  autoSlideInterval = setInterval(nextSlide, 6000);
});

onUnmounted(() => {
  if (autoSlideInterval) clearInterval(autoSlideInterval);
});
</script>
