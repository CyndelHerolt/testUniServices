<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';
import { useField, useForm } from 'vee-validate';
import * as yup from 'yup';

const note = ref(10);
const libelle = ref('');
const coeff = ref(1);
const students = ref([]);
const selectedStudent = ref(null);
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
    const userResponse = await axios.get(`http://localhost:8000/universal/users_${userId}/8001/`, {
      headers: { Authorization: `Bearer ${storedToken.value}` },
    });
    user.value = userResponse.data;
    localStorage.setItem('user', JSON.stringify(userResponse.data));
  } catch (error) {
    console.error('Error fetching user:', error);
  }
  try {
    const studentsResponse = await axios.get('http://localhost:8000/universal/users/8001', {
      headers: { Authorization: `Bearer ${storedToken.value}` },
    });
    students.value = studentsResponse.data.member;
  } catch (error) {
    console.error('Error fetching users:', error);
  }
});

axios.defaults.withCredentials = true;
const schema = yup.object({
  libelle: yup.string().required('Libelle is required'),
  coeff: yup.number().required('Coeff is required').min(1, 'Coeff must be at least 1'),
  note: yup.number().required('Note is required').min(0, 'Note must be at least 0').max(20, 'Note must be at most 20'),
  selectedStudent: yup.object().required('Student is required')
});

const { handleSubmit, errors } = useForm({
  validationSchema: schema
});

const { value: libelleValue } = useField('libelle');
const { value: coeffValue } = useField('coeff');
const { value: noteValue } = useField('note');
const { value: selectedStudentValue } = useField('selectedStudent');

const submitForm = handleSubmit(async (values) => {
  try {
    const data = {
      libelle: values.libelle,
      coeff: values.coeff,
      note: values.note,
      etudiant: values.selectedStudent.id,
    };
    const response = await axios.post('http://localhost:8000/universal/evaluations/8002', data, {
      headers: {
        'Content-Type': 'application/json',
        Authorization: `Bearer ${storedToken.value}`,
      },
    });
    console.log('Evaluation added:', response.data);
  } catch (error) {
    console.error('Error posting evaluation:', error);
  }
});

const items = ref([
  { label: 'Finder', icon: 'https://primefaces.org/cdn/primevue/images/dock/finder.svg', url: 'http://localhost:5173/portail' },
  { label: 'App Store', icon: 'https://primefaces.org/cdn/primevue/images/dock/appstore.svg' },
  { label: 'Photos', icon: 'https://primefaces.org/cdn/primevue/images/dock/photos.svg' },
  { label: 'Trash', icon: 'https://primefaces.org/cdn/primevue/images/dock/trash.png' },
]);
const position = ref('bottom');

const menuItems = ref([
  { label: 'Home', icon: 'pi pi-home', url: 'http://localhost:5173/portail' },
  { label: 'Features', icon: 'pi pi-star' },
  {
    label: 'Projects', icon: 'pi pi-search', items: [
      { label: 'Components', icon: 'pi pi-bolt' },
      { label: 'Blocks', icon: 'pi pi-server' },
      { label: 'UI Kit', icon: 'pi pi-pencil' },
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
  <Dock :model="items" :position="position">
    <template #itemicon="{ item }">
      <img v-tooltip.top="item.label" :alt="item.label" :src="item.icon" style="width: 100%" />
    </template>
  </Dock>

  <main>
    <h1>Intranet</h1>
    <p>Hello {{ user?.email }}</p>

    <Fieldset legend="Notes" class="notes">
      <form @submit.prevent="submitForm">
        <IftaLabel>
          <InputText id="libelle" v-model="libelleValue" :invalid="errors.libelle" />
          <label for="libelle">Libelle</label>
          <small v-if="errors.libelle" class="p-error">{{ errors.libelle }}</small>
        </IftaLabel>
        <IftaLabel>
          <InputNumber id="coeff" v-model="coeffValue" inputId="integeronly" fluid :invalid="errors.coeff"/>
          <label for="coeff">Coeff.</label>
          <small v-if="errors.coeff" class="p-error">{{ errors.coeff }}</small>
        </IftaLabel>
        <div>
          <InputNumber v-model="noteValue" showButtons buttonLayout="horizontal" style="width: 100%" :min="0" :max="20" :invalid="errors.note">
            <template #incrementbuttonicon>
              <span class="pi pi-plus" />
            </template>
            <template #decrementbuttonicon>
              <span class="pi pi-minus" />
            </template>
          </InputNumber>
          <small v-if="errors.note">{{ errors.note }}</small>
        </div>
        <div>
          <Select v-model="selectedStudentValue" :options="students" optionLabel="email" placeholder="Select a Student" style="width: 100%" :invalid="errors.selectedStudent"/>
          <small v-if="errors.selectedStudent">{{ errors.selectedStudent }}</small>
        </div>

        <Button label="Valider" raised type="submit" />
      </form>
    </Fieldset>
  </main>
</template>

<style scoped>
.notes {
  width: 50%;
  form {
    display: flex;
    flex-direction: column;
    gap: 2rem;
    margin: 2rem 0;
    input, .p-inputnumber {
      width: 100% !important;
    }
  }
}
</style>
