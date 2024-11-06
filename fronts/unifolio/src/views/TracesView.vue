<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';

const userString = localStorage.getItem('user');
const user = ref(userString ? JSON.parse(userString) : null);

const storedToken = ref(localStorage.getItem('token'));

</script>

<template>
  <main>
    <h1>Traces</h1>

    <p>Hello {{ user?.email }}</p>
    <small>
      {{ storedToken }}
    </small>
  </main>
</template>
