<template>
  <header class="sticky top-0 z-20 bg-[#051F20]/90 backdrop-blur-md border-b border-[#235347] px-4 sm:px-8 py-3.5 flex items-center justify-between shadow-[0_4px_20px_rgba(5,31,32,0.6)]">
    <!-- Left: Mobile Menu Toggle & Breadcrumb -->
    <div class="flex items-center gap-3">
      <!-- Mobile Sidebar Toggle -->
      <button
        type="button"
        @click="$emit('toggle-sidebar')"
        class="lg:hidden p-2 rounded-xl bg-[#0B2B26] border border-[#235347] text-[#8EB69B] hover:text-[#DAF1DE] transition-colors"
      >
        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
        </svg>
      </button>

      <!-- Breadcrumbs -->
      <div class="flex items-center gap-2 text-xs">
        <span class="text-[#8EB69B]/70 font-mono">CMS</span>
        <span class="text-[#235347]">/</span>
        <span class="font-bold text-[#DAF1DE] capitalize">{{ activeTabLabel }}</span>
      </div>
    </div>

    <!-- Right: Quick Actions & Preview Website Button -->
    <div class="flex items-center gap-3">
      <!-- Quick Status -->
      <div class="hidden sm:flex items-center gap-2 px-3 py-1 rounded-full bg-[#0B2B26] border border-[#235347] text-[11px] text-[#8EB69B]">
        <span class="w-2 h-2 rounded-full bg-[#8EB69B] animate-pulse"></span>
        <span>MySQL Connected</span>
      </div>

      <!-- Preview Website Button -->
      <a
        href="/"
        target="_blank"
        title="Buka Website Portofolio Publik di Tab Baru"
        class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-[#235347] hover:bg-[#8EB69B] text-[#DAF1DE] hover:text-[#051F20] font-semibold text-xs tracking-wide transition-all duration-300 shadow-[0_0_15px_rgba(142,182,155,0.2)] hover:shadow-[0_0_20px_rgba(142,182,155,0.4)]"
      >
        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
        </svg>
        <span class="hidden sm:inline">Preview Website</span>
      </a>
    </div>
  </header>
</template>

<script setup>
import { computed } from 'vue';

const props = defineProps({
  activeTab: {
    type: String,
    default: 'dashboard',
  },
});

defineEmits(['toggle-sidebar']);

const activeTabLabel = computed(() => {
  const map = {
    dashboard: 'Dashboard Overview',
    profile: 'About & Profile Details',
    services: 'Services Management',
    projects: 'Portfolio Projects',
    skills: 'Skills & Proficiencies',
    educations: 'Education & Certifications',
    messages: 'Contact Messages Inbox',
  };
  return map[props.activeTab] || props.activeTab;
});
</script>

