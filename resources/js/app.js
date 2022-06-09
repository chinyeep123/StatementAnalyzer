import Vue from 'vue';

Vue.component('statement-analyzer', require('./pages/StatementAnalyzer/Index.vue').default);

const app = new Vue({
    el: "#app"
});
// window.Fusion.booting(function(router, store) {
// 	router.addRoutes([
// 		{
// 			path: '/orders',
//             component: () => import('./pages/Order/Index'),
//             name: 'order',
//             meta: {
//                 requiresAuth: true,
//                 layout: 'admin'
//             }
// 		},
// 		{
// 			path: '/orders/:order/show',
//             component: () => import('./pages/Order/Show'),
//             name: 'order.show',
//             meta: {
//                 requiresAuth: true,
//                 layout: 'admin'
//             }
// 		}
// 	])
// })

// window.addEventListener('DOMContentLoaded', function () {
// })