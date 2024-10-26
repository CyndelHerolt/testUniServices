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

// extract user data from the token
const tokenParts = token.split('.');
const payload = JSON.parse(atob(tokenParts[1]));
const email = payload.username;
console.log(payload);

const storedToken = ref(localStorage.getItem('token'));
axios.defaults.withCredentials = true;
const submitForm = async () => {
  try {
    const formData = new FormData();
    formData.append('libelle', libelle.value);
    formData.append('coeff', JSON.stringify({ value: coeff.value, type: 'int' }));
    formData.append('note', JSON.stringify({ value: note.value, type: 'int' }));
    formData.append('student', JSON.stringify({ value: selectedStudent.value.id, type: 'int' }));

    const response = await axios.post('http://localhost:8000/universal/evaluations/8002', formData, {
      headers: {
        Authorization: `Bearer ${storedToken.value}`,
      },
    });
    console.log('Evaluation added:', response.data);
  } catch (error) {
    console.error('Error posting evaluation:', error);
  }
};

onMounted(async () => {
  try {
    const method = 'GET';
    const response = await axios.get('http://localhost:8000/universal/users/8001', {
      headers: {
        Authorization: `Bearer ${storedToken.value}`,
      },
    });
    students.value = response.data.member;
  } catch (error) {
    console.error('Error fetching users:', error);
  }
});

const items = ref([
  {
    label: 'Finder',
    icon: 'https://primefaces.org/cdn/primevue/images/dock/finder.svg',
    url: 'http://localhost:5173/portail'
  },
  {
    label: 'App Store',
    icon: 'https://primefaces.org/cdn/primevue/images/dock/appstore.svg'
  },
  {
    label: 'Photos',
    icon: 'https://primefaces.org/cdn/primevue/images/dock/photos.svg'
  },
  {
    label: 'Trash',
    icon: 'https://primefaces.org/cdn/primevue/images/dock/trash.png'
  }
]);
const position = ref('bottom');


const menuItems = ref([
  {
    label: 'Home',
    icon: 'pi pi-home',
    url: 'http://localhost:5173/portail'
  },
  {
    label: 'Features',
    icon: 'pi pi-star'
  },
  {
    label: 'Projects',
    icon: 'pi pi-search',
    items: [
      {
        label: 'Components',
        icon: 'pi pi-bolt'
      },
      {
        label: 'Blocks',
        icon: 'pi pi-server'
      },
      {
        label: 'UI Kit',
        icon: 'pi pi-pencil'
      },
      {
        label: 'Templates',
        icon: 'pi pi-palette',
        items: [
          {
            label: 'Apollo',
            icon: 'pi pi-palette'
          },
          {
            label: 'Ultima',
            icon: 'pi pi-palette'
          }
        ]
      }
    ]
  },
  {
    label: 'Contact',
    icon: 'pi pi-envelope'
  }
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
