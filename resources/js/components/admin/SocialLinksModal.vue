<template>
  <AdminModal
    :show="isOpen"
    title="Pengaturan Social Links"
    max-width="md"
    @close="$emit('close')"
  >
    <form @submit.prevent="saveLinks" class="space-y-3.5">
      <div>
        <label class="block text-xs font-semibold text-[#8EB69B] uppercase mb-1">GitHub URL</label>
        <input
          v-model="links.github"
          type="url"
          placeholder="https://github.com/..."
          class="w-full bg-[#163832] border border-[#235347] text-[#DAF1DE] rounded-xl px-3.5 py-2 text-xs outline-none focus:border-[#8EB69B] ring-1 ring-transparent focus:ring-sage-400/20"
        />
      </div>

      <div>
        <label class="block text-xs font-semibold text-[#8EB69B] uppercase mb-1">LinkedIn URL</label>
        <input
          v-model="links.linkedin"
          type="url"
          placeholder="https://linkedin.com/in/..."
          class="w-full bg-[#163832] border border-[#235347] text-[#DAF1DE] rounded-xl px-3.5 py-2 text-xs outline-none focus:border-[#8EB69B] ring-1 ring-transparent focus:ring-sage-400/20"
        />
      </div>

      <div>
        <label class="block text-xs font-semibold text-[#8EB69B] uppercase mb-1">Twitter / X URL</label>
        <input
          v-model="links.twitter"
          type="url"
          placeholder="https://x.com/..."
          class="w-full bg-[#163832] border border-[#235347] text-[#DAF1DE] rounded-xl px-3.5 py-2 text-xs outline-none focus:border-[#8EB69B] ring-1 ring-transparent focus:ring-sage-400/20"
        />
      </div>

      <div>
        <label class="block text-xs font-semibold text-[#8EB69B] uppercase mb-1">Instagram URL</label>
        <input
          v-model="links.instagram"
          type="url"
          placeholder="https://instagram.com/..."
          class="w-full bg-[#163832] border border-[#235347] text-[#DAF1DE] rounded-xl px-3.5 py-2 text-xs outline-none focus:border-[#8EB69B] ring-1 ring-transparent focus:ring-sage-400/20"
        />
      </div>
    </form>

    <template #footer>
      <div class="w-full flex items-center justify-end gap-3">
        <BaseButton
          variant="ghost"
          size="sm"
          @click="$emit('close')"
        >
          <span>Batal</span>
        </BaseButton>
        <BaseButton
          variant="primary"
          size="sm"
          :loading="saving"
          @click="saveLinks"
        >
          <span>{{ saving ? 'Menyimpan...' : 'Simpan Links' }}</span>
        </BaseButton>
      </div>
    </template>
  </AdminModal>
</template>

<script setup>
import { ref, watch } from 'vue';
import AdminModal from '../ui/AdminModal.vue';
import BaseButton from '../ui/BaseButton.vue';

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
