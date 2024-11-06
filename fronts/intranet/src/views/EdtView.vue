<script setup>
import axios from "axios";
import * as yup from "yup";
import { useField, useForm } from "vee-validate";
import { onMounted, ref } from "vue";
import { format, addWeeks, startOfWeek } from "date-fns";
import EdtShow from "@/components/EdtShow.vue";

const storedToken = ref(localStorage.getItem('token'));

axios.defaults.withCredentials = true;

const users = ref([]);
onMounted(async () => {
  try {
    const usersResponse = await axios.get('http://localhost:8000/universal/users/8001', {
      headers: { Authorization: `Bearer ${storedToken.value}` },
    });
    users.value = usersResponse.data.member;
  } catch (error) {
    console.error('Error fetching users:', error);
  }
});

const schema = yup.object({
  jour: yup.number().required('Jour is required').min(1).max(5),
  salle: yup.string().required('Salle is required'),
  debut: yup.number().required('Debut is required').min(8).max(19.5),
  fin: yup.number().required('Fin is required').min(9).max(20.5),
  semaine: yup.number().required('Semaine is required').min(1),
  type: yup.string().required('Type is required').oneOf(['CM', 'TD', 'TP']),
  groupe: yup.string().required('Groupe is required'),
  matiere: yup.string().required('Matiere is required'),
});

const { handleSubmit, errors } = useForm({
  validationSchema: schema
});

const { value: jourValue } = useField('jour');
const { value: salleValue } = useField('salle');
const { value: debutValue } = useField('debut');
const { value: finValue } = useField('fin');
const { value: semaineValue } = useField('semaine');
const { value: typeValue } = useField('type');
const { value: groupeValue } = useField('groupe');
const { value: matiereValue } = useField('matiere');
const { value: selectedUserValue } = useField('selectedUser');

const submitEdt = handleSubmit(async (values) => {
  try {
    const startOfCurrentWeek = startOfWeek(new Date(), { weekStartsOn: 1 });
    const date = addWeeks(startOfCurrentWeek, values.semaine - 1);
    // trouver la bonne date en fonction du jour
    const day = values.jour;
    date.setDate(date.getDate() + day - 1);
    const formattedDate = format(date, 'yyyy-MM-dd');

    const data = {
      jour: values.jour,
      salle: values.salle,
      debut: values.debut,
      fin: values.fin,
      semaine: values.semaine,
      type: values.type,
      groupe: values.groupe,
      date: formattedDate,
      matiere: values.matiere,
      user: values.selectedUser.id,
    };

    const response = await axios.post('http://localhost:8000/universal/edt_plannings/8002', data, {
      headers: {
        'Content-Type': 'application/json',
        Authorization: `Bearer ${storedToken.value}`,
      },
    });
    console.log('Edt added');
  } catch (error) {
    console.error('Error posting edt:', error);
  }
});
</script>

<template>
  <main>
    <Fieldset legend="Edt Create" class="edt">
      <form @submit.prevent="submitEdt">
        <IftaLabel>
          <Select id="jour" v-model="jourValue" :options="[1, 2, 3, 4, 5]" :invalid="errors.jour" />
          <label for="jour">Jour</label>
          <small v-if="errors.jour" class="p-error">{{ errors.jour }}</small>
        </IftaLabel>
        <IftaLabel>
          <InputText id="salle" v-model="salleValue" :invalid="errors.salle" />
          <label for="salle">Salle</label>
          <small v-if="errors.salle" class="p-error">{{ errors.salle }}</small>
        </IftaLabel>
        <div>
          <label for="debut">Début</label>
          <InputNumber v-model="debutValue" inputId="horizontal-buttons" showButtons buttonLayout="horizontal" :step="0.5" :min="8" :max="19.5" fluid>
            <template #incrementbuttonicon>
              <span class="pi pi-plus" />
            </template>
            <template #decrementbuttonicon>
              <span class="pi pi-minus" />
            </template>
          </InputNumber>
        </div>
        <div>
          <label for="fin">Fin</label>
          <InputNumber v-model="finValue" inputId="horizontal-buttons" showButtons buttonLayout="horizontal" :step="0.5" :min="9" :max="20.5" fluid>
            <template #incrementbuttonicon>
              <span class="pi pi-plus" />
            </template>
            <template #decrementbuttonicon>
              <span class="pi pi-minus" />
            </template>
          </InputNumber>
        </div>
        <div>
          <label for="semaine">Semaine</label>
          <InputNumber v-model="semaineValue" inputId="horizontal-buttons" showButtons buttonLayout="horizontal" :step="1" :min="1" :max="20.5" fluid>
            <template #incrementbuttonicon>
              <span class="pi pi-plus" />
            </template>
            <template #decrementbuttonicon>
              <span class="pi pi-minus" />
            </template>
          </InputNumber>
        </div>
        <IftaLabel>
          <Select id="type" v-model="typeValue" :options="['CM', 'TD', 'TP']" :invalid="errors.type" />
          <label for="type">Type</label>
          <small v-if="errors.type" class="p-error">{{ errors.type }}</small>
        </IftaLabel>
        <IftaLabel>
          <InputText id="groupe" v-model="groupeValue" :invalid="errors.groupe" />
          <label for="groupe">Groupe</label>
          <small v-if="errors.groupe" class="p-error">{{ errors.groupe }}</small>
        </IftaLabel>
        <IftaLabel>
          <InputText id="matiere" v-model="matiereValue" :invalid="errors.matiere" />
          <label for="matiere">Matière</label>
          <small v-if="errors.matiere" class="p-error">{{ errors.matiere }}</small>
        </IftaLabel>
        <div>
          <Select v-model="selectedUserValue" :options="users" optionLabel="prenom" placeholder="Select a user" style="width: 100%" :invalid="errors.selectedUser"/>
          <small v-if="errors.selectedUser">{{ errors.selectedUser }}</small>
        </div>
        <Button type="submit" label="Submit" />
      </form>
    </Fieldset>


    <Fieldset legend="Edt Show" class="edt">
      <EdtShow />
    </Fieldset>
  </main>
</template>

<style scoped>
.edt {
  margin-bottom: 5rem;
  form {
    display: flex;
    flex-direction: column;
    gap: 2rem;
    margin: 2rem 0;
    input, select {
      width: 100% !important;
    }
  }
}
</style>
