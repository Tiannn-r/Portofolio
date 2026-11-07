<template>
  <div class="space-y-6">
    <!-- Header with Search & Add Project Button -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-2 border-b border-[#235347]">
      <div>
        <h3 class="text-xl sm:text-2xl font-bold text-[#DAF1DE] tracking-tight">
          Portfolio Projects Management
        </h3>
        <p class="text-xs text-[#8EB69B] mt-0.5">
          Kelola portofolio proyek, unggah thumbnail, atur tech stack tags, dan tandai featured projects
        </p>
      </div>

      <div class="flex items-center gap-3">
        <!-- Quick Search with Ring Focus -->
        <input
          v-model="searchQuery"
          type="text"
          placeholder="Cari proyek..."
          class="bg-[#163832] border border-[#235347] text-[#DAF1DE] placeholder-[#8EB69B]/60 rounded-xl px-3.5 py-2 text-xs outline-none focus:border-[#8EB69B] ring-1 ring-transparent focus:ring-sage-400/20"
        />

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
          <span>Tambah Proyek Baru</span>
        </BaseButton>
      </div>
    </div>

    <!-- Grid 4 Kolom Kartu Proyek -->
    <div v-if="filteredProjects.length > 0" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
      <GlassCard
        v-for="project in filteredProjects"
        :key="project.id"
        variant="secondary"
        hoverable
        class="flex flex-col justify-between group overflow-hidden !p-0 transition-all duration-300 hover:-translate-y-1 hover:border-sage-400/80 ring-1 ring-transparent hover:ring-sage-400/30"
      >
        <!-- Thumbnail Preview & Featured Badge -->
        <div class="relative h-40 overflow-hidden border-b border-[#235347]">
          <img
            :src="project.thumbnail_url || project.thumbnail || 'https://images.unsplash.com/photo-1507238691740-187a5b1d37b8?auto=format&fit=crop&w=800&q=80'"
            :alt="project.title"
            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
          />
          <div class="absolute inset-0 bg-gradient-to-t from-[#0B2B26] via-transparent to-transparent opacity-80"></div>

          <!-- Category Badge -->
          <span class="absolute top-2.5 left-2.5 px-2.5 py-0.5 rounded text-[10px] font-mono font-bold bg-[#051F20]/90 text-[#8EB69B] border border-[#235347] backdrop-blur-md">
            {{ project.category }}
          </span>

          <!-- Featured Toggle Button Direct on Card -->
          <button
            type="button"
            @click="toggleFeatured(project)"
            :title="project.is_featured ? 'Hapus dari Featured' : 'Jadikan Featured Slider'"
            class="absolute top-2.5 right-2.5 px-2 py-0.5 rounded-full text-[10px] font-bold transition-all flex items-center gap-1 shadow-md active:scale-95"
            :class="project.is_featured ? 'bg-[#8EB69B] text-[#051F20] shadow-[0_0_8px_#8EB69B]' : 'bg-[#051F20]/80 text-[#8EB69B] border border-[#235347]'"
          >
            ★ {{ project.is_featured ? 'Featured' : 'Regular' }}
          </button>
        </div>

        <!-- Project Details -->
        <div class="p-4 flex-1 flex flex-col justify-between">
          <div>
            <h4 class="text-base font-bold text-[#DAF1DE] group-hover:text-[#8EB69B] transition-colors mb-1.5 line-clamp-1 tracking-tight">
              {{ project.title }}
            </h4>
            <p class="text-xs text-[#8EB69B] line-clamp-2 leading-relaxed mb-3">
              {{ project.description }}
            </p>

            <!-- Tech Stack Tags -->
            <div class="flex flex-wrap gap-1 mb-4">
              <span
                v-for="(tag, idx) in project.tech_stack"
                :key="idx"
                class="px-2 py-0.5 rounded text-[10px] bg-[#163832] text-[#DAF1DE] border border-[#235347]"
              >
                {{ tag }}
              </span>
            </div>
          </div>

          <!-- Action Buttons -->
          <div class="pt-3 border-t border-[#235347]/70 flex items-center justify-between gap-2">
            <BaseButton
              variant="glass"
              size="sm"
              class="flex-1"
              @click="openEditModal(project)"
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
              @click="confirmDelete(project)"
            >
              <span>Hapus</span>
            </BaseButton>
          </div>
        </div>
      </GlassCard>
    </div>

    <!-- Empty State -->
    <EmptyState
      v-else
      title="Tidak ada proyek ditemukan"
      description="Coba ubah kata kunci pencarian atau tambahkan proyek portofolio baru."
    >
      <BaseButton
        variant="primary"
        size="sm"
        @click="openCreateModal"
      >
        <span>Tambah Proyek Baru</span>
      </BaseButton>
    </EmptyState>

    <!-- Modal Form (Create / Edit) using AdminModal -->
    <AdminModal
      :show="isModalOpen"
      :title="isEditing ? 'Edit Proyek Portofolio' : 'Tambah Proyek Portofolio Baru'"
      max-width="2xl"
      @close="closeModal"
    >
      <form @submit.prevent="saveProject" class="space-y-4">
        <!-- Title & Category -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
          <div>
            <label class="block text-xs font-semibold text-[#8EB69B] uppercase mb-1">Judul Proyek *</label>
            <input
              v-model="form.title"
              type="text"
              required
              placeholder="e.g. Enterprise ERP Platform"
              class="w-full bg-[#163832] border border-[#235347] text-[#DAF1DE] rounded-xl px-4 py-2.5 text-sm outline-none focus:border-[#8EB69B] ring-1 ring-transparent focus:ring-sage-400/20"
            />
          </div>
          <div>
            <label class="block text-xs font-semibold text-[#8EB69B] uppercase mb-1">Kategori *</label>
            <input
              v-model="form.category"
              type="text"
              required
              placeholder="e.g. Web Application / E-Commerce"
              class="w-full bg-[#163832] border border-[#235347] text-[#DAF1DE] rounded-xl px-4 py-2.5 text-sm outline-none focus:border-[#8EB69B] ring-1 ring-transparent focus:ring-sage-400/20"
            />
          </div>
        </div>

        <!-- Description -->
        <div>
          <label class="block text-xs font-semibold text-[#8EB69B] uppercase mb-1">Deskripsi Proyek *</label>
          <textarea
            v-model="form.description"
            required
            rows="3"
            placeholder="Jelaskan tantangan, solusi arsitektur, dan hasil dari proyek ini..."
            class="w-full bg-[#163832] border border-[#235347] text-[#DAF1DE] rounded-xl px-4 py-2 text-sm outline-none focus:border-[#8EB69B] resize-none ring-1 ring-transparent focus:ring-sage-400/20"
          ></textarea>
        </div>

        <!-- Tech Stack Tags (Chips Input) -->
        <div>
          <label class="block text-xs font-semibold text-[#8EB69B] uppercase mb-1">
            Tech Stack Tags (Pisahkan dengan Koma atau Enter) *
          </label>
          <input
            v-model="tagInput"
            type="text"
            @keydown.enter.prevent="addTag"
            @keydown.comma.prevent="addTag"
            placeholder="e.g. Laravel 11, Vue 3, Tailwind CSS (Tekan Enter)"
            class="w-full bg-[#163832] border border-[#235347] text-[#DAF1DE] rounded-xl px-4 py-2 text-sm outline-none focus:border-[#8EB69B]"
          />
          <!-- Tags Badges Preview -->
          <div class="flex flex-wrap gap-1.5 mt-2">
            <span
              v-for="(tag, idx) in form.tech_stack"
              :key="idx"
              class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-xs bg-[#235347] text-[#DAF1DE] border border-[#8EB69B]/30"
            >
              {{ tag }}
              <button type="button" @click="removeTag(idx)" class="text-[#8EB69B] hover:text-red-400 font-bold ml-0.5">×</button>
            </span>
          </div>
        </div>

        <!-- Thumbnail Upload with Preview -->
        <div>
          <label class="block text-xs font-semibold text-[#8EB69B] uppercase mb-1">Thumbnail Proyek</label>
          <div class="flex items-center gap-4">
            <div v-if="thumbnailPreview || form.thumbnail" class="w-20 h-14 rounded-xl overflow-hidden border border-[#235347] shrink-0 bg-[#051F20] ring-1 ring-sage-400/20">
              <img :src="thumbnailPreview || form.thumbnail" class="w-full h-full object-cover" />
            </div>
            <input
              type="file"
              accept="image/*"
              @change="handleThumbnailUpload"
              class="w-full text-xs text-[#8EB69B] file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-[#235347] file:text-[#DAF1DE] hover:file:bg-[#8EB69B] hover:file:text-[#051F20] file:cursor-pointer"
            />
          </div>
        </div>

        <!-- Demo & Repo URLs -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
          <div>
            <label class="block text-xs font-semibold text-[#8EB69B] uppercase mb-1">URL Live Demo (Opsional)</label>
            <input
              v-model="form.url_demo"
              type="url"
              placeholder="https://demo.example.com"
              class="w-full bg-[#163832] border border-[#235347] text-[#DAF1DE] rounded-xl px-4 py-2 text-sm outline-none focus:border-[#8EB69B]"
            />
          </div>
          <div>
            <label class="block text-xs font-semibold text-[#8EB69B] uppercase mb-1">URL Repository (Opsional)</label>
            <input
              v-model="form.url_repo"
              type="url"
              placeholder="https://github.com/..."
              class="w-full bg-[#163832] border border-[#235347] text-[#DAF1DE] rounded-xl px-4 py-2 text-sm outline-none focus:border-[#8EB69B]"
            />
          </div>
        </div>

        <!-- Featured Checkbox & Order -->
        <div class="flex items-center justify-between p-3.5 rounded-xl bg-[#163832] border border-[#235347]">
          <label class="inline-flex items-center gap-2 cursor-pointer text-xs font-bold text-[#DAF1DE]">
            <input
              v-model="form.is_featured"
              type="checkbox"
              class="w-4 h-4 rounded text-[#8EB69B] bg-[#051F20] border-[#235347] focus:ring-0"
            />
            <span>Tampilkan di Slider Featured Projects</span>
          </label>

          <div class="flex items-center gap-2">
            <span class="text-xs text-[#8EB69B]">Urutan:</span>
            <input
              v-model.number="form.order"
              type="number"
              min="0"
              class="w-16 bg-[#051F20] border border-[#235347] text-[#DAF1DE] rounded-lg px-2 py-1 text-xs text-center outline-none"
            />
          </div>
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
            @click="saveProject"
          >
            <span>{{ saving ? 'Menyimpan...' : 'Simpan Proyek' }}</span>
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
  projects: {
    type: Array,
    default: () => [],
  },
});

