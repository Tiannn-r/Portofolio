<template>
  <footer class="relative z-10 w-full mt-16 py-8 pb-24 lg:pb-10 border-t border-forest-700/60 bg-forest-950/90 backdrop-blur-md">
    <div class="max-w-7xl mx-auto lg:pl-28 px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row items-center justify-between gap-5">
      <!-- Left: Copyright & Location Identity -->
      <div class="text-center md:text-left space-y-1">
        <p class="text-xs sm:text-sm text-sage-400 font-sans">
          © 2026 <span class="text-mint-100 font-semibold">{{ profile?.name || 'Muhamad Ibnhu' }}</span>. Hak cipta dilindungi.
        </p>
        <p class="text-[11px] text-sage-400/70 font-mono">
          {{ profile?.location || 'Jakarta, Indonesia' }}
        </p>
      </div>

      <!-- Center: Social / Contact App Logos -->
      <div class="flex flex-wrap items-center justify-center gap-2.5">
        <!-- GitHub -->
        <a
          v-if="profile?.social_links?.github"
          :href="profile.social_links.github"
          target="_blank"
          rel="noopener noreferrer"
          title="GitHub"
          class="w-9 h-9 rounded-full bg-forest-900 border border-forest-700 hover:border-warm-400 text-sage-400 hover:text-mint-100 hover:bg-forest-800 flex items-center justify-center transition-all duration-200 active:scale-95"
        >
          <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24">
            <path fill-rule="evenodd" clip-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.53 1.032 1.53 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z"/>
          </svg>
        </a>

        <!-- LinkedIn -->
        <a
          v-if="profile?.social_links?.linkedin"
          :href="profile.social_links.linkedin"
          target="_blank"
          rel="noopener noreferrer"
          title="LinkedIn"
          class="w-9 h-9 rounded-full bg-forest-900 border border-forest-700 hover:border-warm-400 text-sage-400 hover:text-mint-100 hover:bg-forest-800 flex items-center justify-center transition-all duration-200 active:scale-95"
        >
          <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24">
            <path d="M19 3a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h14m-.5 15.5v-5.3a3.26 3.26 0 0 0-3.26-3.26c-.85 0-1.84.52-2.28 1.3v-1.11h-2.79v8.37h2.79v-4.93c0-.77.62-1.4 1.39-1.4a1.4 1.4 0 0 1 1.4 1.4v4.93h2.75M6.88 8.56a1.68 1.68 0 0 0 1.68-1.68c0-.93-.75-1.69-1.68-1.69a1.69 1.69 0 0 0-1.69 1.69c0 .93.76 1.68 1.69 1.68m1.39 9.94v-8.37H5.5v8.37h2.77z"/>
          </svg>
        </a>

        <!-- Twitter / X -->
        <a
          v-if="profile?.social_links?.twitter || profile?.social_links?.x"
          :href="profile?.social_links?.twitter || profile?.social_links?.x"
          target="_blank"
          rel="noopener noreferrer"
          title="Twitter / X"
          class="w-9 h-9 rounded-full bg-forest-900 border border-forest-700 hover:border-warm-400 text-sage-400 hover:text-mint-100 hover:bg-forest-800 flex items-center justify-center transition-all duration-200 active:scale-95"
        >
          <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 24 24">
            <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/>
          </svg>
        </a>

        <!-- Instagram -->
        <a
          v-if="profile?.social_links?.instagram"
          :href="profile.social_links.instagram"
          target="_blank"
          rel="noopener noreferrer"
          title="Instagram"
          class="w-9 h-9 rounded-full bg-forest-900 border border-forest-700 hover:border-warm-400 text-sage-400 hover:text-mint-100 hover:bg-forest-800 flex items-center justify-center transition-all duration-200 active:scale-95"
        >
          <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24">
            <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
          </svg>
        </a>

        <!-- TikTok -->
        <a
          v-if="profile?.social_links?.tiktok"
          :href="profile.social_links.tiktok"
          target="_blank"
          rel="noopener noreferrer"
          title="TikTok"
          class="w-9 h-9 rounded-full bg-forest-900 border border-forest-700 hover:border-warm-400 text-sage-400 hover:text-mint-100 hover:bg-forest-800 flex items-center justify-center transition-all duration-200 active:scale-95"
        >
          <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24">
            <path d="M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.59-1.62-.99v9.18c-.01 1.74-.53 3.48-1.57 4.88-1.49 2.04-3.9 3.25-6.42 3.21-2.07-.02-4.08-.85-5.58-2.27-1.74-1.64-2.64-3.98-2.48-6.38.16-2.58 1.57-4.94 3.79-6.24 1.71-1 3.76-1.33 5.72-.94v4.14c-1.11-.32-2.34-.23-3.39.27-.99.47-1.72 1.39-1.95 2.46-.31 1.45.24 3.03 1.41 3.92 1.09.84 2.58.98 3.81.38 1.11-.53 1.79-1.68 1.81-2.92V.02h-2.64z"/>
          </svg>
        </a>

        <!-- WhatsApp (only if phone is provided) -->
        <a
          v-if="profile?.phone || profile?.social_links?.whatsapp"
          :href="'https://wa.me/' + cleanPhone(profile?.social_links?.whatsapp || profile?.phone)"
          target="_blank"
          rel="noopener noreferrer"
          title="WhatsApp"
          class="w-9 h-9 rounded-full bg-forest-900 border border-forest-700 hover:border-warm-400 text-sage-400 hover:text-mint-100 hover:bg-forest-800 flex items-center justify-center transition-all duration-200 active:scale-95"
        >
          <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24">
            <path d="M12.04 2c-5.46 0-9.91 4.45-9.91 9.91 0 1.75.46 3.45 1.32 4.95L2.05 22l5.25-1.38c1.45.79 3.08 1.21 4.74 1.21 5.46 0 9.91-4.45 9.91-9.91 0-2.65-1.03-5.14-2.9-7.01A9.82 9.82 0 0012.04 2zm5.78 14.07c-.24.68-1.4 1.27-1.93 1.32-.49.05-1.13.07-1.83-.16-.43-.14-.99-.33-1.7-.64-3-1.3-4.96-4.32-5.11-4.52-.15-.2-1.22-1.63-1.22-3.1 0-1.48.77-2.2 1.04-2.5.28-.3.6-.37.8-.37.2 0 .4 0 .58.01.19.01.44-.07.69.52.25.6.86 2.1.94 2.25.07.16.12.35.02.55-.1.2-.15.33-.3.51-.15.18-.32.4-.46.54-.15.15-.31.32-.13.63.18.31.8 1.32 1.72 2.14 1.18 1.05 2.17 1.38 2.48 1.53.31.15.49.13.67-.08.19-.21.79-.92 1-.1.23.21.37.13.62.24.25.11 1.58.74 1.85.88.27.14.45.2.52.32.07.11.07.66-.17 1.34z"/>
          </svg>
        </a>

        <!-- Gmail / Email -->
        <a
          v-if="profile?.email || profile?.social_links?.email"
          :href="'mailto:' + (profile?.social_links?.email || profile?.email)"
          title="Email"
          class="w-9 h-9 rounded-full bg-forest-900 border border-forest-700 hover:border-warm-400 text-sage-400 hover:text-mint-100 hover:bg-forest-800 flex items-center justify-center transition-all duration-200 active:scale-95"
        >
          <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24">
            <path d="M24 5.457v13.909c0 .904-.732 1.636-1.636 1.636h-3.819V11.73L12 16.64l-6.545-4.91v9.273H1.636A1.636 1.636 0 0 1 0 19.366V5.457c0-2.023 2.309-3.178 3.927-1.964L5.455 4.64 12 9.548l6.545-4.91 1.528-1.145C21.69 2.28 24 3.434 24 5.457z"/>
          </svg>
        </a>
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
defineProps({
  profile: {
    type: Object,
    default: () => null,
  },
});

const cleanPhone = (phone) => {
  return String(phone || '').replace(/[^0-9]/g, '');
};

const scrollToTop = () => {
  window.scrollTo({
    top: 0,
    behavior: 'smooth',
  });
};
</script>
