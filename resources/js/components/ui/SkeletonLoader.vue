<template>
  <div class="animate-pulse space-y-4">
    <!-- Card Skeleton -->
    <div
      v-if="type === 'card'"
      class="bg-[#163832]/50 border border-[#235347]/80 rounded-2xl p-6 space-y-3"
    >
      <div class="h-5 bg-[#235347]/60 rounded-md w-1/3"></div>
      <div class="h-4 bg-[#235347]/40 rounded-md w-full"></div>
      <div class="h-4 bg-[#235347]/40 rounded-md w-3/4"></div>
      <div class="pt-4 flex gap-2">
        <div class="h-6 w-16 bg-[#235347]/50 rounded-md"></div>
        <div class="h-6 w-16 bg-[#235347]/50 rounded-md"></div>
      </div>
    </div>

    <!-- Text line -->
    <div
      v-else-if="type === 'text'"
      class="h-4 bg-[#235347]/50 rounded-md"
      :style="{ width: width || '100%' }"
    ></div>

    <!-- Avatar circle -->
    <div
      v-else-if="type === 'avatar'"
      class="rounded-full bg-[#235347]/60"
      :class="sizeClasses"
    ></div>

    <!-- Grid of cards -->
    <div
      v-else-if="type === 'grid'"
      class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6"
    >
      <div
        v-for="i in count"
        :key="i"
        class="bg-[#163832]/40 border border-[#235347]/70 rounded-2xl p-5 space-y-3"
      >
        <div class="h-36 bg-[#235347]/50 rounded-xl w-full"></div>
        <div class="h-4 bg-[#235347]/60 rounded-md w-2/3"></div>
        <div class="h-3 bg-[#235347]/40 rounded-md w-full"></div>
        <div class="flex gap-1.5 pt-2">
          <div class="h-5 w-12 bg-[#235347]/50 rounded"></div>
          <div class="h-5 w-12 bg-[#235347]/50 rounded"></div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { computed } from 'vue';

const props = defineProps({
  type: {
    type: String,
    default: 'card', // 'card', 'text', 'avatar', 'grid'
  },
  width: {
    type: String,
    default: null,
  },
  count: {
    type: Number,
    default: 3,
  },
  size: {
    type: String,
    default: 'md', // 'sm', 'md', 'lg'
  },
});

const sizeClasses = computed(() => {
  switch (props.size) {
    case 'sm':
      return 'w-10 h-10';
    case 'lg':
      return 'w-36 h-36';
    case 'md':
    default:
      return 'w-20 h-20';
  }
});
</script>

