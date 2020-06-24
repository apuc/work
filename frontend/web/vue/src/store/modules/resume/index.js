import * as type from './types';
import actions from './actions';

const state = {
    allResume: [],
    updateResume: {},
    removeResume: {},
    addResume: {},
    resume: {},
    editResume: {},
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
    [type.ADD_RESUME](state, payload) {
        state.addResume = payload;
    },
    [type.GET_RESUME](state, payload) {
        state.resume = payload;
    },
    [type.EDIT_RESUME](state, payload) {
        state.editResume = payload;
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
    addResume: state => {
        return state.addResume;
    },
    resume: state => {
        return state.resume;
    },
    editResume: state => {
        return state.editResume;
    },
};

export default {
    state,
    mutations,
    actions,
    getters,
};
