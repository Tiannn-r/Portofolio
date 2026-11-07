<template>
  <div class="bg-[#0B2B26] border border-[#235347] rounded-2xl p-6 sm:p-8 shadow-[0_10px_30px_rgba(5,31,32,0.6)] relative overflow-hidden group">
    <!-- Ambient Glow Accent -->
    <div class="absolute -top-16 -right-16 w-56 h-56 bg-[#8EB69B]/10 rounded-full blur-3xl pointer-events-none"></div>

    <div class="flex flex-col md:flex-row items-center md:items-start gap-6 relative z-10">
      <!-- Avatar with Sage Glow Border -->
      <div class="relative w-28 h-28 sm:w-32 sm:h-32 rounded-2xl overflow-hidden shrink-0 border-2 border-[#8EB69B]/60 shadow-[0_0_20px_rgba(142,182,155,0.3)] bg-[#051F20]">
        <img
          :src="profile?.avatar_url || 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=600&q=80'"
          :alt="profile?.name || 'Admin Avatar'"
          class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"
        />
        <!-- Change Avatar Overlay / Trigger -->
        <label
          class="absolute inset-0 bg-[#051F20]/75 opacity-0 group-hover:opacity-100 flex flex-col items-center justify-center cursor-pointer transition-opacity text-[11px] text-[#DAF1DE] font-semibold"
        >
          <svg class="w-5 h-5 text-[#8EB69B] mb-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
          </svg>
          <span>Ganti Foto</span>
          <input type="file" accept="image/*" class="hidden" @change="handleAvatarChange" />
        </label>
      </div>

      <!-- Profile Information -->
      <div class="flex-1 text-center md:text-left">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-2">
          <div>
            <h2 class="text-2xl sm:text-3xl font-extrabold text-[#DAF1DE]">
              {{ profile?.name || 'Muhamad Ibnhu' }}
            </h2>
            <div class="flex flex-wrap items-center justify-center md:justify-start gap-1.5 mt-1 font-mono text-xs text-[#8EB69B]">
              <span v-for="(role, idx) in (profile?.roles || ['Full-Stack Developer'])" :key="idx" class="px-2 py-0.5 rounded bg-[#163832] border border-[#235347]">
                {{ role }}
              </span>
            </div>
          </div>

          <!-- Badge "Years of Experience" & Edit Button -->
          <div class="flex items-center justify-center md:justify-end gap-2.5">
            <div class="px-3.5 py-1.5 rounded-xl bg-[#163832] border border-[#8EB69B] text-[#DAF1DE] shadow-[0_0_12px_rgba(142,182,155,0.25)] flex items-center gap-2">
              <span class="w-2 h-2 rounded-full bg-[#8EB69B] animate-pulse"></span>
              <span class="text-xs font-bold font-mono">{{ profile?.years_experience || 3 }}+ Years Experience</span>
            </div>

            <button
              type="button"
              @click="$emit('edit-profile')"
              class="px-4 py-1.5 rounded-xl bg-[#235347] hover:bg-[#8EB69B] text-[#DAF1DE] hover:text-[#051F20] text-xs font-semibold tracking-wide transition-all duration-200 inline-flex items-center gap-1.5"
            >
              <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
              </svg>
              <span>Edit Profil</span>
            </button>
          </div>
        </div>

        <!-- Short Bio -->
        <p class="text-xs sm:text-sm text-[#8EB69B] leading-relaxed mt-3 max-w-3xl">
          {{ profile?.short_bio || 'Passionate Full-Stack Developer with deep experience crafting scalable web applications, sleek user experiences, and robust RESTful APIs using Laravel and Vue.js.' }}
        </p>

        <!-- Contact Micro-badges -->
        <div class="mt-4 pt-3 border-t border-[#235347]/60 flex flex-wrap items-center justify-center md:justify-start gap-4 text-xs text-[#8EB69B]">
          <span class="inline-flex items-center gap-1.5">
            <span class="text-[#DAF1DE] font-semibold">Email:</span> {{ profile?.email || 'ibnhu.work@gmail.com' }}
          </span>
          <span class="text-[#235347]">•</span>
          <span class="inline-flex items-center gap-1.5">
            <span class="text-[#DAF1DE] font-semibold">Phone:</span> {{ profile?.phone || '+62 812-3456-7890' }}
          </span>
          <span class="text-[#235347]">•</span>
          <span class="inline-flex items-center gap-1.5">
            <span class="text-[#DAF1DE] font-semibold">Location:</span> {{ profile?.location || 'Jakarta, ID' }}
          </span>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
const props = defineProps({
  profile: {
    type: Object,
    default: () => ({}),
  },
});

const emit = defineEmits(['edit-profile', 'upload-avatar']);

const handleAvatarChange = (e) => {
  const file = e.target.files[0];
  if (file) {
    emit('upload-avatar', file);
  }
};
</script>
