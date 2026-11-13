<template>
  <div class="space-y-6">
    <!-- Header with Add Service Button -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-2 border-b border-[#235347]">
      <div>
        <h3 class="text-xl sm:text-2xl font-bold text-[#DAF1DE] tracking-tight">
          Services Management
        </h3>
        <p class="text-xs text-[#8EB69B] mt-0.5">
          Kelola penawaran layanan profesional yang Anda berikan kepada klien
        </p>
      </div>

      <BaseButton
        variant="primary"
        size="sm"
        @click="openCreateModal"
      >
        <template #icon-left>
          <svg class="w-4 h-4 text-mint-100" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
          </svg>
        </template>
        <span>Tambah Layanan Baru</span>
      </BaseButton>
    </div>

    <!-- Grid 4 Kolom Kartu Layanan -->
    <div v-if="services.length > 0" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
      <GlassCard
        v-for="service in services"
        :key="service.id"
        variant="secondary"
        hoverable
        class="flex flex-col justify-between group transition-all duration-300 hover:-translate-y-1 hover:border-sage-400/80 ring-1 ring-transparent hover:ring-sage-400/30"
      >
        <div>
          <!-- Icon & Order Badge -->
          <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 rounded-xl bg-[#163832] border border-[#235347] flex items-center justify-center p-2.5 shadow-inner group-hover:scale-105 transition-transform">
              <div
                v-if="service.icon && service.icon.trim().startsWith('<svg')"
                class="w-full h-full flex items-center justify-center [&>svg]:w-full [&>svg]:h-full [&>svg]:object-contain"
                v-html="service.icon"
              ></div>
              <img
                v-else-if="!failedIcons[service.id] && (service.icon_url || service.icon)"
                :src="service.icon_url || service.icon"
                :alt="service.title"
                class="w-full h-full object-contain"
                @error="failedIcons[service.id] = true"
              />
              <svg v-else class="w-6 h-6 text-[#8EB69B]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" />
              </svg>
            </div>
            <span class="text-[11px] font-mono text-[#8EB69B] bg-[#051F20] px-2.5 py-0.5 rounded border border-[#235347] ring-1 ring-sage-400/10">
              Order: {{ service.order ?? 0 }}
            </span>
          </div>

          <h4 class="text-base font-bold text-[#DAF1DE] group-hover:text-[#8EB69B] transition-colors mb-2 line-clamp-1 tracking-tight">
            {{ service.title }}
          </h4>
          <p class="text-xs text-[#8EB69B] leading-relaxed line-clamp-3 mb-4">
            {{ service.description }}
          </p>
        </div>

        <!-- Action Buttons: Edit & Delete -->
        <div class="pt-3 border-t border-[#235347]/70 flex items-center justify-between gap-2">
          <BaseButton
            variant="glass"
            size="sm"
            class="flex-1"
            @click="openEditModal(service)"
          >
            <template #icon-left>
              <svg class="w-3.5 h-3.5 text-[#8EB69B]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
              </svg>
            </template>
            <span>Edit</span>
          </BaseButton>

          <BaseButton
            variant="danger"
            size="sm"
            @click="confirmDelete(service)"
          >
            <span>Hapus</span>
          </BaseButton>
        </div>
      </GlassCard>
    </div>

    <!-- Empty State -->
    <EmptyState
      v-else
      title="Belum ada data layanan"
      description="Tambahkan layanan yang Anda berikan untuk ditampilkan di halaman utama portofolio."
    >
      <BaseButton
        variant="primary"
        size="sm"
        @click="openCreateModal"
      >
        <span>Tambah Layanan Pertama</span>
      </BaseButton>
    </EmptyState>

    <!-- Modal Form (Create / Edit) using AdminModal -->
    <AdminModal
      :show="isModalOpen"
      :title="isEditing ? 'Edit Layanan' : 'Tambah Layanan Baru'"
      max-width="lg"
      @close="closeModal"
    >
      <form id="service-form" @submit.prevent="saveService" class="space-y-4">
        <div>
          <label class="block text-xs font-semibold text-[#8EB69B] uppercase mb-1">Judul Layanan *</label>
          <input
            v-model="form.title"
            type="text"
            required
            placeholder="e.g. Web Development"
            class="w-full bg-[#163832] border border-[#235347] text-[#DAF1DE] rounded-xl px-4 py-2.5 text-sm outline-none focus:border-[#8EB69B] ring-1 ring-transparent focus:ring-sage-400/20"
          />
        </div>

        <div>
          <label class="block text-xs font-semibold text-[#8EB69B] uppercase mb-1">Deskripsi Singkat *</label>
          <textarea
            v-model="form.description"
            required
            rows="3"
            placeholder="Deskripsi layanan yang Anda sediakan..."
            class="w-full bg-[#163832] border border-[#235347] text-[#DAF1DE] rounded-xl px-4 py-2 text-sm outline-none focus:border-[#8EB69B] resize-none ring-1 ring-transparent focus:ring-sage-400/20"
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
            @click="saveService"
          >
            <span>{{ saving ? 'Menyimpan...' : 'Simpan Layanan' }}</span>
          </BaseButton>
        </div>
      </template>
    </AdminModal>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import axios from 'axios';
import GlassCard from '../ui/GlassCard.vue';
import BaseButton from '../ui/BaseButton.vue';
import AdminModal from '../ui/AdminModal.vue';
import EmptyState from '../ui/EmptyState.vue';
import { useToast } from '../../composables/useToast';

const props = defineProps({
  services: {
    type: Array,
    default: () => [],
  },
});

const emit = defineEmits(['refresh']);
const { success, error: toastError } = useToast();

const isModalOpen = ref(false);
const isEditing = ref(false);
const editingId = ref(null);
const saving = ref(false);
const iconFile = ref(null);
const failedIcons = ref({});

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
  if (!form.value.title || !form.value.description) {
    toastError('Judul dan deskripsi wajib diisi');
    return;
  }

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
      success('Layanan berhasil diperbarui');
    } else {
      await axios.post('/api/admin/services', formData);
      success('Layanan baru berhasil ditambahkan');
    }

    closeModal();
    emit('refresh');
  } catch (err) {
    console.error('Error saving service:', err);
    toastError(err.response?.data?.message || 'Gagal menyimpan layanan. Periksa kembali form input.');
  } finally {
    saving.value = false;
  }
};

const confirmDelete = async (service) => {
  if (confirm(`Yakin ingin menghapus layanan "${service.title}"?`)) {
    try {
      await axios.delete(`/api/admin/services/${service.id}`);
      success(`Layanan "${service.title}" berhasil dihapus`);
      emit('refresh');
    } catch (err) {
      console.error('Error deleting service:', err);
      toastError('Gagal menghapus layanan.');
    }
  }
};
</script>
