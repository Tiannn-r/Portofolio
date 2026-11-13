<template>
  <component
    :is="componentTag"
    :to="to"
    :href="href"
    :type="isButton ? type : null"
    :disabled="disabled || loading"
    class="inline-flex items-center justify-center gap-2 font-semibold tracking-wide rounded-full transition-all duration-200 focus:outline-none select-none disabled:opacity-50 disabled:cursor-not-allowed group"
    :class="[
      variantClasses,
      sizeClasses,
      interactiveClasses,
    ]"
  >
    <!-- Loading Spinner -->
    <svg
      v-if="loading"
      class="animate-spin -ml-1 mr-1.5 h-4 w-4 text-current"
      fill="none"
      viewBox="0 0 24 24"
    >
      <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
      <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
    </svg>

    <!-- Left Icon Slot -->
    <slot name="icon-left" />

    <!-- Button Text -->
    <span><slot /></span>

    <!-- Right Icon Slot -->
    <slot name="icon-right" />
  </component>
</template>

<script setup>
import { computed } from 'vue';

const props = defineProps({
  variant: {
    type: String,
    default: 'primary', // 'primary', 'secondary', 'glass', 'gradient', 'danger'
  },
  size: {
    type: String,
    default: 'md', // 'sm', 'md', 'lg'
  },
  type: {
    type: String,
    default: 'button',
  },
  to: {
    type: [String, Object],
    default: null,
  },
  href: {
    type: String,
    default: null,
  },
  loading: {
    type: Boolean,
    default: false,
  },
  disabled: {
    type: Boolean,
    default: false,
  },
});

const componentTag = computed(() => {
  if (props.to) return 'router-link';
  if (props.href) return 'a';
  return 'button';
});

const isButton = computed(() => !props.to && !props.href);

const variantClasses = computed(() => {
  switch (props.variant) {
    case 'primary':
      return 'bg-[#235347] text-[#DAF1DE] border border-[#8EB69B] hover:border-[#D4A574] hover:bg-[#235347]/90 shadow-sm transition-all duration-200';
    case 'secondary':
      return 'bg-[#0B2B26]/80 border border-[#235347] text-[#DAF1DE] hover:border-[#D4A574] hover:text-[#D4A574] hover:bg-[#163832]/80 transition-all duration-200';
    case 'glass':
      return 'bg-[#163832] border border-[#235347] text-[#8EB69B] hover:border-[#8EB69B] hover:text-[#DAF1DE] transition-all duration-200';
    case 'gradient':
      return 'bg-gradient-to-r from-[#163832] via-[#235347] to-[#8EB69B] text-[#DAF1DE] border border-[#8EB69B]/40 hover:border-[#D4A574] transition-all duration-200';
    case 'danger':
      return 'bg-[#051F20] text-red-400 border border-red-500/40 hover:bg-red-950/80 hover:text-red-300';
    default:
      return 'bg-[#235347] text-[#DAF1DE] border border-[#8EB69B]';
  }
});

const sizeClasses = computed(() => {
  switch (props.size) {
    case 'sm':
      return 'px-4 py-1.5 text-xs';
    case 'lg':
      return 'px-8 py-3.5 text-sm sm:text-base';
    case 'md':
    default:
      return 'px-6 py-2.5 text-xs sm:text-sm';
  }
});

const interactiveClasses = computed(() => {
  return props.disabled || props.loading
    ? ''
    : 'hover:-translate-y-0.5 active:scale-95';
});
</script>

