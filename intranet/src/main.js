import './assets/main.css'

import { createApp } from 'vue'
import App from './App.vue'
import router from './router'
import PrimeVue from 'primevue/config';
import Aura from '@primevue/themes/aura';
import 'primeicons/primeicons.css'


import Button from "primevue/button"
import Fieldset from 'primevue/fieldset';
import FloatLabel from 'primevue/floatlabel';
import IftaLabel from 'primevue/iftalabel';
import InputText from "primevue/inputtext";
import Password from 'primevue/password';
import SelectButton from 'primevue/selectbutton';import Divider from 'primevue/divider';
import Card from 'primevue/card';
import InputNumber from 'primevue/inputnumber';

const app = createApp(App)

app.component('Button', Button);
app.component('Fieldset', Fieldset);
app.component('FloatLabel', FloatLabel);
app.component('IftaLabel', IftaLabel);
app.component('InputText', InputText);
app.component('Password', Password);
app.component('SelectButton', SelectButton);
app.component('Divider', Divider);
app.component('Card', Card);
app.component('InputNumber', InputNumber);

app.use(router)
app.use(PrimeVue, {
    theme: {
        preset: Aura
    }
});


app.mount('#app')
