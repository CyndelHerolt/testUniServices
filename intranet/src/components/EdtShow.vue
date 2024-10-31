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

const hours = Array.from({ length: 26 }, (_, i) => `${8 + Math.floor(i / 2)}:${i % 2 === 0 ? '00' : '30'}`);

const getCoursesForDayAndHour = (dayIndex, hour) => {
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

const getRowSpan = (course) => {
  const startHour = Math.floor(course.debut);
  const startMinute = (course.debut % 1) * 60;
  const endHour = Math.floor(course.fin);
  const endMinute = (course.fin % 1) * 60;
  const duration = (endHour * 60 + endMinute) - (startHour * 60 + startMinute);
  return Math.ceil(duration / 30);
};

const shouldRenderCourse = (dayIndex, hour) => {
  const hourInt = parseInt(hour.split(':')[0], 10);
  const minuteInt = parseInt(hour.split(':')[1], 10);
  return edtData.value.some(course => {
    const courseStartHour = Math.floor(course.debut);
    const courseStartMinute = (course.debut % 1) * 60;
    return course.jour === dayIndex &&
           courseStartHour === hourInt &&
           courseStartMinute === minuteInt;
  });
};
</script>

<template>
  <div class="edt-show">
    <table>
      <thead>
      <tr>
        <th class="hours"></th>
        <th v-for="(day, index) in weekDays" :key="day">{{ day }}</th>
      </tr>
      </thead>
      <tbody>
      <tr v-for="hour in hours" :key="hour">
        <td class="hours">{{ hour }}</td>
        <template v-for="(day, index) in weekDays" :key="day">
          <td v-if="shouldRenderCourse(index + 1, hour)" v-for="course in getCoursesForDayAndHour(index + 1, hour)" :key="course.id" v-bind:rowspan="getRowSpan(course)" class="course">
            <ul>
              <li>{{ course.matiere }}</li>
              <li><small>{{ course.salle }}</small></li>
              <li><small>{{ course.type }} - {{ course.groupe }}</small></li>
            </ul>
          </td>
          <td v-else></td>
        </template>
      </tr>
      </tbody>
    </table>
  </div>
</template>

<style scoped>
table {
  width: 100%;
  border-collapse: separate;
  border-spacing: 10px 0;
  table-layout: fixed;
}

.hours {
  padding: 10px;
  width: 7% !important;
  background-color: transparent;
  text-align: center;
  color: rgba(119, 119, 119);
}
th, td {
  width: 20%;
  background-color: rgba(119, 119, 119, 0.05);
}

th {
  padding: 2rem 10px;
  text-align: center;
}

td {
  padding: 8px;
  text-align: left;
  vertical-align: top;
}

ul {
  list-style-type: none;
  padding: 0;
  margin: 0;
}

.course {
  background-color: #c3ffe6;
  color: #333;
  margin: 2px 0;
  padding: 5px;
  border-radius: 4px;
}
</style>
