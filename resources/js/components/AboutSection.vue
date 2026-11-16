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
          class="h-full group p-6 sm:p-8 flex flex-col"
          content-class="h-full flex flex-col justify-center"
        >
          <div class="my-auto flex flex-col sm:flex-row gap-6 items-center relative z-10">
            <!-- Square Photo with clean border -->
            <div class="relative w-32 h-32 sm:w-40 sm:h-40 rounded-2xl overflow-hidden shrink-0 border border-forest-700 group-hover:border-sage-400/60 transition-colors duration-200">
              <img
                :src="profile?.about_image_url || profile?.about_image || profile?.avatar_url || '/storage/profile/vQNDsJ2Nb1YtlQ9dV3VcI7PaMFdF0BLZq3HIhLSv.jpg'"
                :alt="profile?.name || 'Foto Tentang Saya'"
                class="w-full h-full object-cover"
              />
            </div>

            <!-- Content -->
            <div class="flex-1 flex flex-col text-center sm:text-left">
              <h3 class="text-xl sm:text-2xl font-bold text-mint-100 mb-2.5 tracking-tight">
                Tentang Saya
              </h3>
              <p class="text-xs sm:text-sm text-mint-100/85 leading-relaxed mb-4 whitespace-pre-line">
                {{ profile?.about_me || 'Saya adalah seorang Full-Stack Developer yang berdedikasi dalam membangun produk digital modern, cepat, dan terukur. Berpengalaman dalam merancang arsitektur backend berbasis Laravel, relational database MySQL, serta antarmuka interaktif dengan Vue 3 dan Tailwind CSS.' }}
              </p>

              <!-- Meta List -->
              <div class="flex items-center gap-4 text-xs text-sage-400 pt-3 border-t border-forest-700/60 justify-center sm:justify-start">
                <div class="flex items-center gap-1.5">
                  <span class="w-1.5 h-1.5 rounded-full bg-sage-400"></span>
                  <span class="text-mint-100 font-medium">Lokasi:</span> {{ profile?.location || 'Jakarta, Indonesia' }}
                </div>
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
