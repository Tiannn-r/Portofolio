<template>
  <div class="space-y-6">
    <!-- Header with Type Filter Tabs & Add Skill Button -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-2 border-b border-[#235347]">
      <div>
        <h3 class="text-xl sm:text-2xl font-bold text-[#DAF1DE] tracking-tight">
          Skills & Proficiencies Management
        </h3>
        <p class="text-xs text-[#8EB69B] mt-0.5">
          Kelola keahlian teknis (Technical Skills kotak) dan persentase penguasaan (My Skills progress bar)
        </p>
      </div>

      <div class="flex items-center gap-3">
        <!-- Type Filter Tabs with Micro-interactions -->
        <div class="flex items-center p-1 bg-[#163832] border border-[#235347] rounded-xl text-xs">
          <button
            type="button"
            @click="filterType = 'all'"
            class="px-3 py-1.5 rounded-lg transition-all font-medium active:scale-95"
            :class="filterType === 'all' ? 'bg-[#235347] text-[#DAF1DE] shadow-[0_0_8px_rgba(142,182,155,0.2)]' : 'text-[#8EB69B] hover:text-[#DAF1DE]'"
          >
            Semua ({{ skills.length }})
          </button>
          <button
            type="button"
            @click="filterType = 'grid_icon'"
            class="px-3 py-1.5 rounded-lg transition-all font-medium active:scale-95"
            :class="filterType === 'grid_icon' ? 'bg-[#235347] text-[#DAF1DE] shadow-[0_0_8px_rgba(142,182,155,0.2)]' : 'text-[#8EB69B] hover:text-[#DAF1DE]'"
          >
            Grid Icon
          </button>
          <button
            type="button"
            @click="filterType = 'progress_bar'"
            class="px-3 py-1.5 rounded-lg transition-all font-medium active:scale-95"
            :class="filterType === 'progress_bar' ? 'bg-[#235347] text-[#DAF1DE] shadow-[0_0_8px_rgba(142,182,155,0.2)]' : 'text-[#8EB69B] hover:text-[#DAF1DE]'"
          >
            Progress Bar
          </button>
        </div>

        <BaseButton
          variant="primary"
          size="sm"
          class="shrink-0"
          @click="openCreateModal"
        >
          <template #icon-left>
            <svg class="w-4 h-4 text-mint-100" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
          </template>
          <span>Tambah Skill</span>
        </BaseButton>
      </div>
    </div>

    <!-- Skills List Display -->
    <div v-if="filteredSkills.length > 0" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
      <GlassCard
        v-for="skill in filteredSkills"
        :key="skill.id"
        variant="secondary"
        hoverable
        class="flex flex-col justify-between group transition-all duration-300 hover:-translate-y-1 hover:border-sage-400/80 ring-1 ring-transparent hover:ring-sage-400/30"
      >
        <div>
          <div class="flex items-center justify-between mb-3">
            <!-- Icon preview -->
            <div class="w-10 h-10 rounded-xl bg-[#163832] border border-[#235347] flex items-center justify-center p-2 shadow-inner group-hover:scale-105 transition-transform">
              <img
                v-if="skill.icon_url || (skill.icon && !skill.icon.startsWith('<svg'))"
                :src="skill.icon_url || skill.icon"
                :alt="skill.name"
                class="w-full h-full object-contain"
              />
              <svg v-else class="w-5 h-5 text-[#8EB69B]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
              </svg>
            </div>

            <!-- Type Badge -->
            <span
              class="px-2 py-0.5 rounded text-[10px] font-mono ring-1 ring-sage-400/10"
              :class="skill.type === 'grid_icon' ? 'bg-[#163832] text-[#8EB69B] border border-[#235347]' : 'bg-[#235347] text-[#DAF1DE]'"
            >
              {{ skill.type === 'grid_icon' ? 'Grid Kotak' : 'Progress Bar' }}
            </span>
          </div>

          <h4 class="text-sm font-bold text-[#DAF1DE] group-hover:text-[#8EB69B] transition-colors mb-1 truncate tracking-tight">
            {{ skill.name }}
          </h4>

          <!-- Percentage Slider Bar Preview -->
          <div class="mt-2 mb-3">
            <div class="flex items-center justify-between text-[11px] font-mono text-[#8EB69B] mb-1">
              <span>Penguasaan:</span>
              <span class="font-bold text-[#DAF1DE]">{{ skill.percentage }}%</span>
            </div>
            <div class="w-full h-2 rounded-full bg-[#051F20] overflow-hidden border border-[#235347] p-0.5">
              <div
                class="h-full bg-gradient-to-r from-[#235347] to-[#8EB69B] rounded-full shadow-[0_0_8px_#8EB69B] transition-all duration-700"
                :style="{ width: `${skill.percentage}%` }"
              ></div>
            </div>
          </div>
        </div>

        <!-- Actions -->
        <div class="pt-3 border-t border-[#235347]/60 flex items-center justify-between gap-2">
          <BaseButton
            variant="glass"
            size="sm"
            class="flex-1"
            @click="openEditModal(skill)"
          >
            <span>Edit</span>
          </BaseButton>
          <BaseButton
            variant="danger"
            size="sm"
            @click="confirmDelete(skill)"
          >
            <span>Hapus</span>
          </BaseButton>
        </div>
      </GlassCard>
    </div>

    <!-- Empty State -->
    <EmptyState
      v-else
      title="Tidak ada skill pada kategori ini"
      description="Silakan tambahkan keahlian teknis atau ubah filter tipe di atas."
    >
      <BaseButton
        variant="primary"
        size="sm"
        @click="openCreateModal"
      >
        <span>Tambah Skill Baru</span>
      </BaseButton>
    </EmptyState>

    <!-- Modal Form (Create / Edit) using AdminModal -->
    <AdminModal
      :show="isModalOpen"
      :title="isEditing ? 'Edit Skill' : 'Tambah Skill Baru'"
      max-width="md"
      @close="closeModal"
    >
      <form @submit.prevent="saveSkill" class="space-y-4">
        <div>
          <label class="block text-xs font-semibold text-[#8EB69B] uppercase mb-1">Nama Skill *</label>
          <input
            v-model="form.name"
            type="text"
            required
            placeholder="e.g. Vue.js 3 / Laravel"
            class="w-full bg-[#163832] border border-[#235347] text-[#DAF1DE] rounded-xl px-4 py-2 text-sm outline-none focus:border-[#8EB69B] ring-1 ring-transparent focus:ring-sage-400/20"
          />
        </div>

        <!-- Type Selection: grid_icon vs progress_bar -->
        <div>
          <label class="block text-xs font-semibold text-[#8EB69B] uppercase mb-1.5">Tipe Tampilan *</label>
          <div class="grid grid-cols-2 gap-3">
            <label
              class="flex items-center justify-center gap-2 p-2.5 rounded-xl border cursor-pointer text-xs font-semibold transition-all active:scale-95"
              :class="form.type === 'grid_icon' ? 'bg-[#235347] border-[#8EB69B] text-[#DAF1DE] shadow-[0_0_10px_rgba(142,182,155,0.25)]' : 'bg-[#163832] border-[#235347] text-[#8EB69B]'"
            >
              <input type="radio" v-model="form.type" value="grid_icon" class="hidden" />
              <span>Technical Grid</span>
            </label>

            <label
              class="flex items-center justify-center gap-2 p-2.5 rounded-xl border cursor-pointer text-xs font-semibold transition-all active:scale-95"
              :class="form.type === 'progress_bar' ? 'bg-[#235347] border-[#8EB69B] text-[#DAF1DE] shadow-[0_0_10px_rgba(142,182,155,0.25)]' : 'bg-[#163832] border-[#235347] text-[#8EB69B]'"
            >
              <input type="radio" v-model="form.type" value="progress_bar" class="hidden" />
              <span>Progress Bar</span>
            </label>
          </div>
        </div>

        <!-- Percentage Slider -->
        <div>
          <div class="flex items-center justify-between text-xs font-semibold text-[#8EB69B] mb-1">
            <span>Persentase Penguasaan:</span>
            <span class="font-bold text-[#DAF1DE] font-mono text-sm">{{ form.percentage }}%</span>
          </div>
          <input
            v-model.number="form.percentage"
            type="range"
            min="0"
            max="100"
            class="w-full accent-[#8EB69B] cursor-pointer"
          />
        </div>

        <!-- Icon (URL or file) -->
        <div>
          <label class="block text-xs font-semibold text-[#8EB69B] uppercase mb-1">URL Ikon / SVG</label>
          <input
            v-model="form.icon"
            type="text"
            placeholder="https://cdn.jsdelivr.net/... (SVG URL)"
            class="w-full bg-[#163832] border border-[#235347] text-[#DAF1DE] rounded-xl px-4 py-2 text-sm outline-none focus:border-[#8EB69B]"
          />
        </div>

        <div>
          <label class="block text-xs font-semibold text-[#8EB69B] uppercase mb-1">Upload File Ikon (Opsional)</label>
          <input
            type="file"
            accept="image/*"
            @change="handleIconUpload"
            class="w-full text-xs text-[#8EB69B] file:mr-4 file:py-1.5 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-[#235347] file:text-[#DAF1DE] hover:file:bg-[#8EB69B] hover:file:text-[#051F20] file:cursor-pointer"
          />
        </div>

        <div>
          <label class="block text-xs font-semibold text-[#8EB69B] uppercase mb-1">Urutan (Order)</label>
          <input
            v-model.number="form.order"
            type="number"
            min="0"
            class="w-full bg-[#163832] border border-[#235347] text-[#DAF1DE] rounded-xl px-4 py-2 text-sm outline-none focus:border-[#8EB69B]"
          />
        </div>
      </form>

      <template #footer>
        <div class="w-full flex items-center justify-end gap-3">
          <BaseButton
            variant="ghost"
            size="sm"
            @click="closeModal"
          >
            <span>Batal</span>
          </BaseButton>
          <BaseButton
            variant="primary"
            size="sm"
            :loading="saving"
            @click="saveSkill"
          >
            <span>{{ saving ? 'Menyimpan...' : 'Simpan Skill' }}</span>
          </BaseButton>
        </div>
      </template>
    </AdminModal>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue';
import axios from 'axios';
import GlassCard from '../ui/GlassCard.vue';
import BaseButton from '../ui/BaseButton.vue';
import AdminModal from '../ui/AdminModal.vue';
import EmptyState from '../ui/EmptyState.vue';
import { useToast } from '../../composables/useToast';

const props = defineProps({
  skills: {
    type: Array,
    default: () => [],
  },
});

const emit = defineEmits(['refresh']);
const { success, error: toastError } = useToast();

const filterType = ref('all');
const isModalOpen = ref(false);
const isEditing = ref(false);
const editingId = ref(null);
const saving = ref(false);
const iconFile = ref(null);

const form = ref({
  name: '',
  percentage: 85,
  type: 'grid_icon',
  icon: '',
  order: 0,
});

const filteredSkills = computed(() => {
  if (filterType.value === 'all') return props.skills;
  return props.skills.filter((s) => s.type === filterType.value);
});

const openCreateModal = () => {
  isEditing.value = false;
  editingId.value = null;
  iconFile.value = null;
  form.value = {
    name: '',
    percentage: 85,
    type: filterType.value === 'progress_bar' ? 'progress_bar' : 'grid_icon',
    icon: '',
    order: props.skills.length + 1,
  };
  isModalOpen.value = true;
};

const openEditModal = (skill) => {
  isEditing.value = true;
  editingId.value = skill.id;
  iconFile.value = null;
  form.value = {
    name: skill.name,
    percentage: skill.percentage ?? 80,
    type: skill.type || 'grid_icon',
    icon: skill.icon || '',
    order: skill.order ?? 0,
  };
  isModalOpen.value = true;
};

const closeModal = () => {
  isModalOpen.value = false;
  iconFile.value = null;
};

const handleIconUpload = (e) => {
  iconFile.value = e.target.files[0] || null;
};

const saveSkill = async () => {
  if (!form.value.name) {
    toastError('Nama skill wajib diisi');
    return;
  }

  saving.value = true;
  try {
    const formData = new FormData();
    formData.append('name', form.value.name);
    formData.append('percentage', form.value.percentage);
    formData.append('type', form.value.type);
    formData.append('order', form.value.order);

    if (iconFile.value) {
      formData.append('icon', iconFile.value);
    } else if (form.value.icon) {
      formData.append('icon', form.value.icon);
    }

    if (isEditing.value) {
      formData.append('_method', 'PUT');
      await axios.post(`/api/admin/skills/${editingId.value}`, formData);
      success('Skill berhasil diperbarui');
    } else {
      await axios.post('/api/admin/skills', formData);
      success('Skill baru berhasil ditambahkan');
    }

    closeModal();
    emit('refresh');
  } catch (err) {
    console.error('Error saving skill:', err);
    toastError(err.response?.data?.message || 'Gagal menyimpan skill. Periksa kembali form input.');
  } finally {
    saving.value = false;
  }
};

const confirmDelete = async (skill) => {
  if (confirm(`Hapus skill "${skill.name}"?`)) {
    try {
      await axios.delete(`/api/admin/skills/${skill.id}`);
      success(`Skill "${skill.name}" berhasil dihapus`);
      emit('refresh');
    } catch (err) {
      console.error('Error deleting skill:', err);
      toastError('Gagal menghapus skill');
    }
  }
};
</script>
