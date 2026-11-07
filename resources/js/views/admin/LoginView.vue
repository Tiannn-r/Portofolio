<template>
  <div class="min-h-screen bg-forest-950 flex items-center justify-center p-4 relative overflow-hidden selection:bg-sage-400 selection:text-forest-950">
    <!-- Ambient Radial Glows -->
    <div class="absolute -top-32 -left-32 w-96 h-96 rounded-full bg-forest-700/30 blur-[130px] pointer-events-none"></div>
    <div class="absolute -bottom-32 -right-32 w-96 h-96 rounded-full bg-sage-400/15 blur-[140px] pointer-events-none"></div>

    <div class="relative w-full max-w-md z-10">
      <!-- Brand Logo / Badge -->
      <div class="text-center mb-8">
        <div class="inline-flex items-center justify-center w-14 h-14 rounded-2xl bg-forest-900 border border-sage-400/50 shadow-[0_0_20px_rgba(142,182,155,0.3)] mb-4">
          <span class="text-xl font-extrabold text-sage-400 tracking-wider">MI</span>
        </div>
        <h1 class="text-2xl sm:text-3xl font-extrabold text-mint-100 tracking-tight">
          CMS Admin <span class="text-sage-400">Portal</span>
        </h1>
        <p class="text-xs sm:text-sm text-sage-400/80 mt-1.5">
          Sign in to manage your portfolio content & metrics
        </p>
      </div>

      <!-- Login Glassmorphism Card -->
      <div class="bg-forest-900/90 backdrop-blur-md border border-forest-700 rounded-2xl p-6 sm:p-8 shadow-[0_15px_40px_rgba(5,31,32,0.8)]">
        <!-- Error Alert -->
        <div
          v-if="errorMessage"
          class="mb-6 p-3.5 rounded-xl bg-red-950/80 border border-red-500/50 text-red-200 text-xs flex items-center gap-2.5 animate-shake"
        >
          <span class="w-2 h-2 rounded-full bg-red-400 shrink-0"></span>
          <span>{{ errorMessage }}</span>
        </div>

        <form @submit.prevent="handleLogin" class="space-y-5">
          <!-- Email Input -->
          <div>
            <label for="admin-email" class="block text-xs font-semibold uppercase tracking-wider text-sage-400 mb-1.5">
              Email Address
            </label>
            <div class="relative">
              <input
                id="admin-email"
                v-model="form.email"
                type="email"
                required
                autocomplete="email"
                placeholder="admin@portofolio.test"
                class="w-full bg-forest-800/80 border border-forest-700 text-mint-100 placeholder-sage-400/50 focus:border-sage-400 focus:ring-1 focus:ring-sage-400 rounded-xl px-4 py-2.5 outline-none text-sm transition-all"
              />
            </div>
          </div>

          <!-- Password Input -->
          <div>
            <div class="flex items-center justify-between mb-1.5">
              <label for="admin-password" class="block text-xs font-semibold uppercase tracking-wider text-sage-400">
                Password
              </label>
              <button
                type="button"
                @click="showPassword = !showPassword"
                class="text-[11px] text-sage-400 hover:text-mint-100 transition-colors"
              >
                {{ showPassword ? 'Hide' : 'Show' }}
              </button>
            </div>
            <div class="relative">
              <input
                id="admin-password"
                v-model="form.password"
                :type="showPassword ? 'text' : 'password'"
                required
                autocomplete="current-password"
                placeholder="••••••••••••"
                class="w-full bg-forest-800/80 border border-forest-700 text-mint-100 placeholder-sage-400/50 focus:border-sage-400 focus:ring-1 focus:ring-sage-400 rounded-xl px-4 py-2.5 outline-none text-sm transition-all"
              />
            </div>
          </div>

          <!-- Hint Credentials Badge -->
          <div class="p-2.5 rounded-lg bg-forest-950/60 border border-forest-700/60 text-[11px] text-sage-400/80 flex items-center justify-between font-mono">
            <span>Demo: admin@portofolio.test</span>
            <span class="text-mint-100/90 font-semibold">password123</span>
          </div>

          <!-- Submit Button -->
          <button
            type="submit"
            :disabled="loading"
            class="w-full mt-2 py-3 px-6 rounded-full bg-gradient-to-r from-forest-800 via-forest-700 to-sage-400 text-mint-100 font-bold text-sm tracking-wide uppercase shadow-[0_0_20px_rgba(142,182,155,0.3)] hover:shadow-[0_0_30px_rgba(142,182,155,0.5)] hover:scale-[1.02] active:scale-[0.98] transition-all duration-300 disabled:opacity-60 disabled:cursor-not-allowed flex items-center justify-center gap-2"
          >
            <svg
              v-if="loading"
              class="animate-spin -ml-1 mr-2 h-4 w-4 text-mint-100"
              fill="none"
              viewBox="0 0 24 24"
            >
              <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
              <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
            </svg>
            <span>{{ loading ? 'Signing in...' : 'Sign In to Dashboard' }}</span>
          </button>
        </form>

        <!-- Back to Website Link -->
        <div class="mt-6 pt-5 border-t border-forest-700/60 text-center">
          <router-link
            to="/"
            class="inline-flex items-center gap-1.5 text-xs text-sage-400 hover:text-mint-100 transition-colors"
          >
            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            <span>Back to Public Portfolio</span>
          </router-link>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import { useRouter } from 'vue-router';
import axios from 'axios';

const router = useRouter();

const form = ref({
  email: 'admin@portofolio.test',
  password: 'password123',
});

const showPassword = ref(false);
const loading = ref(false);
const errorMessage = ref('');

const handleLogin = async () => {
  loading.value = true;
  errorMessage.value = '';

  try {
    const response = await axios.post('/api/admin/login', {
      email: form.value.email,
      password: form.value.password,
    });

    if (response.data && response.data.success) {
      const { token, user } = response.data.data;

      // Store auth in localStorage
      localStorage.setItem('admin_token', token);
      localStorage.setItem('admin_user', JSON.stringify(user));

      // Inject to Axios defaults immediately
      window.axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;

      // Redirect to Admin Dashboard
      router.push('/admin/dashboard');
    } else {
      errorMessage.value = response.data.message || 'Login gagal, periksa email dan password Anda.';
    }
  } catch (error) {
    if (error.response && error.response.data && error.response.data.message) {
      errorMessage.value = error.response.data.message;
    } else {
      errorMessage.value = 'Kredensial tidak valid atau server bermasalah.';
    }
  } finally {
    loading.value = false;
  }
};
</script>
