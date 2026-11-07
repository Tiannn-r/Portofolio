<template>
  <div class="space-y-6">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
      <!-- Left (8 Cols): Contact Messages Inbox -->
      <div class="lg:col-span-8 bg-[#0B2B26] border border-[#235347] rounded-2xl p-6 shadow-[0_4px_20px_rgba(5,31,32,0.4)]">
        <div class="flex items-center justify-between pb-4 mb-5 border-b border-[#235347]">
          <div>
            <div class="flex items-center gap-2">
              <h3 class="text-lg sm:text-xl font-bold text-[#DAF1DE]">
                Pesan Masuk (Contact Messages Inbox)
              </h3>
              <span
                v-if="unreadCount > 0"
                class="px-2 py-0.5 rounded-full text-xs font-bold bg-[#8EB69B] text-[#051F20] shadow-[0_0_8px_#8EB69B]"
              >
                {{ unreadCount }} Baru
              </span>
            </div>
            <p class="text-xs text-[#8EB69B] mt-0.5">
              Kelola pesan dan penawaran kerja sama yang dikirimkan pengunjung dari website
            </p>
          </div>

          <button
            type="button"
            @click="fetchMessages"
            class="p-2 rounded-xl bg-[#163832] hover:bg-[#235347] text-[#8EB69B] hover:text-[#DAF1DE] transition-colors"
            title="Refresh Pesan"
          >
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
            </svg>
          </button>
        </div>

        <!-- Messages List -->
        <div v-if="messages.length > 0" class="space-y-3">
          <div
            v-for="msg in messages"
            :key="msg.id"
            class="p-4 rounded-xl border transition-all"
            :class="msg.is_read
              ? 'bg-[#163832]/30 border-[#235347]'
              : 'bg-[#163832]/80 border-[#8EB69B]/50 shadow-[0_0_12px_rgba(142,182,155,0.15)]'"
          >
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 mb-2">
              <div class="flex items-center gap-2.5">
                <span
                  class="w-2.5 h-2.5 rounded-full shrink-0"
                  :class="msg.is_read ? 'bg-[#235347]' : 'bg-[#8EB69B] shadow-[0_0_8px_#8EB69B]'"
                ></span>
                <span class="text-sm font-bold text-[#DAF1DE]">{{ msg.name }}</span>
                <span class="text-xs text-[#8EB69B] font-mono">({{ msg.email }})</span>
              </div>

              <!-- Message Timestamp -->
              <span class="text-[11px] font-mono text-[#8EB69B]/70">
                {{ formatDate(msg.created_at) }}
              </span>
            </div>

            <!-- Message Body Text -->
            <p class="text-xs text-[#DAF1DE]/90 leading-relaxed mb-3 whitespace-pre-line pl-5">
              {{ msg.message }}
            </p>

            <!-- Actions -->
            <div class="flex items-center justify-between pt-2 border-t border-[#235347]/50 text-xs pl-5">
              <a
                :href="'mailto:' + msg.email + '?subject=Re: Inquiries from Portfolio Website'"
                class="text-[#8EB69B] hover:text-[#DAF1DE] font-semibold inline-flex items-center gap-1 transition-colors"
              >
                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
                <span>Balas Email</span>
              </a>

              <div class="flex items-center gap-2">
                <button
                  type="button"
                  @click="toggleRead(msg)"
                  class="px-2.5 py-1 rounded bg-[#051F20] text-[#8EB69B] hover:text-[#DAF1DE] font-medium transition-colors border border-[#235347]"
                >
                  {{ msg.is_read ? 'Tandai Belum Dibaca' : 'Tandai Sudah Dibaca' }}
                </button>
                <button
                  type="button"
                  @click="deleteMessage(msg)"
                  class="px-2.5 py-1 rounded bg-[#051F20] hover:bg-red-950/80 text-red-400 hover:text-red-300 font-medium transition-colors border border-red-500/30"
                >
                  Hapus
                </button>
              </div>
            </div>
          </div>
        </div>

        <div v-else class="text-center py-10">
          <p class="text-xs text-[#8EB69B]">Kotak masuk masih kosong.</p>
        </div>
      </div>

      <!-- Right (4 Cols): Update Contact Info Form -->
      <div class="lg:col-span-4 bg-[#0B2B26] border border-[#235347] rounded-2xl p-6 shadow-[0_4px_20px_rgba(5,31,32,0.4)]">
        <div class="pb-3 mb-4 border-b border-[#235347]">
          <h3 class="text-base sm:text-lg font-bold text-[#DAF1DE]">
            Update Informasi Kontak
          </h3>
          <p class="text-xs text-[#8EB69B] mt-0.5">
            Perbarui data kontak publik yang tampil di footer & form
          </p>
        </div>

        <form @submit.prevent="saveContactInfo" class="space-y-4">
          <div>
            <label class="block text-xs font-semibold text-[#8EB69B] uppercase mb-1">Email Publik *</label>
            <input
              v-model="infoForm.email"
              type="email"
              required
              class="w-full bg-[#163832] border border-[#235347] text-[#DAF1DE] rounded-xl px-3.5 py-2 text-xs outline-none focus:border-[#8EB69B]"
            />
          </div>

          <div>
            <label class="block text-xs font-semibold text-[#8EB69B] uppercase mb-1">Nomor Telepon / WhatsApp</label>
            <input
              v-model="infoForm.phone"
              type="text"
              class="w-full bg-[#163832] border border-[#235347] text-[#DAF1DE] rounded-xl px-3.5 py-2 text-xs outline-none focus:border-[#8EB69B]"
            />
          </div>

          <div>
            <label class="block text-xs font-semibold text-[#8EB69B] uppercase mb-1">Lokasi Domisili</label>
            <input
              v-model="infoForm.location"
              type="text"
              class="w-full bg-[#163832] border border-[#235347] text-[#DAF1DE] rounded-xl px-3.5 py-2 text-xs outline-none focus:border-[#8EB69B]"
            />
          </div>

          <button
            type="submit"
            :disabled="savingInfo"
            class="w-full mt-2 py-2.5 px-4 rounded-xl bg-[#235347] hover:bg-[#8EB69B] text-[#DAF1DE] hover:text-[#051F20] text-xs font-bold uppercase transition-all shadow-[0_0_15px_rgba(142,182,155,0.2)] disabled:opacity-50"
          >
            {{ savingInfo ? 'Menyimpan...' : 'Simpan Informasi Kontak' }}
          </button>
        </form>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, watch, onMounted } from 'vue';
