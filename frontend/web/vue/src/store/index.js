import Vue from 'vue';
import Vuex from 'vuex';
import global from './modules/global';
import user from './modules/user';
import message from './modules/message';
import statistics from './modules/statistics';
import resume from './modules/resume';
import vacancy from './modules/vacancy';
import company from './modules/company';
import updates from './modules/updates';
import payment from './modules/payment';
import banners from './modules/banners';
import promocode from './modules/promocode';
import purchaseAudit from './modules/purchaseAudit';
import operations from './modules/operations';
import notifications from './modules/notifications'
Vue.use(Vuex);

Vue.config.debug = true;


export default new Vuex.Store({
    modules: {
        global,
        user,
        message,
        statistics,
        resume,
        vacancy,
        company,
        updates,
        payment,
        banners,
        promocode,
        purchaseAudit,
        operations,
        notifications
    },
    strict: false,
});
