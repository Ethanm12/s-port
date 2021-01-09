/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
import Vue from 'vue';
import Meta from 'vue-meta';

import AppComponent from './App.vue';
import { createRouter } from './router';
import { createStore } from './store';

export function createApp() {
    const store = createStore();
    const router = createRouter();
    Vue.use(Meta);

    // Set up the router to check for async data before resolving each route:

    router.beforeEach((to, from, next) => {
        const asyncRequests = [];
        to.matched.forEach(match => {
            if (typeof match.components.default.asyncData === 'function') {
                asyncRequests.push(match.components.default.asyncData(store, to));
            }
        });

        Promise.all(asyncRequests).then(() => {
            next()
        }).catch(e => {
            store.commit('routeError', e);
            next();
        });
    });

    const initApp = () => new Vue({
        store,
        router,
        render: h => h(AppComponent),
        watch: {
            '$route.path'() {
                window.scrollTo(0, 0);
            }
        }
    });

    return { initApp, router, store };
}

