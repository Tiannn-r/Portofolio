<template>
  <footer class="relative z-10 mt-16 pt-8 pb-24 lg:pb-12 border-t border-forest-700/60">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
      <!-- Direct Contact Info (Clean Text Only) -->
      <div class="flex flex-wrap items-center justify-center gap-x-6 gap-y-2 text-xs sm:text-sm text-sage-400 font-mono">
        <a
          :href="'mailto:' + (profile?.email || 'ibnhu.work@gmail.com')"
          class="hover:text-mint-100 transition-colors underline-offset-4 hover:underline"
        >
          {{ profile?.email || 'ibnhu.work@gmail.com' }}
        </a>
        <span class="hidden sm:inline text-forest-700">•</span>
        <a
          :href="'https://wa.me/' + cleanPhone(profile?.phone || '6281234567890')"
          target="_blank"
          rel="noopener noreferrer"
          class="hover:text-mint-100 transition-colors underline-offset-4 hover:underline"
        >
          {{ profile?.phone || '+62 812-3456-7890' }}
        </a>
        <span class="hidden sm:inline text-forest-700">•</span>
        <span class="text-mint-100/80">
          {{ profile?.location || 'Jakarta, Indonesia' }}
        </span>
      </div>

      <!-- Unified Bottom Row: Copyright, Social Text Links, and Back to Top -->
      <div class="pt-5 border-t border-forest-700/40 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs text-sage-400/80">
        <div>
          <p>© 2026 <span class="text-mint-100 font-semibold">{{ profile?.name || 'Muhamad Ibnhu' }}</span>. All rights reserved.</p>
          <p class="text-[11px] text-sage-400/60 mt-0.5 font-mono">Built with Laravel 11, Vue 3, & Tailwind CSS</p>
        </div>

        <!-- Social Links (Text Only) -->
        <div class="flex flex-wrap items-center gap-4 text-xs">
          <a
            v-if="profile?.social_links?.linkedin"
            :href="profile.social_links.linkedin"
            target="_blank"
            rel="noopener noreferrer"
            class="hover:text-mint-100 transition-colors"
          >
            LinkedIn
          </a>
          <a
            v-if="profile?.social_links?.twitter"
            :href="profile.social_links.twitter"
            target="_blank"
            rel="noopener noreferrer"
            class="hover:text-mint-100 transition-colors"
          >
            Twitter / X
          </a>
          <a
            v-if="profile?.social_links?.instagram"
            :href="profile.social_links.instagram"
            target="_blank"
            rel="noopener noreferrer"
            class="hover:text-mint-100 transition-colors"
          >
            Instagram
          </a>
        </div>

        <!-- Back to Top Button -->
        <button
          @click="scrollToTop"
          type="button"
          class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-forest-900 border border-forest-700 hover:border-sage-400 text-sage-400 hover:text-mint-100 transition-all text-xs font-mono active:scale-95 shadow-[0_0_10px_rgba(5,31,32,0.5)] cursor-pointer"
        >
          <span>Back to Top</span>
          <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18" />
          </svg>
        </button>
      </div>
    </div>
  </footer>
</template>

<script setup>
defineProps({
  profile: {
    type: Object,
    default: () => null,
  },
});

const cleanPhone = (phone) => {
  return String(phone).replace(/[^0-9]/g, '');
};

const scrollToTop = () => {
  window.scrollTo({
    top: 0,
    behavior: 'smooth',
  });
};
</script>