const emit = defineEmits(['refresh']);
const { success, error: toastError } = useToast();

const searchQuery = ref('');
const isModalOpen = ref(false);
const isEditing = ref(false);
const editingId = ref(null);
const saving = ref(false);
const thumbnailFile = ref(null);
const thumbnailPreview = ref(null);
const tagInput = ref('');

const form = ref({
  title: '',
  category: '',
  description: '',
  tech_stack: ['Vue 3', 'Laravel 11', 'Tailwind CSS'],
  thumbnail: '',
  url_demo: '',
  url_repo: '',
  is_featured: false,
  order: 0,
});

const filteredProjects = computed(() => {
  if (!searchQuery.value) return props.projects;
  const q = searchQuery.value.toLowerCase();
  return props.projects.filter(
    (p) =>
      p.title.toLowerCase().includes(q) ||
      p.category.toLowerCase().includes(q) ||
      (p.tech_stack && p.tech_stack.some((t) => t.toLowerCase().includes(q)))
  );
});

const openCreateModal = () => {
  isEditing.value = false;
  editingId.value = null;
  thumbnailFile.value = null;
  thumbnailPreview.value = null;
  tagInput.value = '';
  form.value = {
    title: '',
    category: 'Web Application',
    description: '',
    tech_stack: ['Laravel 11', 'Vue 3', 'Tailwind CSS'],
    thumbnail: '',
    url_demo: '',
    url_repo: '',
    is_featured: false,
    order: props.projects.length + 1,
  };
  isModalOpen.value = true;
};

