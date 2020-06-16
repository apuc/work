import Vue from 'vue';
import Vuex from 'vuex';
import user from './modules/user';
import message from './modules/message';

Vue.use(Vuex);

Vue.config.debug = true;


export default new Vuex.Store({
    modules: {
        user,
        message,
    },
    strict: false,
});
