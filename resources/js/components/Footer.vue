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

      <!-- Center: Social Media App Logos (GitHub, TikTok, YouTube, Instagram, X/Twitter) -->
      <div v-if="socialMediaList.length" class="flex flex-wrap items-center justify-center gap-2.5">
        <a
          v-for="(item, idx) in socialMediaList"
          :key="idx"
          :href="item.url"
          target="_blank"
          rel="noopener noreferrer"
          :title="item.name"
          class="w-9 h-9 rounded-full bg-forest-900 border border-forest-700 hover:border-warm-400 text-sage-400 hover:text-mint-100 hover:bg-forest-800 flex items-center justify-center transition-all duration-200 active:scale-95 overflow-hidden p-2"
        >
          <!-- Custom Uploaded / Linked Logo -->
          <img
            v-if="item.logo_file_url || (item.logo_source === 'url' && item.logo_url)"
            :src="item.logo_file_url || item.logo_url"
            :alt="item.name"
            class="w-full h-full object-contain"
          />

          <!-- Preset GitHub -->
          <svg v-else-if="item.platform.includes('github')" class="w-4 h-4 fill-current" viewBox="0 0 24 24">
            <path fill-rule="evenodd" clip-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.53 1.032 1.53 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z"/>
          </svg>

          <!-- Preset TikTok -->
          <svg v-else-if="item.platform.includes('tiktok')" class="w-4 h-4 fill-current" viewBox="0 0 24 24">
            <path d="M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.59-1.62-.99v9.18c-.01 1.74-.53 3.48-1.57 4.88-1.49 2.04-3.9 3.25-6.42 3.21-2.07-.02-4.08-.85-5.58-2.27-1.74-1.64-2.64-3.98-2.48-6.38.16-2.58 1.57-4.94 3.79-6.24 1.71-1 3.76-1.33 5.72-.94v4.14c-1.11-.32-2.34-.23-3.39.27-.99.47-1.72 1.39-1.95 2.46-.31 1.45.24 3.03 1.41 3.92 1.09.84 2.58.98 3.81.38 1.11-.53 1.79-1.68 1.81-2.92V.02h-2.64z"/>
          </svg>

          <!-- Preset YouTube -->
          <svg v-else-if="item.platform.includes('youtube')" class="w-4 h-4 fill-current" viewBox="0 0 24 24">
            <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
          </svg>

          <!-- Preset Instagram -->
          <svg v-else-if="item.platform.includes('instagram')" class="w-4 h-4 fill-current" viewBox="0 0 24 24">
            <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
          </svg>

          <!-- Preset Twitter / X -->
          <svg v-else-if="item.platform.includes('twitter') || item.platform.includes('x')" class="w-3.5 h-3.5 fill-current" viewBox="0 0 24 24">
            <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/>
          </svg>

          <!-- Default Link Icon -->
          <svg v-else class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />
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
import { computed } from 'vue';

const props = defineProps({
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

const socialMediaList = computed(() => {
  const list = [];

  // 1. If backend has social_channels array (new format)
  if (Array.isArray(props.profile?.social_channels) && props.profile.social_channels.length > 0) {
    const socials = props.profile.social_channels.filter(c => c.category !== 'formal');
    if (socials.length > 0) return socials;
  }

  // 2. Fallback: Parse from social_links (old KeyValue format)
  const links = props.profile?.social_links;
  if (!links) return [];

  const platforms = ['github', 'instagram', 'tiktok', 'youtube', 'twitter', 'x'];

  if (Array.isArray(links)) {
    return links.filter(item => {
      const p = (item.name || item.platform || '').toLowerCase();
      return !['linkedin', 'whatsapp', 'email', 'gmail'].includes(p);
    });
  }

  if (typeof links === 'object') {
    for (const key of platforms) {
      if (links[key]) {
        list.push({
          name: key === 'x' ? 'Twitter / X' : key.charAt(0).toUpperCase() + key.slice(1),
          platform: key,
          url: links[key],
        });
      }
    }
  }

  return list;
});
</script>
