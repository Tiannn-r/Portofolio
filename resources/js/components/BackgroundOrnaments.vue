<template>
  <div>
    <!-- Fixed Background Canvas Layer (pointer-events-none) -->
    <div class="fixed inset-0 pointer-events-none overflow-hidden z-0" aria-hidden="true">
      <!-- Deep Gradient Base -->
      <div class="absolute inset-0 bg-gradient-to-b from-forest-950 via-forest-900 to-forest-950"></div>

      <!-- Soft Ambient Lighting Layer -->
      <div class="absolute -top-40 -left-40 w-[38rem] h-[38rem] rounded-full bg-forest-700/20 blur-[150px] transition-all duration-700"></div>
      <div class="absolute top-1/3 -right-40 w-[32rem] h-[32rem] rounded-full bg-sage-400/8 blur-[160px] transition-all duration-700"></div>
      <div class="absolute bottom-10 left-1/4 w-[30rem] h-[30rem] rounded-full bg-warm-400/8 blur-[160px] transition-all duration-700"></div>

      <!-- Extra Atmospheric Aurora Layer (Active in 'atmospheric' mode) -->
      <div
        v-if="currentMode === 'atmospheric'"
        class="absolute inset-0 transition-opacity duration-700"
      >
        <div class="absolute top-1/4 left-1/3 w-[45rem] h-[45rem] rounded-full bg-emerald-500/5 blur-[180px]"></div>
        <div class="absolute bottom-1/3 right-1/4 w-[35rem] h-[35rem] rounded-full bg-forest-600/15 blur-[170px]"></div>
      </div>

      <!-- Mode 1: Analog Film Grain (High-taste Organic Texture) -->
      <div
        v-if="currentMode === 'grain'"
        class="absolute inset-0 opacity-[0.045] mix-blend-screen transition-opacity duration-500 pointer-events-none"
        :style="{
          backgroundImage: `url(&quot;data:image/svg+xml,%3Csvg viewBox='0 0 200 200' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noiseFilter'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.8' numOctaves='3' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noiseFilter)'/%3E%3C/svg%3E&quot;)`,
        }"
      ></div>

      <!-- Mode 2: Topographic Contour Lines (Bespoke Wavy Contours) -->
      <div
        v-if="currentMode === 'topography'"
        class="absolute inset-0 opacity-[0.04] bg-repeat transition-opacity duration-500 pointer-events-none"
        :style="{
          backgroundImage: `url(&quot;data:image/svg+xml,%3Csvg width='400' height='400' viewBox='0 0 400 400' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath fill='none' stroke='%238EB69B' stroke-width='1.2' stroke-linecap='round' d='M -50 80 C 50 120, 150 40, 250 80 C 350 120, 420 50, 480 90 M -40 140 C 60 190, 140 100, 240 150 C 340 200, 410 120, 490 160 M -60 210 C 40 260, 160 170, 260 220 C 360 270, 430 190, 500 230 M -30 280 C 70 330, 130 240, 230 290 C 330 340, 420 260, 480 300 M -50 350 C 50 390, 150 310, 250 360 C 350 410, 410 330, 490 370 M 120 70 C 170 30, 230 40, 250 80 C 270 120, 210 160, 160 150 C 110 140, 90 90, 120 70 Z M 140 85 C 170 60, 210 65, 225 90 C 240 115, 200 140, 170 135 C 135 130, 120 100, 140 85 Z M 280 260 C 330 220, 390 230, 410 270 C 430 310, 370 350, 320 340 C 270 330, 250 280, 280 260 Z'/%3E%3C/svg%3E&quot;)`,
          backgroundSize: '400px 400px'
        }"
      ></div>

      <!-- Mode 3: Classic Square Grid (Pembanding Garis Kotak Lama) -->
      <div
        v-if="currentMode === 'grid'"
        class="absolute inset-0 opacity-[0.035] bg-[linear-gradient(to_right,#DAF1DE_1px,transparent_1px),linear-gradient(to_bottom,#DAF1DE_1px,transparent_1px)] bg-[size:4rem_4rem] transition-opacity duration-500 pointer-events-none"
      ></div>
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

const currentMode = ref('grain'); // default: 'grain'
const isCollapsed = ref(false);

const backgroundOptions = [
  {
    id: 'grain',
    name: 'Film Grain',
    desc: 'Noise Tekstur Analog',
    icon: '🎞️',
  },
  {
    id: 'atmospheric',
    name: 'Atmosfer',
    desc: 'Zero Pattern Murni',
    icon: '🌌',
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
    }
  } catch (e) {}
});
</script>
