<template>
  <section :id="id" class="relative py-20 z-10">
    <!-- Standardized Section Heading -->
    <div v-if="hasHeader" class="text-center mb-10 max-w-3xl mx-auto px-4">
      <!-- Badge / Pill Tag Slot -->
      <div v-if="$slots.badge || badge" class="mb-3">
        <slot name="badge">
          <span
            class="inline-block px-3 py-0.5 text-xs font-medium text-sage-400 bg-forest-900/90 border border-forest-700/80 rounded-full"
            v-html="badge"
          ></span>
        </slot>
      </div>

      <!-- Title Slot -->
      <h2 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-mint-100 tracking-tight">
        <slot name="title">
          <span v-html="title"></span>
        </slot>
      </h2>

      <!-- Description Subtitle Slot -->
      <p v-if="$slots.description || description" class="mt-2.5 text-xs sm:text-sm text-sage-400/80 leading-relaxed max-w-xl mx-auto">
        <slot name="description">
          <span v-html="description"></span>
        </slot>
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
  return (
    !!props.badge ||
    !!props.title ||
    !!props.description ||
    !!slots.badge ||
    !!slots.title ||
    !!slots.description
  );
});
</script>
