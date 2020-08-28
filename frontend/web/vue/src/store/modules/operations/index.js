import * as type from './types';
import actions from './actions';

const state = {
    purchaseAudit: {},
};

const mutations = {
    [type.PURCHASE_AUDIT](state, payload) {
        state.purchaseAudit = payload;
    },
};

const getters = {
    purchaseAudit: state => {
        return state.purchaseAudit;
    }
};

export default {
    state,
    mutations,
    actions,
    getters,
};
