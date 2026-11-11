<template>
  <div class="relative min-h-screen bg-forest-950 text-mint-100 selection:bg-sage-400 selection:text-forest-950 overflow-x-hidden">
    <!-- 3D Geometric Ornaments Background -->
    <BackgroundOrnaments />

    <!-- Left Floating Vertical Pill Sidebar -->
    <Navbar
      :activeSection="activeSection"
      @section-change="onSectionChange"
    />

    <!-- Skeleton Loading Screen when initial fetch is active and data is empty -->
    <div
      v-if="loading && !portfolio?.profile?.name"
      class="relative z-10 lg:pl-28 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24 space-y-12"
    >
      <div class="flex flex-col items-center justify-center space-y-6">
        <SkeletonLoader variant="avatar" width="160px" height="160px" />
        <SkeletonLoader variant="text" width="300px" height="40px" />
        <SkeletonLoader variant="text" width="220px" height="24px" />
        <SkeletonLoader variant="text" width="500px" height="20px" />
      </div>
      <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
        <SkeletonLoader v-for="i in 4" :key="i" variant="card" height="100px" />
      </div>
    </div>

    <!-- Main Content Container (Padded left on desktop to make room for floating sidebar) -->
    <main
      v-else
      class="relative z-10 lg:pl-28 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-16 animate-fade-in"
    >
      <!-- Section 1: Hero Section -->
      <HeroSection :profile="portfolio.profile" />

      <!-- Section 2: About Me & Technical Skills -->
      <AboutSection :profile="portfolio.profile" :skills="portfolio.skills" />

      <!-- Section 3: Stories & Services (Updates & Solutions) -->
      <FeaturedServicesSection
        :stories="portfolio.stories"
        :services="portfolio.services"
      />

      <!-- Section 4: My Skills (Progress Bar) & My Portfolio Grid -->
      <SkillsPortfolioSection
        :profile="portfolio.profile"
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

    <!-- Section 7: Professional Footer & Direct Contact Channels (Full Width Kiri-Kanan) -->
    <Footer v-if="!loading || portfolio?.profile?.name" :profile="portfolio.profile" />
  </div>
</template>

<script setup>
import { ref, onMounted, onUnmounted } from 'vue';
import { usePublicPortfolio } from '../composables/usePublicPortfolio';
import BackgroundOrnaments from '../components/BackgroundOrnaments.vue';
import Navbar from '../components/Navbar.vue';
import HeroSection from '../components/HeroSection.vue';
import AboutSection from '../components/AboutSection.vue';
import FeaturedServicesSection from '../components/FeaturedServicesSection.vue';
import SkillsPortfolioSection from '../components/SkillsPortfolioSection.vue';
import EducationSection from '../components/EducationSection.vue';
import ContactSection from '../components/ContactSection.vue';
import Footer from '../components/Footer.vue';
import SkeletonLoader from '../components/ui/SkeletonLoader.vue';

const { portfolio, loading, error } = usePublicPortfolio();
const activeSection = ref('hero');
let isClickScrolling = false;
let scrollLockTimeout = null;

const onSectionChange = (id) => {
  activeSection.value = id;
  isClickScrolling = true;
  if (scrollLockTimeout) clearTimeout(scrollLockTimeout);
  scrollLockTimeout = setTimeout(() => {
    isClickScrolling = false;
  }, 850);
};

// Bulletproof Scroll Spy using getBoundingClientRect with requestAnimationFrame throttling
const handleScroll = () => {
  if (isClickScrolling) return;

  // 1. If at the very top of page, activate hero
  if (window.scrollY < 120) {
    activeSection.value = 'hero';
    return;
  }

  // 2. If at the bottom of the page (footer / contact area), activate contact
  const isBottom = window.innerHeight + window.scrollY >= document.documentElement.scrollHeight - 120;
  if (isBottom) {
    activeSection.value = 'contact';
    return;
  }

  // 3. Find the lowest section whose top has crossed the viewport trigger point (38% from top)
  const sections = ['hero', 'about', 'featured', 'portfolio', 'education', 'contact'];
  const triggerPoint = window.innerHeight * 0.38;

  let current = 'hero';
  for (const id of sections) {
    const el = document.getElementById(id);
    if (el) {
      const rect = el.getBoundingClientRect();
      if (rect.top <= triggerPoint) {
        current = id;
      }
    }
  }

  activeSection.value = current;
};

let ticking = false;
const onScrollThrottled = () => {
  if (!ticking) {
    window.requestAnimationFrame(() => {
      handleScroll();
      ticking = false;
    });
    ticking = true;
  }
};

onMounted(() => {
  window.addEventListener('scroll', onScrollThrottled, { passive: true });
  // Initial check
  handleScroll();
});

onUnmounted(() => {
  window.removeEventListener('scroll', onScrollThrottled);
  if (scrollLockTimeout) clearTimeout(scrollLockTimeout);
});
</script>
