<script setup>
import axios from "axios";
import * as yup from "yup";
import {useField, useForm} from "vee-validate";
import {onMounted, ref} from "vue";

const students = ref([]);
const storedToken = ref(localStorage.getItem('token'));

onMounted(async () => {
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
</script>

<template>
  <main>
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
          <label for="note">Note</label>
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
    input {
      width: 100% !important;
    }
  }
}
</style>
