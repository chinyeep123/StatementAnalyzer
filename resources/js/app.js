import Vue from 'vue';

Vue.component('statement', require('./pages/Statement/Index.vue').default);
Vue.component('statement-tag', require('./pages/StatementTag/Index.vue').default);
Vue.component('table-rows', require('./pages/Statement/components/TableRows.vue').default);

const app = new Vue({
    el: "#app"
});