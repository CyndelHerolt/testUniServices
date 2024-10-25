<script setup>
import { ref } from 'vue';
import axios from 'axios';
import router from "@/router/index.js";

const roleValue = ref('Etudiant');
const options = ref(['Etudiant', 'Enseignant', 'Administratif']);
const username = ref('');
const email = ref('');
const password = ref('');

const submitForm = async () => {
  try {
    const formData = new FormData();
    formData.append('email', email.value);
    formData.append('password', password.value);

    const response = await axios.post('http://localhost:8000/login',
      formData,
    );
    console.log('User logged successfully:', response.data);
    localStorage.setItem('token', response.data.token);
    document.cookie = `token=${response.data.token}; Secure; SameSite=None; HttpOnly`;
    router.push('/test');
  } catch (error) {
    console.error('Error logged user:', error);
  }
};
</script>

<template>
  <main>
    <Fieldset legend="Connexion" class="register">
      <form @submit.prevent="submitForm">
        <IftaLabel>
          <InputText id="email" v-model="email" />
          <label for="email">Email</label>
        </IftaLabel>
        <IftaLabel>
          <InputText id="password" v-model="password" />
          <label for="password">Password</label>
        </IftaLabel>

        <Button label="Se connecter" raised type="submit" />
      </form>
    </Fieldset>
  </main>
</template>

<style>
.register {
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

.connect {
  display: flex;
  flex-direction: column;
  align-items: center;
}
</style>
