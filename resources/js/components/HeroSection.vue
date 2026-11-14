<template>
  <section id="hero" class="relative min-h-[85vh] flex flex-col items-center justify-center text-center px-4 pt-20 pb-16 z-10">
    <!-- Availability Badge (Restrained & Calm) -->
    <div
      v-if="profile?.is_available"
      class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-forest-900/90 border border-forest-700 backdrop-blur-md mb-8 transition-colors duration-200 hover:border-warm-400/60"
    >
      <span class="w-2 h-2 rounded-full bg-warm-400"></span>
      <span class="text-xs font-medium text-mint-100 tracking-normal">
        Terbuka untuk Kerja Sama Proyek
      </span>
    </div>

    <!-- Center Profile Image -->
    <div class="relative mb-6 group">
      <div class="relative w-36 h-36 md:w-40 md:h-40 rounded-full p-1 bg-forest-900 border border-forest-700 hover:border-warm-400/80 transition-colors duration-300 overflow-hidden shadow-lg">
        <img
          :src="profile?.hero_image_url || profile?.hero_image || profile?.avatar_url || '/storage/profile/vBfVcc3JaeCdZUCrq0THNsz7xsvdZuvxhR1Sh5bO.jpg'"
          :alt="profile?.name || 'Foto Profil'"
          class="w-full h-full object-cover rounded-full"
        />
      </div>
    </div>

    <!-- Greeting & Name (Clean Typography without Artificial Colored Word) -->
    <h1 class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-extrabold tracking-tight text-mint-100 mb-3">
      Halo, saya <span class="text-mint-100">{{ profile?.name || 'Muhamad Ibnhu' }}</span>
    </h1>

    <!-- Confident Tagline Role (No Typing Effect) -->
    <div class="mb-5">
      <p class="text-lg sm:text-xl md:text-2xl font-medium text-sage-400">
        {{ roleTitle }}
      </p>
    </div>

    <!-- Short Bio Description (Natural Indonesian) -->
    <p class="max-w-2xl text-sm sm:text-base md:text-lg text-mint-100/80 leading-relaxed mb-9 px-4">
      {{ profile?.short_bio || 'Membantu mengubah ide dan kebutuhan sistem menjadi aplikasi web yang siap pakai. Suka kode yang terstruktur dan tampilan yang bersih tanpa ribet.' }}
    </p>

    <!-- Call to Action Buttons -->
    <div class="flex flex-col sm:flex-row items-center justify-center gap-3.5 w-full sm:w-auto px-4">
      <!-- "Lihat Portofolio" Button -->
      <BaseButton
        variant="primary"
        size="lg"
        class="w-full sm:w-auto"
        @click="scrollTo('#portfolio')"
      >
        <span>Lihat Portofolio</span>
        <template #icon-right>
          <svg class="w-4 h-4 text-forest-950" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3" />
          </svg>
        </template>
      </BaseButton>

      <!-- "Unduh CV" Button -->
      <BaseButton
        variant="secondary"
        size="lg"
        class="w-full sm:w-auto"
        @click="handleCvDownload"
      >
        <template #icon-left>
          <svg class="w-4 h-4 text-mint-100/80" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
          </svg>
        </template>
        <span>Unduh CV</span>
      </BaseButton>
    </div>
  </section>
</template>

<script setup>
import { computed } from 'vue';
import BaseButton from './ui/BaseButton.vue';

const props = defineProps({
  profile: {
    type: Object,
    default: () => ({}),
  },
});

const roleTitle = computed(() => {
  if (props.profile?.roles && props.profile.roles.length > 0) {
    return Array.isArray(props.profile.roles) ? props.profile.roles[0] : props.profile.roles;
  }
  return 'Web Developer — Spesialis Laravel & Vue.js';
});

const scrollTo = (selector) => {
  const el = document.querySelector(selector);
  if (el) {
    el.scrollIntoView({ behavior: 'smooth' });
  }
};

const handleCvDownload = () => {
  const url = props.profile?.cv_url || '/files/CV-Muhamad-Ibnhu.pdf';
  const link = document.createElement('a');
  link.href = url;
  link.download = 'CV-Muhamad-Ibnhu.pdf';
  link.target = '_blank';
  document.body.appendChild(link);
  link.click();
  document.body.removeChild(link);
};
</script>
