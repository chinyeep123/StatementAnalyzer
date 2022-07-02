import Vue from 'vue';

Vue.component('statement', require('./pages/Statement/Index.vue').default);

const app = new Vue({
    el: "#app"
});