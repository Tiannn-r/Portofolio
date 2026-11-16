<template>
  <SectionContainer
    id="about"
    badge="Tentang"
    title="Tentang Saya & Keahlian Teknis"
    description="Ringkasan latar belakang rekayasa perangkat lunak dan keahlian teknis utama saya."
  >
    <!-- 2 Column Layout -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 lg:gap-8 items-stretch">
      <!-- Left Column: About Me Card -->
      <div class="lg:col-span-7 flex flex-col">
        <GlassCard
          variant="primary"
          class="h-full group p-6 sm:p-7 flex flex-col justify-between"
          content-class="h-full flex flex-col justify-between"
        >
          <!-- Top Row: Photo + Narrative -->
          <div class="flex flex-col sm:flex-row gap-5 sm:gap-6 items-center sm:items-start relative z-10">
            <!-- Modern Portrait Photo Frame -->
            <div class="relative w-36 sm:w-44 aspect-[4/5] rounded-2xl overflow-hidden shrink-0 border border-forest-700/80 group-hover:border-sage-400/70 transition-all duration-300 shadow-md bg-forest-950">
              <img
                :src="profile?.about_image_url || profile?.about_image || profile?.avatar_url || '/storage/profile/vQNDsJ2Nb1YtlQ9dV3VcI7PaMFdF0BLZq3HIhLSv.jpg'"
                :alt="profile?.name || 'Foto Tentang Saya'"
                class="w-full h-full object-cover object-center group-hover:scale-105 transition-transform duration-500"
              />
              <!-- Subtle gradient overlay on bottom of photo -->
              <div class="absolute inset-x-0 bottom-0 h-16 bg-gradient-to-t from-forest-950/90 via-forest-950/40 to-transparent pointer-events-none"></div>

              <!-- Floating Role Badge -->
              <div class="absolute bottom-2 inset-x-2 px-2 py-1 rounded-lg bg-forest-950/85 backdrop-blur-md border border-forest-700/70 text-[10px] font-medium text-mint-100 flex items-center justify-center gap-1.5 shadow-sm">
                <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                <span class="truncate">{{ primaryRole }}</span>
              </div>
            </div>

            <!-- Content -->
            <div class="flex-1 flex flex-col text-center sm:text-left">
              <h3 class="text-xl sm:text-2xl font-bold text-mint-100 mb-2.5 tracking-tight">
                Tentang Saya
              </h3>
              <p class="text-xs sm:text-sm text-mint-100/85 leading-relaxed whitespace-pre-line">
                {{ profile?.about_me || 'Saya adalah seorang Full-Stack Developer yang berdedikasi dalam membangun produk digital modern, cepat, dan terukur. Berpengalaman dalam merancang arsitektur backend berbasis Laravel, relational database MySQL, serta antarmuka interaktif dengan Vue 3 dan Tailwind CSS.' }}
              </p>
            </div>
          </div>

          <!-- Bottom Row: 4 Key Highlights Micro-Cards -->
          <div class="grid grid-cols-2 gap-2.5 pt-4 mt-5 border-t border-forest-700/60 relative z-10">
            <!-- Highlight 1: Domisili -->
            <div class="flex items-center gap-2.5 px-3 py-2 rounded-xl bg-forest-950/60 border border-forest-700/60 hover:border-sage-400/40 transition-colors">
              <div class="w-7 h-7 rounded-lg bg-forest-800/80 border border-forest-700/60 flex items-center justify-center text-sage-400 shrink-0">
                <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
              </div>
              <div class="min-w-0">
                <span class="block text-[10px] text-sage-400/80 font-medium">Domisili</span>
                <span class="block text-xs font-semibold text-mint-100 truncate">{{ profile?.location || 'Bandung, Indonesia' }}</span>
              </div>
            </div>

            <!-- Highlight 2: Spesialisasi -->
            <div class="flex items-center gap-2.5 px-3 py-2 rounded-xl bg-forest-950/60 border border-forest-700/60 hover:border-sage-400/40 transition-colors">
              <div class="w-7 h-7 rounded-lg bg-forest-800/80 border border-forest-700/60 flex items-center justify-center text-sage-400 shrink-0">
                <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
              </div>
              <div class="min-w-0">
                <span class="block text-[10px] text-sage-400/80 font-medium">Spesialisasi</span>
                <span class="block text-xs font-semibold text-mint-100 truncate">Web & UI/UX</span>
              </div>
            </div>

            <!-- Highlight 3: Core Stack -->
            <div class="flex items-center gap-2.5 px-3 py-2 rounded-xl bg-forest-950/60 border border-forest-700/60 hover:border-sage-400/40 transition-colors">
              <div class="w-7 h-7 rounded-lg bg-forest-800/80 border border-forest-700/60 flex items-center justify-center text-sage-400 shrink-0">
                <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" />
                </svg>
              </div>
              <div class="min-w-0">
                <span class="block text-[10px] text-sage-400/80 font-medium">Core Stack</span>
                <span class="block text-xs font-semibold text-mint-100 truncate">Laravel & Vue 3</span>
              </div>
            </div>

            <!-- Highlight 4: Standar Kode -->
            <div class="flex items-center gap-2.5 px-3 py-2 rounded-xl bg-forest-950/60 border border-forest-700/60 hover:border-sage-400/40 transition-colors">
              <div class="w-7 h-7 rounded-lg bg-forest-800/80 border border-forest-700/60 flex items-center justify-center text-sage-400 shrink-0">
                <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                </svg>
              </div>
              <div class="min-w-0">
                <span class="block text-[10px] text-sage-400/80 font-medium">Standar Kode</span>
                <span class="block text-xs font-semibold text-mint-100 truncate">Clean & Scalable</span>
              </div>
            </div>
          </div>
        </GlassCard>
      </div>

      <!-- Right Column: Technical Skills Grid -->
      <div class="lg:col-span-5 flex flex-col">
        <GlassCard
          variant="secondary"
          class="h-full flex flex-col justify-between p-6 sm:p-7"
        >
          <div>
            <div class="mb-4">
              <h3 class="text-lg sm:text-xl font-bold text-mint-100 tracking-tight">
                Keahlian Teknis
              </h3>
            </div>

            <!-- Square Small Cards Grid -->
            <div class="grid grid-cols-2 sm:grid-cols-4 lg:grid-cols-3 gap-2.5">
              <div
                v-for="skill in technicalSkills"
                :key="skill.id || skill.name"
                class="bg-forest-900/90 border border-forest-700 hover:border-sage-400/80 rounded-xl p-2.5 flex flex-col items-center justify-center gap-2 hover:bg-forest-800/80 transition-colors duration-200 cursor-default"
              >
                <!-- Logo / Icon -->
                <div class="w-9 h-9 rounded-lg bg-forest-950/90 p-1.5 flex items-center justify-center border border-forest-700/60">
                  <!-- Inline SVG support -->
                  <div
                    v-if="skill.icon && skill.icon.trim().startsWith('<svg')"
                    class="w-full h-full flex items-center justify-center [&>svg]:w-full [&>svg]:h-full [&>svg]:object-contain"
                    v-html="skill.icon"
                  ></div>
                  <!-- Image URL / Uploaded File -->
                  <img
                    v-else-if="(skill.icon_url || skill.icon) && !brokenSkillIcons[skill.id || skill.name]"
                    :src="skill.icon_url || skill.icon"
                    :alt="skill.name"
                    class="w-full h-full object-contain"
                    loading="lazy"
                    @error="brokenSkillIcons[skill.id || skill.name] = true"
                  />
                  <!-- Fallback Tech Icon -->
                  <svg v-else class="w-4 h-4 text-sage-400" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" />
                  </svg>
                </div>

                <!-- Skill Name -->
                <span class="text-[11px] font-medium text-mint-100 text-center line-clamp-1">
                  {{ skill.name }}
                </span>
              </div>
            </div>
          </div>
        </GlassCard>
      </div>
    </div>
  </SectionContainer>
