<template>
  <section id="portfolio" class="relative py-20 z-10">
    <!-- Part 1: My Skills (Progress Bars) -->
    <div id="skills" class="mb-24">
      <div class="text-center mb-12">
        <span class="inline-block px-3 py-1 text-xs font-semibold tracking-widest text-sage-400 uppercase bg-forest-900 border border-forest-700 rounded-full mb-3 shadow-[0_0_10px_rgba(142,182,155,0.15)]">
          Core Competencies
        </span>
        <h2 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-mint-100">
          My Skills & <span class="text-sage-400">Proficiency</span>
        </h2>
        <p class="mt-3 text-sage-400/80 max-w-xl mx-auto text-sm sm:text-base">
          Quantitative assessment of my engineering and interface development proficiencies.
        </p>
      </div>

      <!-- Glassmorphism Card with Illustration on Left & Progress Bars on Right -->
      <div class="bg-forest-800/60 backdrop-blur-md border border-sage-400/25 rounded-2xl p-6 sm:p-10 shadow-[0_10px_35px_rgba(5,31,32,0.6)] relative overflow-hidden">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-center">
          <!-- Left: Futuristic Illustration / Code Visualizer -->
          <div class="lg:col-span-5 flex flex-col items-center justify-center">
            <div class="w-full max-w-sm bg-forest-950/90 border border-forest-700 rounded-2xl p-5 shadow-[0_0_25px_rgba(142,182,155,0.15)] relative">
              <!-- Window dots -->
              <div class="flex items-center gap-1.5 mb-4 pb-3 border-b border-forest-700/60">
                <span class="w-3 h-3 rounded-full bg-red-500/80"></span>
                <span class="w-3 h-3 rounded-full bg-yellow-500/80"></span>
                <span class="w-3 h-3 rounded-full bg-sage-400 shadow-[0_0_8px_#8EB69B]"></span>
                <span class="ml-2 text-[11px] font-mono text-sage-400/70">developer-skills.config.ts</span>
              </div>

              <!-- Code snippet illustration -->
              <div class="space-y-2 font-mono text-xs">
                <p class="text-sage-400/60">// Full-Stack Mastery</p>
                <p class="text-mint-100"><span class="text-sage-400 font-bold">const</span> developer = {</p>
                <p class="text-mint-100/90 pl-4">mindset: <span class="text-emerald-400">'Scalable & Resilient'</span>,</p>
                <p class="text-mint-100/90 pl-4">backend: [<span class="text-emerald-400">'Laravel'</span>, <span class="text-emerald-400">'MySQL'</span>, <span class="text-emerald-400">'REST API'</span>],</p>
                <p class="text-mint-100/90 pl-4">frontend: [<span class="text-emerald-400">'Vue 3'</span>, <span class="text-emerald-400">'Tailwind CSS'</span>],</p>
                <p class="text-mint-100/90 pl-4">cleanCode: <span class="text-sage-400">true</span>,</p>
                <p class="text-mint-100/90 pl-4">testDriven: <span class="text-sage-400">true</span>,</p>
                <p class="text-mint-100">};</p>
              </div>

              <!-- Floating Accent Badge -->
              <div class="mt-5 p-3 rounded-xl bg-forest-900 border border-sage-400/30 flex items-center gap-3">
                <div class="w-9 h-9 rounded-lg bg-forest-800 flex items-center justify-center text-sage-400 shrink-0">
                  <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                  </svg>
                </div>
                <div>
                  <h5 class="text-xs font-bold text-mint-100">High Execution Velocity</h5>
                  <p class="text-[11px] text-sage-400/80">Rapid prototyping to production.</p>
                </div>
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

              <!-- Track & Bar -->
              <div class="w-full h-3 rounded-full bg-forest-900 border border-forest-700/80 overflow-hidden p-0.5">
                <div
                  class="h-full rounded-full bg-gradient-to-r from-forest-700 to-sage-400 shadow-[0_0_12px_rgba(142,182,155,0.5)] transition-all duration-1000 ease-out"
                  :style="{ width: `${skill.percentage}%` }"
                ></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Part 2: My Portfolio Grid (3x2) -->
    <div>
      <div class="text-center mb-10">
        <span class="inline-block px-3 py-1 text-xs font-semibold tracking-widest text-sage-400 uppercase bg-forest-900 border border-forest-700 rounded-full mb-3 shadow-[0_0_10px_rgba(142,182,155,0.15)]">
          Selected Works
        </span>
        <h2 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-mint-100">
          My <span class="text-sage-400">Portfolio</span>
        </h2>
        <p class="mt-3 text-sage-400/80 max-w-xl mx-auto text-sm sm:text-base">
          Explore a curation of web applications, platforms, and interactive interfaces built with passion.
        </p>
      </div>

      <!-- Category Filter Tabs -->
      <div class="flex flex-wrap items-center justify-center gap-2 mb-10">
        <button
          v-for="cat in categories"
          :key="cat"
          @click="selectedCategory = cat"
          type="button"
          class="px-4 py-1.5 rounded-full text-xs font-semibold tracking-wide transition-all duration-300"
          :class="selectedCategory === cat ? 'bg-forest-700 text-mint-100 border border-sage-400 shadow-[0_0_15px_rgba(142,182,155,0.3)]' : 'bg-forest-900/80 text-sage-400/70 border border-forest-700 hover:text-mint-100 hover:bg-forest-800'"
        >
          {{ cat }}
        </button>
      </div>

      <!-- 3x2 Grid Display (6 Projects) -->
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <div
          v-for="project in filteredProjects"
          :key="project.id || project.slug || project.title"
          class="group bg-forest-900/90 border border-forest-700 hover:border-sage-400 rounded-2xl overflow-hidden hover:scale-[1.02] hover:shadow-[0_0_25px_rgba(142,182,155,0.25)] transition-all duration-300 flex flex-col justify-between"
        >
          <!-- Thumbnail Image -->
          <div class="relative h-48 overflow-hidden border-b border-forest-700/80">
            <img
              :src="project.thumbnail_url || project.thumbnail || 'https://images.unsplash.com/photo-1507238691740-187a5b1d37b8?auto=format&fit=crop&w=800&q=80'"
              :alt="project.title"
              class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"
            />
            <div class="absolute inset-0 bg-gradient-to-t from-forest-950 via-transparent to-transparent opacity-80"></div>
            <!-- Category Tag -->
            <span class="absolute top-3 left-3 px-2.5 py-0.5 text-[10px] font-semibold tracking-wider uppercase bg-forest-950/80 text-sage-400 border border-forest-700 rounded-md backdrop-blur-md">
              {{ project.category }}
            </span>
          </div>

          <!-- Project Body -->
          <div class="p-5 flex-1 flex flex-col justify-between">
            <div>
              <h3 class="text-lg font-bold text-mint-100 group-hover:text-sage-400 transition-colors mb-2 line-clamp-1">
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
                  class="bg-forest-700 text-mint-100 text-[11px] px-2.5 py-0.5 rounded-md font-medium border border-forest-700"
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
                class="text-xs text-sage-400 font-semibold hover:text-mint-100 inline-flex items-center gap-1 group/btn"
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
                  class="w-8 h-8 rounded-full bg-forest-800 text-sage-400 hover:text-mint-100 hover:bg-forest-700 flex items-center justify-center transition-colors border border-forest-700"
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
                  class="w-8 h-8 rounded-full bg-forest-800 text-sage-400 hover:text-mint-100 hover:bg-forest-700 flex items-center justify-center transition-colors border border-forest-700"
                >
                  <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                  </svg>
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Detail Modal -->
    <div
      v-if="activeModalProject"
      class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-forest-950/80 backdrop-blur-md animate-fade-in"
      @click.self="activeModalProject = null"
    >
      <div class="relative w-full max-w-2xl bg-forest-900 border border-sage-400/40 rounded-2xl p-6 sm:p-8 shadow-[0_0_40px_rgba(142,182,155,0.3)] max-h-[90vh] overflow-y-auto">
        <button
          @click="activeModalProject = null"
          type="button"
          class="absolute top-5 right-5 w-8 h-8 rounded-full bg-forest-800 text-sage-400 hover:text-mint-100 hover:bg-forest-700 flex items-center justify-center transition-colors border border-forest-700"
        >
          <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
          </svg>
        </button>

        <span class="text-xs uppercase tracking-wider text-sage-400 font-semibold font-mono">
          {{ activeModalProject.category }}
        </span>
        <h3 class="text-2xl font-bold text-mint-100 mb-3 mt-1">
          {{ activeModalProject.title }}
        </h3>

        <div class="rounded-xl overflow-hidden mb-5 border border-forest-700 max-h-72">
          <img
            :src="activeModalProject.thumbnail_url || activeModalProject.thumbnail"
            :alt="activeModalProject.title"
            class="w-full h-full object-cover"
          />
        </div>

        <p class="text-sm text-mint-100/90 leading-relaxed mb-6 whitespace-pre-line">
          {{ activeModalProject.description }}
        </p>

        <div class="mb-6">
          <span class="text-xs uppercase text-sage-400 font-semibold block mb-2">Technologies Used:</span>
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

        <div class="flex items-center gap-3 pt-4 border-t border-forest-700">
          <a
            v-if="activeModalProject.url_demo"
            :href="activeModalProject.url_demo"
            target="_blank"
            class="px-5 py-2.5 rounded-full bg-forest-700 text-mint-100 font-semibold text-xs border border-sage-400 shadow-[0_0_15px_rgba(142,182,155,0.3)] hover:bg-forest-700/80 transition-all inline-flex items-center gap-2"
          >
            <span>Visit Live Demo</span>
            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
            </svg>
          </a>
          <a
            v-if="activeModalProject.url_repo"
            :href="activeModalProject.url_repo"
            target="_blank"
            class="px-5 py-2.5 rounded-full bg-forest-800 text-sage-400 hover:text-mint-100 font-medium text-xs border border-forest-700 hover:border-sage-400 transition-colors inline-flex items-center gap-2"
          >
            <span>Repository</span>
            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24">
              <path fill-rule="evenodd" clip-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.53 1.032 1.53 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z" />
            </svg>
          </a>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
import { ref, computed } from 'vue';

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
    // If fewer than 6, blend with defaults to maintain clean 3x2 grid
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

