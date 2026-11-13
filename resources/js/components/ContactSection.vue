<template>
  <SectionContainer
    id="contact"
    badge="Kontak"
    title="Mari Terhubung & Berdiskusi"
    description="Punya pertanyaan seputar proyek, tawaran kolaborasi, atau sekadar ingin berdiskusi? Jangan ragu untuk mengirimkan pesan."
  >
    <!-- Center Glassmorphism Contact Card -->
    <GlassCard
      variant="primary"
      class="max-w-3xl mx-auto relative overflow-hidden p-6 sm:p-8"
    >
      <!-- Feedback Alert Notification -->
      <div
        v-if="feedback.message"
        class="mb-6 p-4 rounded-xl flex items-center gap-3 transition-all relative z-10"
        :class="feedback.success ? 'bg-forest-900 border border-sage-400 text-mint-100' : 'bg-red-950/80 border border-red-500/50 text-red-200'"
      >
        <span class="w-2.5 h-2.5 rounded-full shrink-0" :class="feedback.success ? 'bg-warm-400' : 'bg-red-400'"></span>
        <span class="text-sm font-medium">{{ feedback.message }}</span>
      </div>

      <!-- Contact Form -->
      <form @submit.prevent="submit" class="space-y-5 relative z-10">
        <!-- 2 Column Inputs for Name & Email -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
          <div>
            <label for="contact-name" class="block text-xs font-semibold text-sage-400 mb-1.5">
              Nama Lengkap *
            </label>
            <input
              id="contact-name"
              v-model="form.name"
              type="text"
              required
              placeholder="contoh: Budi Santoso"
              class="w-full bg-forest-900/90 border border-forest-700 text-mint-100 placeholder-sage-400/50 focus:border-warm-400 focus:ring-1 focus:ring-warm-400 rounded-xl px-4 py-3 outline-none text-sm transition-all"
            />
          </div>

          <div>
            <label for="contact-email" class="block text-xs font-semibold text-sage-400 mb-1.5">
              Alamat Email *
            </label>
            <input
              id="contact-email"
              v-model="form.email"
              type="email"
              required
              placeholder="contoh: nama@email.com"
              class="w-full bg-forest-900/90 border border-forest-700 text-mint-100 placeholder-sage-400/50 focus:border-warm-400 focus:ring-1 focus:ring-warm-400 rounded-xl px-4 py-3 outline-none text-sm transition-all"
            />
          </div>
        </div>

        <!-- Textarea Message -->
        <div>
          <label for="contact-message" class="block text-xs font-semibold text-sage-400 mb-1.5">
            Pesan Anda *
          </label>
          <textarea
            id="contact-message"
            v-model="form.message"
            required
            rows="5"
            placeholder="Tuliskan pesan, rencana proyek, atau pertanyaan Anda di sini..."
            class="w-full bg-forest-900/90 border border-forest-700 text-mint-100 placeholder-sage-400/50 focus:border-warm-400 focus:ring-1 focus:ring-warm-400 rounded-xl px-4 py-3 outline-none text-sm transition-all resize-none"
          ></textarea>
        </div>

        <!-- Action Buttons -->
        <div class="flex flex-col sm:flex-row items-center gap-3.5 pt-2">
          <!-- Button 1: Kirim Pesan -->
          <BaseButton
            type="submit"
            variant="primary"
            size="lg"
            :loading="isSubmitting"
            class="w-full sm:flex-1"
          >
            <span>{{ isSubmitting ? 'Mengirim...' : 'Kirim Pesan' }}</span>
            <template #icon-right>
              <svg
                v-if="!isSubmitting"
                class="w-4 h-4 text-mint-100"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
              >
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
              </svg>
            </template>
          </BaseButton>

          <!-- Button 2: Unduh CV -->
          <BaseButton
            variant="secondary"
            size="lg"
            as="a"
            :href="profile?.cv_url || '#hero'"
            :download="profile?.cv_url ? 'CV-Muhamad-Ibnhu.pdf' : null"
            class="w-full sm:w-auto"
          >
            <template #icon-left>
              <svg class="w-4 h-4 text-warm-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
              </svg>
            </template>
            <span>Unduh CV</span>
          </BaseButton>
        </div>
      </form>
    </GlassCard>
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
