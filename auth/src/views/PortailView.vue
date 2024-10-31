<script setup>

// récupérer le token depuis le cookie
const token = document.cookie.split('; ').find(row => row.startsWith('token')).split('=')[1];
if (token) {
  localStorage.setItem('token', token);
}
// extract user data from the token
const tokenParts = token.split('.');
const payload = JSON.parse(atob(tokenParts[1]));
const email = payload.username;

const redirectToUnifolio = async () => {
  window.location.href = 'http://localhost:5174';
};

// passer le token en paramètre
const redirectToIntranet = async () => {
  window.location.href = `http://localhost:5175`;
}
</script>

<template>
  <main>
    <Fieldset legend="Portail" class="register">
      <Card>
        <template #title>Tools</template>
        <template #content>
          <Button label="Intranet" outlined @click="redirectToIntranet" />
          <Button label="Unifolio" outlined @click="redirectToUnifolio" />
        </template>
      </Card>
    </Fieldset>
  </main>
</template>

<style>

</style>
