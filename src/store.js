import Vue from 'vue';
import Vuex from 'vuex';
import cms from './utils/cms';

Vue.use(Vuex);

const state = {
    pageData: null,
    routeError: null,
    serverRendered: false
}

const mutations = {
    pageLoad(state, data) {
        state.pageData = data;
    },
    routeError(state, data) {
        state.routeError = data;
    },
    setServerRendered(state, value) {
        state.serverRendered = value;
    }
}

const actions = {
    async loadCollectionPage({ commit, state }, collectionName) {
        if (!state.pageData || !state.serverRendered) {
            commit('pageLoad', (await cms.getCollection(collectionName))[0]);
        }
    }
}

export function createStore() {
    return new Vuex.Store({
        state,
        mutations,
        actions
    });
}