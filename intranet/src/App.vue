<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';

const user = ref(null);

const token = document.cookie.split('; ').find(row => row.startsWith('token'))?.split('=')[1];
if (token) localStorage.setItem('token', token);

const tokenParts = token?.split('.');
const payload = tokenParts ? JSON.parse(atob(tokenParts[1])) : {};
const userId = payload.user_id;
const storedToken = ref(localStorage.getItem('token'));

const checkTokenExpiration = () => {
  const token = localStorage.getItem('token');
  if (token) {
    const { exp } = JSON.parse(atob(token.split('.')[1]));
    if (Date.now() >= exp * 1000) {
      localStorage.removeItem('token');
      localStorage.removeItem('user');
      window.location.href = 'http://localhost:5173/login';
    }
  } else {
    window.location.href = 'http://localhost:5173/login';
    localStorage.removeItem('user');
  }
};

onMounted(async () => {
  checkTokenExpiration();
  try {
    const userResponse = await axios.get(`http://localhost:8000/universal/users-${userId}/8001/`, {
      headers: { Authorization: `Bearer ${storedToken.value}` },
    });
    user.value = userResponse.data;
    localStorage.setItem('user', JSON.stringify(userResponse.data));
  } catch (error) {
    console.error('Error fetching user:', error);
  }
});

const menuItems = ref([
  { label: 'Back', icon: 'pi pi-arrow-circle-left', url: 'http://localhost:5173/portail' },
  { label: 'Home', icon: 'pi pi-home', url: '/' },
  {
    label: 'Features', icon: 'pi pi-search', items: [
      { label: 'Eval', icon: 'pi pi-bolt', url:'/eval' },
      { label: 'Edt', icon: 'pi pi-server', url:'/edt' },
      {
        label: 'Templates', icon: 'pi pi-palette', items: [
          { label: 'Apollo', icon: 'pi pi-palette' },
          { label: 'Ultima', icon: 'pi pi-palette' },
        ],
      },
    ],
  },
  { label: 'Contact', icon: 'pi pi-envelope' },
]);
</script>

<template>
  <header>
    <Menubar :model="menuItems" />
  </header>

  <main>
    <h1>Intranet</h1>
    <p>Hello {{ user?.email }}</p>

    <RouterView />
  </main>
</template>

<style scoped>

</style>
