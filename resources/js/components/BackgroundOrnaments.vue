<template>
  <div class="fixed inset-0 pointer-events-none overflow-hidden z-0" aria-hidden="true">
    <!-- Deep Gradient Base -->
    <div class="absolute inset-0 bg-gradient-to-b from-forest-950 via-forest-950 to-forest-900"></div>

    <!-- Soft Ambient Radial Glow Spheres -->
    <div class="absolute -top-32 -left-32 w-96 h-96 rounded-full bg-forest-700/20 blur-[120px] animate-pulse"></div>
    <div class="absolute top-1/3 -right-32 w-[32rem] h-[32rem] rounded-full bg-sage-400/10 blur-[140px] animate-ornament-1"></div>
    <div class="absolute bottom-20 left-10 w-80 h-80 rounded-full bg-forest-800/30 blur-[100px] animate-ornament-2"></div>

    <!-- 3D Geometric Ornaments (Hexagonal & Isometric Wireframes) -->
    <!-- Top Right 3D Cube / Hex Wireframe -->
    <svg class="absolute top-12 right-8 w-72 h-72 text-forest-700/35 animate-ornament-1" viewBox="0 0 200 200" fill="none">
      <polygon points="100,20 170,60 170,140 100,180 30,140 30,60" stroke="currentColor" stroke-width="1.5" stroke-dasharray="4 4" />
      <line x1="100" y1="20" x2="100" y2="100" stroke="currentColor" stroke-width="1.5" />
      <line x1="170" y1="60" x2="100" y2="100" stroke="currentColor" stroke-width="1.5" />
      <line x1="30" y1="60" x2="100" y2="100" stroke="currentColor" stroke-width="1.5" />
      <line x1="100" y1="100" x2="100" y2="180" stroke="currentColor" stroke-width="1.5" />
      <circle cx="100" cy="100" r="3" fill="#8EB69B" fill-opacity="0.6" />
      <circle cx="100" cy="20" r="3" fill="#8EB69B" fill-opacity="0.4" />
      <circle cx="170" cy="60" r="3" fill="#8EB69B" fill-opacity="0.4" />
    </svg>

    <!-- Mid Left 3D Geometric Tetrahedron -->
    <svg class="absolute top-1/2 left-4 w-60 h-60 text-forest-700/30 animate-ornament-2" viewBox="0 0 200 200" fill="none">
      <polygon points="100,25 180,165 20,165" stroke="currentColor" stroke-width="1.5" />
      <line x1="100" y1="25" x2="100" y2="120" stroke="currentColor" stroke-width="1.2" stroke-dasharray="3 3" />
      <line x1="20" y1="165" x2="100" y2="120" stroke="currentColor" stroke-width="1.2" stroke-dasharray="3 3" />
      <line x1="180" y1="165" x2="100" y2="120" stroke="currentColor" stroke-width="1.2" stroke-dasharray="3 3" />
      <circle cx="100" cy="120" r="2.5" fill="#8EB69B" fill-opacity="0.5" />
    </svg>

    <!-- Bottom Right Subtle Matrix Grid -->
    <svg class="absolute bottom-10 right-16 w-80 h-80 text-forest-700/20" viewBox="0 0 100 100" fill="none">
      <defs>
        <pattern id="grid-pattern" width="10" height="10" patternUnits="userSpaceOnUse">
          <circle cx="2" cy="2" r="0.75" fill="currentColor" />
        </pattern>
      </defs>
      <rect width="100" height="100" fill="url(#grid-pattern)" />
    </svg>
  </div>
</template>

