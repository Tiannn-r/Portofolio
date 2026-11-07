<template>
  <section id="hero" class="relative min-h-[90vh] flex flex-col items-center justify-center text-center px-4 pt-20 pb-16 z-10">
    <!-- Availability Badge -->
    <div
      v-if="profile?.is_available"
      class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-forest-900/90 border border-forest-700/80 backdrop-blur-md mb-8 shadow-[0_0_15px_rgba(142,182,155,0.15)] animate-fade-in"
    >
      <span class="relative flex h-2.5 w-2.5">
        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-sage-400 opacity-75"></span>
        <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-sage-400 shadow-[0_0_8px_#8EB69B]"></span>
      </span>
      <span class="text-xs font-semibold tracking-wider uppercase text-mint-100/90">
        Available for Freelance Projects
      </span>
    </div>

    <!-- Center Profile Image with Sage Glow Border -->
    <div class="relative mb-8 group">
      <div class="absolute -inset-1 rounded-full bg-gradient-to-r from-sage-400 via-forest-700 to-sage-400 opacity-80 blur-md group-hover:opacity-100 group-hover:blur-lg transition-all duration-500 shadow-[0_0_25px_rgba(142,182,155,0.4)]"></div>
      <div class="relative w-36 h-36 md:w-44 md:h-44 rounded-full p-1 bg-forest-900 border-2 border-sage-400 shadow-[0_0_20px_rgba(142,182,155,0.35)] overflow-hidden">
        <img
          :src="profile?.avatar_url || 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=600&q=80'"
          :alt="profile?.name || 'Profile Picture'"
          class="w-full h-full object-cover rounded-full transition-transform duration-500 group-hover:scale-105"
        />
      </div>
    </div>

    <!-- Greeting & Name -->
    <h1 class="text-4xl sm:text-5xl md:text-6xl lg:text-7xl font-extrabold tracking-tight text-mint-100 mb-4">
      Hi, I'm <span class="text-sage-400 underline decoration-forest-700 decoration-wavy decoration-2">{{ profile?.name || 'Muhamad Ibnhu' }}</span>
    </h1>

    <!-- Typing Effect Role -->
    <div class="h-10 md:h-12 flex items-center justify-center mb-6">
      <p class="text-xl sm:text-2xl md:text-3xl font-medium text-mint-100/90 font-mono">
        I'm a <span class="text-sage-400 font-semibold">{{ currentTypingText }}</span>
        <span class="animate-pulse text-sage-400 font-bold">|</span>
      </p>
    </div>

    <!-- Short Bio Description -->
    <p class="max-w-2xl text-base sm:text-lg md:text-xl text-sage-400/90 leading-relaxed mb-10 px-4">
      {{ profile?.short_bio || 'Passionate Full-Stack Developer crafting scalable web applications, sleek user experiences, and robust RESTful APIs using Laravel and Vue.js.' }}
    </p>

    <!-- Call to Action Buttons -->
    <div class="flex flex-col sm:flex-row items-center justify-center gap-4 w-full sm:w-auto px-4">
      <!-- "View My Work" Button -->
      <a
        href="#featured"
        @click.prevent="scrollTo('#featured')"
        class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-8 py-3.5 rounded-full bg-forest-700 text-mint-100 font-semibold border-2 border-sage-400 shadow-[0_0_20px_rgba(142,182,155,0.3)] hover:shadow-[0_0_30px_rgba(142,182,155,0.5)] hover:bg-forest-700/80 hover:scale-105 transition-all duration-300"
      >
        <span>View My Work</span>
        <svg class="w-4 h-4 text-sage-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3" />
        </svg>
      </a>

      <!-- "Download CV" Button -->
      <a
        :href="profile?.cv_url || '#contact'"
        :download="profile?.cv_url ? 'CV-Muhamad-Ibnhu.pdf' : null"
        @click="!profile?.cv_url ? scrollTo('#contact') : null"
        class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-8 py-3.5 rounded-full bg-forest-900/60 border border-forest-700 text-mint-100 font-medium hover:border-sage-400 hover:text-sage-400 hover:bg-forest-800/60 transition-all duration-300 shadow-[0_0_10px_rgba(5,31,32,0.5)]"
      >
        <svg class="w-4 h-4 text-sage-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
        </svg>
        <span>Download CV</span>
      </a>
    </div>

    <!-- Quick Stats Bar -->
    <div class="mt-16 grid grid-cols-2 md:grid-cols-4 gap-4 sm:gap-6 w-full max-w-4xl px-4">
      <div class="p-4 rounded-2xl bg-forest-800/40 backdrop-blur-md border border-forest-700/60 flex flex-col items-center">
        <span class="text-3xl font-extrabold text-mint-100 font-mono">{{ profile?.years_experience || 3 }}+</span>
        <span class="text-xs text-sage-400 mt-1 uppercase tracking-wider">Years Experience</span>
      </div>
      <div class="p-4 rounded-2xl bg-forest-800/40 backdrop-blur-md border border-forest-700/60 flex flex-col items-center">
        <span class="text-3xl font-extrabold text-mint-100 font-mono">{{ profile?.projects_completed || 24 }}+</span>
        <span class="text-xs text-sage-400 mt-1 uppercase tracking-wider">Projects Completed</span>
      </div>
      <div class="p-4 rounded-2xl bg-forest-800/40 backdrop-blur-md border border-forest-700/60 flex flex-col items-center">
        <span class="text-3xl font-extrabold text-mint-100 font-mono">{{ profile?.happy_clients || 18 }}+</span>
        <span class="text-xs text-sage-400 mt-1 uppercase tracking-wider">Happy Clients</span>
      </div>
      <div class="p-4 rounded-2xl bg-forest-800/40 backdrop-blur-md border border-forest-700/60 flex flex-col items-center">
        <span class="text-3xl font-extrabold text-mint-100 font-mono">{{ profile?.awards_received || 5 }}</span>
        <span class="text-xs text-sage-400 mt-1 uppercase tracking-wider">Awards & Certs</span>
      </div>
    </div>
  </section>
</template>

<script setup>
import { ref, onMounted, onUnmounted, computed } from 'vue';

const props = defineProps({
  profile: {
    type: Object,
    default: () => ({}),
  },
});

// Roles Typing Effect
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

const currentTypingText = ref('');
let roleIndex = 0;
let charIndex = 0;
let isDeleting = false;
let typingTimeout = null;

const typeEffect = () => {
  const currentRole = roles.value[roleIndex % roles.value.length];

  if (isDeleting) {
    currentTypingText.value = currentRole.substring(0, charIndex - 1);
    charIndex--;
  } else {
    currentTypingText.value = currentRole.substring(0, charIndex + 1);
    charIndex++;
  }

  let delay = isDeleting ? 45 : 95;

  if (!isDeleting && charIndex === currentRole.length) {
    delay = 1800; // Pause when word is completely typed
    isDeleting = true;
  } else if (isDeleting && charIndex === 0) {
    isDeleting = false;
    roleIndex++;
    delay = 400; // Pause before typing next word
  }

  typingTimeout = setTimeout(typeEffect, delay);
};

onMounted(() => {
  typeEffect();
});

onUnmounted(() => {
  if (typingTimeout) clearTimeout(typingTimeout);
});

const scrollTo = (selector) => {
  const el = document.querySelector(selector);
  if (el) {
    el.scrollIntoView({ behavior: 'smooth' });
  }
};
</script>

