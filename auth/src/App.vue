<script setup>
import { ref, onMounted } from 'vue'
import { RouterLink, RouterView } from 'vue-router'

const isLoggedIn = ref(false)

onMounted(() => {
  isLoggedIn.value = !!localStorage.getItem('token')
})

const logout = () => {
  localStorage.removeItem('token')
  isLoggedIn.value = false
  window.location.href = '/login'
}
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