import axios from 'axios';

const props = defineProps({
  profile: {
    type: Object,
    default: () => ({}),
  },
});

const emit = defineEmits(['refresh-profile', 'update-unread-count']);

const messages = ref([]);
const unreadCount = ref(0);
const savingInfo = ref(false);

const infoForm = ref({
  email: '',
  phone: '',
  location: '',
});

watch(
  () => props.profile,
  (newVal) => {
    if (newVal) {
      infoForm.value.email = newVal.email || 'ibnhu.work@gmail.com';
      infoForm.value.phone = newVal.phone || '+62 812-3456-7890';
      infoForm.value.location = newVal.location || 'Jakarta, Indonesia';
    }
  },
  { immediate: true }
);

const fetchMessages = async () => {
  try {
    const res = await axios.get('/api/admin/messages');
    if (res.data && res.data.success) {
      messages.value = res.data.data;
      unreadCount.value = res.data.unread_count ?? 0;
      emit('update-unread-count', unreadCount.value);
    }
  } catch (error) {
    console.error('Error fetching messages:', error);
  }
};

const toggleRead = async (msg) => {
  try {
    const res = await axios.patch(`/api/admin/messages/${msg.id}/read`);
    if (res.data && res.data.success) {
      msg.is_read = res.data.data.is_read;
      unreadCount.value = messages.value.filter((m) => !m.is_read).length;
      emit('update-unread-count', unreadCount.value);
    }
  } catch (error) {
    console.error('Error toggling read status:', error);
  }
};

const deleteMessage = async (msg) => {
  if (confirm(`Hapus pesan dari "${msg.name}"?`)) {
    try {
      await axios.delete(`/api/admin/messages/${msg.id}`);
      fetchMessages();
    } catch (error) {
      console.error('Error deleting message:', error);
    }
  }
};

const saveContactInfo = async () => {
  savingInfo.value = true;
  try {
    await axios.post('/api/admin/profile', {
      email: infoForm.value.email,
      phone: infoForm.value.phone,
      location: infoForm.value.location,
    });
    alert('Informasi kontak berhasil diperbarui!');
    emit('refresh-profile');
  } catch (error) {
    console.error('Error saving contact info:', error);
    alert('Gagal memperbarui informasi kontak.');
  } finally {
    savingInfo.value = false;
  }
};

const formatDate = (dateString) => {
  if (!dateString) return '';
  const d = new Date(dateString);
  return d.toLocaleDateString('id-ID', {
    day: 'numeric',
    month: 'short',
    year: 'numeric',
    hour: '2-digit',
    minute: '2-digit',
  });
};

onMounted(() => {
  fetchMessages();
});
</script>
