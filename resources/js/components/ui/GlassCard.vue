<template>
  <div
    class="relative rounded-2xl transition-all duration-300 overflow-hidden"
    :class="[
      variantClasses,
      glowClasses,
      ringClasses,
      interactiveClasses,
      paddingClasses,
    ]"
  >
    <!-- Optional Inner Ambient Radial Light -->
    <div
      v-if="ambient"
      class="absolute -top-16 -right-16 w-48 h-48 bg-[#8EB69B]/10 rounded-full blur-3xl pointer-events-none"
    ></div>

    <!-- Header Slot -->
    <header v-if="$slots.header" class="relative z-10 mb-4 pb-3 border-b border-forest-700/60">
      <slot name="header" />
    </header>

    <!-- Main Content Slot -->
    <div class="relative z-10 flex-1">
      <slot />
    </div>

    <!-- Footer Slot -->
    <footer v-if="$slots.footer" class="relative z-10 mt-6 pt-4 border-t border-forest-700/60">
      <slot name="footer" />
    </footer>
  </div>
</template>

<script setup>
import { computed } from 'vue';

const props = defineProps({
  variant: {
    type: String,
    default: 'primary', // 'primary', 'secondary', 'dark', 'gradient'
    validator: (v) => ['primary', 'secondary', 'dark', 'gradient'].includes(v),
  },
  glow: {
    type: String,
    default: 'none', // 'none', 'hover', 'always'
    validator: (v) => ['none', 'hover', 'always'].includes(v),
  },
  ring: {
    type: Boolean,
    default: false,
  },
  interactive: {
    type: Boolean,
    default: false,
  },
  ambient: {
    type: Boolean,
    default: false,
  },
  padding: {
    type: String,
    default: 'normal', // 'none', 'sm', 'normal', 'lg'
    validator: (v) => ['none', 'sm', 'normal', 'lg'].includes(v),
  },
});

const variantClasses = computed(() => {
  switch (props.variant) {
    case 'secondary':
      return 'bg-forest-900/90 backdrop-blur-md border border-forest-700';
    case 'dark':
      return 'bg-forest-950/95 backdrop-blur-md border border-forest-700';
    case 'gradient':
      return 'bg-gradient-to-r from-forest-900 via-forest-800 to-forest-700 text-mint-100 border border-sage-400/30';
    case 'primary':
    default:
      return 'bg-forest-900/85 backdrop-blur-xl border border-forest-700';
  }
});

const glowClasses = computed(() => {
  switch (props.glow) {
    case 'always':
      return 'shadow-md border-sage-400/50';
    case 'hover':
      return 'hover:border-sage-400/80 shadow-sm';
    case 'none':
    default:
      return 'shadow-sm';
  }
});

const ringClasses = computed(() => {
  return props.ring ? 'ring-1 ring-[#8EB69B]/20' : '';
});

const interactiveClasses = computed(() => {
  return props.interactive
    ? 'hover:-translate-y-0.5 hover:border-sage-400 transition-all duration-200 cursor-pointer'
    : '';
});

const paddingClasses = computed(() => {
  switch (props.padding) {
    case 'none':
      return '';
    case 'sm':
      return 'p-3 sm:p-4';
    case 'lg':
      return 'p-6 sm:p-10';
    case 'normal':
    default:
      return 'p-5 sm:p-7';
  }
});
</script>

