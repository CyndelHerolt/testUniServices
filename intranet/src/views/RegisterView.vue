<script setup>
import { ref } from 'vue';

const roleValue = ref('Etudiant');
const options = ref(['Etudiant', 'Enseignant', 'Administratif']);

// axios
import axios from 'axios';

</script>

<template>
  <main>
    <Fieldset legend="Inscription" class="register">
      <form action="">
        <IftaLabel>
          <InputText id="username" v-model="value" />
          <label for="username">Username</label>
        </IftaLabel>
        <IftaLabel>
          <InputText id="email" v-model="value" />
          <label for="email">Email</label>
        </IftaLabel>
        <IftaLabel>
          <InputText id="password" v-model="value" />
          <label for="password">Password</label>
        </IftaLabel>
        <div>
          <SelectButton v-model="roleValue" :options="options" aria-labelledby="role" />
        </div>

        <Button label="S'enregistrer" raised />
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
