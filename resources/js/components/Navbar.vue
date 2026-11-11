<template>
  <div>
    <!-- Desktop Left Floating Vertical Pill Sidebar -->
    <aside
      class="hidden lg:flex fixed left-6 top-1/2 -translate-y-1/2 z-50 flex-col items-center gap-6 py-6 px-3.5 rounded-full bg-forest-900/85 backdrop-blur-xl border border-forest-700 ring-1 ring-sage-400/20 shadow-[0_10px_35px_rgba(5,31,32,0.8)] transition-all duration-300"
    >
      <!-- Brand Logo / Monogram -->
      <a
        href="#hero"
        @click.prevent="scrollTo('#hero')"
        class="w-10 h-10 rounded-full bg-forest-800 border border-sage-400/30 flex items-center justify-center text-sage-400 font-bold text-sm hover:scale-110 active:scale-95 hover:border-sage-400 transition-all duration-300 shadow-[0_0_12px_rgba(142,182,155,0.2)]"
        title="Home"
      >
        MI
      </a>

      <div class="w-6 h-[1px] bg-forest-700/60 my-1"></div>

      <!-- Navigation Icons with Smooth Sliding Active Indicator -->
      <nav class="relative flex flex-col items-center gap-4">
        <!-- Silky Smooth Sliding Active Capsule & Dot -->
        <div
          class="absolute left-0 top-0 w-11 h-11 rounded-full bg-forest-800 border border-sage-400 ring-1 ring-sage-400/30 shadow-[0_0_18px_rgba(142,182,155,0.45)] pointer-events-none transition-transform duration-500 ease-[cubic-bezier(0.25,1,0.4,1)] z-0 will-change-transform"
          :style="{ transform: `translateY(${desktopIndicatorTop})` }"
        >
          <!-- Active Glow Indicator Dot on the left edge with aura -->
          <span
            class="absolute -left-1 top-1/2 -translate-y-1/2 w-2 h-2 rounded-full bg-sage-400 shadow-[0_0_10px_#8EB69B] animate-pulse"
          ></span>
        </div>

        <a
          v-for="(item, idx) in navItems"
          :key="item.id"
          :ref="el => desktopItemRefs[idx] = el"
          :href="item.href"
          @click.prevent="scrollTo(item.href)"
          :title="item.label"
          class="group relative z-10 flex items-center justify-center w-11 h-11 rounded-full transition-colors duration-300 active:scale-95 cursor-pointer"
          :class="activeSection === item.id ? 'text-mint-100 font-semibold' : 'text-sage-400/70 hover:text-mint-100 hover:bg-forest-800/40'"
        >
          <!-- Icon Component with hover lift -->
          <component :is="item.icon" class="w-5 h-5 transition-transform duration-200 group-hover:scale-110" />

          <!-- Tooltip on hover -->
          <span
            class="absolute left-16 px-3 py-1.5 rounded-lg text-xs font-medium tracking-wide bg-forest-900/95 text-mint-100 border border-forest-700 ring-1 ring-sage-400/25 shadow-xl opacity-0 -translate-x-2 pointer-events-none group-hover:opacity-100 group-hover:translate-x-0 group-hover:pointer-events-auto transition-all duration-200 whitespace-nowrap"
          >
            {{ item.label }}
          </span>
        </a>
      </nav>
    </aside>

    <!-- Mobile Floating Bottom Pill Navigation -->
    <nav
      class="lg:hidden fixed bottom-4 left-1/2 -translate-x-1/2 z-50 flex items-center gap-2 py-2 px-3.5 rounded-full bg-forest-900/95 backdrop-blur-xl border border-forest-700 ring-1 ring-sage-400/25 shadow-[0_10px_30px_rgba(5,31,32,0.9)] max-w-[95vw] overflow-x-auto relative"
    >
      <!-- Sliding Active Indicator on Mobile -->
      <div
        class="absolute top-2 w-10 h-10 rounded-full bg-forest-800 border border-sage-400/50 shadow-[0_0_12px_rgba(142,182,155,0.35)] pointer-events-none transition-transform duration-400 ease-[cubic-bezier(0.25,1,0.4,1)] z-0 will-change-transform"
        :style="{ transform: `translateX(${mobileIndicatorLeft})` }"
      >
        <span
          class="absolute -bottom-1 left-1/2 -translate-x-1/2 w-1.5 h-1.5 rounded-full bg-sage-400 shadow-[0_0_6px_#8EB69B]"
        ></span>
      </div>

      <a
        v-for="(item, idx) in navItems"
        :key="'mobile-' + item.id"
        :ref="el => mobileItemRefs[idx] = el"
        :href="item.href"
        @click.prevent="scrollTo(item.href)"
        class="relative z-10 flex flex-col items-center justify-center w-10 h-10 rounded-full transition-colors duration-200 active:scale-90"
        :class="activeSection === item.id ? 'text-mint-100' : 'text-sage-400/70 hover:text-mint-100'"
      >
        <component :is="item.icon" class="w-5 h-5" />
      </a>
    </nav>
  </div>
