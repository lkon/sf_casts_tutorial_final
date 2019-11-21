import Vue from 'vue';
import ImageApp from './components/ImageApp';

const app = new Vue({
    render: h => h(ImageApp)
}).$mount('#images-app');