</template>

<script setup>
import { ref, computed } from 'vue';
import SectionContainer from './ui/SectionContainer.vue';
import GlassCard from './ui/GlassCard.vue';

const props = defineProps({
  profile: {
    type: Object,
    default: () => ({}),
  },
  skills: {
    type: Object,
    default: () => ({
      technical_grid: [],
      progress_bars: [],
    }),
  },
});

const brokenSkillIcons = ref({});

const primaryRole = computed(() => {
  if (Array.isArray(props.profile?.roles) && props.profile.roles.length > 0) {
    return props.profile.roles[0];
  }
  return 'Full-Stack Developer';
});

const defaultTechSkills = [
  { name: 'Laravel 11', percentage: 92, icon_url: 'https://cdn.jsdelivr.net/gh/devicons/devicon/icons/laravel/laravel-original.svg' },
  { name: 'Vue.js 3', percentage: 88, icon_url: 'https://cdn.jsdelivr.net/gh/devicons/devicon/icons/vuejs/vuejs-original.svg' },
  { name: 'Tailwind CSS', percentage: 95, icon_url: 'https://cdn.jsdelivr.net/gh/devicons/devicon/icons/tailwindcss/tailwindcss-original.svg' },
  { name: 'MySQL', percentage: 85, icon_url: 'https://cdn.jsdelivr.net/gh/devicons/devicon/icons/mysql/mysql-original.svg' },
  { name: 'PHP 8.5', percentage: 90, icon_url: 'https://cdn.jsdelivr.net/gh/devicons/devicon/icons/php/php-original.svg' },
  { name: 'JavaScript', percentage: 89, icon_url: 'https://cdn.jsdelivr.net/gh/devicons/devicon/icons/javascript/javascript-original.svg' },
  { name: 'Git & GitHub', percentage: 87, icon_url: 'https://cdn.jsdelivr.net/gh/devicons/devicon/icons/git/git-original.svg' },
  { name: 'Docker', percentage: 76, icon_url: 'https://cdn.jsdelivr.net/gh/devicons/devicon/icons/docker/docker-original.svg' },
];

const technicalSkills = computed(() => {
  if (props.skills?.technical_grid && props.skills.technical_grid.length > 0) {
    return props.skills.technical_grid;
  }
  return defaultTechSkills;
});
</script>
