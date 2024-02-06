<script setup>
import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'
const authStore = useAuthStore();
const userStore = useUsersStore();
authStore.loadPosition();
userStore.getUsers();
</script>
<template>
  <NuxtLayout>
    <NuxtPage />
  </NuxtLayout>
</template>
