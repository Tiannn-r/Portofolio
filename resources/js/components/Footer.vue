<template>
  <footer class="relative z-10 mt-16 py-10 pb-24 lg:pb-12 border-t border-forest-700/50 text-center">
    <div class="max-w-4xl mx-auto px-4 space-y-4">
      <!-- Contact Info Text Only -->
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

      <!-- Copyright & Identity Text -->
      <div class="text-xs text-sage-400/60 font-sans tracking-wide">
        <p>
          © 2026 {{ profile?.name || 'Muhamad Ibnhu' }}. All rights reserved.
        </p>
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
</script>
