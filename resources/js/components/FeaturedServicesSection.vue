<template>
  <SectionContainer
    id="featured"
    badge="Showcase & Offerings"
    title="Featured Projects & <span class='text-sage-400'>Services</span>"
    description="Selected high-impact client deliverables alongside specialized engineering services I deliver."
  >
    <!-- =================================================================================== -->
    <!-- 1. FULL-WIDTH FEATURED CASE STUDY (Widescreen, Grand & Prominent / Digedein & Dilebarin) -->
    <!-- =================================================================================== -->
    <div class="w-full mb-16">
      <GlassCard
        variant="primary"
        class="w-full relative overflow-hidden p-6 sm:p-8 lg:p-10 shadow-[0_15px_40px_rgba(5,31,32,0.9)] border border-[#235347] ring-1 ring-sage-400/20"
      >
        <!-- Ambient Glowing Aura in Background -->
        <div class="absolute -top-32 -right-32 w-96 h-96 bg-sage-400/10 rounded-full blur-[120px] pointer-events-none"></div>
        <div class="absolute -bottom-32 -left-32 w-96 h-96 bg-forest-700/20 rounded-full blur-[120px] pointer-events-none"></div>

        <!-- Top Header Bar with Slide Counter & Arrows -->
        <div class="flex items-center justify-between mb-8 pb-4 border-b border-forest-700/60 relative z-10">
          <div class="flex items-center gap-3">
            <span class="relative flex h-3 w-3">
              <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-sage-400 opacity-75"></span>
              <span class="relative inline-flex rounded-full h-3 w-3 bg-sage-400 shadow-[0_0_8px_#8EB69B]"></span>
            </span>
            <span class="text-xs sm:text-sm uppercase tracking-wider text-sage-400 font-bold font-mono">
              Featured Case Studies ({{ currentSlide + 1 }}/{{ featuredProjects.length }})
            </span>
          </div>

          <!-- Slide Navigation Controls -->
          <div class="flex items-center gap-2.5">
            <button
              @click="prevSlide"
              type="button"
              title="Previous Project"
              class="w-9 h-9 rounded-full bg-forest-900 border border-forest-700 text-sage-400 hover:text-mint-100 hover:border-sage-400 hover:bg-forest-800 flex items-center justify-center transition-all active:scale-90 shadow-sm"
            >
              <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
              </svg>
            </button>
            <button
              @click="nextSlide"
              type="button"
              title="Next Project"
              class="w-9 h-9 rounded-full bg-forest-900 border border-forest-700 text-sage-400 hover:text-mint-100 hover:border-sage-400 hover:bg-forest-800 flex items-center justify-center transition-all active:scale-90 shadow-sm"
            >
              <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
              </svg>
            </button>
          </div>
        </div>

        <!-- Carousel Slide Content (2 Column Widescreen Split) -->
        <div
          v-if="currentProject"
          class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-center relative z-10 transition-all duration-300"
        >
          <!-- Left: Big Preview Image Container -->
          <div class="lg:col-span-6 relative w-full h-64 sm:h-80 lg:h-[400px] rounded-2xl overflow-hidden border border-forest-700 ring-1 ring-sage-400/25 group/img shadow-[0_10px_35px_rgba(5,31,32,0.9)] bg-forest-950">
            <img
              :src="currentProject.thumbnail_url || currentProject.thumbnail || 'https://images.unsplash.com/photo-1460925895917-afdab827c52f?auto=format&fit=crop&w=1000&q=80'"
              :alt="currentProject.title"
              class="w-full h-full object-cover transition-transform duration-700 group-hover/img:scale-105"
            />
            <div class="absolute inset-0 bg-gradient-to-t from-forest-950/85 via-forest-950/20 to-transparent"></div>
            
            <!-- Category Tag Pill -->
            <span class="absolute top-4 left-4 px-3 py-1 text-xs font-semibold bg-forest-900/90 text-sage-400 border border-forest-700 rounded-lg backdrop-blur-md shadow-md">
              {{ currentProject.category }}
            </span>

            <!-- Top Right: Featured Badge -->
            <span class="absolute top-4 right-4 px-3 py-1 text-[11px] font-bold font-mono tracking-wider bg-forest-800/90 text-mint-100 border border-sage-400/50 rounded-lg backdrop-blur-md shadow-[0_0_12px_rgba(142,182,155,0.3)]">
              ★ FEATURED
            </span>
          </div>

          <!-- Right: Project Narrative & Actions -->
          <div class="lg:col-span-6 flex flex-col justify-between h-full space-y-5">
            <div>
              <span class="text-xs font-mono text-sage-400 uppercase tracking-widest block mb-2 font-semibold">
                // Flagship Production Deliverable
              </span>

              <h3 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-mint-100 mb-3.5 tracking-tight leading-snug">
                {{ currentProject.title }}
              </h3>

              <p class="text-sm sm:text-base text-mint-100/85 leading-relaxed mb-6 whitespace-pre-line">
                {{ currentProject.description }}
              </p>

              <!-- Tech Stack Badges -->
              <div class="mb-6">
                <span class="text-[11px] uppercase tracking-wider text-sage-400/80 font-mono font-semibold block mb-2">
                  Architecture & Tech Stack:
                </span>
                <div class="flex flex-wrap gap-2">
                  <span
                    v-for="(tech, i) in currentProject.tech_stack"
                    :key="i"
                    class="px-3 py-1 text-xs font-mono font-medium bg-forest-800 text-mint-100 rounded-lg border border-forest-700 ring-1 ring-sage-400/20"
                  >
                    {{ tech }}
                  </span>
                </div>
              </div>
            </div>

            <!-- Action Buttons using BaseButton -->
            <div class="flex flex-wrap items-center gap-3 pt-3 border-t border-forest-700/50">
              <BaseButton
                variant="primary"
                size="md"
                @click="openProjectModal(currentProject)"
              >
                <span>LEARN MORE</span>
                <template #icon-right>
                  <svg class="w-4 h-4 text-mint-100" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                  </svg>
                </template>
              </BaseButton>

              <BaseButton
                v-if="currentProject.url_demo"
                variant="glass"
                size="md"
                as="a"
                :href="currentProject.url_demo"
                target="_blank"
              >
                <template #icon-right>
                  <svg class="w-3.5 h-3.5 text-sage-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                  </svg>
                </template>
                <span>Live Demo</span>
              </BaseButton>

              <BaseButton
                v-if="currentProject.url_repo"
                variant="ghost"
                size="md"
                as="a"
                :href="currentProject.url_repo"
                target="_blank"
              >
                <span>Repository</span>
              </BaseButton>
            </div>
          </div>
        </div>

        <!-- Bottom Dot Indicators -->
        <div class="flex items-center justify-center gap-2.5 mt-8 pt-4 border-t border-forest-700/50 relative z-10">
          <button
            v-for="(p, index) in featuredProjects"
            :key="'dot-' + (p.id || index)"
            @click="currentSlide = index"
            :title="p.title"
            type="button"
            class="h-2.5 rounded-full transition-all duration-300"
            :class="currentSlide === index ? 'w-10 bg-sage-400 shadow-[0_0_12px_#8EB69B]' : 'w-2.5 bg-forest-700 hover:bg-sage-400/60'"
          ></button>
        </div>
      </GlassCard>
    </div>

    <!-- =================================================================================== -->
    <!-- 2. SERVICES SECTION (Diletakkan di Bawah Project, Format Grid 3 Kolom Lebih Josjis)  -->
    <!-- =================================================================================== -->
    <div>
      <!-- Sub-header Title for Services -->
      <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4 mb-8">
        <div>
          <span class="text-xs uppercase tracking-widest text-sage-400 font-bold font-mono">
            // Specialized Capabilities
          </span>
          <h3 class="text-2xl sm:text-3xl font-extrabold text-mint-100 tracking-tight mt-1">
            Services & Engineering Solutions
          </h3>
        </div>
        <p class="text-xs sm:text-sm text-sage-400/80 max-w-md">
          Solusi rekayasa perangkat lunak ujung-ke-ujung yang dirancang dengan standar performa, arsitektur bersih, dan skalabilitas modern.
        </p>
      </div>

      <!-- 3 Columns Services Grid Layout -->
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 items-stretch">
        <GlassCard
          v-for="(service, idx) in displayServices"
          :key="service.id || idx"
          variant="secondary"
          hoverable
          class="h-full flex flex-col justify-between group rounded-2xl p-6 sm:p-7 transition-all duration-400 hover:-translate-y-2 hover:border-sage-400/80 ring-1 ring-forest-700/80 hover:ring-sage-400/40 hover:shadow-[0_15px_35px_rgba(142,182,155,0.22)] relative overflow-hidden"
        >
          <!-- Top Neon Line Accent (Expands smoothly on hover) -->
          <div class="h-1 w-12 rounded-full bg-gradient-to-r from-forest-700 via-[#235347] to-sage-400 group-hover:w-full transition-all duration-500 mb-6"></div>

          <div>
            <!-- Header: Elevated Icon & Index Number -->
            <div class="flex items-center justify-between mb-5">
              <div class="w-14 h-14 rounded-2xl bg-forest-800 border border-forest-700 group-hover:border-sage-400/60 p-3.5 flex items-center justify-center text-sage-400 group-hover:text-mint-100 shadow-[0_0_15px_rgba(142,182,155,0.2)] group-hover:scale-110 group-hover:rotate-3 transition-all duration-300">
                <img
                  v-if="!brokenServiceIcons[service.id || idx] && (service.icon_url || (service.icon && !service.icon.startsWith('<svg')))"
                  :src="service.icon_url || service.icon"
                  :alt="service.title"
                  class="w-full h-full object-contain"
                  @error="brokenServiceIcons[service.id || idx] = true"
                />
                <!-- Fallback SVGs -->
                <svg v-else-if="idx % 3 === 0" class="w-7 h-7 text-sage-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" />
                </svg>
                <svg v-else-if="idx % 3 === 1" class="w-7 h-7 text-sage-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01" />
                </svg>
                <svg v-else class="w-7 h-7 text-sage-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                </svg>
              </div>

              <span class="text-xs font-mono font-bold text-sage-400/50 group-hover:text-sage-400 transition-colors">
                0{{ idx + 1 }}
              </span>
            </div>

            <!-- Service Title -->
            <h4 class="text-xl font-bold text-mint-100 group-hover:text-sage-400 transition-colors mb-2.5 tracking-tight">
              {{ service.title }}
            </h4>

            <!-- Service Description -->
            <p class="text-xs sm:text-sm text-sage-400/85 leading-relaxed mb-6">
              {{ service.description }}
            </p>

            <!-- Feature Pills / Highlights -->
            <div class="flex flex-wrap gap-1.5 mb-6">
              <span
                v-for="(feature, fIdx) in getServiceFeatures(idx)"
                :key="fIdx"
                class="px-2.5 py-0.5 rounded-md text-[11px] font-mono bg-forest-800 text-mint-100 border border-forest-700/70"
              >
                {{ feature }}
              </span>
            </div>
          </div>

          <!-- Bottom Action: Explore Shortcut -->
          <div class="pt-4 border-t border-forest-700/60 flex items-center justify-between text-xs font-semibold text-sage-400 group-hover:text-mint-100 transition-colors">
            <span>Specialized Craft</span>
            <svg class="w-4 h-4 group-hover:translate-x-1.5 transition-transform text-sage-400 group-hover:text-mint-100" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
            </svg>
          </div>
        </GlassCard>
      </div>
    </div>

    <!-- Project Detail Modal using AdminModal -->
    <AdminModal
      :show="!!selectedModalProject"
      :title="selectedModalProject?.title || 'Project Detail'"
      max-width="2xl"
      @close="selectedModalProject = null"
    >
      <div v-if="selectedModalProject" class="space-y-4">
        <span class="inline-block px-2.5 py-0.5 text-xs uppercase tracking-wider text-sage-400 font-semibold font-mono bg-forest-800 rounded border border-forest-700">
          {{ selectedModalProject.category }}
        </span>

        <div class="rounded-xl overflow-hidden border border-forest-700 max-h-72 ring-1 ring-sage-400/20">
          <img
            :src="selectedModalProject.thumbnail_url || selectedModalProject.thumbnail"
            :alt="selectedModalProject.title"
            class="w-full h-full object-cover"
          />
        </div>

        <p class="text-sm text-mint-100/90 leading-relaxed whitespace-pre-line">
          {{ selectedModalProject.description }}
        </p>

        <div>
          <span class="text-xs uppercase text-sage-400 font-semibold block mb-2 font-mono">Tech Stack & Tools:</span>
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
      </div>

      <template #footer>
        <div v-if="selectedModalProject" class="w-full flex items-center justify-between gap-3">
          <div class="flex items-center gap-2">
            <BaseButton
              v-if="selectedModalProject.url_demo"
              variant="primary"
              size="sm"
              as="a"
              :href="selectedModalProject.url_demo"
              target="_blank"
            >
              <span>Visit Demo</span>
              <template #icon-right>
                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                </svg>
              </template>
            </BaseButton>

            <BaseButton
              v-if="selectedModalProject.url_repo"
              variant="glass"
              size="sm"
              as="a"
              :href="selectedModalProject.url_repo"
              target="_blank"
            >
              <span>Repository</span>
            </BaseButton>
          </div>

          <BaseButton
            variant="ghost"
            size="sm"
            @click="selectedModalProject = null"
          >
            <span>Close</span>
          </BaseButton>
        </div>
      </template>
    </AdminModal>
  </SectionContainer>
