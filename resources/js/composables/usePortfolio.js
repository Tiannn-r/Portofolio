import { ref, onMounted } from 'vue';
import axios from 'axios';

export function usePortfolio() {
    const loading = ref(true);
    const error = ref(null);
    const portfolio = ref({
        profile: {
            name: 'Muhamad Ibnhu',
            roles: [
                'Full-Stack Developer',
                'Backend Specialist',
                'UI/UX Enthusiast',
                'Cloud & System Architect',
            ],
            short_bio: 'Passionate Full-Stack Developer crafting scalable web applications, sleek user experiences, and robust RESTful APIs using Laravel and Vue.js.',
            about_me: 'Halo! Saya adalah seorang Full-Stack Developer yang berdedikasi dalam membangun produk digital modern, cepat, dan terukur. Berpengalaman dalam merancang arsitektur backend berbasis Laravel, relational database MySQL, serta antarmuka interaktif dengan Vue 3 dan Tailwind CSS.',
            avatar_url: 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=600&q=80',
            cv_url: null,
            is_available: true,
            email: 'ibnhu.work@gmail.com',
            phone: '+62 812-3456-7890',
            location: 'Jakarta, Indonesia',
            social_links: {
                github: 'https://github.com/Tiannn-r',
                linkedin: 'https://linkedin.com/in/muhamad-ibnhu',
                instagram: 'https://instagram.com/tiannn',
                twitter: 'https://x.com/tiannn',
            },
            happy_clients: 18,
            projects_completed: 24,
            years_experience: 3,
            awards_received: 5,
        },
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
        try {
            const response = await axios.get('/api/portfolio');
            if (response.data && response.data.success) {
                const data = response.data.data;
                if (data.profile) portfolio.value.profile = data.profile;
                if (data.skills) portfolio.value.skills = data.skills;
                if (data.services) portfolio.value.services = data.services;
                if (data.featured_projects) portfolio.value.featured_projects = data.featured_projects;
                if (data.projects) portfolio.value.projects = data.projects;
                if (data.educations) portfolio.value.educations = data.educations;
                if (data.certifications) portfolio.value.certifications = data.certifications;
            }
        } catch (err) {
            console.warn('Could not fetch portfolio API, falling back to cached seed data:', err);
            error.value = err.message || 'Error loading portfolio data';
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
