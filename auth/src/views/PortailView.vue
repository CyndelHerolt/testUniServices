<script setup>
const token = localStorage.getItem('token');
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
      <p>Token
        <span v-if="token">: {{ token }}</span>
        <span v-else>: No token</span>
      </p>
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
