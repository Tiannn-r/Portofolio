<template>
  <div class="py-12 px-4 text-center rounded-2xl bg-[#0B2B26]/60 border border-[#235347] flex flex-col items-center justify-center max-w-lg mx-auto">
    <!-- Icon Container -->
    <div class="w-14 h-14 rounded-2xl bg-[#163832] border border-[#235347] flex items-center justify-center text-[#8EB69B] mb-4 shadow-inner">
      <slot name="icon">
        <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
        </svg>
      </slot>
    </div>

    <!-- Title -->
    <h4 class="text-base font-bold text-[#DAF1DE] mb-1">
      <slot name="title">
        <span v-html="title"></span>
      </slot>
    </h4>

    <!-- Description -->
    <p class="text-xs text-[#8EB69B] max-w-sm leading-relaxed mb-5">
      <slot name="description">
        <span v-html="description"></span>
      </slot>
    </p>

    <!-- Action Button Slot -->
    <div v-if="$slots.action || $slots.default">
      <slot name="action">
        <slot />
      </slot>
    </div>
  </div>
</template>

<script setup>
defineProps({
  title: {
    type: String,
    default: 'Belum ada data',
  },
  description: {
    type: String,
    default: 'Data belum tersedia atau belum ditambahkan.',
  },
});
</script>
