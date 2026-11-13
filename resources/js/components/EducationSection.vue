<template>
  <SectionContainer
    id="education"
    badge="Pendidikan"
    title="Pendidikan & Sertifikasi"
    description="Latar belakang pendidikan formal dan sertifikasi keahlian profesional."
  >
    <!-- Glassmorphic Card Container -->
    <GlassCard
      variant="primary"
      class="relative overflow-hidden"
    >
      <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12 items-stretch">
        <!-- Left Column: Formal Education -->
        <div class="flex flex-col">
          <!-- Column Header -->
          <div class="flex items-center gap-3 mb-6 pb-3 border-b border-forest-700/60">
            <div class="w-10 h-10 rounded-xl bg-forest-900 border border-forest-700 flex items-center justify-center text-sage-400">
              <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5" />
              </svg>
            </div>
            <div>
              <h3 class="text-xl sm:text-2xl font-bold text-mint-100 tracking-tight">
                Pendidikan Formal
              </h3>
            </div>
          </div>

          <!-- Vertical List of Education Cards -->
          <div v-if="educationList.length" class="space-y-4">
            <div
              v-for="(item, idx) in educationList"
              :key="item.id || idx"
              class="group bg-forest-900/90 border border-forest-700 hover:border-sage-400/70 rounded-xl p-5 hover:bg-forest-800/80 transition-colors duration-200 relative pl-14"
            >
              <!-- Icon Indicator -->
              <div class="w-8 h-8 rounded-full bg-forest-800 border border-forest-700 flex items-center justify-center text-sage-400 absolute left-4 top-5">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                </svg>
              </div>

              <!-- Content -->
              <span class="inline-block px-2.5 py-0.5 rounded text-[11px] font-mono font-semibold bg-forest-950 text-sage-400 border border-forest-700/80 mb-1.5">
                {{ item.period }}
              </span>
              <h4 class="text-base sm:text-lg font-bold text-mint-100 group-hover:text-sage-400 transition-colors">
                {{ item.title }}
              </h4>
              <p class="text-xs font-semibold text-sage-400 mb-2">
                {{ item.institution }}
              </p>
              <p class="text-xs sm:text-sm text-mint-100/75 leading-relaxed">
                {{ item.description }}
              </p>
            </div>
          </div>
          <div v-else class="py-10 px-4 text-center text-xs text-sage-400/60 bg-forest-900/40 rounded-xl border border-forest-700/40">
            Riwayat pendidikan belum ditambahkan.
          </div>
        </div>

        <!-- Right Column: Certifications (Clickable Cards with Pop-up Modal) -->
        <div class="flex flex-col">
          <!-- Column Header -->
          <div class="flex items-center justify-between mb-6 pb-3 border-b border-forest-700/60">
            <div class="flex items-center gap-3">
              <div class="w-10 h-10 rounded-xl bg-forest-900 border border-forest-700 flex items-center justify-center text-sage-400">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138z" />
                </svg>
              </div>
              <div>
                <h3 class="text-xl sm:text-2xl font-bold text-mint-100 tracking-tight">
                  Sertifikasi & Kredensial
                </h3>
              </div>
            </div>

            <span class="text-[11px] font-mono text-sage-400/80 bg-forest-950/80 px-2.5 py-1 rounded border border-forest-700">
              Klik kartu untuk detail
            </span>
          </div>

          <!-- Vertical List of Certification Cards -->
          <div v-if="certificationList.length" class="space-y-4">
            <div
              v-for="(item, idx) in certificationList"
              :key="item.id || idx"
              @click="openCertificateModal(item)"
              role="button"
              tabindex="0"
              class="group bg-forest-900/90 border border-forest-700 hover:border-sage-400/70 rounded-xl p-5 hover:bg-forest-800/80 transition-colors duration-200 relative pl-14 cursor-pointer"
            >
              <!-- Icon Indicator -->
              <div class="w-8 h-8 rounded-full bg-forest-800 border border-forest-700 flex items-center justify-center text-sage-400 absolute left-4 top-5">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
              </div>

              <!-- Top Row: Period & Click hint -->
              <div class="flex items-center justify-between gap-2 mb-1.5">
                <span class="inline-block px-2.5 py-0.5 rounded text-[11px] font-mono font-semibold bg-forest-950 text-sage-400 border border-forest-700/80 ring-1 ring-sage-400/10">
                  {{ item.period }}
                </span>
                <span class="text-[11px] text-sage-400/70 group-hover:text-sage-400 flex items-center gap-1 transition-colors font-mono">
                  <span>Lihat Detail</span>
                  <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                  </svg>
                </span>
              </div>

              <h4 class="text-base sm:text-lg font-bold text-mint-100 group-hover:text-sage-400 transition-colors">
                {{ item.title }}
              </h4>
              <p class="text-xs font-semibold text-sage-400 mb-2">
                {{ item.institution }}
              </p>
              <p class="text-xs sm:text-sm text-mint-100/75 leading-relaxed line-clamp-2">
                {{ item.description }}
              </p>
            </div>
          </div>
          <div v-else class="py-10 px-4 text-center text-xs text-sage-400/60 bg-forest-900/40 rounded-xl border border-forest-700/40">
            Sertifikasi belum ditambahkan.
          </div>
        </div>
      </div>
    </GlassCard>

    <!-- =================================================================================== -->
    <!-- CERTIFICATE DETAIL MODAL (Image, Event, Period, History)                           -->
    <!-- =================================================================================== -->
    <AdminModal
      :show="!!selectedCertificate"
      :title="selectedCertificate?.title || 'Detail Sertifikat'"
      max-width="2xl"
      @close="selectedCertificate = null"
    >
      <div v-if="selectedCertificate" class="space-y-5">
        <!-- Badges Bar -->
        <div class="flex flex-wrap items-center gap-2">
          <span class="inline-block px-2.5 py-1 text-xs uppercase tracking-wider text-sage-400 font-semibold font-mono bg-forest-800 rounded-lg border border-forest-700">
            {{ selectedCertificate.institution }}
          </span>
          <span v-if="selectedCertificate.event_name" class="inline-block px-2.5 py-1 text-xs text-mint-100/90 font-medium bg-forest-900 rounded-lg border border-forest-700">
            Event: {{ selectedCertificate.event_name }}
          </span>
          <span class="inline-block px-2.5 py-1 text-xs text-sage-400/90 font-mono bg-forest-950 rounded-lg border border-forest-700">
            Tahun Perolehan: {{ selectedCertificate.period }}
          </span>
        </div>

        <!-- Certificate Image Preview -->
        <div class="rounded-xl overflow-hidden border border-forest-700 bg-forest-950/80 p-2 shadow-[0_10px_30px_rgba(5,31,32,0.8)] ring-1 ring-sage-400/20">
          <img
            :src="selectedCertificate.certificate_image_url || selectedCertificate.certificate_image || 'https://images.unsplash.com/photo-1589330694653-dad6d3240a2b?auto=format&fit=crop&w=1000&q=80'"
            :alt="selectedCertificate.title"
            class="w-full max-h-80 object-contain rounded-lg bg-forest-900/60"
          />
        </div>

        <!-- Description Summary -->
        <div class="space-y-1">
          <span class="text-xs uppercase text-sage-400 font-mono font-bold block">Deskripsi Sertifikasi:</span>
          <p class="text-xs sm:text-sm text-mint-100/90 leading-relaxed">
            {{ selectedCertificate.description }}
          </p>
        </div>

        <!-- History Narrative -->
        <div class="p-4 rounded-xl bg-forest-900/90 border border-forest-700 ring-1 ring-sage-400/10 space-y-1.5">
          <div class="flex items-center gap-2 text-sage-400">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span class="text-xs uppercase font-mono font-bold tracking-wider">
              Riwayat & Catatan Perolehan:
            </span>
          </div>
          <p class="text-xs sm:text-sm text-mint-100/85 leading-relaxed whitespace-pre-line">
            {{ selectedCertificate.history || 'Menyelesaikan modul pembelajaran terstandarisasi, pengujian kurikulum mendalam, serta evaluasi kode berbasis proyek nyata sesuai standar kompetensi institusi penerbit.' }}
          </p>
        </div>
      </div>

      <template #footer>
        <div v-if="selectedCertificate" class="w-full flex items-center justify-between gap-3">
          <BaseButton
            v-if="selectedCertificate.credential_url"
            variant="primary"
            size="sm"
            as="a"
            :href="selectedCertificate.credential_url"
            target="_blank"
          >
            <span>Verifikasi Kredensial ↗</span>
          </BaseButton>
          <div v-else></div>

          <BaseButton
            variant="ghost"
            size="sm"
            @click="selectedCertificate = null"
          >
            <span>Tutup</span>
          </BaseButton>
        </div>
      </template>
    </AdminModal>
  </SectionContainer>
</template>

<script setup>
import { ref, computed } from 'vue';
import SectionContainer from './ui/SectionContainer.vue';
import GlassCard from './ui/GlassCard.vue';
import AdminModal from './ui/AdminModal.vue';
import BaseButton from './ui/BaseButton.vue';

const props = defineProps({
  educations: {
    type: Array,
    default: () => [],
  },
  certifications: {
    type: Array,
    default: () => [],
  },
});

const selectedCertificate = ref(null);

const educationList = computed(() => {
  return props.educations && props.educations.length > 0 ? props.educations : [];
});

const certificationList = computed(() => {
  return props.certifications && props.certifications.length > 0 ? props.certifications : [];
});

const openCertificateModal = (item) => {
  selectedCertificate.value = item;
};
</script>
