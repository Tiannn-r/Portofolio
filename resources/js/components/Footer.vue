<template>
  <footer class="relative z-10 mt-20 pt-16 pb-24 lg:pb-12 border-t border-forest-700/80 bg-forest-950/80 backdrop-blur-xl">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-12">
      <!-- 1. Quick Contact Cards Row (Moved from Contact Section as Requested) -->
      <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <!-- Email Card -->
        <a
          :href="'mailto:' + (profile?.email || 'ibnhu.work@gmail.com')"
          class="flex items-center gap-4 p-4 rounded-2xl bg-forest-900/90 border border-forest-700 hover:border-sage-400/80 hover:bg-forest-800/90 transition-all duration-300 group hover:-translate-y-1 hover:shadow-[0_0_25px_rgba(142,182,155,0.25)] ring-1 ring-transparent hover:ring-sage-400/30"
        >
          <div class="w-11 h-11 rounded-xl bg-forest-800 border border-forest-700 flex items-center justify-center text-sage-400 group-hover:scale-110 group-hover:border-sage-400 transition-all shadow-[0_0_12px_rgba(142,182,155,0.2)]">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
            </svg>
          </div>
          <div class="overflow-hidden">
            <span class="text-[10px] uppercase tracking-wider text-sage-400/80 block font-mono font-bold">Email Langsung</span>
            <span class="text-sm font-semibold text-mint-100 group-hover:text-sage-400 transition-colors truncate block">{{ profile?.email || 'ibnhu.work@gmail.com' }}</span>
          </div>
        </a>

        <!-- Phone / WA Card -->
        <a
          :href="'https://wa.me/' + cleanPhone(profile?.phone || '6281234567890')"
          target="_blank"
          rel="noopener noreferrer"
          class="flex items-center gap-4 p-4 rounded-2xl bg-forest-900/90 border border-forest-700 hover:border-sage-400/80 hover:bg-forest-800/90 transition-all duration-300 group hover:-translate-y-1 hover:shadow-[0_0_25px_rgba(142,182,155,0.25)] ring-1 ring-transparent hover:ring-sage-400/30"
        >
          <div class="w-11 h-11 rounded-xl bg-forest-800 border border-forest-700 flex items-center justify-center text-sage-400 group-hover:scale-110 group-hover:border-sage-400 transition-all shadow-[0_0_12px_rgba(142,182,155,0.2)]">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
            </svg>
          </div>
          <div class="overflow-hidden">
            <span class="text-[10px] uppercase tracking-wider text-sage-400/80 block font-mono font-bold">WhatsApp / Telepon</span>
            <span class="text-sm font-semibold text-mint-100 group-hover:text-sage-400 transition-colors truncate block">{{ profile?.phone || '+62 812-3456-7890' }}</span>
          </div>
        </a>

        <!-- Location Card -->
        <div class="flex items-center gap-4 p-4 rounded-2xl bg-forest-900/90 border border-forest-700">
          <div class="w-11 h-11 rounded-xl bg-forest-800 border border-forest-700 flex items-center justify-center text-sage-400 shadow-[0_0_12px_rgba(142,182,155,0.2)]">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
            </svg>
          </div>
          <div class="overflow-hidden">
            <span class="text-[10px] uppercase tracking-wider text-sage-400/80 block font-mono font-bold">Lokasi Domisili</span>
            <span class="text-sm font-semibold text-mint-100 truncate block">{{ profile?.location || 'Jakarta, Indonesia' }}</span>
          </div>
        </div>
      </div>

      <!-- 2. Main Footer Brand & Links Section -->
      <div class="pt-8 border-t border-forest-700/60 flex flex-col md:flex-row items-center justify-between gap-6">
        <!-- Left: Brand Monogram & Name -->
        <div class="flex items-center gap-3.5">
          <div class="w-10 h-10 rounded-full bg-forest-800 border border-sage-400/40 flex items-center justify-center text-sage-400 font-bold text-sm shadow-[0_0_12px_rgba(142,182,155,0.25)]">
            MI
          </div>
          <div>
            <span class="text-base font-bold text-mint-100 block tracking-tight">
              {{ profile?.name || 'Muhamad Ibnhu' }}
            </span>
            <span class="text-xs text-sage-400/80 block font-mono">
              {{ profile?.title || 'Full-Stack Web Developer & Software Engineer' }}
            </span>
          </div>
        </div>

        <!-- Center: Quick Nav Anchors -->
        <nav class="flex flex-wrap items-center justify-center gap-5 text-xs text-sage-400/80 font-medium">
          <a href="#hero" class="hover:text-mint-100 transition-colors">Beranda</a>
          <a href="#about" class="hover:text-mint-100 transition-colors">Tentang</a>
          <a href="#featured" class="hover:text-mint-100 transition-colors">Cerita & Layanan</a>
          <a href="#portfolio" class="hover:text-mint-100 transition-colors">Portofolio</a>
          <a href="#education" class="hover:text-mint-100 transition-colors">Sertifikasi</a>
          <a href="#contact" class="hover:text-mint-100 transition-colors">Kontak</a>
        </nav>

        <!-- Right: Social & Professional Links -->
        <div class="flex items-center gap-3">
          <a
            v-if="profile?.github_url"
            :href="profile.github_url"
            target="_blank"
            rel="noopener noreferrer"
            title="GitHub Profile"
            class="w-9 h-9 rounded-full bg-forest-900 border border-forest-700 text-sage-400 hover:text-mint-100 hover:border-sage-400 hover:bg-forest-800 flex items-center justify-center transition-all"
          >
            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
              <path fill-rule="evenodd" clip-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.53 1.032 1.53 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z" />
            </svg>
          </a>
          <a
            v-if="profile?.linkedin_url"
            :href="profile.linkedin_url"
            target="_blank"
            rel="noopener noreferrer"
            title="LinkedIn Profile"
            class="w-9 h-9 rounded-full bg-forest-900 border border-forest-700 text-sage-400 hover:text-mint-100 hover:border-sage-400 hover:bg-forest-800 flex items-center justify-center transition-all"
          >
            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
              <path d="M19 3a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h14m-.5 15.5v-5.3a3.26 3.26 0 0 0-3.26-3.26c-.85 0-1.84.52-2.28 1.3v-1.11h-2.79v8.37h2.79v-4.93c0-.77.62-1.4 1.39-1.4a1.4 1.4 0 0 1 1.4 1.4v4.93h2.75M6.88 8.56a1.68 1.68 0 0 0 1.68-1.68c0-.93-.75-1.69-1.68-1.69a1.69 1.69 0 0 0-1.69 1.69c0 .93.76 1.68 1.69 1.68m1.39 9.94v-8.37H5.5v8.37h2.77z" />
            </svg>
          </a>
          <a
            href="/admin/login"
            title="Admin CMS Login"
            class="w-9 h-9 rounded-full bg-forest-900 border border-forest-700 text-sage-400 hover:text-mint-100 hover:border-sage-400 hover:bg-forest-800 flex items-center justify-center transition-all"
          >
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
            </svg>
          </a>
        </div>
      </div>

      <!-- 3. Bottom Copyright Notice -->
      <div class="pt-6 border-t border-forest-800/80 flex flex-col sm:flex-row items-center justify-between text-center sm:text-left gap-2 text-xs text-sage-400/60 font-mono">
        <p>© 2026 {{ profile?.name || 'Muhamad Ibnhu' }}. All rights reserved.</p>
        <p class="text-[11px] text-sage-400/50">Designed & Engineered with Laravel 11, Filament & Vue 3</p>
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
