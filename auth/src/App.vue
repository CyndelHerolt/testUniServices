<script setup>
import {RouterLink, RouterView} from 'vue-router'
import {ref, computed} from 'vue';

const userToken = ref(localStorage.getItem('token'));

const isLoggedIn = computed(() => {
  return userToken.value != null;
});

const logout = () => {
  localStorage.removeItem('token');
  location.reload();
};
</script>

<template>
  <header>
    <nav>
      <RouterLink v-if="!isLoggedIn" to="/">Inscription</RouterLink>
      <RouterLink v-if="!isLoggedIn" to="/login">Connexion</RouterLink>
      <button v-if="isLoggedIn" @click="logout">Logout</button>
    </nav>
  </header>

  <RouterView />
</template>

<style scoped>
/* Add your styles here */
</style>
