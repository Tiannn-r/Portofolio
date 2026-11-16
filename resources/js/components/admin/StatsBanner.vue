<template>
  <div class="rounded-2xl p-6 sm:p-7 bg-gradient-to-r from-[#163832] via-[#235347] to-[#8EB69B] shadow-[0_10px_35px_rgba(22,56,50,0.5)] border border-[#8EB69B]/40 ring-1 ring-[#8EB69B]/25 relative overflow-hidden group">
    <!-- Ornaments inside banner -->
    <div class="absolute -right-10 -bottom-10 w-44 h-44 rounded-full bg-white/10 blur-2xl pointer-events-none"></div>

    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-5 border-b border-[#DAF1DE]/20 pb-3">
      <div class="flex items-center gap-2">
        <span class="w-2.5 h-2.5 rounded-full bg-[#DAF1DE] shadow-[0_0_8px_#DAF1DE] animate-pulse"></span>
        <h3 class="text-sm font-bold uppercase tracking-wider text-[#DAF1DE]">
          Statistik Utama Portofolio (Live Metrics)
        </h3>
      </div>
      <button
        type="button"
        @click="isEditing = !isEditing"
        class="self-start sm:self-auto px-3.5 py-1.5 rounded-full bg-[#051F20]/50 hover:bg-[#051F20] text-[#DAF1DE] text-xs font-semibold border border-[#DAF1DE]/30 transition-all flex items-center gap-1.5 active:scale-95"
      >
        <svg class="w-3.5 h-3.5 text-[#DAF1DE]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
        </svg>
        <span>{{ isEditing ? 'Batal Edit' : 'Ubah Angka Statistik' }}</span>
      </button>
    </div>

    <!-- 2 Real Metrics Display Mode (Years Experience & Projects Completed) -->
    <div v-if="!isEditing" class="grid grid-cols-1 sm:grid-cols-2 gap-5 text-center">
      <!-- Metric 1: Years Experience -->
      <div class="p-4 rounded-xl bg-[#051F20]/30 backdrop-blur-sm border border-white/10 flex flex-col items-center transition-all duration-300 hover:-translate-y-0.5 hover:bg-[#051F20]/45">
        <div class="w-10 h-10 rounded-xl bg-white/10 flex items-center justify-center text-[#DAF1DE] mb-2 shadow-inner">
          <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
          </svg>
        </div>
        <span class="text-2xl sm:text-3xl font-extrabold text-[#DAF1DE] font-mono tracking-tight">
          {{ profile?.years_experience || '2.5' }}+
        </span>
        <span class="text-xs text-[#DAF1DE]/90 font-medium mt-1">Years Experience (Tahun Pengalaman)</span>
      </div>

      <!-- Metric 2: Projects Completed (Auto-Count) -->
      <div class="p-4 rounded-xl bg-[#051F20]/30 backdrop-blur-sm border border-white/10 flex flex-col items-center transition-all duration-300 hover:-translate-y-0.5 hover:bg-[#051F20]/45">
        <div class="w-10 h-10 rounded-xl bg-white/10 flex items-center justify-center text-[#DAF1DE] mb-2 shadow-inner">
          <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138z" />
          </svg>
        </div>
        <span class="text-2xl sm:text-3xl font-extrabold text-[#DAF1DE] font-mono tracking-tight">
          {{ profile?.projects_completed ?? 3 }}+
        </span>
        <span class="text-xs text-[#DAF1DE]/90 font-medium mt-1">Projects Completed (Otomatis dari Database)</span>
      </div>
    </div>

    <!-- Edit Mode Form -->
    <form v-else @submit.prevent="saveStats" class="grid grid-cols-1 sm:grid-cols-2 gap-4">
      <div>
        <label class="block text-xs font-bold text-[#DAF1DE] mb-1">Years Experience</label>
        <div class="flex items-center gap-2">
          <input
            v-model="form.years_experience"
            type="text"
            placeholder="Contoh: 2.5 atau 3"
            required
            class="w-full bg-[#051F20]/80 border border-white/20 text-[#DAF1DE] rounded-xl px-3 py-2 text-sm font-mono outline-none focus:border-[#DAF1DE]"
          />
          <BaseButton
            type="submit"
            variant="primary"
            size="sm"
            :loading="saving"
            class="shrink-0"
          >
            <span>Simpan</span>
          </BaseButton>
        </div>
      </div>

      <div>
        <label class="block text-xs font-bold text-[#DAF1DE] mb-1">Projects Completed (Auto-Count)</label>
        <input
          :value="`${profile?.projects_completed ?? 3} Proyek (Dihitung Otomatis)`"
          type="text"
          disabled
          class="w-full bg-[#051F20]/40 border border-white/10 text-[#DAF1DE]/60 rounded-xl px-3 py-2 text-sm font-mono cursor-not-allowed"
        />
      </div>
    </form>
  </div>
</template>

<script setup>
import { ref, watch } from 'vue';
import BaseButton from '../ui/BaseButton.vue';

const props = defineProps({
  profile: {
    type: Object,
    default: () => ({}),
  },
});

const emit = defineEmits(['save-metrics']);

const isEditing = ref(false);
const saving = ref(false);

const form = ref({
  years_experience: '2.5',
});

watch(
  () => props.profile,
  (newVal) => {
    if (newVal) {
      form.value = {
        years_experience: newVal.years_experience ?? '2.5',
      };
    }
  },
  { immediate: true }
);

const saveStats = () => {
  saving.value = true;
  emit('save-metrics', { ...form.value }, () => {
    saving.value = false;
    isEditing.value = false;
  });
};
</script>
