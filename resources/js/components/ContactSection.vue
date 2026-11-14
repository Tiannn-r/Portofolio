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
                class="w-4 h-4 text-forest-950"
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
              <svg class="w-4 h-4 text-mint-100/80" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
              </svg>
            </template>
            <span>Unduh CV</span>
          </BaseButton>
        </div>
      </form>

      <!-- Saluran Kontak Formal (LinkedIn, Gmail, WhatsApp) Berjejer Rapi ke Kanan -->
      <div v-if="formalChannels.length" class="mt-9 pt-7 border-t border-forest-700/60 relative z-10">
        <div class="flex items-center justify-between mb-4">
          <span class="text-xs font-semibold text-sage-400 uppercase tracking-wider font-mono">
            Saluran Kontak Langsung
          </span>
          <span class="text-[11px] text-sage-400/70 font-mono">
            Respon Cepat
          </span>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
          <a
            v-for="(item, idx) in formalChannels"
            :key="idx"
            :href="item.url"
            target="_blank"
            rel="noopener noreferrer"
            class="group bg-forest-900/90 border border-forest-700 hover:border-warm-400 rounded-xl p-3.5 flex items-center justify-between transition-all duration-200 hover:-translate-y-0.5 hover:bg-forest-800/90 shadow-sm cursor-pointer"
          >
            <div class="flex items-center gap-3 min-w-0">
              <!-- Platform Logo / Icon -->
              <div class="w-10 h-10 rounded-lg bg-forest-950 border border-forest-700 flex items-center justify-center text-sage-400 group-hover:text-warm-400 group-hover:border-warm-400/60 transition-colors shrink-0 overflow-hidden p-2">
                <!-- Custom Uploaded or URL Logo -->
                <img
                  v-if="item.logo_file_url || (item.logo_source === 'url' && item.logo_url)"
                  :src="item.logo_file_url || item.logo_url"
                  :alt="item.name"
                  class="w-full h-full object-contain"
                />
                <!-- Preset LinkedIn -->
                <svg v-else-if="item.platform.includes('linkedin')" class="w-5 h-5 fill-current" viewBox="0 0 24 24">
                  <path d="M19 3a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h14m-.5 15.5v-5.3a3.26 3.26 0 0 0-3.26-3.26c-.85 0-1.84.52-2.28 1.3v-1.11h-2.79v8.37h2.79v-4.93c0-.77.62-1.4 1.39-1.4a1.4 1.4 0 0 1 1.4 1.4v4.93h2.75M6.88 8.56a1.68 1.68 0 0 0 1.68-1.68c0-.93-.75-1.69-1.68-1.69a1.69 1.69 0 0 0-1.69 1.69c0 .93.76 1.68 1.69 1.68m1.39 9.94v-8.37H5.5v8.37h2.77z"/>
                </svg>
                <!-- Preset WhatsApp -->
                <svg v-else-if="item.platform.includes('whatsapp')" class="w-5 h-5 fill-current" viewBox="0 0 24 24">
                  <path d="M12.04 2c-5.46 0-9.91 4.45-9.91 9.91 0 1.75.46 3.45 1.32 4.95L2.05 22l5.25-1.38c1.45.79 3.08 1.21 4.74 1.21 5.46 0 9.91-4.45 9.91-9.91 0-2.65-1.03-5.14-2.9-7.01A9.82 9.82 0 0012.04 2zm5.78 14.07c-.24.68-1.4 1.27-1.93 1.32-.49.05-1.13.07-1.83-.16-.43-.14-.99-.33-1.7-.64-3-1.3-4.96-4.32-5.11-4.52-.15-.2-1.22-1.63-1.22-3.1 0-1.48.77-2.2 1.04-2.5.28-.3.6-.37.8-.37.2 0 .4 0 .58.01.19.01.44-.07.69.52.25.6.86 2.1.94 2.25.07.16.12.35.02.55-.1.2-.15.33-.3.51-.15.18-.32.4-.46.54-.15.15-.31.32-.13.63.18.31.8 1.32 1.72 2.14 1.18 1.05 2.17 1.38 2.48 1.53.31.15.49.13.67-.08.19-.21.79-.92 1-.1.23.21.37.13.62.24.25.11 1.58.74 1.85.88.27.14.45.2.52.32.07.11.07.66-.17 1.34z"/>
                </svg>
                <!-- Preset Email / Gmail -->
                <svg v-else-if="item.platform.includes('email') || item.platform.includes('gmail')" class="w-5 h-5 fill-current" viewBox="0 0 24 24">
                  <path d="M24 5.457v13.909c0 .904-.732 1.636-1.636 1.636h-3.819V11.73L12 16.64l-6.545-4.91v9.273H1.636A1.636 1.636 0 0 1 0 19.366V5.457c0-2.023 2.309-3.178 3.927-1.964L5.455 4.64 12 9.548l6.545-4.91 1.528-1.145C21.69 2.28 24 3.434 24 5.457z"/>
                </svg>
                <!-- Default / Link Icon -->
                <svg v-else class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />
                </svg>
              </div>

              <!-- Content -->
              <div class="min-w-0">
                <span class="block text-xs font-bold text-mint-100 group-hover:text-warm-400 transition-colors truncate">
                  {{ item.name }}
                </span>
                <span class="block text-[11px] text-sage-400/80 truncate">
                  {{ item.subtext || 'Hubungi Langsung' }}
                </span>
              </div>
            </div>

            <!-- Arrow -->
            <svg class="w-4 h-4 text-sage-400/50 group-hover:text-warm-400 group-hover:translate-x-0.5 transition-all shrink-0 ml-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
            </svg>
          </a>
        </div>
      </div>
    </GlassCard>
  </SectionContainer>
