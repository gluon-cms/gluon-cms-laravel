/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

//const files = require.context('./', true, /\.vue$/i);
//files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

Vue.component('gluon-parameter-number', require('./components/gluon/admin/GluonParameter_Number.vue').default);
Vue.component('gluon-parameter-text', require('./components/gluon/admin/GluonParameter_Text.vue').default);
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
});
