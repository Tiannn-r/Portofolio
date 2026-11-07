<template>
  <SectionContainer
    id="contact"
    badge="Get In Touch"
    title="Let's Connect & <span class='text-sage-400'>Collaborate</span>"
    description="Have an upcoming project, freelance inquiry, or architectural challenge to discuss? Leave a message below!"
  >
    <!-- Center Glassmorphism Contact Card -->
    <GlassCard
      variant="primary"
      class="max-w-3xl mx-auto relative overflow-hidden"
    >
      <!-- Background Ambient Radial Glow -->
      <div class="absolute -top-20 -left-20 w-64 h-64 bg-sage-400/10 rounded-full blur-3xl pointer-events-none"></div>

      <!-- Quick Contact Badges Row -->
      <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 mb-8 relative z-10">
        <a
          :href="'mailto:' + (profile?.email || 'ibnhu.work@gmail.com')"
          class="flex items-center gap-3 p-3 rounded-xl bg-forest-900/90 border border-forest-700 hover:border-sage-400/80 transition-all duration-300 group hover:-translate-y-0.5"
        >
          <div class="w-8 h-8 rounded-lg bg-forest-800 flex items-center justify-center text-sage-400 group-hover:scale-110 transition-transform shadow-[0_0_8px_rgba(142,182,155,0.2)]">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
            </svg>
          </div>
          <div class="overflow-hidden">
            <span class="text-[10px] uppercase text-sage-400/80 block font-mono">Email</span>
            <span class="text-xs font-semibold text-mint-100 truncate block">{{ profile?.email || 'ibnhu.work@gmail.com' }}</span>
          </div>
        </a>

        <div class="flex items-center gap-3 p-3 rounded-xl bg-forest-900/90 border border-forest-700">
          <div class="w-8 h-8 rounded-lg bg-forest-800 flex items-center justify-center text-sage-400 shadow-[0_0_8px_rgba(142,182,155,0.2)]">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
            </svg>
          </div>
          <div class="overflow-hidden">
            <span class="text-[10px] uppercase text-sage-400/80 block font-mono">Phone / WA</span>
            <span class="text-xs font-semibold text-mint-100 truncate block">{{ profile?.phone || '+62 812-3456-7890' }}</span>
          </div>
        </div>

        <div class="flex items-center gap-3 p-3 rounded-xl bg-forest-900/90 border border-forest-700">
          <div class="w-8 h-8 rounded-lg bg-forest-800 flex items-center justify-center text-sage-400 shadow-[0_0_8px_rgba(142,182,155,0.2)]">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
            </svg>
          </div>
          <div class="overflow-hidden">
            <span class="text-[10px] uppercase text-sage-400/80 block font-mono">Location</span>
            <span class="text-xs font-semibold text-mint-100 truncate block">{{ profile?.location || 'Jakarta, Indonesia' }}</span>
          </div>
        </div>
      </div>

      <!-- Feedback Alert Notification -->
      <div
        v-if="feedback.message"
        class="mb-6 p-4 rounded-xl flex items-center gap-3 transition-all relative z-10"
        :class="feedback.success ? 'bg-forest-900 border border-sage-400 text-mint-100 shadow-[0_0_15px_rgba(142,182,155,0.3)] ring-1 ring-sage-400/30' : 'bg-red-950/80 border border-red-500/50 text-red-200'"
      >
        <span class="w-2.5 h-2.5 rounded-full shrink-0" :class="feedback.success ? 'bg-sage-400 shadow-[0_0_8px_#8EB69B]' : 'bg-red-400'"></span>
        <span class="text-sm font-medium">{{ feedback.message }}</span>
      </div>

      <!-- Contact Form -->
      <form @submit.prevent="submit" class="space-y-6 relative z-10">
        <!-- 2 Column Inputs for Name & Email -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
          <div>
            <label for="contact-name" class="block text-xs font-semibold uppercase tracking-wider text-sage-400 mb-2">
              Your Name *
            </label>
            <input
              id="contact-name"
              v-model="form.name"
              type="text"
              required
              placeholder="e.g. Alexander Pierce"
              class="w-full bg-[#0B2B26]/90 border border-[#235347] text-[#DAF1DE] placeholder-[#8EB69B]/60 focus:border-[#8EB69B] focus:ring-1 focus:ring-[#8EB69B] rounded-xl px-4 py-3 outline-none text-sm transition-all shadow-inner"
            />
          </div>

          <div>
            <label for="contact-email" class="block text-xs font-semibold uppercase tracking-wider text-sage-400 mb-2">
              Your Email *
            </label>
            <input
              id="contact-email"
              v-model="form.email"
              type="email"
              required
              placeholder="e.g. alex@company.com"
              class="w-full bg-[#0B2B26]/90 border border-[#235347] text-[#DAF1DE] placeholder-[#8EB69B]/60 focus:border-[#8EB69B] focus:ring-1 focus:ring-[#8EB69B] rounded-xl px-4 py-3 outline-none text-sm transition-all shadow-inner"
            />
          </div>
        </div>

        <!-- Textarea Message -->
        <div>
          <label for="contact-message" class="block text-xs font-semibold uppercase tracking-wider text-sage-400 mb-2">
            Your Message *
          </label>
          <textarea
            id="contact-message"
            v-model="form.message"
            required
            rows="5"
            placeholder="Tell me about your project, timeline, and goals..."
            class="w-full bg-[#0B2B26]/90 border border-[#235347] text-[#DAF1DE] placeholder-[#8EB69B]/60 focus:border-[#8EB69B] focus:ring-1 focus:ring-[#8EB69B] rounded-xl px-4 py-3 outline-none text-sm transition-all resize-none shadow-inner"
          ></textarea>
        </div>

        <!-- 2 Parallel Buttons at Bottom: SEND MESSAGE & DOWNLOAD CV -->
        <div class="flex flex-col sm:flex-row items-center gap-4 pt-2">
          <!-- Button 1: SEND MESSAGE using BaseButton -->
          <BaseButton
            type="submit"
            variant="primary"
            size="lg"
            :loading="isSubmitting"
            class="w-full sm:flex-1"
          >
            <span>{{ isSubmitting ? 'SENDING...' : 'SEND MESSAGE' }}</span>
            <template #icon-right>
              <svg
                v-if="!isSubmitting"
                class="w-4 h-4 text-mint-100 group-hover:translate-x-1 transition-transform"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
              >
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
              </svg>
            </template>
          </BaseButton>

          <!-- Button 2: DOWNLOAD CV using BaseButton -->
          <BaseButton
            variant="secondary"
            size="lg"
            as="a"
            :href="profile?.cv_url || '#hero'"
            :download="profile?.cv_url ? 'CV-Muhamad-Ibnhu.pdf' : null"
            class="w-full sm:w-auto"
          >
            <template #icon-left>
              <svg class="w-4 h-4 text-sage-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
              </svg>
            </template>
            <span>DOWNLOAD CV</span>
          </BaseButton>
        </div>
      </form>
    </GlassCard>

    <!-- Elegant Footer -->
    <footer class="mt-24 pt-10 border-t border-forest-700/60 flex flex-col sm:flex-row items-center justify-between gap-6 text-xs text-sage-400/80">
      <div>
        <p>© 2026 <span class="text-mint-100 font-semibold">{{ profile?.name || 'Muhamad Ibnhu' }}</span>. All rights reserved.</p>
        <p class="text-[11px] text-sage-400/60 mt-0.5 font-mono">Built with Laravel 11, Vue 3, & Tailwind CSS</p>
      </div>

      <!-- Social Links -->
      <div class="flex items-center gap-4">
        <a
          v-if="profile?.social_links?.github"
          :href="profile.social_links.github"
          target="_blank"
          class="hover:text-mint-100 transition-colors"
          title="GitHub"
        >
          GitHub
        </a>
        <a
          v-if="profile?.social_links?.linkedin"
          :href="profile.social_links.linkedin"
          target="_blank"
          class="hover:text-mint-100 transition-colors"
          title="LinkedIn"
        >
          LinkedIn
        </a>
        <a
          v-if="profile?.social_links?.twitter"
          :href="profile.social_links.twitter"
          target="_blank"
          class="hover:text-mint-100 transition-colors"
          title="Twitter"
        >
          Twitter / X
        </a>
        <a
          v-if="profile?.social_links?.instagram"
          :href="profile.social_links.instagram"
          target="_blank"
          class="hover:text-mint-100 transition-colors"
          title="Instagram"
        >
          Instagram
        </a>
      </div>

      <!-- Back To Top Button with Micro-interaction -->
      <a
        href="#hero"
        class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-forest-900 border border-forest-700 hover:border-sage-400 text-sage-400 hover:text-mint-100 transition-all text-xs font-mono active:scale-95 shadow-[0_0_10px_rgba(5,31,32,0.5)]"
      >
        <span>Back to Top</span>
        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18" />
        </svg>
      </a>
    </footer>
  </SectionContainer>
</template>

<script setup>
import SectionContainer from './ui/SectionContainer.vue';
import GlassCard from './ui/GlassCard.vue';
import BaseButton from './ui/BaseButton.vue';
import { useContactSubmission } from '../composables/useContactSubmission';

const props = defineProps({
  profile: {
    type: Object,
    default: () => ({}),
  },
});

const {
  form,
  isSubmitting,
  feedback,
  submit,
} = useContactSubmission();
</script>
