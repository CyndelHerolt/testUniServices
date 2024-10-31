<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';
import { startOfWeek, addDays, format } from 'date-fns';

const storedToken = ref(localStorage.getItem('token'));
const edtData = ref([]);

const getCours = async () => {
  try {
    const response = await axios.get('http://localhost:8000/universal/edt_plannings/8002', {
      headers: { Authorization: `Bearer ${storedToken.value}` },
    });
    edtData.value = response.data.member;
    console.log('Edt data:', edtData.value);
  } catch (error) {
    console.error('Error fetching edt data:', error);
  }
};

onMounted(() => {
  getCours();
});

</script>

<template>
  <div class="edt-show">

  </div>
</template>

<style scoped>

</style>
