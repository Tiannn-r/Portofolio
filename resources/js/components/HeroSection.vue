<template>
  <section id="hero" class="relative min-h-[90vh] flex flex-col items-center justify-center text-center px-4 pt-20 pb-16 z-10">
    <!-- Availability Badge -->
    <div
      v-if="profile?.is_available"
      class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-forest-900/90 border border-forest-700/80 backdrop-blur-md mb-8 shadow-[0_0_15px_rgba(142,182,155,0.15)] ring-1 ring-sage-400/20 transition-all duration-300 hover:scale-105"
    >
      <span class="relative flex h-2.5 w-2.5">
        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-sage-400 opacity-75"></span>
        <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-sage-400 shadow-[0_0_8px_#8EB69B]"></span>
      </span>
      <span class="text-xs font-semibold tracking-wider uppercase text-mint-100/90">
        Available for Freelance Projects
      </span>
    </div>

    <!-- Center Profile Image with Sage Glow Border & Micro-interaction -->
    <div class="relative mb-8 group cursor-pointer">
      <div class="absolute -inset-1 rounded-full bg-gradient-to-r from-sage-400 via-forest-700 to-sage-400 opacity-75 blur-md group-hover:opacity-100 group-hover:blur-lg transition-all duration-500 shadow-[0_0_25px_rgba(142,182,155,0.4)]"></div>
      <div class="relative w-36 h-36 md:w-44 md:h-44 rounded-full p-1 bg-forest-900 border-2 border-sage-400 shadow-[0_0_20px_rgba(142,182,155,0.35)] overflow-hidden transition-transform duration-500 group-hover:scale-105 group-active:scale-95">
        <img
          :src="profile?.avatar_url || 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=600&q=80'"
          :alt="profile?.name || 'Profile Picture'"
          class="w-full h-full object-cover rounded-full transition-transform duration-700 group-hover:scale-110"
        />
      </div>
    </div>

    <!-- Greeting & Name -->
    <h1 class="text-4xl sm:text-5xl md:text-6xl lg:text-7xl font-extrabold tracking-tight text-mint-100 mb-4">
      Hi, I'm <span class="text-sage-400 underline decoration-forest-700 decoration-wavy decoration-2">{{ profile?.name || 'Muhamad Ibnhu' }}</span>
    </h1>

    <!-- Typing Effect Role using Composable -->
    <div class="h-10 md:h-12 flex items-center justify-center mb-6">
      <p class="text-xl sm:text-2xl md:text-3xl font-medium text-mint-100/90 font-mono">
        I'm a <span class="text-sage-400 font-semibold">{{ currentText }}</span>
        <span class="animate-pulse text-sage-400 font-bold ml-0.5">|</span>
      </p>
    </div>

    <!-- Short Bio Description -->
    <p class="max-w-2xl text-base sm:text-lg md:text-xl text-sage-400/90 leading-relaxed mb-10 px-4">
      {{ profile?.short_bio || 'Passionate Full-Stack Developer crafting scalable web applications, sleek user experiences, and robust RESTful APIs using Laravel and Vue.js.' }}
    </p>

    <!-- Call to Action Buttons using BaseButton -->
    <div class="flex flex-col sm:flex-row items-center justify-center gap-4 w-full sm:w-auto px-4">
      <!-- "View My Work" Button -->
      <BaseButton
        variant="primary"
        size="lg"
        class="w-full sm:w-auto"
        @click="scrollTo('#featured')"
      >
        <span>View My Work</span>
        <template #icon-right>
          <svg class="w-4 h-4 text-mint-100" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3" />
          </svg>
        </template>
      </BaseButton>

      <!-- "Download CV" Button -->
      <BaseButton
        variant="secondary"
        size="lg"
        class="w-full sm:w-auto"
        @click="handleCvDownload"
      >
        <template #icon-left>
          <svg class="w-4 h-4 text-sage-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
          </svg>
        </template>
        <span>Download CV</span>
      </BaseButton>
    </div>

    <!-- Quick Stats Bar using GlassCard with hover-lift & micro-interactions -->
    <div class="mt-16 grid grid-cols-2 md:grid-cols-4 gap-4 sm:gap-6 w-full max-w-4xl px-4">
      <GlassCard
        variant="subtle"
        hoverable
        class="text-center transition-all duration-300 hover:-translate-y-1 hover:border-sage-400/50"
      >
        <span class="text-3xl sm:text-4xl font-extrabold text-mint-100 font-mono tracking-tight block">
          {{ profile?.years_experience || 3 }}+
        </span>
        <span class="text-xs text-sage-400 mt-1 uppercase tracking-wider font-semibold block">
          Years Experience
        </span>
      </GlassCard>

      <GlassCard
        variant="subtle"
        hoverable
        class="text-center transition-all duration-300 hover:-translate-y-1 hover:border-sage-400/50"
      >
        <span class="text-3xl sm:text-4xl font-extrabold text-mint-100 font-mono tracking-tight block">
          {{ profile?.projects_completed || 24 }}+
        </span>
        <span class="text-xs text-sage-400 mt-1 uppercase tracking-wider font-semibold block">
          Projects Done
        </span>
      </GlassCard>

      <GlassCard
        variant="subtle"
        hoverable
        class="text-center transition-all duration-300 hover:-translate-y-1 hover:border-sage-400/50"
      >
        <span class="text-3xl sm:text-4xl font-extrabold text-mint-100 font-mono tracking-tight block">
          {{ profile?.happy_clients || 18 }}+
        </span>
        <span class="text-xs text-sage-400 mt-1 uppercase tracking-wider font-semibold block">
          Happy Clients
        </span>
      </GlassCard>

      <GlassCard
        variant="subtle"
        hoverable
        class="text-center transition-all duration-300 hover:-translate-y-1 hover:border-sage-400/50"
      >
        <span class="text-3xl sm:text-4xl font-extrabold text-mint-100 font-mono tracking-tight block">
          {{ profile?.awards_received || 5 }}
        </span>
        <span class="text-xs text-sage-400 mt-1 uppercase tracking-wider font-semibold block">
          Awards & Certs
        </span>
      </GlassCard>
    </div>
  </section>
</template>

<script setup>
import { computed } from 'vue';
import { useTypingEffect } from '../composables/useTypingEffect';
import BaseButton from './ui/BaseButton.vue';
import GlassCard from './ui/GlassCard.vue';

const props = defineProps({
  profile: {
    type: Object,
    default: () => ({}),
  },
});

const defaultRoles = [
  'Full-Stack Developer',
  'UI/UX Enthusiast',
  'Backend Specialist',
  'Cloud Explorer',
];

const roles = computed(() => {
  return props.profile?.roles && props.profile.roles.length > 0
    ? props.profile.roles
    : defaultRoles;
});

// Use Typing Effect Composable
const { currentText } = useTypingEffect(roles, {
  typeSpeed: 95,
  deleteSpeed: 45,
  delayBetween: 1800,
});

const scrollTo = (selector) => {
  const el = document.querySelector(selector);
  if (el) {
    el.scrollIntoView({ behavior: 'smooth' });
  }
};

const handleCvDownload = () => {
  if (props.profile?.cv_url) {
    const link = document.createElement('a');
    link.href = props.profile.cv_url;
    link.download = 'CV-Muhamad-Ibnhu.pdf';
    link.target = '_blank';
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
  } else {
    scrollTo('#contact');
  }
};
</script>
