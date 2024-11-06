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

const allMenuItems = ref([
  {
    label: 'LogIn',
    icon: 'pi pi-sign-in',
    condition: () => !isLoggedIn.value,
    url: '/login',
  },
  {
    label: 'Register',
    icon: 'pi pi-user-plus',
    condition: () => !isLoggedIn.value,
    url: '/register',
  },
  {
    label: 'Logout',
    icon: 'pi pi-sign-out',
    command: logout,
    condition: () => isLoggedIn.value,
  },
]);

const menuItems = computed(() => {
  return allMenuItems.value.filter(item => item.condition());
});
</script>

<template>
  <header>
    <Menubar :model="menuItems" />
  </header>

  <RouterView />
</template>

<style scoped>
/* Add your styles here */
</style>
