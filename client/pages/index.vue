<template>
      <h1>Get token</h1>
      <button @click="authStore.loadToken">Click</button><br>
      <textarea cols="50" rows="3">{{authStore.token}}</textarea>
</template>

<script setup>
const authStore = useAuthStore();

definePageMeta({
    layout: 'default',
});

</script>
