<script setup>
import { ref, onMounted } from 'vue';

const userString = localStorage.getItem('user');
const user = ref(userString ? JSON.parse(userString) : null);

const storedToken = ref(localStorage.getItem('token'));
</script>

<template>
  <main>
    <h1>home</h1>
  </main>
</template>
