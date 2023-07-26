import { createStore } from 'vuex';
import rootActions from './actions.js';
import rootMutations from './mutations.js';
import rootGetters from './getters.js';

const store = createStore({
    state:{
        user: null,
        processing: false,
        validationErrors: null
    },
    actions: rootActions,
    mutations: rootMutations,
    getters: rootGetters
});

export default store;