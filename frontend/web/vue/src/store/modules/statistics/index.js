import * as type from './types';
import actions from './actions';

const state = {
    statistics: {}
};

const mutations = {
    [type.GET_STATISTICS](state, payload) {
        state.statistics = payload;
    },
};

const getters = {
    statistics: state => {
        return state.statistics;
    }
};

export default {
    state,
    mutations,
    actions,
    getters,
};
