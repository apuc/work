import * as type from './types';
import actions from './actions';

const state = {
    allResume: [],
    updateResume: {},
    removeResume: {},
};

const mutations = {
    [type.GET_ALL_RESUME](state, payload) {
        state.allResume = payload;
    },
    [type.UPDATE_RESUME](state, payload) {
        state.updateResume = payload;
    },
    [type.REMOVE_RESUME](state, payload) {
        state.removeResume = payload;
    },
};

const getters = {
    allResume: state => {
        return state.allResume;
    },
    updateResume: state => {
        return state.updateResume;
    },
    removeResume: state => {
        return state.removeResume;
    },
};

export default {
    state,
    mutations,
    actions,
    getters,
};
