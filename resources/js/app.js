
require('./bootstrap');

import Vue from 'vue';
import VueSweetalert2 from 'vue-sweetalert2';
import VueToast from 'vue-toast-notification';
import 'vue-toast-notification/dist/theme-sugar.css';
Vue.use(VueToast);

import 'sweetalert2/dist/sweetalert2.min.css';

Vue.use(VueSweetalert2);

Vue.component('posts', require('./components/Posts.vue').default);


const app = new Vue({
    el: '#app',
});


