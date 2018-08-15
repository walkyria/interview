
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('example-component', {
    template: '<h3>{{ title }}</h3>'
});

const app = new Vue({
    el: '#app'
});

new Vue({
   el: '#my-example',
    data: {
        title: 'Im example components title'
    }
});