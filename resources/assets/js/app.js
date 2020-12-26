
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

import Vuetify from "vuetify";
Vue.use(Vuetify);

import * as VueGoogleMaps from 'vue2-google-maps';



Vue.use(VueGoogleMaps, 
    {
        load: {
            key: 'AIzaSyC0BU9xbauWZcWtnD-eAQaFKU9vYJQ8Mn8'
        }

    })

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */



Vue.component('vehiculo', require('./components/Vehiculo.vue'));
Vue.component('paraderos', require('./components/Paraderos.vue'));
Vue.component('rutas', require('./components/Rutas.vue'));
Vue.component('tipos', require('./components/Tipos.vue'));
Vue.component('horarios', require('./components/Horarios.vue'));

Vue.component('info', require('./components/Informacion.vue'));
Vue.component('ejemplo', require('./components/ejemplo.vue'));

const app = new Vue({
    el: '#app',
    data :{
        menu : 0
    }
});
