<template>
  <div
    v-if="isOpen"
    class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/80 backdrop-blur-sm animate-fade-in"
    @click.self="$emit('close')"
  >
    <div class="w-full max-w-md bg-[#0B2B26] border border-[#8EB69B]/40 rounded-2xl p-6 shadow-[0_0_40px_rgba(142,182,155,0.3)]">
      <div class="flex items-center justify-between pb-3 mb-4 border-b border-[#235347]">
        <h3 class="text-lg font-bold text-[#DAF1DE]">
          Pengaturan Social Links
        </h3>
        <button @click="$emit('close')" class="text-[#8EB69B] hover:text-[#DAF1DE]">
          <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
          </svg>
        </button>
      </div>

      <form @submit.prevent="saveLinks" class="space-y-3.5">
        <div>
          <label class="block text-xs font-semibold text-[#8EB69B] uppercase mb-1">GitHub URL</label>
          <input
            v-model="links.github"
            type="url"
            placeholder="https://github.com/..."
            class="w-full bg-[#163832] border border-[#235347] text-[#DAF1DE] rounded-xl px-3.5 py-2 text-xs outline-none focus:border-[#8EB69B]"
          />
        </div>

        <div>
          <label class="block text-xs font-semibold text-[#8EB69B] uppercase mb-1">LinkedIn URL</label>
          <input
            v-model="links.linkedin"
            type="url"
            placeholder="https://linkedin.com/in/..."
            class="w-full bg-[#163832] border border-[#235347] text-[#DAF1DE] rounded-xl px-3.5 py-2 text-xs outline-none focus:border-[#8EB69B]"
          />
        </div>

        <div>
          <label class="block text-xs font-semibold text-[#8EB69B] uppercase mb-1">Twitter / X URL</label>
          <input
            v-model="links.twitter"
            type="url"
            placeholder="https://x.com/..."
            class="w-full bg-[#163832] border border-[#235347] text-[#DAF1DE] rounded-xl px-3.5 py-2 text-xs outline-none focus:border-[#8EB69B]"
          />
        </div>

        <div>
          <label class="block text-xs font-semibold text-[#8EB69B] uppercase mb-1">Instagram URL</label>
          <input
            v-model="links.instagram"
            type="url"
            placeholder="https://instagram.com/..."
            class="w-full bg-[#163832] border border-[#235347] text-[#DAF1DE] rounded-xl px-3.5 py-2 text-xs outline-none focus:border-[#8EB69B]"
          />
        </div>

        <div class="flex items-center justify-end gap-3 pt-3 border-t border-[#235347]">
          <button
            type="button"
            @click="$emit('close')"
            class="px-4 py-2 rounded-xl bg-[#051F20] text-[#8EB69B] hover:text-[#DAF1DE] text-xs font-semibold"
          >
            Batal
          </button>
          <button
            type="submit"
            :disabled="saving"
            class="px-5 py-2 rounded-xl bg-[#235347] hover:bg-[#8EB69B] text-[#DAF1DE] hover:text-[#051F20] text-xs font-bold uppercase transition-all shadow-[0_0_15px_rgba(142,182,155,0.2)]"
          >
            {{ saving ? 'Menyimpan...' : 'Simpan Links' }}
          </button>
        </div>
      </form>
    </div>
  </div>
</template>

<script setup>
import { ref, watch } from 'vue';

const props = defineProps({
  isOpen: {
    type: Boolean,
    default: false,
  },
  socialLinks: {
    type: Object,
    default: () => ({}),
  },
});

const emit = defineEmits(['close', 'save-links']);

const saving = ref(false);
const links = ref({
  github: '',
  linkedin: '',
  twitter: '',
  instagram: '',
});

watch(
  () => props.socialLinks,
  (newVal) => {
    if (newVal) {
      links.value.github = newVal.github || '';
      links.value.linkedin = newVal.linkedin || '';
      links.value.twitter = newVal.twitter || '';
      links.value.instagram = newVal.instagram || '';
    }
  },
  { immediate: true }
);

const saveLinks = () => {
  saving.value = true;
  emit('save-links', { ...links.value }, () => {
    saving.value = false;
    emit('close');
  });
};
</script>

