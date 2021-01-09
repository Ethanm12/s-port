
import Vue from 'vue';
import Router from 'vue-router';

Vue.use(Router);

export function createRouter () {
  return new Router({
    mode: 'history',
    routes: [
        { path: '/', name: 'home', component: require('./pages/Home.vue').default },
        { path: '/contact', name: 'contact', component: require('./pages/Contact.vue').default },
        { path: '*', redirect: '/'},
        { path: '**', redirect: '/'}
    ]
  });
}