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
Vue.component('gluon-parameter-relation-one', require('./components/gluon/admin/GluonParameter_RelationOne.vue').default);
Vue.component('gluon-parameter-relation-many', require('./components/gluon/admin/GluonParameter_RelationMany.vue').default);

const app = new Vue({
    el: '#app',
});
