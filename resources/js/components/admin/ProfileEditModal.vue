<template>
  <AdminModal
    :show="isOpen"
    title="Edit Profil & Biodata Diri"
    max-width="2xl"
    @close="$emit('close')"
  >
    <form @submit.prevent="handleSubmit" class="space-y-4">
      <!-- Name -->
      <div>
        <label class="block text-xs font-semibold text-[#8EB69B] uppercase mb-1">Nama Lengkap *</label>
        <input
          v-model="form.name"
          type="text"
          required
          class="w-full bg-[#163832] border border-[#235347] text-[#DAF1DE] rounded-xl px-4 py-2 text-sm outline-none focus:border-[#8EB69B] ring-1 ring-transparent focus:ring-sage-400/20"
        />
      </div>

      <!-- Roles for Typing Effect (Tag Input) -->
      <div>
        <label class="block text-xs font-semibold text-[#8EB69B] uppercase mb-1">
          Roles / Titles untuk Typing Effect * (Tekan Enter untuk menambah)
        </label>
        <input
          v-model="roleInput"
          type="text"
          @keydown.enter.prevent="addRole"
          placeholder="e.g. Full-Stack Developer, UI/UX Designer, Backend Specialist"
          class="w-full bg-[#163832] border border-[#235347] text-[#DAF1DE] rounded-xl px-4 py-2 text-sm outline-none focus:border-[#8EB69B]"
        />
        <div class="flex flex-wrap gap-1.5 mt-2">
          <span
            v-for="(r, idx) in form.roles"
            :key="idx"
            class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-xs bg-[#235347] text-[#DAF1DE] border border-[#8EB69B]/30"
          >
            {{ r }}
            <button type="button" @click="removeRole(idx)" class="text-[#8EB69B] hover:text-red-400 font-bold ml-0.5">×</button>
          </span>
        </div>
      </div>

      <!-- Short Bio -->
      <div>
        <label class="block text-xs font-semibold text-[#8EB69B] uppercase mb-1">Bio Singkat (Hero Section) *</label>
        <textarea
          v-model="form.short_bio"
          rows="2"
          required
          class="w-full bg-[#163832] border border-[#235347] text-[#DAF1DE] rounded-xl px-4 py-2 text-sm outline-none focus:border-[#8EB69B] resize-none ring-1 ring-transparent focus:ring-sage-400/20"
        ></textarea>
      </div>

      <!-- About Me -->
      <div>
        <label class="block text-xs font-semibold text-[#8EB69B] uppercase mb-1">Deskripsi Lengkap About Me *</label>
        <textarea
          v-model="form.about_me"
          rows="4"
          required
          class="w-full bg-[#163832] border border-[#235347] text-[#DAF1DE] rounded-xl px-4 py-2 text-sm outline-none focus:border-[#8EB69B] resize-none ring-1 ring-transparent focus:ring-sage-400/20"
        ></textarea>
      </div>

      <!-- Avatar Upload with Preview -->
      <div>
        <label class="block text-xs font-semibold text-[#8EB69B] uppercase mb-1">Foto Profil / Avatar</label>
        <div class="flex items-center gap-4">
          <div class="w-16 h-16 rounded-2xl overflow-hidden border border-[#8EB69B]/50 shrink-0 bg-[#051F20] ring-1 ring-sage-400/20">
            <img :src="avatarPreview || profile?.avatar_url" class="w-full h-full object-cover" />
          </div>
          <input
            type="file"
            accept="image/*"
            @change="handleAvatarFile"
            class="w-full text-xs text-[#8EB69B] file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-[#235347] file:text-[#DAF1DE] hover:file:bg-[#8EB69B] hover:file:text-[#051F20] file:cursor-pointer"
          />
        </div>
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
          @click="handleSubmit"
        >
          <span>{{ saving ? 'Menyimpan...' : 'Simpan Profil' }}</span>
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
  profile: {
    type: Object,
    default: () => ({}),
  },
});

const emit = defineEmits(['close', 'save-profile']);

const saving = ref(false);
const roleInput = ref('');
const avatarFile = ref(null);
const avatarPreview = ref(null);

const form = ref({
  name: '',
  roles: ['Full-Stack Developer'],
  short_bio: '',
  about_me: '',
});

watch(
  () => props.profile,
  (newVal) => {
    if (newVal) {
      form.value.name = newVal.name || '';
      form.value.roles = Array.isArray(newVal.roles) ? [...newVal.roles] : ['Full-Stack Developer'];
      form.value.short_bio = newVal.short_bio || '';
      form.value.about_me = newVal.about_me || '';
    }
  },
  { immediate: true }
);

const addRole = () => {
  const val = roleInput.value.trim().replace(/,/g, '');
  if (val && !form.value.roles.includes(val)) {
    form.value.roles.push(val);
  }
  roleInput.value = '';
};

const removeRole = (idx) => {
  form.value.roles.splice(idx, 1);
};

const handleAvatarFile = (e) => {
  const file = e.target.files[0];
  if (file) {
    avatarFile.value = file;
    avatarPreview.value = URL.createObjectURL(file);
  }
};

const handleSubmit = () => {
  saving.value = true;
  emit(
    'save-profile',
    {
      ...form.value,
      avatar: avatarFile.value,
    },
    () => {
      saving.value = false;
      emit('close');
    }
  );
};
</script>
