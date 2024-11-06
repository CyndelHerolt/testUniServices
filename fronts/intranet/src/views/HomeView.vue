<script setup>
</script>

<template>
  <main>
    <Fieldset legend="Features" class="features">
      <Card>
        <template #title>Tools</template>
        <template #content>
          <Button as="router-link" label="Eval" outlined to="/eval" />
          <Button as="router-link" label="Edt" outlined to="/edt" />
        </template>
      </Card>
    </Fieldset>
  </main>
</template>
