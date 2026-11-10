<template>
  <SectionContainer
    id="about"
    badge="About"
    title="About Me & <span class='text-sage-400'>Technical Skills</span>"
    description="A brief overview of my engineering background and core technical stack."
  >
    <!-- 2 Column Layout -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-stretch">
      <!-- Left Column: About Me GlassCard -->
      <div class="lg:col-span-7 flex flex-col">
        <GlassCard
          variant="primary"
          hoverable
          class="h-full flex flex-col justify-between group"
        >
          <!-- Ambient Radial Glow -->
          <div class="absolute -top-20 -left-20 w-52 h-52 bg-sage-400/10 rounded-full blur-3xl pointer-events-none"></div>

          <div class="flex flex-col sm:flex-row gap-6 items-center sm:items-start relative z-10">
            <!-- Square Photo with border glow -->
            <div class="relative w-36 h-36 sm:w-44 sm:h-44 rounded-2xl overflow-hidden shrink-0 border border-sage-400/40 shadow-[0_0_20px_rgba(142,182,155,0.25)] ring-1 ring-sage-400/20">
              <img
                :src="profile?.avatar_url || 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=600&q=80'"
                :alt="profile?.name || 'About Me Photo'"
                class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105"
              />
              <div class="absolute inset-0 bg-gradient-to-t from-forest-950/80 via-transparent to-transparent"></div>
            </div>

            <!-- Content -->
            <div class="flex-1 flex flex-col text-center sm:text-left">
              <h3 class="text-2xl sm:text-3xl font-bold text-mint-100 mb-3 tracking-tight">
                About Me
              </h3>
              <p class="text-sm sm:text-base text-mint-100/90 leading-relaxed mb-5 whitespace-pre-line">
                {{ profile?.about_me || 'Saya adalah seorang Full-Stack Developer yang berdedikasi dalam membangun produk digital modern, cepat, dan terukur. Berpengalaman dalam merancang arsitektur backend berbasis Laravel, relational database MySQL, serta antarmuka interaktif dengan Vue 3 dan Tailwind CSS.' }}
              </p>

              <!-- Meta List -->
              <div class="flex flex-wrap items-center gap-4 text-xs text-sage-400 pt-3 border-t border-forest-700/50 justify-center sm:justify-start">
                <div class="flex items-center gap-1.5">
                  <span class="w-1.5 h-1.5 rounded-full bg-sage-400"></span>
                  <span class="text-mint-100 font-medium">Location:</span> {{ profile?.location || 'Jakarta, ID' }}
                </div>
                <div class="flex items-center gap-1.5">
                  <span class="w-1.5 h-1.5 rounded-full bg-sage-400"></span>
                  <span class="text-mint-100 font-medium">Status:</span> Freelance Available
                </div>
              </div>
            </div>
          </div>

          <!-- Bottom Action: Learn More Button -->
          <div class="mt-6 pt-4 border-t border-forest-700/50 flex items-center justify-end relative z-10">
            <BaseButton
              variant="primary"
              size="sm"
              @click="isModalOpen = true"
            >
              <span>Learn More</span>
              <template #icon-right>
                <svg class="w-3.5 h-3.5 text-mint-100" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                </svg>
              </template>
            </BaseButton>
          </div>
        </GlassCard>
      </div>

      <!-- Right Column: Technical Skills Grid -->
      <div class="lg:col-span-5 flex flex-col">
        <GlassCard
          variant="secondary"
          class="h-full flex flex-col justify-between"
        >
          <div>
            <div class="mb-5">
              <h3 class="text-xl sm:text-2xl font-bold text-mint-100 tracking-tight">
                Technical Skills
              </h3>
            </div>

            <!-- Square Small Cards Grid -->
            <div class="grid grid-cols-2 sm:grid-cols-4 lg:grid-cols-3 gap-3">
              <div
                v-for="skill in technicalSkills"
                :key="skill.id || skill.name"
                class="group bg-forest-900/90 border border-forest-700 hover:border-sage-400/80 rounded-xl p-3 flex flex-col items-center justify-center gap-2 hover:bg-forest-800/90 hover:-translate-y-1 hover:shadow-[0_0_20px_rgba(142,182,155,0.25)] transition-all duration-300 cursor-default ring-1 ring-transparent hover:ring-sage-400/30"
              >
                <!-- Logo / Icon -->
                <div class="w-10 h-10 rounded-lg bg-forest-950/80 p-2 flex items-center justify-center border border-forest-700/60 group-hover:border-sage-400/50 transition-colors">
                  <img
                    v-if="skill.icon_url || (skill.icon && !skill.icon.startsWith('<svg'))"
                    :src="skill.icon_url || skill.icon"
                    :alt="skill.name"
                    class="w-full h-full object-contain group-hover:scale-110 transition-transform duration-300"
                    loading="lazy"
                  />
                  <!-- Fallback Tech Icon -->
                  <svg v-else class="w-5 h-5 text-sage-400" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" />
                  </svg>
                </div>

                <!-- Skill Name -->
                <span class="text-xs font-semibold text-mint-100 group-hover:text-sage-400 transition-colors text-center line-clamp-1">
                  {{ skill.name }}
                </span>
              </div>
            </div>
          </div>
        </GlassCard>
      </div>
    </div>

    <!-- Learn More Modal Dialog using AdminModal -->
    <AdminModal
      :show="isModalOpen"
      title="Deep Dive Into My Journey"
      max-width="2xl"
      @close="isModalOpen = false"
    >
      <div class="space-y-4 text-sm text-mint-100/90 leading-relaxed">
        <div class="p-3 rounded-xl bg-forest-800/50 border border-forest-700/60 mb-2">
          <span class="text-xs uppercase tracking-wider text-sage-400 font-semibold block mb-1">
            Extended Story & Philosophy
          </span>
          <p class="text-mint-100">
            {{ profile?.about_me }}
          </p>
        </div>
        <p>
          Saya selalu percaya bahwa sebuah aplikasi web yang hebat tidak hanya memiliki tampilan visual yang memikat, tetapi juga fondasi kode yang kokoh, terstruktur, aman, serta siap berkembang seiring bertambahnya pengguna.
        </p>
        <p class="text-sage-400/90">
          Dengan fokus pada continuous integration, modular design patterns, dan performa tinggi, setiap baris kode dirancang untuk memberikan nilai bisnis nyata.
        </p>
      </div>

      <template #footer>
        <div class="w-full flex flex-wrap items-center justify-between gap-4">
          <div class="flex items-center gap-3">
            <a
              v-if="profile?.social_links?.github"
              :href="profile.social_links.github"
              target="_blank"
              class="text-sage-400 hover:text-mint-100 transition-colors text-xs font-mono underline"
            >
              GitHub ↗
            </a>
            <a
              v-if="profile?.social_links?.linkedin"
              :href="profile.social_links.linkedin"
              target="_blank"
              class="text-sage-400 hover:text-mint-100 transition-colors text-xs font-mono underline"
            >
              LinkedIn ↗
            </a>
          </div>

          <BaseButton
            variant="primary"
            size="sm"
            @click="handleContactShortcut"
          >
            <span>Get In Touch</span>
          </BaseButton>
        </div>
      </template>
    </AdminModal>
  </SectionContainer>
</template>

<script setup>
import { ref, computed } from 'vue';
import SectionContainer from './ui/SectionContainer.vue';
import GlassCard from './ui/GlassCard.vue';
import BaseButton from './ui/BaseButton.vue';
import AdminModal from './ui/AdminModal.vue';

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

const isModalOpen = ref(false);

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

const handleContactShortcut = () => {
  isModalOpen.value = false;
  const target = document.querySelector('#contact');
  if (target) {
    target.scrollIntoView({ behavior: 'smooth' });
  }
};
</script>