const openEditModal = (project) => {
  isEditing.value = true;
  editingId.value = project.id;
  thumbnailFile.value = null;
  thumbnailPreview.value = null;
  tagInput.value = '';
  form.value = {
    title: project.title,
    category: project.category,
    description: project.description,
    tech_stack: Array.isArray(project.tech_stack) ? [...project.tech_stack] : ['Laravel', 'Vue'],
    thumbnail: project.thumbnail_url || project.thumbnail || '',
    url_demo: project.url_demo || '',
    url_repo: project.url_repo || '',
    is_featured: !!project.is_featured,
    order: project.order ?? 0,
  };
  isModalOpen.value = true;
};

const closeModal = () => {
  isModalOpen.value = false;
  thumbnailFile.value = null;
  thumbnailPreview.value = null;
};

const addTag = () => {
  const val = tagInput.value.trim().replace(/,/g, '');
  if (val && !form.value.tech_stack.includes(val)) {
    form.value.tech_stack.push(val);
  }
  tagInput.value = '';
};

const removeTag = (index) => {
  form.value.tech_stack.splice(index, 1);
};

const handleThumbnailUpload = (e) => {
  const file = e.target.files[0];
  if (file) {
    thumbnailFile.value = file;
    thumbnailPreview.value = URL.createObjectURL(file);
  }
};

