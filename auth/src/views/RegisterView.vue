<script setup>
import { ref } from 'vue';
import axios from 'axios';

const roleValue = ref('Etudiant');
const options = ref(['Etudiant', 'Enseignant', 'Administratif']);
const username = ref('');
const email = ref('');
const password = ref('');

const submitForm = async () => {
  try {
    const formData = new FormData();
    formData.append('username', username.value);
    formData.append('email', email.value);
    formData.append('password', password.value);
    formData.append('role', roleValue.value);

    const response = await axios.post('http://localhost:8000/register',
      formData,
    );
    console.log('User registered successfully:', response.data);
  } catch (error) {
    console.error('Error registering user:', error);
  }
};
</script>

<template>
  <main>
    <Fieldset legend="Inscription" class="register">
      <form @submit.prevent="submitForm">
        <IftaLabel>
          <InputText id="username" v-model="username" />
          <label for="username">Username</label>
        </IftaLabel>
        <IftaLabel>
          <InputText id="email" v-model="email" />
          <label for="email">Email</label>
        </IftaLabel>
        <IftaLabel>
          <InputText id="password" v-model="password" />
          <label for="password">Password</label>
        </IftaLabel>
        <div>
          <SelectButton v-model="roleValue" :options="options" aria-labelledby="role" />
        </div>

        <Button label="S'enregistrer" raised type="submit" />
      </form>
      <Divider />
      <div class="connect">
        <p>
          Vous avez déjà un compte ?
        </p>
        <Button label="Se connecter" severity="secondary" raised />
      </div>
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
