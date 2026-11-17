<template>
  <div>
    <!-- Fixed Background Canvas Layer (pointer-events-none) -->
    <div class="fixed inset-0 pointer-events-none overflow-hidden z-0" aria-hidden="true">
      <!-- Deep Gradient Base -->
      <div class="absolute inset-0 bg-gradient-to-b from-forest-950 via-forest-900 to-forest-950"></div>

      <!-- Mode: Atmospheric (Enhanced & Bold Presence with Aurora Waves & Luminous Glows) -->
      <div
        v-if="currentMode === 'atmospheric'"
        class="absolute inset-0 transition-opacity duration-700 pointer-events-none"
      >
        <!-- Atmospheric Nebula Glow Orbs (High Presence & Dynamic Contrast) -->
        <!-- 1. Top Spotlight over Hero (Sage & Mint Aurora) -->
        <div class="absolute -top-32 left-1/2 -translate-x-1/2 w-[60rem] h-[36rem] rounded-full bg-gradient-to-b from-[#8EB69B]/30 via-[#235347]/25 to-transparent blur-[110px] animate-pulse" style="animation-duration: 8s;"></div>

        <!-- 2. Left Middle Glow (Deep Emerald Forest) -->
        <div class="absolute top-1/4 -left-32 w-[46rem] h-[46rem] rounded-full bg-[#163832]/65 blur-[130px]"></div>

        <!-- 3. Right Middle Glow (Warm Amber & Sage Horizon) -->
        <div class="absolute top-1/2 -right-24 w-[48rem] h-[48rem] rounded-full bg-gradient-to-l from-[#C9A96E]/20 via-[#8EB69B]/20 to-transparent blur-[140px]"></div>

        <!-- 4. Lower Left Accent (Deep Sage Green) -->
        <div class="absolute bottom-28 left-1/4 w-[42rem] h-[42rem] rounded-full bg-[#235347]/40 blur-[140px]"></div>

        <!-- 5. Bottom Warm Sunset Glow -->
        <div class="absolute -bottom-20 right-1/3 w-[40rem] h-[40rem] rounded-full bg-[#D4AF37]/15 blur-[150px]"></div>

        <!-- Atmospheric Flowing Aurora Waves (Curved Light Flow - Visible & Organic) -->
        <svg
          class="absolute inset-0 w-full h-full opacity-40 mix-blend-screen pointer-events-none"
          preserveAspectRatio="none"
          viewBox="0 0 1440 900"
          xmlns="http://www.w3.org/2000/svg"
        >
          <defs>
            <linearGradient id="auroraGrad1" x1="0%" y1="0%" x2="100%" y2="100%">
              <stop offset="0%" stop-color="#8EB69B" stop-opacity="0.8" />
              <stop offset="45%" stop-color="#235347" stop-opacity="0.4" />
              <stop offset="100%" stop-color="#D4AF37" stop-opacity="0.7" />
            </linearGradient>
            <linearGradient id="auroraGrad2" x1="100%" y1="0%" x2="0%" y2="100%">
              <stop offset="0%" stop-color="#DAF1DE" stop-opacity="0.7" />
              <stop offset="50%" stop-color="#8EB69B" stop-opacity="0.4" />
              <stop offset="100%" stop-color="#163832" stop-opacity="0.2" />
            </linearGradient>
            <linearGradient id="auroraGrad3" x1="0%" y1="50%" x2="100%" y2="50%">
              <stop offset="0%" stop-color="#D4AF37" stop-opacity="0.5" />
              <stop offset="50%" stop-color="#8EB69B" stop-opacity="0.6" />
              <stop offset="100%" stop-color="#235347" stop-opacity="0.3" />
            </linearGradient>
          </defs>

          <!-- Wave Ribbon Set 1: Upper Atmospheric Arc -->
          <path
            d="M -100,180 C 280,30 620,320 1020,160 C 1320,30 1520,220 1620,180"
            fill="none"
            stroke="url(#auroraGrad1)"
            stroke-width="2.5"
            stroke-dasharray="10 8"
            class="opacity-75"
          />
          <path
            d="M -100,220 C 300,70 640,350 1000,200 C 1300,70 1500,260 1620,220"
            fill="none"
            stroke="url(#auroraGrad1)"
            stroke-width="1.5"
            class="opacity-55"
          />

          <!-- Wave Ribbon Set 2: Middle Horizon Arc -->
          <path
            d="M -50,480 C 350,340 750,620 1150,450 C 1380,350 1520,520 1620,480"
            fill="none"
            stroke="url(#auroraGrad3)"
            stroke-width="2"
            stroke-dasharray="14 10"
            class="opacity-65"
          />
          <path
            d="M -50,515 C 370,380 770,650 1130,485 C 1360,390 1500,550 1620,515"
            fill="none"
            stroke="url(#auroraGrad3)"
            stroke-width="1.2"
            class="opacity-45"
          />

          <!-- Wave Ribbon Set 3: Lower Ocean Arc -->
          <path
            d="M -80,720 C 380,590 680,880 1080,710 C 1340,600 1500,770 1620,720"
            fill="none"
            stroke="url(#auroraGrad2)"
            stroke-width="2.2"
            stroke-dasharray="8 6"
            class="opacity-60"
          />
        </svg>

        <!-- Subtle Ambient Stardust Mist Texture -->
        <div
          class="absolute inset-0 opacity-[0.04] mix-blend-screen pointer-events-none"
          :style="{
            backgroundImage: `url(&quot;data:image/svg+xml,%3Csvg viewBox='0 0 250 250' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='atmNoise'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.85' numOctaves='3' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23atmNoise)'/%3E%3C/svg%3E&quot;)`,
          }"
        ></div>
      </div>

      <!-- Mode 1: Analog Film Grain (High-taste Organic Texture) -->
      <div
        v-if="currentMode === 'grain'"
        class="absolute inset-0 opacity-[0.05] mix-blend-screen transition-opacity duration-500 pointer-events-none"
        :style="{
          backgroundImage: `url(&quot;data:image/svg+xml,%3Csvg viewBox='0 0 200 200' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noiseFilter'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.8' numOctaves='3' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noiseFilter)'/%3E%3C/svg%3E&quot;)`,
        }"
      >
        <!-- Ambient Underglow for Grain Mode -->
        <div class="absolute -top-40 -left-40 w-[38rem] h-[38rem] rounded-full bg-forest-700/25 blur-[150px]"></div>
        <div class="absolute top-1/3 -right-40 w-[32rem] h-[32rem] rounded-full bg-sage-400/12 blur-[160px]"></div>
        <div class="absolute bottom-10 left-1/4 w-[30rem] h-[30rem] rounded-full bg-warm-400/12 blur-[160px]"></div>
      </div>

      <!-- Mode 2: Topographic Contour Lines (Bespoke Wavy Contours) -->
      <div
        v-if="currentMode === 'topography'"
        class="absolute inset-0 opacity-[0.05] bg-repeat transition-opacity duration-500 pointer-events-none"
        :style="{
          backgroundImage: `url(&quot;data:image/svg+xml,%3Csvg width='400' height='400' viewBox='0 0 400 400' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath fill='none' stroke='%238EB69B' stroke-width='1.2' stroke-linecap='round' d='M -50 80 C 50 120, 150 40, 250 80 C 350 120, 420 50, 480 90 M -40 140 C 60 190, 140 100, 240 150 C 340 200, 410 120, 490 160 M -60 210 C 40 260, 160 170, 260 220 C 360 270, 430 190, 500 230 M -30 280 C 70 330, 130 240, 230 290 C 330 340, 420 260, 480 300 M -50 350 C 50 390, 150 310, 250 360 C 350 410, 410 330, 490 370 M 120 70 C 170 30, 230 40, 250 80 C 270 120, 210 160, 160 150 C 110 140, 90 90, 120 70 Z M 140 85 C 170 60, 210 65, 225 90 C 240 115, 200 140, 170 135 C 135 130, 120 100, 140 85 Z M 280 260 C 330 220, 390 230, 410 270 C 430 310, 370 350, 320 340 C 270 330, 250 280, 280 260 Z'/%3E%3C/svg%3E&quot;)`,
          backgroundSize: '400px 400px'
        }"
      >
        <div class="absolute -top-40 -left-40 w-[38rem] h-[38rem] rounded-full bg-forest-700/20 blur-[150px]"></div>
        <div class="absolute top-1/3 -right-40 w-[32rem] h-[32rem] rounded-full bg-sage-400/10 blur-[160px]"></div>
      </div>

      <!-- Mode 3: Classic Square Grid (Pembanding Garis Kotak Lama) -->
      <div
        v-if="currentMode === 'grid'"
        class="absolute inset-0 opacity-[0.035] bg-[linear-gradient(to_right,#DAF1DE_1px,transparent_1px),linear-gradient(to_bottom,#DAF1DE_1px,transparent_1px)] bg-[size:4rem_4rem] transition-opacity duration-500 pointer-events-none"
      >
        <div class="absolute -top-40 -left-40 w-[38rem] h-[38rem] rounded-full bg-forest-700/20 blur-[150px]"></div>
        <div class="absolute top-1/3 -right-40 w-[32rem] h-[32rem] rounded-full bg-sage-400/8 blur-[160px]"></div>
      </div>
    </div>

    <!-- Floating Interactive Style Switcher (pointer-events-auto) -->
    <aside
      class="fixed bottom-5 right-5 sm:bottom-6 sm:right-6 z-50 pointer-events-auto select-none"
      aria-label="Pemilih Gaya Background"
    >
      <!-- Collapsed Toggle Button -->
      <button
        v-if="isCollapsed"
        @click="isCollapsed = false"
        type="button"
        class="flex items-center gap-2 px-3.5 py-2 rounded-full bg-forest-900/95 border border-forest-700/80 hover:border-warm-400 text-mint-100 hover:text-white shadow-xl backdrop-blur-md transition-all duration-200 active:scale-95 group cursor-pointer"
        title="Buka Pengalih Gaya Background"
      >
        <span class="text-sm">🎨</span>
        <span class="text-xs font-semibold text-mint-100 group-hover:text-warm-400">Pilih Background</span>
        <span class="w-2 h-2 rounded-full bg-warm-400 animate-pulse"></span>
      </button>

      <!-- Expanded Control Panel -->
      <div
        v-else
        class="p-2.5 rounded-2xl bg-forest-950/95 border border-forest-700/90 shadow-2xl backdrop-blur-xl text-mint-100 animate-fade-in ring-1 ring-white/10 max-w-xs sm:max-w-none"
      >
        <!-- Panel Header -->
        <div class="flex items-center justify-between gap-3 px-1.5 pb-2 mb-1.5 border-b border-forest-700/60">
          <div class="flex items-center gap-1.5 text-xs font-semibold text-mint-100">
            <span>🎨</span>
            <span>Uji Coba Background:</span>
          </div>
          <button
            @click="isCollapsed = true"
            type="button"
            class="text-sage-400 hover:text-mint-100 p-0.5 rounded-md hover:bg-forest-800 transition-colors text-xs cursor-pointer"
            title="Kecilkan panel"
          >
            <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
            </svg>
          </button>
        </div>

        <!-- 4 Option Buttons -->
        <div class="grid grid-cols-2 gap-1.5">
          <button
            v-for="opt in backgroundOptions"
            :key="opt.id"
            @click="selectMode(opt.id)"
            type="button"
            class="flex items-center gap-2 px-3 py-2 rounded-xl text-left transition-all duration-200 cursor-pointer border"
            :class="currentMode === opt.id
              ? 'bg-warm-400 text-forest-950 font-bold border-warm-400 shadow-md scale-[1.02]'
              : 'bg-forest-900/80 text-mint-100/90 border-forest-700/60 hover:bg-forest-800 hover:border-sage-400/50 hover:text-mint-100'"
          >
            <span class="text-sm shrink-0">{{ opt.icon }}</span>
            <div class="min-w-0">
              <span class="block text-xs leading-snug truncate">{{ opt.name }}</span>
              <span
                class="block text-[10px] leading-tight opacity-75 truncate"
                :class="currentMode === opt.id ? 'text-forest-900' : 'text-sage-400'"
              >
                {{ opt.desc }}
              </span>
            </div>
          </button>
        </div>
      </div>
    </aside>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';

const currentMode = ref('atmospheric'); // default: 'atmospheric'
const isCollapsed = ref(false);

const backgroundOptions = [
  {
    id: 'atmospheric',
    name: 'Atmosfer Aurora',
    desc: 'Nebula & Gelombang Cahaya',
    icon: '🌌',
  },
  {
    id: 'grain',
    name: 'Film Grain',
    desc: 'Noise Tekstur Analog',
    icon: '🎞️',
  },
  {
    id: 'topography',
    name: 'Topografi',
    desc: 'Garis Kontur Halus',
    icon: '🗺️',
  },
  {
    id: 'grid',
    name: 'Kotak Grid',
    desc: 'Pola Garis Lama',
    icon: '📐',
  },
];

const selectMode = (mode) => {
  currentMode.value = mode;
  try {
    localStorage.setItem('portfolio_bg_mode', mode);
  } catch (e) {}
};

onMounted(() => {
  try {
    const saved = localStorage.getItem('portfolio_bg_mode');
    if (saved && backgroundOptions.some(o => o.id === saved)) {
      currentMode.value = saved;
    } else {
      currentMode.value = 'atmospheric';
      localStorage.setItem('portfolio_bg_mode', 'atmospheric');
    }
  } catch (e) {}
});
</script>