const saveProject = async () => {
  if (!form.value.title || !form.value.category || !form.value.description) {
    toastError('Judul, kategori, dan deskripsi wajib diisi');
    return;
  }

  saving.value = true;
  try {
    const formData = new FormData();
    formData.append('title', form.value.title);
    formData.append('category', form.value.category);
    formData.append('description', form.value.description);
    formData.append('tech_stack', JSON.stringify(form.value.tech_stack));
    formData.append('url_demo', form.value.url_demo || '');
    formData.append('url_repo', form.value.url_repo || '');
    formData.append('is_featured', form.value.is_featured ? '1' : '0');
    formData.append('order', form.value.order);

    if (thumbnailFile.value) {
      formData.append('thumbnail', thumbnailFile.value);
    }

    if (isEditing.value) {
      await axios.post(`/api/admin/projects/${editingId.value}`, formData);
      success('Proyek berhasil diperbarui');
    } else {
      await axios.post('/api/admin/projects', formData);
      success('Proyek baru berhasil ditambahkan');
    }

    closeModal();
    emit('refresh');
  } catch (err) {
    console.error('Error saving project:', err);
    toastError(err.response?.data?.message || 'Gagal menyimpan proyek. Periksa kembali form input.');
  } finally {
    saving.value = false;
  }
};

const toggleFeatured = async (project) => {
  try {
    const newStatus = !project.is_featured;
    await axios.post(`/api/admin/projects/${project.id}`, {
      is_featured: newStatus ? 1 : 0,
    });
    project.is_featured = newStatus;
    success(`Status featured "${project.title}" diperbarui`);
    emit('refresh');
  } catch (err) {
    console.error('Error toggling featured status:', err);
    toastError('Gagal mengubah status featured');
  }
};

const confirmDelete = async (project) => {
  if (confirm(`Hapus proyek "${project.title}"?`)) {
    try {
      await axios.delete(`/api/admin/projects/${project.id}`);
      success(`Proyek "${project.title}" berhasil dihapus`);
      emit('refresh');
    } catch (err) {
      console.error('Error deleting project:', err);
      toastError('Gagal menghapus proyek');
    }
  }
};
</script>
