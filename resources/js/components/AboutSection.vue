<template>
  <section id="about" class="relative py-20 z-10">
    <!-- Section Heading -->
    <div class="text-center mb-12">
      <span class="inline-block px-3 py-1 text-xs font-semibold tracking-widest text-sage-400 uppercase bg-forest-900 border border-forest-700 rounded-full mb-3 shadow-[0_0_10px_rgba(142,182,155,0.15)]">
        Discover
      </span>
      <h2 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-mint-100">
        About Me & <span class="text-sage-400">Technical Skills</span>
      </h2>
      <p class="mt-3 text-sage-400/80 max-w-xl mx-auto text-sm sm:text-base">
        A glimpse into who I am, what drives my passion for software engineering, and my core tech capabilities.
      </p>
    </div>

    <!-- 2 Column Layout -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-stretch">
      <!-- Left Column: About Me Glassmorphism Card -->
      <div class="lg:col-span-7 flex flex-col">
        <div class="h-full bg-forest-800/60 backdrop-blur-md border border-sage-400/25 rounded-2xl p-6 sm:p-8 flex flex-col justify-between shadow-[0_10px_30px_rgba(5,31,32,0.6)] relative overflow-hidden group">
          <!-- Subtle Inner Ambient Glow -->
          <div class="absolute -top-20 -left-20 w-48 h-48 bg-sage-400/10 rounded-full blur-3xl pointer-events-none"></div>

          <div class="flex flex-col sm:flex-row gap-6 items-center sm:items-start">
            <!-- Square Photo with border glow -->
            <div class="relative w-36 h-36 sm:w-44 sm:h-44 rounded-2xl overflow-hidden shrink-0 border border-sage-400/40 shadow-[0_0_15px_rgba(142,182,155,0.25)]">
              <img
                :src="profile?.avatar_url || 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=600&q=80'"
                :alt="profile?.name || 'About Me Photo'"
                class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"
              />
              <div class="absolute inset-0 bg-gradient-to-t from-forest-950/70 via-transparent to-transparent"></div>
            </div>

            <!-- Content -->
            <div class="flex-1 flex flex-col text-center sm:text-left">
              <span class="text-xs uppercase tracking-wider text-sage-400 font-semibold mb-1">
                Who I Am
              </span>
              <h3 class="text-2xl sm:text-3xl font-bold text-mint-100 mb-3">
                About Me
              </h3>
              <p class="text-sm sm:text-base text-mint-100/85 leading-relaxed mb-4 whitespace-pre-line">
                {{ profile?.about_me || 'Saya adalah seorang Full-Stack Developer yang berdedikasi dalam membangun produk digital modern, cepat, dan terukur. Berpengalaman dalam merancang arsitektur backend berbasis Laravel, relational database MySQL, serta antarmuka interaktif dengan Vue 3 dan Tailwind CSS.' }}
              </p>

              <!-- Meta List / Highlights -->
              <div class="grid grid-cols-2 gap-2 text-xs text-sage-400 mb-5 pt-2 border-t border-forest-700/50">
                <div class="flex items-center gap-1.5 justify-center sm:justify-start">
                  <span class="w-1.5 h-1.5 rounded-full bg-sage-400"></span>
                  <span class="text-mint-100/90 font-medium">Location:</span> {{ profile?.location || 'Jakarta, ID' }}
                </div>
                <div class="flex items-center gap-1.5 justify-center sm:justify-start">
                  <span class="w-1.5 h-1.5 rounded-full bg-sage-400"></span>
                  <span class="text-mint-100/90 font-medium">Status:</span> Freelance Ready
                </div>
              </div>
            </div>
          </div>

          <!-- Bottom Action: Learn More Button -->
          <div class="mt-6 pt-4 border-t border-forest-700/40 flex items-center justify-between">
            <span class="text-xs text-sage-400/80 font-mono">
              // Continuous Learning & Craftsmanship
            </span>

            <button
              @click="isModalOpen = true"
              type="button"
              class="inline-flex items-center gap-2 px-6 py-2.5 rounded-full bg-forest-900 text-mint-100 font-semibold text-xs tracking-wider uppercase border border-sage-400 shadow-[0_0_15px_rgba(142,182,155,0.3)] hover:bg-forest-700 hover:shadow-[0_0_25px_rgba(142,182,155,0.5)] hover:scale-105 transition-all duration-300"
            >
              <span>LEARN MORE</span>
              <svg class="w-3.5 h-3.5 text-sage-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
              </svg>
            </button>
          </div>
        </div>
      </div>

      <!-- Right Column: Technical Skills Grid -->
      <div class="lg:col-span-5 flex flex-col">
        <div class="h-full bg-forest-900/50 backdrop-blur-md border border-forest-700 rounded-2xl p-6 sm:p-8 flex flex-col justify-between shadow-[0_10px_30px_rgba(5,31,32,0.5)]">
          <div>
            <div class="flex items-center justify-between mb-4">
              <div>
                <span class="text-xs uppercase tracking-wider text-sage-400 font-semibold">
                  Technologies
                </span>
                <h3 class="text-xl sm:text-2xl font-bold text-mint-100">
                  Technical Skills
                </h3>
              </div>
              <span class="px-2.5 py-1 text-[11px] font-mono bg-forest-800 text-sage-400 border border-forest-700 rounded-md">
                {{ technicalSkills.length }} Stack
              </span>
            </div>

            <!-- Square Small Cards Grid -->
            <div class="grid grid-cols-2 sm:grid-cols-4 lg:grid-cols-3 gap-3">
              <div
                v-for="skill in technicalSkills"
                :key="skill.id || skill.name"
                class="group bg-forest-900/90 border border-forest-700 hover:border-sage-400 rounded-xl p-3 flex flex-col items-center justify-center gap-2 hover:bg-forest-800/80 hover:scale-105 hover:shadow-[0_0_15px_rgba(142,182,155,0.25)] transition-all duration-300 cursor-default"
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

                <!-- Mastery Percentage Badge -->
                <span class="text-[10px] text-sage-400/80 font-mono">
                  {{ skill.percentage }}%
                </span>
              </div>
            </div>
          </div>

          <!-- Bottom Footer Note -->
          <div class="mt-6 pt-3 border-t border-forest-700/40 text-center">
            <p class="text-xs text-sage-400/70">
              Passionate about clean code architecture, modular components & agile engineering.
            </p>
          </div>
        </div>
      </div>
    </div>

    <!-- Learn More Modal Dialog -->
    <div
      v-if="isModalOpen"
      class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-forest-950/80 backdrop-blur-md animate-fade-in"
      @click.self="isModalOpen = false"
    >
      <div class="relative w-full max-w-2xl bg-forest-900 border border-sage-400/40 rounded-2xl p-6 sm:p-8 shadow-[0_0_40px_rgba(142,182,155,0.3)] max-h-[90vh] overflow-y-auto">
        <!-- Close Button -->
        <button
          @click="isModalOpen = false"
          type="button"
          class="absolute top-5 right-5 w-8 h-8 rounded-full bg-forest-800 text-sage-400 hover:text-mint-100 hover:bg-forest-700 flex items-center justify-center transition-colors border border-forest-700"
        >
          <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
          </svg>
        </button>

        <span class="text-xs uppercase tracking-wider text-sage-400 font-semibold">Extended Story</span>
        <h3 class="text-2xl font-bold text-mint-100 mb-4 mt-1">Deep Dive Into My Journey</h3>

        <div class="space-y-4 text-sm text-mint-100/90 leading-relaxed">
          <p>
            {{ profile?.about_me }}
          </p>
          <p>
            Saya selalu percaya bahwa sebuah aplikasi web yang hebat tidak hanya memiliki tampilan visual yang memikat, tetapi juga fondasi kode yang kokoh, terstruktur, aman, serta siap berkembang seiring bertambahnya pengguna.
          </p>
        </div>

        <!-- Social Channels & Contact Shortcut -->
        <div class="mt-6 pt-6 border-t border-forest-700 flex flex-wrap items-center justify-between gap-4">
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

          <button
            @click="isModalOpen = false; scrollTo('#contact')"
            type="button"
            class="px-5 py-2 rounded-full bg-forest-700 text-mint-100 font-semibold text-xs border border-sage-400 shadow-[0_0_15px_rgba(142,182,155,0.3)] hover:bg-forest-700/80 transition-all"
          >
            Get In Touch
          </button>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
import { ref, computed } from 'vue';

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

const scrollTo = (selector) => {
  const el = document.querySelector(selector);
  if (el) {
    el.scrollIntoView({ behavior: 'smooth' });
  }
};
</script>

