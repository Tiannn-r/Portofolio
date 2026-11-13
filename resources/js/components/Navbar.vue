<template>
  <div>
    <!-- Desktop Left Floating Vertical Pill Sidebar -->
    <aside
      class="hidden lg:flex fixed left-6 top-1/2 -translate-y-1/2 z-50 flex-col items-center gap-6 py-6 px-3.5 rounded-full bg-forest-900/85 backdrop-blur-xl border border-forest-700 ring-1 ring-sage-400/20 shadow-[0_10px_35px_rgba(5,31,32,0.8)] transition-all duration-300"
    >
      <!-- Brand Logo -->
      <a
        href="#hero"
        @click.prevent="scrollTo('#hero')"
        class="w-10 h-10 rounded-full bg-forest-900 border border-forest-700 p-1.5 flex items-center justify-center hover:border-warm-400 transition-colors duration-200 overflow-hidden group cursor-pointer"
        title="Beranda"
      >
        <img :src="logoUrl" alt="Logo" class="w-full h-full object-contain" />
      </a>

      <div class="w-6 h-[1px] bg-forest-700/60 my-1"></div>

      <!-- Navigation Icons with Smooth Sliding Active Indicator -->
      <nav class="relative flex flex-col items-center gap-4">
        <!-- Sliding Active Capsule -->
        <div
          class="absolute left-0 top-0 w-11 h-11 rounded-full bg-forest-800 border border-forest-700 pointer-events-none transition-transform duration-300 ease-[cubic-bezier(0.25,1,0.4,1)] z-0 will-change-transform"
          :style="desktopIndicatorStyle"
        >
          <!-- Active Indicator Dot on the left edge -->
          <span
            class="absolute -left-1 top-1/2 -translate-y-1/2 w-1.5 h-1.5 rounded-full bg-warm-400"
          ></span>
        </div>

        <a
          v-for="(item, idx) in navItems"
          :key="item.id"
          :ref="el => setDesktopRef(el, idx)"
          :href="item.href"
          @click.prevent="scrollTo(item.href)"
          :title="item.label"
          class="group relative z-10 flex items-center justify-center w-11 h-11 rounded-full transition-colors duration-200 active:scale-95 cursor-pointer"
          :class="activeSection === item.id ? 'text-mint-100 font-semibold' : 'text-sage-400/70 hover:text-mint-100 hover:bg-forest-800/40'"
        >
          <!-- Icon Component -->
          <component :is="item.icon" class="w-5 h-5 transition-colors duration-150" />

          <!-- Tooltip on hover -->
          <span
            class="absolute left-16 px-3 py-1 rounded-lg text-xs font-medium tracking-normal bg-forest-900 text-mint-100 border border-forest-700 shadow-md opacity-0 -translate-x-2 pointer-events-none group-hover:opacity-100 group-hover:translate-x-0 group-hover:pointer-events-auto transition-all duration-150 whitespace-nowrap"
          >
            {{ item.label }}
          </span>
        </a>
      </nav>
    </aside>

    <!-- Mobile Floating Bottom Pill Navigation with Logo & Sliding Indicator -->
    <nav
      class="lg:hidden fixed bottom-4 left-1/2 -translate-x-1/2 z-50 flex items-center gap-2 py-2 px-3 rounded-full bg-forest-900/95 backdrop-blur-xl border border-forest-700 shadow-lg max-w-[95vw] select-none"
    >
      <!-- Brand Logo on Mobile Navbar -->
      <a
        href="#hero"
        @click.prevent="scrollTo('#hero')"
        class="w-9 h-9 rounded-full bg-forest-950 border border-forest-700 p-1 flex items-center justify-center transition-colors duration-150 shrink-0"
        title="Muhamad Ibnhu - Beranda"
      >
        <img :src="logoUrl" alt="Logo" class="w-full h-full object-contain" />
      </a>

      <!-- Divider -->
      <div class="w-[1px] h-5 bg-forest-700/80 shrink-0 mx-0.5"></div>

      <!-- Navigation Icons Container -->
      <div class="relative flex items-center gap-1">
        <!-- Sliding Active Capsule on Mobile -->
        <div
          class="absolute top-0 w-9 h-9 rounded-full bg-forest-800 border border-forest-700 pointer-events-none transition-transform duration-200 ease-[cubic-bezier(0.25,1,0.4,1)] z-0 will-change-transform"
          :style="mobileIndicatorStyle"
        >
          <span
            class="absolute -bottom-1 left-1/2 -translate-x-1/2 w-1.5 h-1.5 rounded-full bg-warm-400"
          ></span>
        </div>

        <a
          v-for="(item, idx) in navItems"
          :key="'mobile-' + item.id"
          :ref="el => setMobileRef(el, idx)"
          :href="item.href"
          @click.prevent="scrollTo(item.href)"
          class="relative z-10 flex items-center justify-center w-9 h-9 rounded-full transition-colors duration-200 active:scale-90 cursor-pointer"
          :class="activeSection === item.id ? 'text-mint-100 font-semibold' : 'text-sage-400/70 hover:text-mint-100'"
          :title="item.label"
        >
          <component :is="item.icon" class="w-4 h-4" />
        </a>
      </div>
    </nav>
  </div>
