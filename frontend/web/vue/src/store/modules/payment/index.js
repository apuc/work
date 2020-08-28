import * as type from './types';
import actions from './actions';

const state = {
    sendPayment: {},
};

const mutations = {
    [type.SEND_PAYMENT](state, payload) {
        state.sendPayment = payload;
    },
};

const getters = {
    sendPayment: state => {
        return state.sendPayment;
    },
};

export default {
    state,
    mutations,
    actions,
    getters,
};
