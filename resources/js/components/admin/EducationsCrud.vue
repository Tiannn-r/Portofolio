<template>
  <div class="space-y-6">
    <!-- Header with Type Filter & Add Button -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-2 border-b border-[#235347]">
      <div>
        <h3 class="text-xl sm:text-2xl font-bold text-[#DAF1DE] tracking-tight">
          Education & Certifications
        </h3>
        <p class="text-xs text-[#8EB69B] mt-0.5">
          Kelola riwayat pendidikan formal dan sertifikasi keahlian profesional resmi
        </p>
      </div>

      <div class="flex items-center gap-3">
        <!-- Type Tabs with Micro-interactions -->
        <div class="flex items-center p-1 bg-[#163832] border border-[#235347] rounded-xl text-xs">
          <button
            type="button"
            @click="filterType = 'all'"
            class="px-3 py-1.5 rounded-lg transition-all font-medium active:scale-95"
            :class="filterType === 'all' ? 'bg-[#235347] text-[#DAF1DE] shadow-[0_0_8px_rgba(142,182,155,0.2)]' : 'text-[#8EB69B] hover:text-[#DAF1DE]'"
          >
            Semua
          </button>
          <button
            type="button"
            @click="filterType = 'education'"
            class="px-3 py-1.5 rounded-lg transition-all font-medium active:scale-95"
            :class="filterType === 'education' ? 'bg-[#235347] text-[#DAF1DE] shadow-[0_0_8px_rgba(142,182,155,0.2)]' : 'text-[#8EB69B] hover:text-[#DAF1DE]'"
          >
            Pendidikan
          </button>
          <button
            type="button"
            @click="filterType = 'certification'"
            class="px-3 py-1.5 rounded-lg transition-all font-medium active:scale-95"
            :class="filterType === 'certification' ? 'bg-[#235347] text-[#DAF1DE] shadow-[0_0_8px_rgba(142,182,155,0.2)]' : 'text-[#8EB69B] hover:text-[#DAF1DE]'"
          >
            Sertifikasi
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
          <span>Tambah Riwayat</span>
        </BaseButton>
      </div>
    </div>

    <!-- 3 Column Grid for Cards -->
    <div v-if="filteredEducations.length > 0" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
      <GlassCard
        v-for="item in filteredEducations"
        :key="item.id"
        variant="secondary"
        hoverable
        class="flex flex-col justify-between group transition-all duration-300 hover:-translate-y-1 hover:border-sage-400/80 ring-1 ring-transparent hover:ring-sage-400/30"
      >
        <div>
          <!-- Header: Period & Type Badge -->
          <div class="flex items-center justify-between mb-3">
            <span class="px-2.5 py-0.5 rounded text-[11px] font-mono font-bold bg-[#163832] text-[#8EB69B] border border-[#235347] ring-1 ring-sage-400/10">
              {{ item.period }}
            </span>
            <span
              class="px-2 py-0.5 rounded text-[10px] font-mono font-semibold"
              :class="item.type === 'education' ? 'bg-[#235347] text-[#DAF1DE]' : 'bg-[#051F20] text-[#8EB69B] border border-[#235347]'"
            >
              {{ item.type === 'education' ? 'Pendidikan' : 'Sertifikasi' }}
            </span>
          </div>

          <h4 class="text-base font-bold text-[#DAF1DE] group-hover:text-[#8EB69B] transition-colors mb-1 tracking-tight">
            {{ item.title }}
          </h4>
          <p class="text-xs font-semibold text-[#8EB69B] mb-2.5">
            {{ item.institution }}
          </p>
          <p class="text-xs text-[#8EB69B]/80 leading-relaxed line-clamp-3 mb-4">
            {{ item.description || '-' }}
          </p>
        </div>

        <!-- Actions -->
        <div class="pt-3 border-t border-[#235347]/60 flex items-center justify-between gap-2">
          <BaseButton
            variant="glass"
            size="sm"
            class="flex-1"
            @click="openEditModal(item)"
          >
            <span>Edit</span>
          </BaseButton>
          <BaseButton
            variant="danger"
            size="sm"
            @click="confirmDelete(item)"
          >
            <span>Hapus</span>
          </BaseButton>
        </div>
      </GlassCard>
    </div>

    <!-- Empty State -->
    <EmptyState
      v-else
      title="Belum ada riwayat pada kategori ini"
      description="Tambahkan riwayat gelar akademik atau sertifikasi industri Anda."
    >
      <BaseButton
        variant="primary"
        size="sm"
        @click="openCreateModal"
      >
        <span>Tambah Riwayat Pertama</span>
      </BaseButton>
    </EmptyState>

    <!-- Modal Form (Create / Edit) using AdminModal -->
    <AdminModal
      :show="isModalOpen"
      :title="isEditing ? 'Edit Riwayat' : 'Tambah Riwayat Baru'"
      max-width="lg"
      @close="closeModal"
    >
      <form @submit.prevent="saveEducation" class="space-y-4">
        <!-- Type Selection -->
        <div>
          <label class="block text-xs font-semibold text-[#8EB69B] uppercase mb-1.5">Tipe Kategori *</label>
          <div class="grid grid-cols-2 gap-3">
            <label
              class="flex items-center justify-center gap-2 p-2.5 rounded-xl border cursor-pointer text-xs font-semibold transition-all active:scale-95"
              :class="form.type === 'education' ? 'bg-[#235347] border-[#8EB69B] text-[#DAF1DE] shadow-[0_0_10px_rgba(142,182,155,0.25)]' : 'bg-[#163832] border-[#235347] text-[#8EB69B]'"
            >
              <input type="radio" v-model="form.type" value="education" class="hidden" />
              <span>Formal Education</span>
            </label>

            <label
              class="flex items-center justify-center gap-2 p-2.5 rounded-xl border cursor-pointer text-xs font-semibold transition-all active:scale-95"
              :class="form.type === 'certification' ? 'bg-[#235347] border-[#8EB69B] text-[#DAF1DE] shadow-[0_0_10px_rgba(142,182,155,0.25)]' : 'bg-[#163832] border-[#235347] text-[#8EB69B]'"
            >
              <input type="radio" v-model="form.type" value="certification" class="hidden" />
              <span>Certification</span>
            </label>
          </div>
        </div>

        <div>
          <label class="block text-xs font-semibold text-[#8EB69B] uppercase mb-1">Gelar / Nama Sertifikasi *</label>
          <input
            v-model="form.title"
            type="text"
            required
            placeholder="e.g. S1 Teknik Informatika / Google Cloud Leader"
            class="w-full bg-[#163832] border border-[#235347] text-[#DAF1DE] rounded-xl px-4 py-2 text-sm outline-none focus:border-[#8EB69B] ring-1 ring-transparent focus:ring-sage-400/20"
          />
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
          <div>
            <label class="block text-xs font-semibold text-[#8EB69B] uppercase mb-1">Institusi / Penyelenggara *</label>
            <input
              v-model="form.institution"
              type="text"
              required
              placeholder="e.g. Universitas Bina Nusantara"
              class="w-full bg-[#163832] border border-[#235347] text-[#DAF1DE] rounded-xl px-4 py-2 text-sm outline-none focus:border-[#8EB69B] ring-1 ring-transparent focus:ring-sage-400/20"
            />
          </div>

          <div>
            <label class="block text-xs font-semibold text-[#8EB69B] uppercase mb-1">Tahun / Periode *</label>
            <input
              v-model="form.period"
              type="text"
              required
              placeholder="e.g. 2020 - 2024 / 2024"
              class="w-full bg-[#163832] border border-[#235347] text-[#DAF1DE] rounded-xl px-4 py-2 text-sm outline-none focus:border-[#8EB69B] ring-1 ring-transparent focus:ring-sage-400/20"
            />
          </div>
        </div>

        <div>
          <label class="block text-xs font-semibold text-[#8EB69B] uppercase mb-1">Deskripsi Singkat (Opsional)</label>
          <textarea
            v-model="form.description"
            rows="3"
            placeholder="Fokus bidang ilmu, predikat lulus, atau ringkasan kompetensi..."
            class="w-full bg-[#163832] border border-[#235347] text-[#DAF1DE] rounded-xl px-4 py-2 text-sm outline-none focus:border-[#8EB69B] resize-none ring-1 ring-transparent focus:ring-sage-400/20"
          ></textarea>
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
            @click="saveEducation"
          >
            <span>{{ saving ? 'Menyimpan...' : 'Simpan Data' }}</span>
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
  educations: {
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

const form = ref({
  title: '',
  institution: '',
  period: '',
  description: '',
  type: 'education',
  order: 0,
});

const filteredEducations = computed(() => {
  if (filterType.value === 'all') return props.educations;
  return props.educations.filter((e) => e.type === filterType.value);
});

const openCreateModal = () => {
  isEditing.value = false;
  editingId.value = null;
  form.value = {
    title: '',
    institution: '',
    period: '2024',
    description: '',
    type: filterType.value === 'certification' ? 'certification' : 'education',
    order: props.educations.length + 1,
  };
  isModalOpen.value = true;
};

const openEditModal = (item) => {
  isEditing.value = true;
  editingId.value = item.id;
  form.value = {
    title: item.title,
    institution: item.institution,
    period: item.period,
    description: item.description || '',
    type: item.type || 'education',
    order: item.order ?? 0,
  };
  isModalOpen.value = true;
};

const closeModal = () => {
  isModalOpen.value = false;
};

const saveEducation = async () => {
  if (!form.value.title || !form.value.institution || !form.value.period) {
    toastError('Gelar/Sertifikasi, Institusi, dan Periode wajib diisi');
    return;
  }

  saving.value = true;
  try {
    if (isEditing.value) {
      await axios.put(`/api/admin/educations/${editingId.value}`, form.value);
      success('Riwayat berhasil diperbarui');
    } else {
      await axios.post('/api/admin/educations', form.value);
      success('Riwayat baru berhasil ditambahkan');
    }
    closeModal();
    emit('refresh');
  } catch (err) {
    console.error('Error saving education:', err);
    toastError(err.response?.data?.message || 'Gagal menyimpan data pendidikan/sertifikasi.');
  } finally {
    saving.value = false;
  }
};

const confirmDelete = async (item) => {
  if (confirm(`Hapus data "${item.title}"?`)) {
    try {
      await axios.delete(`/api/admin/educations/${item.id}`);
      success(`Data "${item.title}" berhasil dihapus`);
      emit('refresh');
    } catch (err) {
      console.error('Error deleting education:', err);
      toastError('Gagal menghapus data');
    }
  }
};
</script>
