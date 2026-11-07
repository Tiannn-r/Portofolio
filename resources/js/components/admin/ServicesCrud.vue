<template>
  <div class="space-y-6">
    <!-- Header with Add Service Button -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-2 border-b border-[#235347]">
      <div>
        <h3 class="text-xl sm:text-2xl font-bold text-[#DAF1DE]">
          Services Management
        </h3>
        <p class="text-xs text-[#8EB69B] mt-0.5">
          Kelola penawaran layanan profesional yang Anda berikan kepada klien
        </p>
      </div>

      <button
        type="button"
        @click="openCreateModal"
        class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-[#235347] hover:bg-[#8EB69B] text-[#DAF1DE] hover:text-[#051F20] font-semibold text-xs tracking-wide transition-all shadow-[0_0_15px_rgba(142,182,155,0.2)]"
      >
        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
        </svg>
        <span>Tambah Layanan Baru</span>
      </button>
    </div>

    <!-- Grid 4 Kolom Kartu Layanan -->
    <div v-if="services.length > 0" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
      <div
        v-for="service in services"
        :key="service.id"
        class="bg-[#0B2B26] border border-[#235347] hover:border-[#8EB69B] rounded-2xl p-5 shadow-[0_4px_20px_rgba(5,31,32,0.4)] hover:shadow-[0_0_20px_rgba(142,182,155,0.2)] transition-all flex flex-col justify-between group"
      >
        <div>
          <!-- Icon & Order Badge -->
          <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 rounded-xl bg-[#163832] border border-[#235347] flex items-center justify-center p-2.5 shadow-inner">
              <img
                v-if="service.icon_url || (service.icon && !service.icon.startsWith('<svg'))"
                :src="service.icon_url || service.icon"
                :alt="service.title"
                class="w-full h-full object-contain"
              />
              <svg v-else class="w-6 h-6 text-[#8EB69B]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" />
              </svg>
            </div>
            <span class="text-[11px] font-mono text-[#8EB69B] bg-[#051F20] px-2 py-0.5 rounded border border-[#235347]">
              Order: {{ service.order ?? 0 }}
            </span>
          </div>

          <h4 class="text-base font-bold text-[#DAF1DE] group-hover:text-[#8EB69B] transition-colors mb-2 line-clamp-1">
            {{ service.title }}
          </h4>
          <p class="text-xs text-[#8EB69B] leading-relaxed line-clamp-3 mb-4">
            {{ service.description }}
          </p>
        </div>

        <!-- Action Buttons: Edit & Delete -->
        <div class="pt-3 border-t border-[#235347]/70 flex items-center justify-between gap-2">
          <button
            type="button"
            @click="openEditModal(service)"
            class="flex-1 py-1.5 px-3 rounded-lg bg-[#163832] hover:bg-[#235347] text-[#DAF1DE] text-xs font-semibold transition-colors flex items-center justify-center gap-1.5"
          >
            <svg class="w-3.5 h-3.5 text-[#8EB69B]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
            </svg>
            <span>Edit</span>
          </button>

          <button
            type="button"
            @click="confirmDelete(service)"
            class="py-1.5 px-3 rounded-lg bg-[#051F20] hover:bg-red-950/80 text-red-400 hover:text-red-300 text-xs font-semibold transition-colors border border-red-500/30"
          >
            Hapus
          </button>
        </div>
      </div>
    </div>

    <div v-else class="text-center py-12 bg-[#0B2B26] border border-[#235347] rounded-2xl">
      <p class="text-sm text-[#8EB69B]">Belum ada data layanan. Klik "Tambah Layanan Baru" untuk menambahkan.</p>
    </div>

    <!-- Modal Form (Create / Edit) -->
    <div
      v-if="isModalOpen"
      class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/75 backdrop-blur-sm animate-fade-in"
      @click.self="closeModal"
    >
      <div class="w-full max-w-lg bg-[#0B2B26] border border-[#8EB69B]/40 rounded-2xl p-6 sm:p-7 shadow-[0_0_35px_rgba(142,182,155,0.25)]">
        <div class="flex items-center justify-between pb-3 mb-5 border-b border-[#235347]">
          <h4 class="text-lg font-bold text-[#DAF1DE]">
            {{ isEditing ? 'Edit Layanan' : 'Tambah Layanan Baru' }}
          </h4>
          <button @click="closeModal" class="text-[#8EB69B] hover:text-[#DAF1DE]">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
          </button>
        </div>

        <form @submit.prevent="saveService" class="space-y-4">
          <div>
            <label class="block text-xs font-semibold text-[#8EB69B] uppercase mb-1">Judul Layanan *</label>
            <input
              v-model="form.title"
              type="text"
              required
              placeholder="e.g. Web Development"
              class="w-full bg-[#163832] border border-[#235347] text-[#DAF1DE] rounded-xl px-4 py-2.5 text-sm outline-none focus:border-[#8EB69B]"
            />
          </div>

          <div>
            <label class="block text-xs font-semibold text-[#8EB69B] uppercase mb-1">Deskripsi Singkat *</label>
            <textarea
              v-model="form.description"
              required
              rows="3"
              placeholder="Deskripsi layanan yang Anda sediakan..."
              class="w-full bg-[#163832] border border-[#235347] text-[#DAF1DE] rounded-xl px-4 py-2 text-sm outline-none focus:border-[#8EB69B] resize-none"
            ></textarea>
          </div>

          <div class="grid grid-cols-2 gap-4">
            <div>
              <label class="block text-xs font-semibold text-[#8EB69B] uppercase mb-1">Ikon (URL / SVG)</label>
              <input
                v-model="form.icon"
                type="text"
                placeholder="https://... atau path"
                class="w-full bg-[#163832] border border-[#235347] text-[#DAF1DE] rounded-xl px-4 py-2 text-sm outline-none focus:border-[#8EB69B]"
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
          </div>

          <!-- File Upload Icon Alternative -->
          <div>
            <label class="block text-xs font-semibold text-[#8EB69B] uppercase mb-1">Upload File Ikon (Opsional)</label>
            <input
              type="file"
              accept="image/*"
              @change="handleIconUpload"
              class="w-full text-xs text-[#8EB69B] file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-[#235347] file:text-[#DAF1DE] hover:file:bg-[#8EB69B] hover:file:text-[#051F20] file:cursor-pointer"
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
              {{ saving ? 'Menyimpan...' : 'Simpan Layanan' }}
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import axios from 'axios';

const props = defineProps({
  services: {
    type: Array,
    default: () => [],
  },
});

const emit = defineEmits(['refresh']);

const isModalOpen = ref(false);
const isEditing = ref(false);
const editingId = ref(null);
const saving = ref(false);
const iconFile = ref(null);

const form = ref({
  title: '',
  description: '',
  icon: '',
  order: 0,
});

const openCreateModal = () => {
  isEditing.value = false;
  editingId.value = null;
  iconFile.value = null;
  form.value = {
    title: '',
    description: '',
    icon: '',
    order: props.services.length + 1,
  };
  isModalOpen.value = true;
};

const openEditModal = (service) => {
  isEditing.value = true;
  editingId.value = service.id;
  iconFile.value = null;
  form.value = {
    title: service.title,
    description: service.description,
    icon: service.icon || '',
    order: service.order ?? 0,
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

const saveService = async () => {
  saving.value = true;
  try {
    const formData = new FormData();
    formData.append('title', form.value.title);
    formData.append('description', form.value.description);
    formData.append('order', form.value.order);

    if (iconFile.value) {
      formData.append('icon', iconFile.value);
    } else if (form.value.icon) {
      formData.append('icon', form.value.icon);
    }

    if (isEditing.value) {
      formData.append('_method', 'PUT');
      await axios.post(`/api/admin/services/${editingId.value}`, formData);
    } else {
      await axios.post('/api/admin/services', formData);
    }

    closeModal();
    emit('refresh');
  } catch (error) {
    console.error('Error saving service:', error);
    alert('Gagal menyimpan layanan. Periksa kembali form input.');
  } finally {
    saving.value = false;
  }
};

const confirmDelete = async (service) => {
  if (confirm(`Yakin ingin menghapus layanan "${service.title}"?`)) {
    try {
      await axios.delete(`/api/admin/services/${service.id}`);
      emit('refresh');
    } catch (error) {
      console.error('Error deleting service:', error);
      alert('Gagal menghapus layanan.');
    }
  }
};
</script>
