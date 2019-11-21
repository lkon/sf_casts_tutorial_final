import Vue from 'vue';
import ImageApp from './components/ImageApp';

import 'bootstrap/dist/css/bootstrap.css';

const app = new Vue({
    render: h => h(ImageApp)
}).$mount('#images-app');
