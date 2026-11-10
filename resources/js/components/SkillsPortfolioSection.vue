<template>
  <div id="portfolio" class="relative py-12 z-10 space-y-24">
    <!-- Part 1: My Skills (Progress Bars) -->
    <SectionContainer
      id="skills-overview"
      badge="Competencies"
      title="My Skills & <span class='text-sage-400'>Proficiency</span>"
      description="Core technical proficiencies across backend architecture and modern web systems."
    >
      <!-- Glassmorphism Card with Illustration on Left & Progress Bars on Right -->
      <GlassCard
        variant="primary"
        class="relative overflow-hidden"
      >
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-center">
          <!-- Left: Engineering Philosophy & Focus -->
          <div class="lg:col-span-5 flex flex-col justify-center space-y-4">
            <h3 class="text-2xl sm:text-3xl font-extrabold text-mint-100 tracking-tight leading-snug">
              Engineering Scalable & Resilient Systems
            </h3>
            <p class="text-sm text-sage-400/90 leading-relaxed">
              Fokus pada rekayasa perangkat lunak yang andal, pemeliharaan kode bersih, serta antarmuka interaktif yang cepat dan terukur.
            </p>

            <div class="pt-2 grid grid-cols-2 gap-3">
              <div class="p-3.5 rounded-xl bg-forest-900/80 border border-forest-700/80 ring-1 ring-sage-400/10">
                <span class="text-xs font-bold text-mint-100 block">Modern Backend</span>
                <span class="text-[11px] text-sage-400/80 block mt-0.5">Laravel, MySQL, REST API</span>
              </div>
              <div class="p-3.5 rounded-xl bg-forest-900/80 border border-forest-700/80 ring-1 ring-sage-400/10">
                <span class="text-xs font-bold text-mint-100 block">Reactive Frontend</span>
                <span class="text-[11px] text-sage-400/80 block mt-0.5">Vue 3, Tailwind CSS</span>
              </div>
            </div>
          </div>

          <!-- Right: Horizontal Progress Bars -->
          <div class="lg:col-span-7 space-y-6">
            <div
              v-for="skill in progressSkills"
              :key="skill.id || skill.name"
              class="group"
            >
              <!-- Skill Name & Percentage -->
              <div class="flex items-center justify-between mb-2">
                <span class="text-sm sm:text-base font-semibold text-mint-100 group-hover:text-sage-400 transition-colors">
                  {{ skill.name }}
                </span>
                <span class="text-sm font-mono font-bold text-sage-400">
                  {{ skill.percentage }}%
                </span>
              </div>

              <!-- Track & Bar with Glow -->
              <div class="w-full h-3 rounded-full bg-forest-900 border border-forest-700/80 overflow-hidden p-0.5 ring-1 ring-sage-400/10">
                <div
                  class="h-full rounded-full bg-gradient-to-r from-forest-700 to-sage-400 shadow-[0_0_12px_rgba(142,182,155,0.5)] transition-all duration-1000 ease-out"
                  :style="{ width: `${skill.percentage}%` }"
                ></div>
              </div>
            </div>
          </div>
        </div>
      </GlassCard>
    </SectionContainer>

    <!-- Part 2: My Portfolio Grid (3x2) -->
    <SectionContainer
      id="portfolio-grid"
      badge="Selected Works"
      title="My <span class='text-sage-400'>Portfolio</span>"
      description="Explore a curation of web applications, platforms, and interactive interfaces built with passion."
    >
      <!-- Category Filter Tabs with Micro-interactions -->
      <div class="flex flex-wrap items-center justify-center gap-2 mb-10">
        <button
          v-for="cat in categories"
          :key="cat"
          @click="selectedCategory = cat"
          type="button"
          class="px-4 py-1.5 rounded-full text-xs font-semibold tracking-wide transition-all duration-300 active:scale-95"
          :class="selectedCategory === cat ? 'bg-forest-700 text-mint-100 border border-sage-400 ring-1 ring-sage-400/30 shadow-[0_0_15px_rgba(142,182,155,0.3)]' : 'bg-forest-900/80 text-sage-400/70 border border-forest-700 hover:text-mint-100 hover:bg-forest-800'"
        >
          {{ cat }}
        </button>
      </div>

      <!-- 3x2 Grid Display (6 Projects) -->
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <GlassCard
          v-for="project in filteredProjects"
          :key="project.id || project.slug || project.title"
          variant="secondary"
          hoverable
          class="flex flex-col justify-between group overflow-hidden !p-0 transition-all duration-300 hover:-translate-y-1 hover:border-sage-400/80 ring-1 ring-transparent hover:ring-sage-400/30"
        >
          <!-- Thumbnail Image -->
          <div class="relative h-48 overflow-hidden border-b border-forest-700/80">
            <img
              :src="project.thumbnail_url || project.thumbnail || 'https://images.unsplash.com/photo-1507238691740-187a5b1d37b8?auto=format&fit=crop&w=800&q=80'"
              :alt="project.title"
              class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105"
            />
            <div class="absolute inset-0 bg-gradient-to-t from-forest-950/90 via-transparent to-transparent"></div>
            <!-- Category Tag -->
            <span class="absolute top-3 left-3 px-2.5 py-0.5 text-[10px] font-semibold tracking-wider uppercase bg-forest-950/80 text-sage-400 border border-forest-700 rounded-md backdrop-blur-md">
              {{ project.category }}
            </span>
          </div>

          <!-- Project Body -->
          <div class="p-5 flex-1 flex flex-col justify-between">
            <div>
              <h3 class="text-lg font-bold text-mint-100 group-hover:text-sage-400 transition-colors mb-2 line-clamp-1 tracking-tight">
                {{ project.title }}
              </h3>
              <p class="text-xs text-mint-100/75 leading-relaxed line-clamp-2 mb-4">
                {{ project.description }}
              </p>

              <!-- Tech Stack Badges -->
              <div class="flex flex-wrap gap-1.5 mb-5">
                <span
                  v-for="(tag, idx) in project.tech_stack"
                  :key="idx"
                  class="bg-forest-700 text-mint-100 text-[11px] px-2.5 py-0.5 rounded-md font-medium border border-forest-700/60"
                >
                  {{ tag }}
                </span>
              </div>
            </div>

            <!-- Card Bottom Actions -->
            <div class="flex items-center justify-between pt-3 border-t border-forest-700/50">
              <button
                @click="openModal(project)"
                type="button"
                class="text-xs text-sage-400 font-semibold hover:text-mint-100 inline-flex items-center gap-1 group/btn transition-colors"
              >
                <span>Details</span>
                <svg class="w-3 h-3 group-hover/btn:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
              </button>

              <div class="flex items-center gap-2">
                <a
                  v-if="project.url_repo"
                  :href="project.url_repo"
                  target="_blank"
                  title="Source Code"
                  class="w-8 h-8 rounded-full bg-forest-800 text-sage-400 hover:text-mint-100 hover:bg-forest-700 flex items-center justify-center transition-all active:scale-90 border border-forest-700 hover:border-sage-400/50"
                >
                  <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.53 1.032 1.53 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z" />
                  </svg>
                </a>
                <a
                  v-if="project.url_demo"
                  :href="project.url_demo"
                  target="_blank"
                  title="Live Demo"
                  class="w-8 h-8 rounded-full bg-forest-800 text-sage-400 hover:text-mint-100 hover:bg-forest-700 flex items-center justify-center transition-all active:scale-90 border border-forest-700 hover:border-sage-400/50"
                >
                  <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                  </svg>
                </a>
              </div>
            </div>
          </div>
        </GlassCard>
      </div>
    </SectionContainer>

    <!-- Detail Modal using AdminModal -->
    <AdminModal
      :show="!!activeModalProject"
      :title="activeModalProject?.title || 'Project Detail'"
      max-width="2xl"
      @close="activeModalProject = null"
    >
      <div v-if="activeModalProject" class="space-y-4">
        <span class="inline-block px-2.5 py-0.5 text-xs uppercase tracking-wider text-sage-400 font-semibold font-mono bg-forest-800 rounded border border-forest-700">
          {{ activeModalProject.category }}
        </span>

        <div class="rounded-xl overflow-hidden border border-forest-700 max-h-72 ring-1 ring-sage-400/20">
          <img
            :src="activeModalProject.thumbnail_url || activeModalProject.thumbnail"
            :alt="activeModalProject.title"
            class="w-full h-full object-cover"
          />
        </div>

        <p class="text-sm text-mint-100/90 leading-relaxed whitespace-pre-line">
          {{ activeModalProject.description }}
        </p>

        <div>
          <span class="text-xs uppercase text-sage-400 font-semibold block mb-2 font-mono">Technologies Used:</span>
          <div class="flex flex-wrap gap-2">
            <span
              v-for="(tech, i) in activeModalProject.tech_stack"
              :key="i"
              class="px-3 py-1 rounded-md text-xs font-mono bg-forest-800 text-mint-100 border border-forest-700"
            >
              {{ tech }}
            </span>
          </div>
        </div>
      </div>

      <template #footer>
        <div v-if="activeModalProject" class="w-full flex items-center justify-between gap-3">
          <div class="flex items-center gap-2">
            <BaseButton
              v-if="activeModalProject.url_demo"
              variant="primary"
              size="sm"
              as="a"
              :href="activeModalProject.url_demo"
              target="_blank"
            >
              <span>Visit Demo</span>
              <template #icon-right>
                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                </svg>
              </template>
            </BaseButton>

            <BaseButton
              v-if="activeModalProject.url_repo"
              variant="glass"
              size="sm"
              as="a"
              :href="activeModalProject.url_repo"
              target="_blank"
            >
              <span>Repository</span>
            </BaseButton>
          </div>

          <BaseButton
            variant="ghost"
            size="sm"
            @click="activeModalProject = null"
          >
            <span>Close</span>
          </BaseButton>
        </div>
      </template>
    </AdminModal>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue';
