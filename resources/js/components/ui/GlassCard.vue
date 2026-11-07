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
    <header v-if="$slots.header" class="relative z-10 mb-4 pb-3 border-b border-[#235347]/70">
      <slot name="header" />
    </header>

    <!-- Main Content Slot -->
    <div class="relative z-10 flex-1">
      <slot />
    </div>

    <!-- Footer Slot -->
    <footer v-if="$slots.footer" class="relative z-10 mt-6 pt-4 border-t border-[#235347]/60">
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
    default: 'hover', // 'none', 'hover', 'always'
    validator: (v) => ['none', 'hover', 'always'].includes(v),
  },
  ring: {
    type: Boolean,
    default: true,
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
  },
});

const variantClasses = computed(() => {
  switch (props.variant) {
    case 'secondary':
      return 'bg-[#0B2B26]/90 backdrop-blur-md border border-[#235347]';
    case 'dark':
      return 'bg-[#051F20]/95 backdrop-blur-md border border-[#235347]';
    case 'gradient':
      return 'bg-gradient-to-r from-[#163832] via-[#235347] to-[#8EB69B] text-[#DAF1DE] border border-[#8EB69B]/40';
    case 'primary':
    default:
      return 'bg-[#163832]/60 backdrop-blur-xl border border-[#8EB69B]/25';
  }
});

const glowClasses = computed(() => {
  switch (props.glow) {
    case 'always':
      return 'shadow-[0_0_25px_rgba(142,182,155,0.35)]';
    case 'hover':
      return 'hover:shadow-[0_0_25px_rgba(142,182,155,0.3)] shadow-[0_10px_30px_rgba(5,31,32,0.6)]';
    case 'none':
    default:
      return 'shadow-md';
  }
});

const ringClasses = computed(() => {
  return props.ring ? 'ring-1 ring-[#8EB69B]/20' : '';
});

const interactiveClasses = computed(() => {
  return props.interactive
    ? 'hover:-translate-y-1 hover:border-[#8EB69B] cursor-pointer'
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

