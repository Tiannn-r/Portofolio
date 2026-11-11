<template>
  <SectionContainer
    id="featured"
    badge="Stories & Updates"
    title="Stories & <span class='text-sage-400'>Updates</span>"
    description="Berita terbaru, catatan perjalanan rekayasa perangkat lunak, dan cerita pencapaian profesional."
  >
    <!-- =================================================================================== -->
    <!-- 1. FULL-WIDTH STORIES & NEWS CAROUSEL (Widescreen, Grand & Prominent)               -->
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
              BERITA & CERITA ({{ currentSlide + 1 }}/{{ displayStories.length }})
            </span>
          </div>

          <!-- Slide Navigation Controls -->
          <div class="flex items-center gap-2.5">
            <button
              @click="prevSlide"
              type="button"
              title="Previous Story"
              class="w-9 h-9 rounded-full bg-forest-900 border border-forest-700 text-sage-400 hover:text-mint-100 hover:border-sage-400 hover:bg-forest-800 flex items-center justify-center transition-all active:scale-90 shadow-sm"
            >
              <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
              </svg>
            </button>
            <button
              @click="nextSlide"
              type="button"
              title="Next Story"
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
          v-if="currentStory"
          class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-center relative z-10 transition-all duration-300"
        >
          <!-- Left: Big Story Image Container -->
          <div class="lg:col-span-6 relative w-full h-64 sm:h-80 lg:h-[400px] rounded-2xl overflow-hidden border border-forest-700 ring-1 ring-sage-400/25 group/img shadow-[0_10px_35px_rgba(5,31,32,0.9)] bg-forest-950">
            <img
              :src="currentStory.thumbnail_url || currentStory.thumbnail || currentStory.image_url || currentStory.image || 'https://images.unsplash.com/photo-1517694712202-14dd9538aa97?auto=format&fit=crop&w=1000&q=80'"
              :alt="currentStory.title"
              class="w-full h-full object-cover transition-transform duration-700 group-hover/img:scale-105"
            />
            <div class="absolute inset-0 bg-gradient-to-t from-forest-950/85 via-forest-950/20 to-transparent"></div>
            
            <!-- Category Tag Pill & Date -->
            <div class="absolute top-4 left-4 flex flex-wrap items-center gap-2">
              <span class="px-3 py-1 text-xs font-semibold bg-forest-900/90 text-sage-400 border border-forest-700 rounded-lg backdrop-blur-md shadow-md">
                {{ currentStory.category || 'Cerita' }}
              </span>
              <span v-if="currentStory.event_date" class="px-2.5 py-1 text-[11px] font-mono font-medium bg-forest-950/90 text-mint-100/90 border border-forest-700 rounded-lg backdrop-blur-md shadow-md">
                {{ currentStory.event_date }}
              </span>
            </div>
          </div>

          <!-- Right: Story Narrative & Actions -->
          <div class="lg:col-span-6 flex flex-col justify-between h-full space-y-5">
            <div>
              <h3 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-mint-100 mb-3.5 tracking-tight leading-snug">
                {{ currentStory.title }}
              </h3>

              <p class="text-sm sm:text-base text-mint-100/85 leading-relaxed mb-6 whitespace-pre-line">
                {{ currentStory.summary }}
              </p>

              <!-- Tags Badges -->
              <div v-if="currentStory.tags && currentStory.tags.length" class="mb-6 flex flex-wrap gap-2">
                <span
                  v-for="(tag, i) in currentStory.tags"
                  :key="i"
                  class="px-3 py-1 text-xs font-mono font-medium bg-forest-800 text-mint-100 rounded-lg border border-forest-700 ring-1 ring-sage-400/20"
                >
                  #{{ tag }}
                </span>
              </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center gap-3 pt-3 border-t border-forest-700/50">
              <BaseButton
                variant="primary"
                size="md"
                @click="openStoryModal(currentStory)"
              >
                <span>BACA CERITA</span>
                <template #icon-right>
                  <svg class="w-4 h-4 text-mint-100" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                  </svg>
                </template>
              </BaseButton>
            </div>
          </div>
        </div>

        <!-- Bottom Dot Indicators -->
        <div class="flex items-center justify-center gap-2.5 mt-8 pt-4 border-t border-forest-700/50 relative z-10">
          <button
            v-for="(s, index) in displayStories"
            :key="'dot-' + (s.id || index)"
            @click="currentSlide = index"
            :title="s.title"
            type="button"
            class="h-2.5 rounded-full transition-all duration-300"
            :class="currentSlide === index ? 'w-10 bg-sage-400 shadow-[0_0_12px_#8EB69B]' : 'w-2.5 bg-forest-700 hover:bg-sage-400/60'"
          ></button>
        </div>
      </GlassCard>
    </div>

    <!-- =================================================================================== -->
    <!-- 2. SERVICES SECTION (Diletakkan di Bawah Slider, Format Grid 3 Kolom Lebih Josjis)  -->
    <!-- =================================================================================== -->
    <div>
      <!-- Sub-header Title for Services -->
      <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4 mb-8">
        <div>
          <h3 class="text-2xl sm:text-3xl font-extrabold text-mint-100 tracking-tight">
            Services & Solutions
          </h3>
        </div>
        <p class="text-xs sm:text-sm text-sage-400/80 max-w-md">
          Solusi rekayasa perangkat lunak ujung-ke-ujung dengan standar performa dan skalabilitas modern.
        </p>
      </div>

      <!-- 3 Columns Services Grid Layout -->
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 items-stretch">
        <GlassCard
          v-for="(service, idx) in displayServices"
          :key="service.id || idx"
          variant="secondary"
          class="flex flex-col justify-between group hover:-translate-y-1.5 hover:border-sage-400/80 transition-all duration-300 ring-1 ring-transparent hover:ring-sage-400/30 shadow-[0_4px_20px_rgba(5,31,32,0.6)]"
        >
          <div>
            <!-- Header: Service Icon & Index Counter -->
            <div class="flex items-center justify-between mb-5">
              <div class="w-12 h-12 rounded-xl bg-forest-900 border border-forest-700/80 flex items-center justify-center text-sage-400 group-hover:border-sage-400 group-hover:scale-110 group-hover:shadow-[0_0_15px_rgba(142,182,155,0.4)] transition-all duration-300">
                <!-- If icon url provided -->
                <img
                  v-if="(service.icon_url || service.icon) && !brokenServiceIcons[service.id || idx]"
                  :src="service.icon_url || service.icon"
                  :alt="service.title"
                  class="w-6 h-6 object-contain"
                  @error="brokenServiceIcons[service.id || idx] = true"
                />
                <!-- Preset SVG Icons Based on Index/Title -->
                <svg v-else-if="idx === 0 || service.title.toLowerCase().includes('web')" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" />
                </svg>
                <svg v-else-if="idx === 1 || service.title.toLowerCase().includes('design') || service.title.toLowerCase().includes('ui')" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01" />
                </svg>
                <svg v-else class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                </svg>
              </div>

              <span class="text-xs font-mono font-bold text-sage-400/60 group-hover:text-sage-400 transition-colors">
                0{{ idx + 1 }}
              </span>
            </div>

            <!-- Service Title -->
            <h4 class="text-lg sm:text-xl font-bold text-mint-100 group-hover:text-sage-400 transition-colors mb-3">
              {{ service.title }}
            </h4>

            <!-- Service Description -->
            <p class="text-xs sm:text-sm text-mint-100/80 leading-relaxed mb-6">
              {{ service.description }}
            </p>
          </div>

          <!-- Highlight Bullets -->
          <div class="pt-4 border-t border-forest-700/60 mt-auto">
            <ul class="space-y-2">
              <li
                v-for="(feat, fIdx) in getServiceFeatures(idx)"
                :key="fIdx"
                class="flex items-center gap-2 text-xs text-sage-400/90 font-medium"
              >
                <span class="w-1.5 h-1.5 rounded-full bg-sage-400 shadow-[0_0_6px_#8EB69B]"></span>
                <span>{{ feat }}</span>
              </li>
            </ul>
          </div>
        </GlassCard>
      </div>
    </div>

    <!-- =================================================================================== -->
    <!-- READ STORY DETAIL MODAL (AdminModal popup)                                          -->
    <!-- =================================================================================== -->
    <AdminModal
      :show="!!selectedModalStory"
      :title="selectedModalStory?.title || 'Detail Cerita & Berita'"
      max-width="2xl"
      @close="selectedModalStory = null"
    >
      <div v-if="selectedModalStory" class="space-y-4">
        <div class="flex flex-wrap items-center gap-2">
          <span class="inline-block px-2.5 py-0.5 text-xs uppercase tracking-wider text-sage-400 font-semibold font-mono bg-forest-800 rounded border border-forest-700">
            {{ selectedModalStory.category || 'Story' }}
          </span>
          <span v-if="selectedModalStory.event_date" class="inline-block px-2.5 py-0.5 text-xs text-mint-100/80 font-mono bg-forest-900 rounded border border-forest-700">
            {{ selectedModalStory.event_date }}
          </span>
        </div>

        <div class="rounded-xl overflow-hidden border border-forest-700 max-h-72 ring-1 ring-sage-400/20">
          <img
            :src="selectedModalStory.thumbnail_url || selectedModalStory.thumbnail || selectedModalStory.image_url || selectedModalStory.image || 'https://images.unsplash.com/photo-1517694712202-14dd9538aa97?auto=format&fit=crop&w=1000&q=80'"
            :alt="selectedModalStory.title"
            class="w-full h-full object-cover"
          />
        </div>

        <p class="text-sm text-mint-100/90 leading-relaxed whitespace-pre-line font-medium">
          {{ selectedModalStory.summary }}
        </p>

        <div v-if="selectedModalStory.content" class="p-4 rounded-xl bg-forest-900/80 border border-forest-700 text-xs sm:text-sm text-mint-100/85 leading-relaxed whitespace-pre-line space-y-2">
          {{ selectedModalStory.content }}
        </div>

        <div v-if="selectedModalStory.tags && selectedModalStory.tags.length">
          <span class="text-xs uppercase text-sage-400 font-semibold block mb-2 font-mono">Topik / Tags:</span>
          <div class="flex flex-wrap gap-2">
            <span
              v-for="(tag, i) in selectedModalStory.tags"
              :key="i"
              class="px-3 py-1 rounded-md text-xs font-mono bg-forest-800 text-mint-100 border border-forest-700"
            >
              #{{ tag }}
            </span>
          </div>
        </div>
      </div>

      <template #footer>
        <div v-if="selectedModalStory" class="w-full flex items-center justify-end">
          <BaseButton
            variant="ghost"
            size="sm"
            @click="selectedModalStory = null"
          >
            <span>Tutup</span>
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
  stories: {
    type: Array,
    default: () => [],
  },
  services: {
    type: Array,
    default: () => [],
  },
});

