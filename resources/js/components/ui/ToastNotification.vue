<template>
  <Teleport to="body">
    <div class="fixed top-5 right-5 z-[100] flex flex-col gap-2.5 max-w-sm w-full pointer-events-none">
      <TransitionGroup
        enter-active-class="transition duration-300 ease-out"
        enter-from-class="opacity-0 translate-x-8 scale-95"
        enter-to-class="opacity-100 translate-x-0 scale-100"
        leave-active-class="transition duration-200 ease-in"
        leave-from-class="opacity-100 translate-x-0 scale-100"
        leave-to-class="opacity-0 translate-x-8 scale-95"
      >
        <div
          v-for="toast in toasts"
          :key="toast.id"
          class="pointer-events-auto p-3.5 rounded-xl border backdrop-blur-md shadow-[0_10px_25px_rgba(5,31,32,0.8)] flex items-center justify-between gap-3 text-xs font-semibold"
          :class="getToastClasses(toast.type)"
        >
          <div class="flex items-center gap-2.5">
            <span
              class="w-2.5 h-2.5 rounded-full shrink-0"
              :class="getDotClasses(toast.type)"
            ></span>
            <span class="text-[#DAF1DE]">{{ toast.message }}</span>
          </div>

          <button
            type="button"
            @click="removeToast(toast.id)"
            class="text-[#8EB69B] hover:text-[#DAF1DE] transition-colors"
          >
            ✕
          </button>
        </div>
      </TransitionGroup>
    </div>
  </Teleport>
</template>

<script setup>
import { useToast } from '../../composables/useToast';

const { toasts, removeToast } = useToast();

const getToastClasses = (type) => {
  switch (type) {
    case 'error':
      return 'bg-red-950/90 border-red-500/60 shadow-[0_0_15px_rgba(239,68,68,0.25)]';
    case 'info':
      return 'bg-[#0B2B26]/95 border-[#235347]';
    case 'success':
    default:
      return 'bg-[#0B2B26]/95 border-[#8EB69B] shadow-[0_0_15px_rgba(142,182,155,0.3)]';
  }
};

const getDotClasses = (type) => {
  switch (type) {
    case 'error':
      return 'bg-red-400 shadow-[0_0_8px_#F87171]';
    case 'info':
      return 'bg-blue-400 shadow-[0_0_8px_#60A5FA]';
    case 'success':
    default:
      return 'bg-[#8EB69B] shadow-[0_0_8px_#8EB69B]';
  }
};
</script>

