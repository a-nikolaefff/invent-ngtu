import {createApp} from 'vue';
import Model from './vue_components/Model.vue';

const app = createApp({})

app.component('model-components', Model);
app.mount('#vue_container')
