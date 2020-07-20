import * as type from './types';
import actions from './actions';

const state = {
    setReadAllUpdates: {},
    updates: []
};

const mutations = {
    [type.SET_READ_ALL_UPDATES](state, payload) {
        state.setReadAllUpdates = payload;
    },
    [type.GET_UPDATES](state, payload) {
        state.updates = payload;
    },
};

const getters = {
    setReadAllUpdates: state => {
        return state.setReadAllUpdates;
    },
    updates: state => {
        return state.updates;
    },
};

export default {
    state,
    mutations,
    actions,
    getters,
};
