<template>
  <div class="min-h-screen bg-[#051F20] text-[#DAF1DE] flex selection:bg-[#8EB69B] selection:text-[#051F20]">
    <!-- 1. Fixed Left Sidebar -->
    <AdminSidebar
      :isOpen="isSidebarOpen"
      :activeTab="activeTab"
      :profile="profile"
      :adminUser="adminUser"
      :unreadMessagesCount="unreadCount"
      @update-tab="handleTabChange"
      @toggle-freelance="handleToggleFreelance"
      @upload-cv="handleCvUpload"
      @open-social-modal="isSocialModalOpen = true"
      @close-sidebar="isSidebarOpen = false"
    />

    <!-- Main Content Wrapper (Margin left on desktop for fixed sidebar) -->
    <div class="flex-1 lg:pl-72 flex flex-col min-w-0 min-h-screen">
      <!-- 2. Top Bar -->
      <AdminTopBar
        :activeTab="activeTab"
        @toggle-sidebar="isSidebarOpen = !isSidebarOpen"
      />

      <!-- Content Area on Background #051F20 -->
      <main class="flex-1 p-4 sm:p-8 space-y-8 max-w-7xl w-full mx-auto">
        <!-- Toast Alert Notification -->
        <div
          v-if="toastMessage"
          class="p-4 rounded-xl flex items-center justify-between text-xs font-semibold shadow-lg transition-all animate-fade-in"
          :class="toastType === 'success' ? 'bg-[#0B2B26] border border-[#8EB69B] text-[#DAF1DE] shadow-[0_0_15px_rgba(142,182,155,0.25)]' : 'bg-red-950/90 border border-red-500/50 text-red-200'"
        >
          <div class="flex items-center gap-2.5">
            <span class="w-2.5 h-2.5 rounded-full" :class="toastType === 'success' ? 'bg-[#8EB69B] shadow-[0_0_8px_#8EB69B]' : 'bg-red-400'"></span>
            <span>{{ toastMessage }}</span>
          </div>
          <button @click="toastMessage = ''" class="text-xs text-[#8EB69B] hover:text-[#DAF1DE]">✕</button>
        </div>

        <!-- 2. Hero Summary Card (Always present or highlighted) -->
        <HeroSummaryCard
          :profile="profile"
          @edit-profile="isProfileModalOpen = true"
          @upload-avatar="handleAvatarUpload"
        />

        <!-- 2. Gradient Stats Banner (4 Key Metrics) -->
        <StatsBanner
          :profile="profile"
          @save-metrics="handleSaveMetrics"
        />

        <!-- Tabbed Navigation Switcher (Quick Access to CRUD modules) -->
        <div class="flex items-center gap-2 overflow-x-auto pb-2 border-b border-[#235347]">
          <button
            v-for="tab in tabs"
            :key="tab.id"
            type="button"
            @click="handleTabChange(tab.id)"
            class="px-4 py-2 rounded-xl text-xs font-bold tracking-wide uppercase transition-all whitespace-nowrap flex items-center gap-2"
            :class="activeTab === tab.id
              ? 'bg-[#235347] text-[#DAF1DE] border border-[#8EB69B] shadow-[0_0_12px_rgba(142,182,155,0.3)]'
              : 'bg-[#0B2B26] text-[#8EB69B] border border-[#235347] hover:text-[#DAF1DE] hover:bg-[#163832]'"
          >
            <span>{{ tab.label }}</span>
            <span
              v-if="tab.count !== undefined"
              class="px-1.5 py-0.5 rounded-md text-[10px] font-mono bg-[#051F20] text-[#8EB69B]"
            >
              {{ tab.count }}
            </span>
          </button>
        </div>

        <!-- 3. Dynamic CRUD Modules According to Active Tab -->
        <!-- All / Dashboard Overview -->
        <div v-if="activeTab === 'dashboard'" class="space-y-10">
          <ProjectsCrud :projects="projects" @refresh="fetchData" />
          <ServicesCrud :services="services" @refresh="fetchData" />
          <SkillsCrud :skills="skills" @refresh="fetchData" />
          <EducationsCrud :educations="educations" @refresh="fetchData" />
          <ContactInboxSection
            :profile="profile"
            @refresh-profile="fetchProfile"
            @update-unread-count="(val) => unreadCount = val"
          />
        </div>

        <!-- Projects Only Tab -->
        <div v-else-if="activeTab === 'projects'">
          <ProjectsCrud :projects="projects" @refresh="fetchData" />
        </div>

        <!-- Services Only Tab -->
        <div v-else-if="activeTab === 'services'">
          <ServicesCrud :services="services" @refresh="fetchData" />
        </div>

        <!-- Skills Only Tab -->
        <div v-else-if="activeTab === 'skills'">
          <SkillsCrud :skills="skills" @refresh="fetchData" />
        </div>

        <!-- Educations Only Tab -->
        <div v-else-if="activeTab === 'educations'">
          <EducationsCrud :educations="educations" @refresh="fetchData" />
        </div>

        <!-- Contact Inbox & Contact Info Tab -->
        <div v-else-if="activeTab === 'messages' || activeTab === 'profile'">
          <ContactInboxSection
            :profile="profile"
            @refresh-profile="fetchProfile"
            @update-unread-count="(val) => unreadCount = val"
          />
        </div>
      </main>
    </div>

    <!-- Modals -->
    <ProfileEditModal
      :isOpen="isProfileModalOpen"
      :profile="profile"
      @close="isProfileModalOpen = false"
      @save-profile="handleSaveProfile"
    />

    <SocialLinksModal
      :isOpen="isSocialModalOpen"
      :socialLinks="profile?.social_links || {}"
      @close="isSocialModalOpen = false"
      @save-links="handleSaveSocialLinks"
    />
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import axios from 'axios';

