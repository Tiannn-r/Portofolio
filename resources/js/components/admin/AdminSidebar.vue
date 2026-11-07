<template>
  <aside
    class="fixed inset-y-0 left-0 z-40 w-72 bg-[#0B2B26] border-r border-[#235347] flex flex-col justify-between transition-transform duration-300 lg:translate-x-0 shadow-[10px_0_30px_rgba(5,31,32,0.8)]"
    :class="isOpen ? 'translate-x-0' : '-translate-x-full'"
  >
    <!-- Top Part: Logo, Admin Profile & Navigation -->
    <div class="flex-1 overflow-y-auto px-4 py-6 scrollbar-thin">
      <!-- Admin Identity Header -->
      <div class="flex items-center gap-3.5 px-2 mb-8">
        <div class="w-12 h-12 rounded-2xl bg-[#163832] border border-[#8EB69B]/50 flex items-center justify-center text-[#8EB69B] font-extrabold text-lg shadow-[0_0_15px_rgba(142,182,155,0.25)] shrink-0">
          MI
        </div>
        <div class="overflow-hidden">
          <h2 class="text-base font-bold text-[#DAF1DE] truncate">
            {{ adminUser?.name || profile?.name || 'Muhamad Ibnhu' }}
          </h2>
          <span class="inline-flex items-center gap-1.5 text-xs text-[#8EB69B]">
            <span class="w-1.5 h-1.5 rounded-full bg-[#8EB69B] animate-pulse"></span>
            Super Administrator
          </span>
        </div>
      </div>

      <!-- Navigation Menu -->
      <nav class="space-y-1.5">
        <button
          v-for="item in navMenuItems"
          :key="item.id"
          type="button"
          @click="selectTab(item.id)"
          class="w-full flex items-center justify-between px-3.5 py-2.5 rounded-xl text-xs font-semibold tracking-wide transition-all duration-200 text-left group"
          :class="activeTab === item.id
            ? 'bg-[#235347] text-[#DAF1DE] border-l-4 border-[#8EB69B] shadow-[0_0_15px_rgba(142,182,155,0.2)]'
            : 'text-[#8EB69B] hover:text-[#DAF1DE] hover:bg-[#163832]/60'"
        >
          <div class="flex items-center gap-3">
            <component :is="item.icon" class="w-4 h-4 text-[#8EB69B] group-hover:scale-110 transition-transform" />
            <span>{{ item.label }}</span>
          </div>

          <!-- Unread Badge for Messages -->
          <span
            v-if="item.id === 'messages' && unreadMessagesCount > 0"
            class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-[#8EB69B] text-[#051F20] shadow-[0_0_8px_#8EB69B]"
          >
            {{ unreadMessagesCount }}
          </span>
        </button>
      </nav>
    </div>

    <!-- Bottom Part: Freelance Switch, CV File Upload & Social Links -->
    <div class="p-4 border-t border-[#235347] bg-[#0B2B26]/95 space-y-3">
      <!-- Gradient Freelance Card with Toggle Switch -->
      <div class="p-3.5 rounded-xl bg-gradient-to-r from-[#163832] to-[#235347] border border-[#8EB69B]/40 shadow-[0_0_15px_rgba(142,182,155,0.15)]">
        <div class="flex items-center justify-between">
          <div class="flex-1 pr-2">
            <span class="text-[11px] font-bold text-[#DAF1DE] block leading-tight">
              Available for Freelance
            </span>
            <span class="text-[10px] text-[#8EB69B] block mt-0.5">
              {{ profile?.is_available ? 'Status: Active & Open' : 'Status: Busy / Closed' }}
            </span>
          </div>

          <!-- Switch Toggle Button -->
          <button
            type="button"
            @click="toggleAvailability"
            class="relative inline-flex h-5 w-10 shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none"
            :class="profile?.is_available ? 'bg-[#8EB69B]' : 'bg-[#051F20]'"
          >
            <span
              class="pointer-events-none inline-block h-4 w-4 transform rounded-full bg-[#DAF1DE] shadow ring-0 transition duration-200 ease-in-out"
              :class="profile?.is_available ? 'translate-x-5' : 'translate-x-0'"
            />
          </button>
        </div>
      </div>

      <!-- CV File Upload / Preview -->
      <div class="p-3 rounded-xl bg-[#163832]/60 border border-[#235347] flex items-center justify-between text-xs">
        <div class="flex items-center gap-2 overflow-hidden">
          <svg class="w-4 h-4 text-[#8EB69B] shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
          </svg>
          <div class="overflow-hidden">
            <span class="text-[11px] font-semibold text-[#DAF1DE] block truncate">
              {{ profile?.cv_file ? 'CV-Muhamad-Ibnhu.pdf' : 'Belum ada CV' }}
            </span>
            <span class="text-[10px] text-[#8EB69B] block">Format: PDF</span>
          </div>
        </div>

        <label class="cursor-pointer px-2 py-1 rounded bg-[#235347] text-[#DAF1DE] hover:bg-[#8EB69B] hover:text-[#051F20] text-[10px] font-semibold transition-colors shrink-0">
          <span>Upload</span>
          <input type="file" accept=".pdf" class="hidden" @change="handleCvUpload" />
        </label>
      </div>

      <!-- Social Media Links Modal Trigger & Logout -->
      <div class="flex items-center justify-between pt-1">
        <button
          type="button"
          @click="$emit('open-social-modal')"
          class="text-[11px] text-[#8EB69B] hover:text-[#DAF1DE] inline-flex items-center gap-1 transition-colors"
        >
          <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />
          </svg>
          <span>Social Links</span>
        </button>

        <button
          type="button"
          @click="logout"
          class="text-[11px] text-red-400 hover:text-red-300 inline-flex items-center gap-1 transition-colors"
        >
          <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
          </svg>
          <span>Logout</span>
        </button>
      </div>
    </div>
  </aside>

  <!-- Mobile Backdrop Overlay -->
  <div
    v-if="isOpen"
    @click="$emit('close-sidebar')"
    class="fixed inset-0 z-30 bg-black/60 backdrop-blur-sm lg:hidden"
  ></div>
</template>

<script setup>
import { h } from 'vue';
import { useRouter } from 'vue-router';
import axios from 'axios';

const props = defineProps({
  isOpen: {
    type: Boolean,
    default: false,
  },
  activeTab: {
    type: String,
    default: 'dashboard',
  },
  profile: {
    type: Object,
    default: () => ({}),
  },
  adminUser: {
    type: Object,
    default: () => ({}),
  },
  unreadMessagesCount: {
    type: Number,
    default: 0,
  },
});

const emit = defineEmits(['update-tab', 'toggle-freelance', 'upload-cv', 'open-social-modal', 'close-sidebar']);
const router = useRouter();

// SVG Icons
const IconHome = () => h('svg', { fill: 'none', viewBox: '0 0 24 24', stroke: 'currentColor', 'stroke-width': 1.8 }, [
  h('path', { 'stroke-linecap': 'round', 'stroke-linejoin': 'round', d: 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6' })
]);

const IconUser = () => h('svg', { fill: 'none', viewBox: '0 0 24 24', stroke: 'currentColor', 'stroke-width': 1.8 }, [
  h('path', { 'stroke-linecap': 'round', 'stroke-linejoin': 'round', d: 'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z' })
]);

const IconBriefcase = () => h('svg', { fill: 'none', viewBox: '0 0 24 24', stroke: 'currentColor', 'stroke-width': 1.8 }, [
  h('path', { 'stroke-linecap': 'round', 'stroke-linejoin': 'round', d: 'M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z' })
]);

const IconFolder = () => h('svg', { fill: 'none', viewBox: '0 0 24 24', stroke: 'currentColor', 'stroke-width': 1.8 }, [
  h('path', { 'stroke-linecap': 'round', 'stroke-linejoin': 'round', d: 'M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10' })
]);

const IconBolt = () => h('svg', { fill: 'none', viewBox: '0 0 24 24', stroke: 'currentColor', 'stroke-width': 1.8 }, [
  h('path', { 'stroke-linecap': 'round', 'stroke-linejoin': 'round', d: 'M13 10V3L4 14h7v7l9-11h-7z' })
]);

const IconAcademic = () => h('svg', { fill: 'none', viewBox: '0 0 24 24', stroke: 'currentColor', 'stroke-width': 1.8 }, [
  h('path', { 'stroke-linecap': 'round', 'stroke-linejoin': 'round', d: 'M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5' })
]);

const IconMail = () => h('svg', { fill: 'none', viewBox: '0 0 24 24', stroke: 'currentColor', 'stroke-width': 1.8 }, [
  h('path', { 'stroke-linecap': 'round', 'stroke-linejoin': 'round', d: 'M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z' })
]);

const navMenuItems = [
  { id: 'dashboard', label: 'Dashboard Overview', icon: IconHome },
  { id: 'profile', label: 'About & Profile', icon: IconUser },
  { id: 'services', label: 'Services', icon: IconBriefcase },
  { id: 'projects', label: 'Portfolio Projects', icon: IconFolder },
  { id: 'skills', label: 'Skills & Proficiencies', icon: IconBolt },
  { id: 'educations', label: 'Education & Certs', icon: IconAcademic },
  { id: 'messages', label: 'Contact Inbox', icon: IconMail },
];

const selectTab = (tabId) => {
  emit('update-tab', tabId);
  emit('close-sidebar');
};

const toggleAvailability = () => {
  emit('toggle-freelance');
};

const handleCvUpload = (e) => {
  const file = e.target.files[0];
  if (file) {
    emit('upload-cv', file);
  }
};

const logout = async () => {
  try {
    await axios.post('/api/admin/logout');
  } catch (err) {
    console.warn('Logout API error:', err);
  } finally {
    localStorage.removeItem('admin_token');
    localStorage.removeItem('admin_user');
    delete axios.defaults.headers.common['Authorization'];
    router.push('/admin/login');
  }
};
</script>
