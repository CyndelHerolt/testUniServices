<script setup>
const token = document.cookie.split('; ').find(row => row.startsWith('token'))?.split('=')[1];
if (token) {
  localStorage.setItem('token', token);
}
const tokenParts = token?.split('.');
const payload = tokenParts ? JSON.parse(atob(tokenParts[1])) : {};
const email = payload.username;

const redirectToUnifolio = async () => {
  window.location.replace('http://localhost:5174');
};

const redirectToIntranet = async () => {
  window.location.replace('http://localhost:5175');
}
</script>

<template>
  <main>
    <Fieldset legend="Portail" class="register">
      <Card>
        <template #title>Tools</template>
        <template #content>
          <Button label="Intranet" outlined @click="redirectToIntranet" />
          <a href="http://localhost:5175   0 "></a>
          <Button label="Unifolio" outlined @click="redirectToUnifolio" />
        </template>
      </Card>
    </Fieldset>
  </main>
</template>

<style>

</style>
