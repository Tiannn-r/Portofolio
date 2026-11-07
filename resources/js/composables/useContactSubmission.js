import { ref } from 'vue';
import axios from 'axios';
import { useToast } from './useToast';

export function useContactSubmission() {
  const toast = useToast();

  const form = ref({
    name: '',
    email: '',
    message: '',
  });

  const isSubmitting = ref(false);
  const feedback = ref({
    message: '',
    success: false,
  });

  const resetForm = () => {
    form.value = {
      name: '',
      email: '',
      message: '',
    };
  };

  const submitContact = async () => {
    if (!form.value.name || !form.value.email || !form.value.message) {
      feedback.value = {
        message: 'Mohon lengkapi semua kolom formulir kontak.',
        success: false,
      };
      toast.error('Mohon lengkapi semua bidang.');
      return false;
    }

    isSubmitting.value = true;
    feedback.value = { message: '', success: false };

    try {
      const response = await axios.post('/api/contact', {
        name: form.value.name,
        email: form.value.email,
        message: form.value.message,
      });

      if (response.data && response.data.success) {
        const msg = response.data.message || 'Pesan Anda telah berhasil dikirim!';
        feedback.value = {
          message: msg,
          success: true,
        };
        toast.success(msg);
        resetForm();
        return true;
      }
    } catch (err) {
      const errMsg =
        err.response?.data?.message ||
        'Gagal mengirim pesan. Silakan periksa kembali data Anda atau coba beberapa saat lagi.';
      feedback.value = {
        message: errMsg,
        success: false,
      };
      toast.error(errMsg);
      return false;
    } finally {
      isSubmitting.value = false;
    }
  };

  return {
    form,
    isSubmitting,
    feedback,
    submitContact,
    resetForm,
  };
}
