<template>
  <Teleport to="body">
    <Transition
      enter-active-class="transition duration-200 ease-out"
      enter-from-class="opacity-0"
      enter-to-class="opacity-100"
      leave-active-class="transition duration-150 ease-in"
      leave-from-class="opacity-100"
      leave-to-class="opacity-0"
    >
      <div
        v-if="isVisible"
        class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/80 backdrop-blur-md overflow-y-auto"
        @click.self="handleBackdropClick"
      >
        <Transition
          enter-active-class="transition duration-200 ease-out"
          enter-from-class="opacity-0 scale-95 -translate-y-2"
          enter-to-class="opacity-100 scale-100 translate-y-0"
          leave-active-class="transition duration-150 ease-in"
          leave-from-class="opacity-100 scale-100 translate-y-0"
          leave-to-class="opacity-0 scale-95 -translate-y-2"
        >
          <div
            v-if="isVisible"
            class="relative w-full bg-[#0B2B26] border border-[#8EB69B]/40 rounded-2xl p-6 sm:p-7 shadow-[0_0_40px_rgba(142,182,155,0.25)] max-h-[90vh] overflow-y-auto ring-1 ring-[#8EB69B]/20"
            :class="maxWidthClass"
          >
            <!-- Header Slot -->
            <div class="flex items-center justify-between pb-3.5 mb-5 border-b border-[#235347]">
              <div>
                <slot name="header">
                  <h3 class="text-lg sm:text-xl font-bold text-[#DAF1DE]" v-html="title"></h3>
                  <p v-if="subtitle" class="text-xs text-[#8EB69B] mt-0.5" v-html="subtitle"></p>
                </slot>
              </div>

              <!-- Close Button -->
              <button
                type="button"
                @click="close"
                class="w-8 h-8 rounded-full bg-[#163832] text-[#8EB69B] hover:text-[#DAF1DE] hover:bg-[#235347] flex items-center justify-center transition-colors border border-[#235347]"
              >
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
              </button>
            </div>

            <!-- Body Slot -->
            <div class="text-[#DAF1DE]/90">
              <slot />
            </div>

            <!-- Footer Slot -->
            <div
              v-if="$slots.footer"
              class="mt-6 pt-4 border-t border-[#235347] flex items-center justify-end gap-3"
            >
              <slot name="footer" />
            </div>
          </div>
        </Transition>
      </div>
    </Transition>
  </Teleport>
</template>

<script setup>
import { computed, watch, onMounted, onUnmounted } from 'vue';

const props = defineProps({
  modelValue: {
    type: Boolean,
    default: false,
  },
  show: {
    type: Boolean,
    default: undefined,
  },
  title: {
    type: String,
    default: '',
  },
  subtitle: {
    type: String,
    default: '',
  },
  maxWidth: {
    type: String,
    default: 'md',
    validator: (val) => ['sm', 'md', 'lg', 'xl', '2xl', '3xl', '4xl'].includes(val),
  },
  closeOnBackdrop: {
    type: Boolean,
    default: true,
  },
  closeOnEsc: {
    type: Boolean,
    default: true,
  },
});

const emit = defineEmits(['update:modelValue', 'close']);

const isVisible = computed(() => {
  return props.show !== undefined ? props.show : props.modelValue;
});

const maxWidthClass = computed(() => {
  const map = {
    sm: 'max-w-sm',
    md: 'max-w-md',
    lg: 'max-w-lg',
    xl: 'max-w-xl',
    '2xl': 'max-w-2xl',
    '3xl': 'max-w-3xl',
    '4xl': 'max-w-4xl',
  };
  return map[props.maxWidth] || 'max-w-md';
});

const close = () => {
  emit('update:modelValue', false);
  emit('close');
};

const handleBackdropClick = () => {
  if (props.closeOnBackdrop) {
    close();
  }
};

const handleKeydown = (e) => {
  if (props.closeOnEsc && e.key === 'Escape' && isVisible.value) {
    close();
  }
};

onMounted(() => {
  window.addEventListener('keydown', handleKeydown);
});

onUnmounted(() => {
  window.removeEventListener('keydown', handleKeydown);
});
</script>
