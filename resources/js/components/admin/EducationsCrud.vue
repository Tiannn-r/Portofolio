<template>
  <div class="space-y-6">
    <!-- Header with Type Filter & Add Button -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-2 border-b border-[#235347]">
      <div>
        <h3 class="text-xl sm:text-2xl font-bold text-[#DAF1DE]">
          Education & Certifications
        </h3>
        <p class="text-xs text-[#8EB69B] mt-0.5">
          Kelola riwayat pendidikan formal dan sertifikasi keahlian profesional resmi
        </p>
      </div>

      <div class="flex items-center gap-3">
        <!-- Type Tabs -->
        <div class="flex items-center p-1 bg-[#163832] border border-[#235347] rounded-xl text-xs">
          <button
            type="button"
            @click="filterType = 'all'"
            class="px-3 py-1.5 rounded-lg transition-colors font-medium"
            :class="filterType === 'all' ? 'bg-[#235347] text-[#DAF1DE]' : 'text-[#8EB69B] hover:text-[#DAF1DE]'"
          >
            Semua
          </button>
          <button
            type="button"
            @click="filterType = 'education'"
            class="px-3 py-1.5 rounded-lg transition-colors font-medium"
            :class="filterType === 'education' ? 'bg-[#235347] text-[#DAF1DE]' : 'text-[#8EB69B] hover:text-[#DAF1DE]'"
          >
            Pendidikan
          </button>
          <button
            type="button"
            @click="filterType = 'certification'"
            class="px-3 py-1.5 rounded-lg transition-colors font-medium"
            :class="filterType === 'certification' ? 'bg-[#235347] text-[#DAF1DE]' : 'text-[#8EB69B] hover:text-[#DAF1DE]'"
          >
            Sertifikasi
          </button>
        </div>

        <button
          type="button"
          @click="openCreateModal"
          class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-[#235347] hover:bg-[#8EB69B] text-[#DAF1DE] hover:text-[#051F20] font-semibold text-xs tracking-wide transition-all shadow-[0_0_15px_rgba(142,182,155,0.2)] shrink-0"
        >
          <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
          </svg>
          <span>Tambah Riwayat</span>
        </button>
      </div>
    </div>

    <!-- 2 Column Grid for Cards -->
    <div v-if="filteredEducations.length > 0" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
      <div
        v-for="item in filteredEducations"
        :key="item.id"
        class="bg-[#0B2B26] border border-[#235347] hover:border-[#8EB69B] rounded-2xl p-5 shadow-[0_4px_20px_rgba(5,31,32,0.4)] transition-all flex flex-col justify-between group"
      >
        <div>
          <!-- Header: Period & Type Badge -->
          <div class="flex items-center justify-between mb-3">
            <span class="px-2.5 py-0.5 rounded text-[11px] font-mono font-bold bg-[#163832] text-[#8EB69B] border border-[#235347]">
              {{ item.period }}
            </span>
            <span
              class="px-2 py-0.5 rounded text-[10px] font-mono font-semibold"
              :class="item.type === 'education' ? 'bg-[#235347] text-[#DAF1DE]' : 'bg-[#051F20] text-[#8EB69B] border border-[#235347]'"
            >
              {{ item.type === 'education' ? 'Pendidikan' : 'Sertifikasi' }}
            </span>
          </div>

          <h4 class="text-base font-bold text-[#DAF1DE] group-hover:text-[#8EB69B] transition-colors mb-1">
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
          <button
            type="button"
            @click="openEditModal(item)"
            class="flex-1 py-1.5 px-3 rounded-lg bg-[#163832] hover:bg-[#235347] text-[#DAF1DE] text-xs font-semibold transition-colors flex items-center justify-center gap-1.5"
          >
            <span>Edit</span>
          </button>
          <button
            type="button"
            @click="confirmDelete(item)"
            class="py-1.5 px-3 rounded-lg bg-[#051F20] hover:bg-red-950/80 text-red-400 hover:text-red-300 text-xs font-semibold transition-colors border border-red-500/30"
          >
            Hapus
          </button>
        </div>
      </div>
    </div>

    <div v-else class="text-center py-12 bg-[#0B2B26] border border-[#235347] rounded-2xl">
      <p class="text-sm text-[#8EB69B]">Belum ada riwayat pada kategori ini.</p>
    </div>

    <!-- Modal Form (Create / Edit) -->
    <div
      v-if="isModalOpen"
      class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/75 backdrop-blur-sm animate-fade-in"
      @click.self="closeModal"
    >
      <div class="w-full max-w-lg bg-[#0B2B26] border border-[#8EB69B]/40 rounded-2xl p-6 sm:p-7 shadow-[0_0_35px_rgba(142,182,155,0.25)]">
        <div class="flex items-center justify-between pb-3 mb-4 border-b border-[#235347]">
          <h4 class="text-lg font-bold text-[#DAF1DE]">
            {{ isEditing ? 'Edit Riwayat' : 'Tambah Riwayat Baru' }}
          </h4>
          <button @click="closeModal" class="text-[#8EB69B] hover:text-[#DAF1DE]">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
          </button>
        </div>

        <form @submit.prevent="saveEducation" class="space-y-4">
          <!-- Type Selection -->
          <div>
            <label class="block text-xs font-semibold text-[#8EB69B] uppercase mb-1.5">Tipe Kategori *</label>
            <div class="grid grid-cols-2 gap-3">
              <label
                class="flex items-center justify-center gap-2 p-2.5 rounded-xl border cursor-pointer text-xs font-semibold transition-all"
                :class="form.type === 'education' ? 'bg-[#235347] border-[#8EB69B] text-[#DAF1DE]' : 'bg-[#163832] border-[#235347] text-[#8EB69B]'"
              >
                <input type="radio" v-model="form.type" value="education" class="hidden" />
                <span>Formal Education</span>
              </label>

              <label
                class="flex items-center justify-center gap-2 p-2.5 rounded-xl border cursor-pointer text-xs font-semibold transition-all"
                :class="form.type === 'certification' ? 'bg-[#235347] border-[#8EB69B] text-[#DAF1DE]' : 'bg-[#163832] border-[#235347] text-[#8EB69B]'"
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
              class="w-full bg-[#163832] border border-[#235347] text-[#DAF1DE] rounded-xl px-4 py-2 text-sm outline-none focus:border-[#8EB69B]"
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
                class="w-full bg-[#163832] border border-[#235347] text-[#DAF1DE] rounded-xl px-4 py-2 text-sm outline-none focus:border-[#8EB69B]"
              />
            </div>

            <div>
              <label class="block text-xs font-semibold text-[#8EB69B] uppercase mb-1">Tahun / Periode *</label>
              <input
                v-model="form.period"
                type="text"
                required
                placeholder="e.g. 2020 - 2024 / 2024"
                class="w-full bg-[#163832] border border-[#235347] text-[#DAF1DE] rounded-xl px-4 py-2 text-sm outline-none focus:border-[#8EB69B]"
              />
            </div>
          </div>

          <div>
            <label class="block text-xs font-semibold text-[#8EB69B] uppercase mb-1">Deskripsi Singkat (Opsional)</label>
            <textarea
              v-model="form.description"
              rows="3"
              placeholder="Fokus bidang ilmu, predikat lulus, atau ringkasan kompetensi..."
              class="w-full bg-[#163832] border border-[#235347] text-[#DAF1DE] rounded-xl px-4 py-2 text-sm outline-none focus:border-[#8EB69B] resize-none"
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

          <div class="flex items-center justify-end gap-3 pt-3 border-t border-[#235347]">
            <button
              type="button"
              @click="closeModal"
              class="px-4 py-2 rounded-xl bg-[#051F20] text-[#8EB69B] hover:text-[#DAF1DE] text-xs font-semibold"
            >
              Batal
            </button>
            <button
              type="submit"
              :disabled="saving"
              class="px-5 py-2 rounded-xl bg-[#235347] hover:bg-[#8EB69B] text-[#DAF1DE] hover:text-[#051F20] text-xs font-bold uppercase transition-all shadow-[0_0_15px_rgba(142,182,155,0.2)]"
            >
              {{ saving ? 'Menyimpan...' : 'Simpan Data' }}
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue';
import axios from 'axios';

const props = defineProps({
  educations: {
    type: Array,
    default: () => [],
  },
});

const emit = defineEmits(['refresh']);

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
  saving.value = true;
  try {
    if (isEditing.value) {
      await axios.put(`/api/admin/educations/${editingId.value}`, form.value);
    } else {
      await axios.post('/api/admin/educations', form.value);
    }
    closeModal();
    emit('refresh');
  } catch (error) {
    console.error('Error saving education:', error);
    alert('Gagal menyimpan data pendidikan/sertifikasi.');
  } finally {
    saving.value = false;
  }
};

const confirmDelete = async (item) => {
  if (confirm(`Hapus data "${item.title}"?`)) {
    try {
      await axios.delete(`/api/admin/educations/${item.id}`);
      emit('refresh');
    } catch (error) {
      console.error('Error deleting education:', error);
      alert('Gagal menghapus data.');
    }
  }
};
</script>