</template>

<script setup>
import { h, ref, computed, nextTick, onMounted } from 'vue';
import logoUrl from '../../images/logo.png';

const props = defineProps({
  activeSection: {
    type: String,
    default: 'hero',
  },
});

const emit = defineEmits(['section-change']);

const desktopItemRefs = ref([]);
const mobileItemRefs = ref([]);
const layoutRevision = ref(0);

const setDesktopRef = (el, idx) => {
  if (el) desktopItemRefs.value[idx] = el;
};

const setMobileRef = (el, idx) => {
  if (el) mobileItemRefs.value[idx] = el;
};

// SVG Icon Helpers
const IconHome = () => h('svg', { fill: 'none', viewBox: '0 0 24 24', stroke: 'currentColor', 'stroke-width': 1.8 }, [
  h('path', { 'stroke-linecap': 'round', 'stroke-linejoin': 'round', d: 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6' })
]);

const IconAbout = () => h('svg', { fill: 'none', viewBox: '0 0 24 24', stroke: 'currentColor', 'stroke-width': 1.8 }, [
  h('path', { 'stroke-linecap': 'round', 'stroke-linejoin': 'round', d: 'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z' })
]);

const IconFeatured = () => h('svg', { fill: 'none', viewBox: '0 0 24 24', stroke: 'currentColor', 'stroke-width': 1.8 }, [
  h('path', { 'stroke-linecap': 'round', 'stroke-linejoin': 'round', d: 'M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z' })
]);

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
  { id: 'hero', label: 'Beranda', href: '#hero', icon: IconHome },
  { id: 'about', label: 'Tentang', href: '#about', icon: IconAbout },
  { id: 'featured', label: 'Cerita', href: '#featured', icon: IconFeatured },
  { id: 'portfolio', label: 'Portofolio', href: '#portfolio', icon: IconSkills },
  { id: 'education', label: 'Pendidikan', href: '#education', icon: IconEducation },
  { id: 'contact', label: 'Kontak', href: '#contact', icon: IconContact },
];

const activeIndex = computed(() => {
  const idx = navItems.findIndex(item => item.id === props.activeSection);
  return idx !== -1 ? idx : 0;
});

const desktopIndicatorStyle = computed(() => {
  // Access layoutRevision to trigger recalculation on layout events
  const _ = layoutRevision.value;
  const el = desktopItemRefs.value[activeIndex.value];
  if (el) {
    return {
      transform: `translateY(${el.offsetTop}px)`,
    };
  }
  return {
    transform: `translateY(${activeIndex.value * 60}px)`,
  };
});

const mobileIndicatorStyle = computed(() => {
  const _ = layoutRevision.value;
  const el = mobileItemRefs.value[activeIndex.value];
  if (el) {
    return {
      transform: `translateX(${el.offsetLeft}px)`,
    };
  }
  return {
    transform: `translateX(${activeIndex.value * 40}px)`,
  };
});

const scrollTo = (href) => {
  const target = document.querySelector(href);
  if (target) {
    const sectionId = href.replace('#', '');
    emit('section-change', sectionId);

    const targetTop = Math.max(0, target.getBoundingClientRect().top + window.scrollY - 30);
    window.scrollTo({
      top: targetTop,
      behavior: 'smooth'
    });
  }
};

onMounted(() => {
  nextTick(() => {
    layoutRevision.value++;
  });
  window.addEventListener('resize', () => {
    layoutRevision.value++;
  }, { passive: true });
});
</script>
