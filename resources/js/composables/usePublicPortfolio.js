import { ref, onMounted } from 'vue';
import axios from 'axios';

export function usePublicPortfolio() {
  const loading = ref(true);
  const error = ref(null);

  const portfolio = ref({
    profile: {
      name: 'Muhamad Ibnhu',
      roles: ['Web Developer — Spesialis Laravel & Vue.js'],
      short_bio: 'Membantu mengubah ide dan kebutuhan sistem menjadi aplikasi web yang siap pakai. Suka kode yang terstruktur dan tampilan yang bersih tanpa ribet.',
      about_me: 'Saya adalah seorang Full-Stack Developer yang berdedikasi dalam membangun produk digital modern, cepat, dan terukur. Berpengalaman dalam merancang arsitektur backend berbasis Laravel, relational database MySQL, serta antarmuka interaktif dengan Vue 3 dan Tailwind CSS.',
      avatar_url: '/storage/profile/vBfVcc3JaeCdZUCrq0THNsz7xsvdZuvxhR1Sh5bO.jpg',
      hero_image_url: '/storage/profile/vBfVcc3JaeCdZUCrq0THNsz7xsvdZuvxhR1Sh5bO.jpg',
      about_image_url: '/storage/profile/vQNDsJ2Nb1YtlQ9dV3VcI7PaMFdF0BLZq3HIhLSv.jpg',
      cv_url: null,
      is_available: true,
      email: 'ibnhu.work@gmail.com',
      phone: '+62 812-3456-7890',
      location: 'Jakarta, Indonesia',
      social_links: {
        github: 'https://github.com/Tiannn-r',
        linkedin: 'https://linkedin.com/in/muhamad-ibnhu',
        twitter: 'https://x.com/tiannn',
        instagram: 'https://instagram.com/tiannn',
      },
      happy_clients: 18,
      projects_completed: 24,
      years_experience: 3,
      awards_received: 5,
    },
    stories: [],
    skills: {
      all: [],
      technical_grid: [],
      progress_bars: [],
    },
    services: [],
    featured_projects: [],
    projects: [],
    educations: [],
    certifications: [],
  });

  const fetchPortfolio = async () => {
    loading.value = true;
    error.value = null;
    try {
      const response = await axios.get('/api/portfolio');
      if (response.data && response.data.success) {
        const data = response.data.data;
        if (data.profile) portfolio.value.profile = data.profile;
        if (data.stories) portfolio.value.stories = data.stories;
        if (data.skills) portfolio.value.skills = data.skills;
        if (data.services) portfolio.value.services = data.services;
        if (data.featured_projects) portfolio.value.featured_projects = data.featured_projects;
        if (data.projects) portfolio.value.projects = data.projects;
        if (data.educations) portfolio.value.educations = data.educations;
        if (data.certifications) portfolio.value.certifications = data.certifications;
      }
    } catch (err) {
      console.warn('API error, using initial state:', err);
      error.value = err.message || 'Error loading portfolio';
    } finally {
      loading.value = false;
    }
  };

  onMounted(() => {
    fetchPortfolio();
  });

  return {
    portfolio,
    loading,
    error,
    fetchPortfolio,
  };
}