import AdminSidebar from '../../components/admin/AdminSidebar.vue';
import AdminTopBar from '../../components/admin/AdminTopBar.vue';
import HeroSummaryCard from '../../components/admin/HeroSummaryCard.vue';
import StatsBanner from '../../components/admin/StatsBanner.vue';
import ServicesCrud from '../../components/admin/ServicesCrud.vue';
import ProjectsCrud from '../../components/admin/ProjectsCrud.vue';
import SkillsCrud from '../../components/admin/SkillsCrud.vue';
import EducationsCrud from '../../components/admin/EducationsCrud.vue';
import ContactInboxSection from '../../components/admin/ContactInboxSection.vue';
import ProfileEditModal from '../../components/admin/ProfileEditModal.vue';
import SocialLinksModal from '../../components/admin/SocialLinksModal.vue';

const route = useRoute();
const router = useRouter();

const isSidebarOpen = ref(false);
const isProfileModalOpen = ref(false);
const isSocialModalOpen = ref(false);
const activeTab = ref('dashboard');

const toastMessage = ref('');
const toastType = ref('success');
let toastTimer = null;

const showToast = (msg, type = 'success') => {
  toastMessage.value = msg;
  toastType.value = type;
  if (toastTimer) clearTimeout(toastTimer);
  toastTimer = setTimeout(() => {
    toastMessage.value = '';
  }, 4000);
};

// Data States
const profile = ref({});
const adminUser = ref({});
const services = ref([]);
const projects = ref([]);
const skills = ref([]);
const educations = ref([]);
const unreadCount = ref(0);

const tabs = computed(() => [
  { id: 'dashboard', label: 'Overview' },
  { id: 'projects', label: 'Projects', count: projects.value.length },
  { id: 'services', label: 'Services', count: services.value.length },
  { id: 'skills', label: 'Skills', count: skills.value.length },
  { id: 'educations', label: 'Education & Certs', count: educations.value.length },
  { id: 'messages', label: 'Contact Inbox', count: unreadCount.value },
]);

const handleTabChange = (tabId) => {
  activeTab.value = tabId;
  router.push(`/admin/${tabId}`);
};

// Fetch initial data
const fetchProfile = async () => {
  try {
    const res = await axios.get('/api/admin/profile');
    if (res.data && res.data.success) {
      profile.value = res.data.data;
    }
  } catch (err) {
    console.error('Error fetching admin profile:', err);
  }
};

const fetchData = async () => {
  try {
    const [servRes, projRes, skillRes, eduRes, msgRes] = await Promise.all([
      axios.get('/api/admin/services'),
      axios.get('/api/admin/projects'),
      axios.get('/api/admin/skills'),
      axios.get('/api/admin/educations'),
      axios.get('/api/admin/messages'),
    ]);

    if (servRes.data?.success) services.value = servRes.data.data;
    if (projRes.data?.success) projects.value = projRes.data.data;
    if (skillRes.data?.success) skills.value = skillRes.data.data;
    if (eduRes.data?.success) educations.value = eduRes.data.data;
    if (msgRes.data?.success) unreadCount.value = msgRes.data.unread_count ?? 0;
  } catch (err) {
    console.error('Error fetching admin data:', err);
  }
};