</template>

<script setup>
import { h, ref, computed } from 'vue';

const props = defineProps({
  activeSection: {
    type: String,
    default: 'hero',
  },
});

const emit = defineEmits(['section-change']);

const desktopItemRefs = ref([]);
const mobileItemRefs = ref([]);

// SVG Icon Helpers
const IconHome = () => h('svg', { fill: 'none', viewBox: '0 0 24 24', stroke: 'currentColor', 'stroke-width': 1.8 }, [
  h('path', { 'stroke-linecap': 'round', 'stroke-linejoin': 'round', d: 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6' })
]);

const IconAbout = () => h('svg', { fill: 'none', viewBox: '0 0 24 24', stroke: 'currentColor', 'stroke-width': 1.8 }, [
  h('path', { 'stroke-linecap': 'round', 'stroke-linejoin': 'round', d: 'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z' })
]);

// 4-squares grid icon for Featured Showcase / Projects
const IconFeatured = () => h('svg', { fill: 'none', viewBox: '0 0 24 24', stroke: 'currentColor', 'stroke-width': 1.8 }, [
  h('path', { 'stroke-linecap': 'round', 'stroke-linejoin': 'round', d: 'M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z' })
]);

// Code </> icon for Skills & Technical Portfolio
const IconSkills = () => h('svg', { fill: 'none', viewBox: '0 0 24 24', stroke: 'currentColor', 'stroke-width': 1.8 }, [
  h('path', { 'stroke-linecap': 'round', 'stroke-linejoin': 'round', d: 'M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4' })
]);

const IconEducation = () => h('svg', { fill: 'none', viewBox: '0 0 24 24', stroke: 'currentColor', 'stroke-width': 1.8 }, [
  h('path', { 'stroke-linecap': 'round', 'stroke-linejoin': 'round', d: 'M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5' })
]);

const IconContact = () => h('svg', { fill: 'none', viewBox: '0 0 24 24', stroke: 'currentColor', 'stroke-width': 1.8 }, [
  h('path', { 'stroke-linecap': 'round', 'stroke-linejoin': 'round', d: 'M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z' })
]);

const navItems = [
  { id: 'hero', label: 'Home', href: '#hero', icon: IconHome },
  { id: 'about', label: 'About', href: '#about', icon: IconAbout },
  { id: 'featured', label: 'Stories', href: '#featured', icon: IconFeatured },
  { id: 'portfolio', label: 'Portfolio', href: '#portfolio', icon: IconSkills },
  { id: 'education', label: 'Education', href: '#education', icon: IconEducation },
  { id: 'contact', label: 'Contact', href: '#contact', icon: IconContact },
];

const activeIndex = computed(() => {
  const idx = navItems.findIndex(item => item.id === props.activeSection);
  return idx !== -1 ? idx : 0;
});

const desktopIndicatorTop = computed(() => {
  if (desktopItemRefs.value[activeIndex.value]) {
    return `${desktopItemRefs.value[activeIndex.value].offsetTop}px`;
  }
  return `${activeIndex.value * 60}px`;
});

const mobileIndicatorLeft = computed(() => {
  if (mobileItemRefs.value[activeIndex.value]) {
    return `${mobileItemRefs.value[activeIndex.value].offsetLeft}px`;
  }
  return `${activeIndex.value * 48}px`;
});

const scrollTo = (href) => {
  const target = document.querySelector(href);
  if (target) {
    const sectionId = href.replace('#', '');
    emit('section-change', sectionId);

    const targetTop = target.getBoundingClientRect().top + window.scrollY - 30;
    window.scrollTo({
      top: targetTop,
      behavior: 'smooth'
    });
  }
};
</script>
