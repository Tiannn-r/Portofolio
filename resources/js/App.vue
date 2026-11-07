<template>
  <div class="relative min-h-screen bg-forest-950 text-mint-100 selection:bg-sage-400 selection:text-forest-950 overflow-x-hidden">
    <!-- 3D Geometric Ornaments Background -->
    <BackgroundOrnaments />

    <!-- Left Floating Vertical Pill Sidebar -->
    <Navbar :activeSection="activeSection" />

    <!-- Main Content Container (Padded left on desktop to make room for floating sidebar) -->
    <main class="relative z-10 lg:pl-28 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-16">
      <!-- Section 1: Hero Section -->
      <HeroSection :profile="portfolio.profile" />

      <!-- Section 2: About Me & Technical Skills -->
      <AboutSection :profile="portfolio.profile" :skills="portfolio.skills" />

      <!-- Section 3: Featured Projects & Services -->
      <FeaturedServicesSection
        :featuredProjects="portfolio.featured_projects"
        :projects="portfolio.projects"
        :services="portfolio.services"
      />

      <!-- Section 4: My Skills (Progress Bar) & My Portfolio Grid -->
      <SkillsPortfolioSection
        :skills="portfolio.skills"
        :projects="portfolio.projects"
      />

      <!-- Section 5: Education & Certifications -->
      <EducationSection
        :educations="portfolio.educations"
        :certifications="portfolio.certifications"
      />

      <!-- Section 6: Contact Section -->
      <ContactSection :profile="portfolio.profile" />
    </main>
  </div>
</template>

<script setup>
import { ref, onMounted, onUnmounted } from 'vue';
import { usePortfolio } from './composables/usePortfolio';
import BackgroundOrnaments from './components/BackgroundOrnaments.vue';
import Navbar from './components/Navbar.vue';
import HeroSection from './components/HeroSection.vue';
import AboutSection from './components/AboutSection.vue';
import FeaturedServicesSection from './components/FeaturedServicesSection.vue';
import SkillsPortfolioSection from './components/SkillsPortfolioSection.vue';
import EducationSection from './components/EducationSection.vue';
import ContactSection from './components/ContactSection.vue';

const { portfolio, loading, error } = usePortfolio();
const activeSection = ref('hero');

// Scroll Spy to track active section
const handleScroll = () => {
  const sections = ['hero', 'about', 'featured', 'portfolio', 'education', 'contact'];
  const scrollPosition = window.scrollY + 200;

  for (const sectionId of sections) {
    const el = document.getElementById(sectionId);
    if (el) {
      const top = el.offsetTop;
      const height = el.offsetHeight;
      if (scrollPosition >= top && scrollPosition < top + height) {
        activeSection.value = sectionId;
        break;
      }
    }
  }
};

onMounted(() => {
  window.addEventListener('scroll', handleScroll, { passive: true });
});

onUnmounted(() => {
  window.removeEventListener('scroll', handleScroll);
});
</script>
