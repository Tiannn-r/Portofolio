import { ref } from 'vue';

const toasts = ref([]);
let toastCounter = 0;

export function useToast() {
  const addToast = (message, type = 'success', duration = 4000) => {
    const id = ++toastCounter;
    toasts.value.push({ id, message, type });

    if (duration > 0) {
      setTimeout(() => {
        removeToast(id);
      }, duration);
    }
  };

  const removeToast = (id) => {
    toasts.value = toasts.value.filter((t) => t.id !== id);
  };

  const success = (message, duration = 4000) => addToast(message, 'success', duration);
  const error = (message, duration = 5000) => addToast(message, 'error', duration);
  const info = (message, duration = 4000) => addToast(message, 'info', duration);

  return {
    toasts,
    addToast,
    removeToast,
    success,
    error,
    info,
  };
}
