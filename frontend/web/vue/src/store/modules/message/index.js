import * as type from './types';
import actions from './actions';

const state = {
    setReadAll: {}
};

const mutations = {
    [type.SET_READ_ALL](state, payload) {
        state.setReadAll = payload;
    },
};

const getters = {
    setReadAll: state => {
        return state.setReadAll;
    }
};

export default {
    state,
    mutations,
    actions,
    getters,
};
