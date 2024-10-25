<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';

const note = ref(10);
const libelle = ref('');
const coeff = ref(1);
const students = ref([]);
const selectedStudent = ref(null);

// Retrieve the JWT token from the URL and store it in local storage
const url = new URL(window.location.href);
const token = url.searchParams.get('token');
if (token) {
  localStorage.setItem('token', token);
}

const storedToken = ref(localStorage.getItem('token'));

const submitForm = async () => {
  try {
    const formData = new FormData();
    formData.append('libelle', libelle.value);
    formData.append('coeff', coeff.value);
    formData.append('note', note.value);
    formData.append('student', selectedStudent.value.id);

    const response = await axios.post('http://localhost:8000/note', formData, storedToken.value);
    console.log('Evaluation added:', response.data);
  } catch (error) {
    console.error('Error posting evaluation:', error);
  }
};

onMounted(async () => {
  try {
    const response = await axios.get('http://localhost:8001/api/users', {
      headers: {
        Authorization: `Bearer ${storedToken.value}`,
      },
    });
    students.value = response.data.member;
  } catch (error) {
    console.error('Error fetching users:', error);
  }
});
</script>

<template>
  <main>
    <h1>Intranet</h1>
<!--    <small>Token: {{ storedToken }}</small>-->

    <Fieldset legend="Notes" class="notes">
      <form @submit.prevent="submitForm">
        <IftaLabel>
          <InputText id="libelle" v-model="libelle" />
          <label for="libelle">Libelle</label>
        </IftaLabel>
        <IftaLabel>
          <InputNumber v-model="coeff" inputId="integeronly" fluid />
          <label for="coeff">Coeff.</label>
        </IftaLabel>

        <InputNumber v-model="note" showButtons buttonLayout="horizontal" style="width: 3rem" :min="0" :max="20">
          <template #incrementbuttonicon>
            <span class="pi pi-plus" />
          </template>
          <template #decrementbuttonicon>
            <span class="pi pi-minus" />
          </template>
        </InputNumber>

        <Select v-model="selectedStudent" :options="students" optionLabel="email" placeholder="Select a Student" class="w-full md:w-56" />

        <Button label="Valider" raised type="submit" />
      </form>
    </Fieldset>
  </main>
</template>

<style scoped>
.notes {
  width: 25%;

  form {
    display: flex;
    flex-direction: column;
    gap: 2rem;
    margin: 2rem 0;

    input, #password {
      width: 100%;
    }
  }
}
</style>