import SectionContainer from './ui/SectionContainer.vue';
import GlassCard from './ui/GlassCard.vue';
import BaseButton from './ui/BaseButton.vue';
import AdminModal from './ui/AdminModal.vue';

const props = defineProps({
  skills: {
    type: Object,
    default: () => ({
      progress_bars: [],
    }),
  },
  projects: {
    type: Array,
    default: () => [],
  },
});

const selectedCategory = ref('All');
const activeModalProject = ref(null);

const defaultProgressSkills = [
  { name: 'Backend Architecture & API Development', percentage: 92 },
  { name: 'Frontend UI/UX Implementation', percentage: 88 },
  { name: 'Relational Database Design & Query Tuning', percentage: 85 },
  { name: 'Responsive Design & Accessibility', percentage: 95 },
  { name: 'System Security & Authentication (Sanctum/OAuth)', percentage: 86 },
];

const progressSkills = computed(() => {
  if (props.skills?.progress_bars && props.skills.progress_bars.length > 0) {
    return props.skills.progress_bars;
  }
  return defaultProgressSkills;
});

const defaultProjects = [
  {
    title: 'Enterprise Resource Planning (ERP) System',
    slug: 'erp-system',
    category: 'Web Application',
    description: 'Platform ERP modern untuk enterprise dengan manajemen inventaris realtime, pelaporan akuntansi otomatis, manajemen multi-cabang, dan role-based access control yang aman.',
    thumbnail_url: 'https://images.unsplash.com/photo-1460925895917-afdab827c52f?auto=format&fit=crop&w=800&q=80',
    tech_stack: ['Laravel 11', 'Vue 3', 'Tailwind CSS', 'MySQL', 'Chart.js'],
    url_demo: 'https://erp.demo.portofolio.id',
    url_repo: 'https://github.com/Tiannn-r/Portofolio',
  },
  {
    title: 'Multi-Vendor Marketplace & Checkout Platform',
    slug: 'ecommerce-platform',
    category: 'E-Commerce',
    description: 'Aplikasi e-commerce lengkap dengan cart realtime, integrasi pembayaran digital, pelacakan kurir otomatis, serta dashboard analitik penjualan bagi merchant.',
    thumbnail_url: 'https://images.unsplash.com/photo-1557821552-17105176677c?auto=format&fit=crop&w=800&q=80',
    tech_stack: ['Laravel 11', 'Vue 3', 'Pinia', 'Tailwind CSS', 'Midtrans API'],
    url_demo: 'https://shop.demo.portofolio.id',
    url_repo: 'https://github.com/Tiannn-r/Portofolio',
  },
  {
    title: 'Personal Portfolio & Admin CMS Engine',
    slug: 'portfolio-cms',
    category: 'Full-Stack Web',
    description: 'Sistem website portofolio interaktif yang terhubung langsung ke Content Management System (CMS) Admin dengan autentikasi Sanctum dan manajemen pesan kontak.',
    thumbnail_url: 'https://images.unsplash.com/photo-1507238691740-187a5b1d37b8?auto=format&fit=crop&w=800&q=80',
    tech_stack: ['Laravel 11', 'Sanctum', 'Vue 3', 'Tailwind CSS', 'MySQL'],
    url_demo: 'https://portofolio.id',
    url_repo: 'https://github.com/Tiannn-r/Portofolio',
  },
  {
    title: 'Healthcare Clinic Appointment & Electronic Medical Record',
    slug: 'clinic-system',
    category: 'HealthTech',
    description: 'Aplikasi booking janji temu dokter online dengan notifikasi pengingat via WhatsApp dan rekam medis elektronik terenkripsi.',
    thumbnail_url: 'https://images.unsplash.com/photo-1576091160399-112ba8d25d1d?auto=format&fit=crop&w=800&q=80',
    tech_stack: ['Laravel 11', 'Vue.js', 'MySQL', 'Tailwind CSS'],
    url_demo: 'https://clinic.demo.portofolio.id',
    url_repo: 'https://github.com/Tiannn-r/Portofolio',
  },
  {
    title: 'SaaS Analytics & Performance Monitoring',
    slug: 'saas-analytics',
    category: 'Web Application',
    description: 'Dashboard metrik performa cloud server, visualisasi throughput data time-series, dan sistem alarm peringatan kegagalan server.',
    thumbnail_url: 'https://images.unsplash.com/photo-1551288049-bebda4e38f71?auto=format&fit=crop&w=800&q=80',
    tech_stack: ['Vue 3', 'Laravel', 'PostgreSQL', 'Redis'],
    url_demo: 'https://analytics.demo.portofolio.id',
    url_repo: 'https://github.com/Tiannn-r/Portofolio',
  },
  {
    title: 'Real-Time Team Collaboration Suite',
    slug: 'collaboration-suite',
    category: 'Full-Stack Web',
    description: 'Aplikasi kolaborasi kerja tim dengan kanban board interaktif, live document editing via websockets, dan video conference terintegrasi.',
    thumbnail_url: 'https://images.unsplash.com/photo-1522071820081-009f0129c71c?auto=format&fit=crop&w=800&q=80',
    tech_stack: ['Laravel', 'Vue 3', 'WebSockets', 'Tailwind CSS'],
    url_demo: 'https://collab.demo.portofolio.id',
    url_repo: 'https://github.com/Tiannn-r/Portofolio',
  },
];

const allProjects = computed(() => {
  if (props.projects && props.projects.length > 0) {
    if (props.projects.length >= 6) return props.projects;
    const combined = [...props.projects];
    for (const dp of defaultProjects) {
      if (!combined.some(p => p.title === dp.title)) {
        combined.push(dp);
      }
      if (combined.length >= 6) break;
    }
    return combined;
  }
  return defaultProjects;
});

const categories = computed(() => {
  const cats = new Set(['All']);
  allProjects.value.forEach(p => {
    if (p.category) cats.add(p.category);
  });
  return Array.from(cats);
});

const filteredProjects = computed(() => {
  if (selectedCategory.value === 'All') {
    return allProjects.value.slice(0, 6);
  }
  return allProjects.value.filter(p => p.category === selectedCategory.value).slice(0, 6);
});

const openModal = (project) => {
  activeModalProject.value = project;
};
</script>
