/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

import Vue from 'vue'
import VueBootstrapTypeahead from 'vue-bootstrap-typeahead'
import FloatingVue from 'floating-vue'

import 'bootstrap-icons/font/bootstrap-icons.css'
import './components'
import './../css/app.css'
import 'floating-vue/dist/style.css'

Vue.component('vue-bootstrap-typeahead', VueBootstrapTypeahead)
Vue.use(FloatingVue)



const app = new Vue({
    el: '#app',
});
