import Vue from 'vue';
import Vuex from 'vuex';
import global from './modules/global';
import user from './modules/user';
import message from './modules/message';
import statistics from './modules/statistics';
import resume from './modules/resume';

Vue.use(Vuex);

Vue.config.debug = true;


export default new Vuex.Store({
    modules: {
        global,
        user,
        message,
        statistics,
        resume,
    },
    strict: false,
});
