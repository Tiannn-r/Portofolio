<template>
  <div class="fixed inset-0 pointer-events-none overflow-hidden z-0" aria-hidden="true">
    <!-- Deep Gradient Base -->
    <div class="absolute inset-0 bg-gradient-to-b from-forest-950 via-forest-900 to-forest-950"></div>

    <!-- Soft Ambient Atmospheric Lighting -->
    <div class="absolute -top-40 -left-40 w-[42rem] h-[42rem] rounded-full bg-forest-700/25 blur-[150px]"></div>
    <div class="absolute top-1/3 -right-40 w-[36rem] h-[36rem] rounded-full bg-sage-400/10 blur-[160px]"></div>
    <div class="absolute bottom-10 left-1/4 w-[34rem] h-[34rem] rounded-full bg-warm-400/10 blur-[160px]"></div>

    <!-- Organic Topographic Contour Lines Pattern -->
    <div
      class="absolute inset-0 opacity-[0.055] bg-repeat pointer-events-none"
      :style="{
        backgroundImage: `url(&quot;data:image/svg+xml,%3Csvg width='400' height='400' viewBox='0 0 400 400' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath fill='none' stroke='%238EB69B' stroke-width='1.2' stroke-linecap='round' d='M -50 80 C 50 120, 150 40, 250 80 C 350 120, 420 50, 480 90 M -40 140 C 60 190, 140 100, 240 150 C 340 200, 410 120, 490 160 M -60 210 C 40 260, 160 170, 260 220 C 360 270, 430 190, 500 230 M -30 280 C 70 330, 130 240, 230 290 C 330 340, 420 260, 480 300 M -50 350 C 50 390, 150 310, 250 360 C 350 410, 410 330, 490 370 M 120 70 C 170 30, 230 40, 250 80 C 270 120, 210 160, 160 150 C 110 140, 90 90, 120 70 Z M 140 85 C 170 60, 210 65, 225 90 C 240 115, 200 140, 170 135 C 135 130, 120 100, 140 85 Z M 280 260 C 330 220, 390 230, 410 270 C 430 310, 370 350, 320 340 C 270 330, 250 280, 280 260 Z'/%3E%3C/svg%3E&quot;)`,
        backgroundSize: '400px 400px'
      }"
    ></div>
  </div>
</template>
