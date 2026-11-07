<template>
  <SectionContainer
    id="featured"
    badge="Showcase & Offerings"
    title="Featured Projects & <span class='text-sage-400'>Services</span>"
    description="Selected high-impact client deliverables alongside specialized engineering services I deliver."
  >
    <!-- 2 Column Layout -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-stretch">
      <!-- Left Column: Featured Projects Slider/Carousel -->
      <div class="lg:col-span-7 flex flex-col">
        <GlassCard
          variant="primary"
          class="h-full flex flex-col justify-between relative overflow-hidden"
        >
          <!-- Header Bar with Slide Counter & Arrows -->
          <div class="flex items-center justify-between mb-5">
            <div class="flex items-center gap-2">
              <span class="w-2 h-2 rounded-full bg-sage-400 animate-ping"></span>
              <span class="text-xs uppercase tracking-wider text-sage-400 font-semibold font-mono">
                Featured Case Studies ({{ currentSlide + 1 }}/{{ featuredProjects.length }})
              </span>
            </div>

            <!-- Slide Navigation Buttons with Micro-interactions -->
            <div class="flex items-center gap-2">
              <button
                @click="prevSlide"
                type="button"
                title="Previous Project"
                class="w-8 h-8 rounded-full bg-forest-900 border border-forest-700 text-sage-400 hover:text-mint-100 hover:border-sage-400 flex items-center justify-center transition-all active:scale-90"
              >
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
              </button>
              <button
                @click="nextSlide"
                type="button"
                title="Next Project"
                class="w-8 h-8 rounded-full bg-forest-900 border border-forest-700 text-sage-400 hover:text-mint-100 hover:border-sage-400 flex items-center justify-center transition-all active:scale-90"
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
            class="flex-1 flex flex-col md:flex-row gap-6 items-center transition-all duration-300"
          >
            <!-- Preview Image on the left -->
            <div class="relative w-full md:w-1/2 h-52 sm:h-64 rounded-xl overflow-hidden shrink-0 border border-forest-700 ring-1 ring-sage-400/20 group/img">
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
                    class="px-2.5 py-0.5 text-[11px] font-medium bg-forest-700 text-mint-100 rounded-md border border-forest-700/60"
                  >
                    {{ tech }}
                  </span>
                </div>
              </div>

              <!-- Action Buttons using BaseButton -->
              <div class="flex flex-wrap items-center gap-3 pt-2">
                <BaseButton
                  variant="primary"
                  size="sm"
                  @click="openProjectModal(currentProject)"
                >
                  <span>LEARN MORE</span>
                  <template #icon-right>
                    <svg class="w-3.5 h-3.5 text-mint-100" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                  </template>
                </BaseButton>

                <BaseButton
                  v-if="currentProject.url_demo"
                  variant="glass"
                  size="sm"
                  as="a"
                  :href="currentProject.url_demo"
                  target="_blank"
                >
                  <template #icon-right>
                    <svg class="w-3 h-3 text-sage-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                    </svg>
                  </template>
                  <span>Live Demo</span>
                </BaseButton>
              </div>
            </div>
          </div>

          <!-- Bottom Dot Indicators -->
          <div class="flex items-center justify-center gap-2 mt-6 pt-3 border-t border-forest-700/50">
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
        </GlassCard>
      </div>

      <!-- Right Column: 3 Vertical Service Cards -->
      <div class="lg:col-span-5 flex flex-col justify-between gap-4">
        <GlassCard
          v-for="(service, idx) in displayServices"
          :key="service.id || idx"
          variant="secondary"
          hoverable
          class="transition-all duration-300 hover:-translate-y-1 hover:border-sage-400/80 group ring-1 ring-transparent hover:ring-sage-400/30"
        >
          <div class="flex items-start gap-4">
            <!-- Service Icon Container -->
            <div class="w-12 h-12 rounded-xl bg-forest-800 border border-forest-700 group-hover:border-sage-400/50 p-2.5 flex items-center justify-center shrink-0 shadow-[0_0_10px_rgba(142,182,155,0.15)] group-hover:scale-110 transition-transform">
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
