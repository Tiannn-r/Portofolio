<template>
  <div
    v-if="isOpen"
    class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/80 backdrop-blur-sm animate-fade-in"
    @click.self="$emit('close')"
  >
    <div class="w-full max-w-2xl bg-[#0B2B26] border border-[#8EB69B]/40 rounded-2xl p-6 sm:p-8 shadow-[0_0_40px_rgba(142,182,155,0.3)] max-h-[90vh] overflow-y-auto">
      <div class="flex items-center justify-between pb-3 mb-5 border-b border-[#235347]">
        <div>
          <h3 class="text-xl font-bold text-[#DAF1DE]">
            Edit Profil & Biodata Diri
          </h3>
          <p class="text-xs text-[#8EB69B]">Perbarui nama, role typing effect, foto avatar, dan narasi about me</p>
        </div>
        <button @click="$emit('close')" class="text-[#8EB69B] hover:text-[#DAF1DE]">
          <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
          </svg>
        </button>
      </div>

      <form @submit.prevent="handleSubmit" class="space-y-4">
        <!-- Name -->
        <div>
          <label class="block text-xs font-semibold text-[#8EB69B] uppercase mb-1">Nama Lengkap *</label>
          <input
            v-model="form.name"
            type="text"
            required
            class="w-full bg-[#163832] border border-[#235347] text-[#DAF1DE] rounded-xl px-4 py-2 text-sm outline-none focus:border-[#8EB69B]"
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
              class="inline-flex items-center gap-1 px-2.5 py-1 rounded-md text-xs bg-[#235347] text-[#DAF1DE]"
            >
              {{ r }}
              <button type="button" @click="removeRole(idx)" class="text-[#8EB69B] hover:text-red-400 font-bold">×</button>
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
            class="w-full bg-[#163832] border border-[#235347] text-[#DAF1DE] rounded-xl px-4 py-2 text-sm outline-none focus:border-[#8EB69B] resize-none"
          ></textarea>
        </div>

        <!-- About Me -->
        <div>
          <label class="block text-xs font-semibold text-[#8EB69B] uppercase mb-1">Deskripsi Lengkap About Me *</label>
          <textarea
            v-model="form.about_me"
            rows="4"
            required
            class="w-full bg-[#163832] border border-[#235347] text-[#DAF1DE] rounded-xl px-4 py-2 text-sm outline-none focus:border-[#8EB69B] resize-none"
          ></textarea>
        </div>

        <!-- Avatar Upload with Preview -->
        <div>
          <label class="block text-xs font-semibold text-[#8EB69B] uppercase mb-1">Foto Profil / Avatar</label>
          <div class="flex items-center gap-4">
            <div class="w-16 h-16 rounded-2xl overflow-hidden border border-[#8EB69B]/50 shrink-0 bg-[#051F20]">
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
            class="px-5 py-2.5 rounded-xl bg-[#235347] hover:bg-[#8EB69B] text-[#DAF1DE] hover:text-[#051F20] text-xs font-bold uppercase transition-all shadow-[0_0_15px_rgba(142,182,155,0.2)]"
          >
            {{ saving ? 'Menyimpan...' : 'Simpan Profil' }}
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