</template>

<script setup>
import { computed } from 'vue';
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

const cleanPhone = (phone) => {
  let num = String(phone || '').replace(/[^0-9]/g, '');
  if (num.startsWith('0')) {
    num = '62' + num.slice(1);
  }
  return num;
};

const formalChannels = computed(() => {
  const channels = [];
  const addedTypes = new Set();

  // 1. Ambil saluran formal dari custom social_channels (jika ada yang dibuat di CMS)
  if (Array.isArray(props.profile?.social_channels) && props.profile.social_channels.length > 0) {
    props.profile.social_channels
      .filter(c => c.category === 'formal')
      .forEach(c => {
        channels.push(c);
        const p = (c.platform || c.name || '').toLowerCase();
        addedTypes.add(p);
      });
  }

  // 2. LinkedIn (jika belum ada di channels)
  const hasLinkedIn = Array.from(addedTypes).some(p => p.includes('linkedin'));
  if (!hasLinkedIn) {
    const links = props.profile?.social_links;
    let linkedinUrl = null;
    if (Array.isArray(links)) {
      linkedinUrl = links.find(l => (l.name || l.platform || '').toLowerCase().includes('linkedin'))?.url;
    } else if (links && typeof links === 'object') {
      linkedinUrl = links.linkedin_url || links.linkedin;
    }

    if (linkedinUrl) {
      channels.unshift({
        name: 'LinkedIn',
        platform: 'linkedin',
        url: linkedinUrl,
        subtext: 'Terhubung Profesional',
      });
      addedTypes.add('linkedin');
    }
  }

  // 3. Email / Gmail (WAJIB ADA jika belum ditambahkan)
  const hasEmail = Array.from(addedTypes).some(p => p.includes('email') || p.includes('gmail'));
  const userEmail = props.profile?.email || 'ibnhu.work@gmail.com';
  if (!hasEmail && userEmail) {
    channels.push({
      name: 'Email Langsung',
      platform: 'email',
      url: 'mailto:' + userEmail,
      subtext: userEmail,
    });
    addedTypes.add('email');
  }

  // 4. WhatsApp (WAJIB ADA jika nomor telepon ada)
  const hasWhatsapp = Array.from(addedTypes).some(p => p.includes('whatsapp') || p.includes('wa'));
  const userPhone = props.profile?.phone || '+62 812-3456-7890';
  if (!hasWhatsapp && userPhone) {
    channels.push({
      name: 'WhatsApp',
      platform: 'whatsapp',
      url: 'https://wa.me/' + cleanPhone(userPhone),
      subtext: 'Chat & Diskusi Cepat',
    });
    addedTypes.add('whatsapp');
  }

  return channels;
});
</script>
