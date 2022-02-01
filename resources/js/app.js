
require('./bootstrap');

window.Vue = require('vue').default;
import VueToast from 'vue-toast-notification';
import 'vue-toast-notification/dist/theme-sugar.css';
Vue.use(VueToast);

Vue.component('posts', require('./components/Posts.vue').default);


const app = new Vue({
    el: '#app',
});


