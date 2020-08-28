import * as type from './types';
import actions from './actions';

const state = {
    addPromocode: {},
};

const mutations = {
    [type.ADD_PROMOCODE](state, payload) {
        state.addPromocode = payload;
    },
};

const getters = {
    addPromocode: state => {
        return state.addPromocode;
    }
};

export default {
    state,
    mutations,
    actions,
    getters,
};