// Freelance Switch Toggle
const handleToggleFreelance = async () => {
  try {
    const newStatus = !profile.value.is_available;
    profile.value.is_available = newStatus;
    await axios.post('/api/admin/profile', {
      is_available: newStatus ? 1 : 0,
    });
    showToast(`Status ketersediaan freelance diubah menjadi: ${newStatus ? 'TERSEDIA' : 'TIDAK TERSEDIA'}`);
  } catch (err) {
    console.error('Error toggling freelance status:', err);
    showToast('Gagal mengubah status freelance.', 'error');
  }
};

// Handle CV Upload
const handleCvUpload = async (file) => {
  try {
    const formData = new FormData();
    formData.append('cv_file', file);
    const res = await axios.post('/api/admin/profile', formData);
    if (res.data?.success) {
      profile.value = res.data.data;
      showToast('File CV (PDF) berhasil diunggah!');
    }
  } catch (err) {
    console.error('Error uploading CV:', err);
    showToast('Gagal mengunggah file CV (Pastikan format PDF max 5MB).', 'error');
  }
};

// Handle Avatar Upload from Hero Card
const handleAvatarUpload = async (file) => {
  try {
    const formData = new FormData();
    formData.append('avatar', file);
    const res = await axios.post('/api/admin/profile', formData);
    if (res.data?.success) {
      profile.value = res.data.data;
      showToast('Foto profil berhasil diperbarui!');
    }
  } catch (err) {
    console.error('Error uploading avatar:', err);
    showToast('Gagal mengunggah foto profil.', 'error');
  }
};

// Handle Save Stats Metrics
const handleSaveMetrics = async (metrics, callback) => {
  try {
    const res = await axios.post('/api/admin/profile', metrics);
    if (res.data?.success) {
      profile.value = res.data.data;
      showToast('Angka statistik berhasil diperbarui!');
      if (callback) callback();
    }
  } catch (err) {
    console.error('Error saving metrics:', err);
    showToast('Gagal menyimpan metrik statistik.', 'error');
    if (callback) callback();
  }
};

// Handle Save Full Profile
const handleSaveProfile = async (formDataPayload, callback) => {
  try {
    const formData = new FormData();
    formData.append('name', formDataPayload.name);
    formData.append('roles', JSON.stringify(formDataPayload.roles));
    formData.append('short_bio', formDataPayload.short_bio);
    formData.append('about_me', formDataPayload.about_me);

    if (formDataPayload.avatar) {
      formData.append('avatar', formDataPayload.avatar);
    }

    const res = await axios.post('/api/admin/profile', formData);
    if (res.data?.success) {
      profile.value = res.data.data;
      showToast('Profil berhasil disimpan!');
      if (callback) callback();
    }
  } catch (err) {
    console.error('Error updating profile:', err);
    showToast('Gagal memperbarui profil.', 'error');
    if (callback) callback();
  }
};

// Handle Save Social Links
const handleSaveSocialLinks = async (links, callback) => {
  try {
    const res = await axios.post('/api/admin/profile', {
      social_links: links,
    });
    if (res.data?.success) {
      profile.value = res.data.data;
      showToast('Tautan sosial media berhasil diperbarui!');
      if (callback) callback();
    }
  } catch (err) {
    console.error('Error updating social links:', err);
    showToast('Gagal memperbarui tautan sosial media.', 'error');
    if (callback) callback();
  }
};

onMounted(() => {
  // Sync tab with URL param if available
  const tabParam = route.params.tab;
  if (tabParam && ['dashboard', 'projects', 'services', 'skills', 'educations', 'messages', 'profile'].includes(tabParam)) {
    activeTab.value = tabParam;
  }

  // Load user from storage
  const savedUser = localStorage.getItem('admin_user');
  if (savedUser) {
    try {
      adminUser.value = JSON.parse(savedUser);
    } catch (e) {}
  }

  fetchProfile();
  fetchData();
});
</script>
