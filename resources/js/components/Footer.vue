<template>
  <footer class="relative z-10 w-full mt-16 py-8 pb-24 lg:pb-10 border-t border-forest-700/60 bg-forest-950/90 backdrop-blur-md">
    <div class="max-w-7xl mx-auto lg:pl-28 px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row items-center justify-between gap-5">
      <!-- Left: Copyright & Location Identity -->
      <div class="text-center md:text-left space-y-1">
        <p class="text-xs sm:text-sm text-sage-400 font-sans">
          © 2026 <span class="text-mint-100 font-semibold">{{ profile?.name || 'Muhamad Ibnhu' }}</span>. Hak cipta dilindungi.
        </p>
        <p class="text-[11px] text-sage-400/70 font-mono">
          {{ profile?.location || 'Bandung, Indonesia' }}
        </p>
      </div>

      <!-- Right: Back to Top Button -->
      <button
        @click="scrollToTop"
        type="button"
        class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-forest-900 border border-forest-700 hover:border-warm-400 text-sage-400 hover:text-mint-100 transition-all text-xs font-mono active:scale-95 cursor-pointer"
      >
        <span>Kembali ke Atas</span>
        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18" />
        </svg>
      </button>
    </div>
  </footer>
</template>

<script setup>
const props = defineProps({
  profile: {
    type: Object,
    default: () => null,
  },
});

const scrollToTop = () => {
  window.scrollTo({
    top: 0,
    behavior: 'smooth',
  });
};
</script>
