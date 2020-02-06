import 'es6-promise/auto'
import axios from 'axios'
import './bootstrap'
import Vue from 'vue'
import VueAuth from '@websanova/vue-auth'
import VueAxios from 'vue-axios'
import VueRouter from 'vue-router'
import Index from './Index'
import auth from './auth'
import router from './router'

import BootstrapVue from 'bootstrap-vue'

export const serverBus = new Vue();

import { Form, HasError, AlertError } from 'vform'


window.Form = Form
Vue.component(HasError.name, HasError)
Vue.component(AlertError.name, AlertError)

Vue.use(BootstrapVue)


// import 'bootstrap/dist/css/bootstrap.css'
// import 'bootstrap-vue/dist/bootstrap-vue.css'

// Set Vue globally
window.Vue = Vue
window.axios = require('axios');

// Set Vue router
Vue.router = router
Vue.use(VueRouter)

//filter currency
Vue.filter('toCurrency', function (value) {
    if (typeof value !== "number") {
        return value;
    }
    var formatter = new Intl.NumberFormat('en-US'
    // , {
    //     style: 'currency',
    //     currency: '',
    //     minimumFractionDigits: 0
    // }
    );
    return formatter.format(value);
});

// Set Vue authentication
Vue.use(VueAxios, axios)
<<<<<<< HEAD
axios.defaults.baseURL = `http://localhost:8080/api`
Vue.use(VueAuth, auth)
//VueCookie.get('api_token');
=======
axios.defaults.baseURL = `http://localhost:8010/api`
Vue.use(VueAuth, auth)
>>>>>>> 730a4f5e0a45fdfbd4987c405170fa8f2c6f1bc8

// Load Index
Vue.component('index', Index)

const app = new Vue({
  el: '#app',
  router
});
