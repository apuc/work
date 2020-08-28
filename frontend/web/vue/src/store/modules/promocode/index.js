import * as type from './types';
import actions from './actions';

const state = {
    operations: {},
};

const mutations = {
    [type.GET_OPERATIONS](state, payload) {
        state.operations = payload;
    },
};

const getters = {
    operations: state => {
        return state.operations;
    }
};

export default {
    state,
    mutations,
    actions,
    getters,
};
