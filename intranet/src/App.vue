<script setup>
import { RouterLink, RouterView } from 'vue-router'
</script>

<template>
  <header>
      <nav>
        <RouterLink to="/">Inscription</RouterLink>
        <RouterLink to="/login">Connexion</RouterLink>
        <RouterLink to="/test">test</RouterLink>
      </nav>
  </header>

  <RouterView />
</template>

<style scoped>

</style>
