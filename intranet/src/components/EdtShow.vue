<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';
import { startOfWeek, addDays, format } from 'date-fns';
import { fr } from 'date-fns/locale';

const storedToken = ref(localStorage.getItem('token'));
const edtData = ref([]);

const startOfCurrentWeek = startOfWeek(new Date(), { weekStartsOn: 1 });
const endOfCurrentWeek = addDays(startOfCurrentWeek, 4);
const formattedStartOfCurrentWeek = format(startOfCurrentWeek, 'yyyy-MM-dd');
const formattedEndOfCurrentWeek = format(endOfCurrentWeek, 'yyyy-MM-dd');
const formatDate = (date) => {
  const dayName = format(date, 'EEEE', { locale: fr });
  const dayNumber = format(date, 'dd/MM');
  return `${dayName.charAt(0).toUpperCase() + dayName.slice(1)} ${dayNumber}`;
};

const weekDays = Array.from({ length: 5 }, (_, i) => formatDate(addDays(startOfCurrentWeek, i)));

const getCours = async () => {
  try {
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
const hours = Array.from({ length: 26 }, (_, i) => `${8 + Math.floor(i / 2)}:${i % 2 === 0 ? '00' : '30'}`);

const getCoursesForDayAndHour = (day, hour) => {
  const dayIndex = Days.indexOf(day) + 1;
  const hourInt = parseInt(hour.split(':')[0], 10);
  const minuteInt = parseInt(hour.split(':')[1], 10);
  return edtData.value.filter(course => {
    const courseStartHour = Math.floor(course.debut);
    const courseStartMinute = (course.debut % 1) * 60;
    const courseEndHour = Math.floor(course.fin);
    const courseEndMinute = (course.fin % 1) * 60;
    return course.jour === dayIndex &&
           (courseStartHour < hourInt || (courseStartHour === hourInt && courseStartMinute <= minuteInt)) &&
           (courseEndHour > hourInt || (courseEndHour === hourInt && courseEndMinute > minuteInt));
  });
};
</script>

<template>
  <div class="edt-show">
    <table>
      <thead>
        <tr>
          <th v-for="day in weekDays" :key="day">{{ day }}</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="hour in hours" :key="hour">
          <td v-for="day in Days" :key="day">
            <div v-for="course in getCoursesForDayAndHour(day, hour)" :key="course.id" class="course">
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

.course {
  background-color: #f0f0f0;
  color: #333;
  margin: 2px 0;
  padding: 4px;
  border-radius: 4px;
}
</style>
