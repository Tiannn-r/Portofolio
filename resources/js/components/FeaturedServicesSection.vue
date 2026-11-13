<template>
  <SectionContainer
    id="featured"
    badge="Catatan"
    title="Catatan & Cerita Perjalanan"
    description="Berita terbaru, catatan pembelajaran rekayasa perangkat lunak, dan cerita pencapaian profesional."
  >
    <!-- =================================================================================== -->
    <!-- FULL-WIDTH STORIES & NEWS CAROUSEL (Widescreen, Grand & Prominent)                  -->
    <!-- =================================================================================== -->
    <div class="w-full">
      <GlassCard
        variant="primary"
        class="w-full relative overflow-hidden p-6 sm:p-8 lg:p-10 border border-forest-700 shadow-xl"
      >
        <!-- Top Header Bar with Slide Counter & Arrows -->
        <div class="flex items-center justify-between mb-8 pb-4 border-b border-forest-700/60 relative z-10">
          <div class="flex items-center gap-3">
            <span class="w-2.5 h-2.5 rounded-full bg-warm-400"></span>
            <span class="text-xs sm:text-sm tracking-wider text-sage-400 font-bold font-mono">
              KABAR & CATATAN ({{ currentSlide + 1 }}/{{ displayStories.length }})
            </span>
          </div>

          <!-- Slide Navigation Controls -->
          <div class="flex items-center gap-2.5">
            <button
              @click="prevSlide"
              type="button"
              title="Cerita Sebelumnya"
              class="w-9 h-9 rounded-full bg-forest-900 border border-forest-700 text-sage-400 hover:text-mint-100 hover:border-sage-400 hover:bg-forest-800 flex items-center justify-center transition-all active:scale-90 shadow-sm"
            >
              <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
              </svg>
            </button>
            <button
              @click="nextSlide"
              type="button"
              title="Cerita Selanjutnya"
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
          <div class="lg:col-span-6 relative w-full h-64 sm:h-80 lg:h-[400px] rounded-2xl overflow-hidden border border-forest-700 bg-forest-950">
            <img
              :src="currentStory.thumbnail_url || currentStory.thumbnail || currentStory.image_url || currentStory.image || 'https://images.unsplash.com/photo-1517694712202-14dd9538aa97?auto=format&fit=crop&w=1000&q=80'"
              :alt="currentStory.title"
              class="w-full h-full object-cover"
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
                <span>Baca Selengkapnya</span>
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
            class="h-2 rounded-full transition-all duration-200"
            :class="currentSlide === index ? 'w-8 bg-warm-400' : 'w-2 bg-forest-700 hover:bg-forest-700'"
          ></button>
        </div>
      </GlassCard>
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
});

const currentSlide = ref(0);
const selectedModalStory = ref(null);
let autoSlideInterval = null;

const defaultStories = [
  {
    title: 'Membangun Portofolio & Headless CMS Modern dengan Laravel 11 & Vue 3',
    category: 'Proyek Nyata',
    event_date: 'November 2026',
    summary: 'Mendokumentasikan arsitektur personal platform terintegrasi dengan CMS admin Filament, otentikasi Sanctum, dan antarmuka responsif berbasis Vue 3.',
    content: 'Proyek ini menggabungkan performa Laravel 11 di sisi backend dengan reaktivitas Vue 3 di frontend. Fitur utamanya mencakup manajemen portofolio dinamis, otentikasi token Sanctum, optimasi database MySQL, dan tema visual minimalis yang dirancang bebas dari template AI.',
    image: 'https://images.unsplash.com/photo-1460925895917-afdab827c52f?auto=format&fit=crop&w=1000&q=80',
    tags: ['Laravel11', 'Vue3', 'Filament', 'CleanCode'],
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
