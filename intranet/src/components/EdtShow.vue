<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';
import { startOfWeek, addDays, format } from 'date-fns';

const storedToken = ref(localStorage.getItem('token'));
const edtData = ref([]);

const getCours = async () => {
  try {
    const startOfCurrentWeek = startOfWeek(new Date(), { weekStartsOn: 1 });
    const endOfCurrentWeek = addDays(startOfCurrentWeek, 4);
    const formattedStartOfCurrentWeek = format(startOfCurrentWeek, 'yyyy-MM-dd');
    const formattedEndOfCurrentWeek = format(endOfCurrentWeek, 'yyyy-MM-dd');

    const data = {
      start: formattedStartOfCurrentWeek,
      end: formattedEndOfCurrentWeek,
    };

    const response = await axios.post('http://localhost:8000/edt/week', data, {
      'Content-Type': 'application/json',
      Authorization: `Bearer ${storedToken.value}`,
    });
    edtData.value = response.data;
    console.log('Edt data:', edtData.value);
  } catch (error) {
    console.error('Error fetching edt data:', error);
  }
};
onMounted(getCours);

const Days = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi'];
const hours = Array.from({ length: 12 }, (_, i) => `${8 + i}:00`);

const getCoursesForDayAndHour = (day, hour) => {
  const dayIndex = Days.indexOf(day) + 1;
  const hourInt = parseInt(hour.split(':')[0], 10);
  return edtData.value.filter(course => course.jour === dayIndex && course.debut <= hourInt && course.fin > hourInt);
};
</script>

<template>
  <div class="edt-show">
    <table>
      <thead>
        <tr>
          <th>Heure</th>
          <th v-for="day in Days" :key="day">{{ day }}</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="hour in hours" :key="hour">
          <td>{{ hour }}</td>
          <td v-for="day in Days" :key="day">
            <div v-for="course in getCoursesForDayAndHour(day, hour)" :key="course.id">
              {{ course.matiere }} ({{ course.debut }} - {{ course.fin }})
            </div>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<style scoped>
table {
  width: 100%;
  border-collapse: collapse;
}

th, td {
  border: 1px solid rgba(255, 255, 255, 0.4);
  padding: 8px;
  text-align: left;
}

td {
  height: 50px;
  vertical-align: top;
}
</style>