const currentSlide = ref(0);
const selectedModalStory = ref(null);
const brokenServiceIcons = ref({});
let autoSlideInterval = null;

const defaultStories = [
  {
    title: 'Membangun Portofolio & Headless CMS Modern dengan Laravel 11 & Vue 3',
    category: 'Experience & Build',
    event_date: 'November 2026',
    summary: 'Mendokumentasikan arsitektur personal platform terintegrasi dengan CMS admin Filament, otentikasi Sanctum, dan antarmuka responsif berbasis Glassmorphism.',
    content: 'Proyek ini menggabungkan performa Laravel 11 di sisi backend dengan reaktivitas Vue 3 di frontend. Fitur utamanya mencakup manajemen portofolio dinamis, otentikasi token Sanctum, optimasi database MySQL, dan tema visual terkurasi dengan nuansa Forest Deep Green.',
    image: 'https://images.unsplash.com/photo-1460925895917-afdab827c52f?auto=format&fit=crop&w=1000&q=80',
    tags: ['Laravel11', 'Vue3', 'Filament', 'CleanCode'],
    url: null,
  },
  {
    title: 'Meraih Sertifikasi Cloud Architecture & Backend Optimization',
    category: 'Pencapaian',
    event_date: 'Agustus 2026',
    summary: 'Berhasil menyelesaikan sertifikasi arsitektur komputasi awan dan strategi tuning performa database skala enterprise.',
    content: 'Pencapaian ini memperkuat pemahaman mendalam mengenai skalabilitas horizontal, pemisahan dependensi, caching berbasis Redis, dan penanganan ribuan request konkuren pada aplikasi backend modern.',
    image: 'https://images.unsplash.com/photo-1517694712202-14dd9538aa97?auto=format&fit=crop&w=1000&q=80',
    tags: ['Cloud', 'Scalability', 'Performance', 'Certification'],
    url: null,
  },
  {
    title: 'Berbagi Pengalaman di Tech Meetup: Desain Skalabilitas REST API',
    category: 'Tech Talk & Community',
    event_date: 'September 2026',
    summary: 'Menjadi pembicara dalam sesi komunitas developer lokal membahas praktik terbaik merancang RESTful API yang terstandarisasi.',
    content: 'Membahas penggunaan API Resources di Laravel, penanganan error terpusat, pengujian otomatis menggunakan Pest/PHPUnit, serta implementasi rate limiting untuk mengamankan endpoint dari penyalahgunaan.',
    image: 'https://images.unsplash.com/photo-1540575467063-178a50c2df87?auto=format&fit=crop&w=1000&q=80',
    tags: ['TechMeetup', 'RESTfulAPI', 'BestPractices'],
    url: null,
  },
];

const displayStories = computed(() => {
  if (props.stories && props.stories.length > 0) {
    return props.stories;
  }
  return defaultStories;
});

const currentStory = computed(() => {
  return displayStories.value[currentSlide.value % displayStories.value.length];
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
  currentSlide.value = (currentSlide.value + 1) % displayStories.value.length;
};

const prevSlide = () => {
  currentSlide.value = (currentSlide.value - 1 + displayStories.value.length) % displayStories.value.length;
};

const openStoryModal = (story) => {
  selectedModalStory.value = story;
};

onMounted(() => {
  autoSlideInterval = setInterval(nextSlide, 7000);
});

onUnmounted(() => {
  if (autoSlideInterval) clearInterval(autoSlideInterval);
});
</script>