</template>

<script setup>
import { ref, computed, onMounted, onUnmounted } from 'vue';
import SectionContainer from './ui/SectionContainer.vue';
import GlassCard from './ui/GlassCard.vue';
import BaseButton from './ui/BaseButton.vue';
import AdminModal from './ui/AdminModal.vue';

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
const brokenServiceIcons = ref({});
let autoSlideInterval = null;

const defaultFeatured = [
  {
    title: 'Enterprise Resource Planning (ERP) System',
    category: 'Web Application',
    description: 'Platform ERP modern untuk enterprise dengan manajemen inventaris realtime, pelaporan akuntansi otomatis, manajemen multi-cabang, dan role-based access control yang aman.',
    thumbnail_url: 'https://images.unsplash.com/photo-1460925895917-afdab827c52f?auto=format&fit=crop&w=1000&q=80',
    tech_stack: ['Laravel 11', 'Vue 3', 'Tailwind CSS', 'MySQL', 'Chart.js'],
    url_demo: 'https://erp.demo.portofolio.id',
    url_repo: 'https://github.com/Tiannn-r/Portofolio',
  },
  {
    title: 'Multi-Vendor Marketplace & Checkout Platform',
    category: 'E-Commerce',
    description: 'Aplikasi e-commerce lengkap dengan cart realtime, integrasi pembayaran digital, pelacakan kurir otomatis, serta dashboard analitik penjualan bagi merchant.',
    thumbnail_url: 'https://images.unsplash.com/photo-1557821552-17105176677c?auto=format&fit=crop&w=1000&q=80',
    tech_stack: ['Laravel 11', 'Vue 3', 'Pinia', 'Tailwind CSS', 'Midtrans API'],
    url_demo: 'https://shop.demo.portofolio.id',
    url_repo: 'https://github.com/Tiannn-r/Portofolio',
  },
  {
    title: 'Personal Portfolio & Admin CMS Engine',
    category: 'Full-Stack Web',
    description: 'Sistem website portofolio interaktif yang terhubung langsung ke Content Management System (CMS) Admin dengan autentikasi Sanctum dan manajemen pesan kontak.',
    thumbnail_url: 'https://images.unsplash.com/photo-1507238691740-187a5b1d37b8?auto=format&fit=crop&w=1000&q=80',
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
    return props.services;
  }
  return defaultServices;
});

// Feature highlights for service cards
const getServiceFeatures = (idx) => {
  const featureList = [
    ['Clean Architecture', 'Reactive SPA & SSR', 'Performance Tuning'],
    ['Design Systems', 'Responsive UI/UX', 'Interactive Prototyping'],
    ['Secure RESTful API', 'Third-Party Webhooks', 'Database Optimization'],
  ];
  return featureList[idx % featureList.length];
};

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
  autoSlideInterval = setInterval(nextSlide, 7000);
});

onUnmounted(() => {
  if (autoSlideInterval) clearInterval(autoSlideInterval);
});
</script>
