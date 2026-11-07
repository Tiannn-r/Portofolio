<template>
  <div>
    <router-view />
    <ToastNotification />
  </div>
</template>

<script setup>
import ToastNotification from './components/ui/ToastNotification.vue';
</script>
