import { ref, computed, onMounted, onUnmounted, unref } from 'vue';

export function useTypingEffect(wordsSource, options = {}) {
  const {
    typeSpeed = 90,
    deleteSpeed = 45,
    holdTime = 1800,
    pauseTime = 400,
  } = options;

  const currentText = ref('');
  const isTyping = ref(false);
  let wordIndex = 0;
  let charIndex = 0;
  let isDeleting = false;
  let timer = null;

  const words = computed(() => {
    const raw = unref(wordsSource);
    return Array.isArray(raw) && raw.length > 0
      ? raw
      : ['Full-Stack Developer', 'UI/UX Enthusiast', 'Backend Specialist'];
  });

  const tick = () => {
    const list = words.value;
    if (!list.length) return;

    const currentWord = list[wordIndex % list.length];

    if (isDeleting) {
      currentText.value = currentWord.substring(0, charIndex - 1);
      charIndex--;
    } else {
      currentText.value = currentWord.substring(0, charIndex + 1);
      charIndex++;
    }

    let delay = isDeleting ? deleteSpeed : typeSpeed;

    if (!isDeleting && charIndex === currentWord.length) {
      delay = holdTime;
      isDeleting = true;
    } else if (isDeleting && charIndex === 0) {
      isDeleting = false;
      wordIndex++;
      delay = pauseTime;
    }

    timer = setTimeout(tick, delay);
  };

  onMounted(() => {
    isTyping.value = true;
    tick();
  });

  onUnmounted(() => {
    isTyping.value = false;
    if (timer) clearTimeout(timer);
  });

  return {
    currentText,
    isTyping,
  };
}

