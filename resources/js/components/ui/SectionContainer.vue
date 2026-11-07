<template>
  <section :id="id" class="relative py-20 z-10">
    <!-- Standardized Section Heading -->
    <div v-if="hasHeader" class="text-center mb-12 max-w-3xl mx-auto px-4">
      <!-- Badge / Pill Tag Slot -->
      <div v-if="$slots.badge || badge" class="mb-3">
        <slot name="badge">
          <span class="inline-block px-3 py-1 text-xs font-semibold tracking-widest text-[#8EB69B] uppercase bg-[#0B2B26] border border-[#235347] rounded-full shadow-[0_0_10px_rgba(142,182,155,0.15)]">
            {{ badge }}
          </span>
        </slot>
      </div>

      <!-- Title Slot -->
      <h2 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-[#DAF1DE] tracking-tight">
        <slot name="title">{{ title }}</slot>
      </h2>

      <!-- Description Subtitle Slot -->
      <p v-if="$slots.description || description" class="mt-3.5 text-sm sm:text-base text-[#8EB69B]/90 leading-relaxed">
        <slot name="description">{{ description }}</slot>
      </p>
    </div>

    <!-- Main Section Content -->
    <div class="relative">
      <slot />
    </div>
  </section>
</template>

<script setup>
import { computed, useSlots } from 'vue';

const props = defineProps({
  id: {
    type: String,
    required: true,
  },
  badge: {
    type: String,
    default: '',
  },
  title: {
    type: String,
    default: '',
  },
  description: {
    type: String,
    default: '',
  },
});

const slots = useSlots();

const hasHeader = computed(() => {
  return props.title || props.badge || props.description || slots.title || slots.badge || slots.description;
});
</script>
