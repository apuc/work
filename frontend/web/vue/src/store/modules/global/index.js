import * as type from './types';
import actions from './actions';

const state = {
    category: [],
    city: [],
    duties: [],
    allDuties: [],
};

const mutations = {
    [type.GET_CATEGORY](state, payload) {
        state.category = payload;
    },
    [type.GET_CITY](state, payload) {
        state.city = payload;
    },
    [type.GET_DUTIES](state, payload) {
        state.duties = payload;
    },
    [type.GET_ALL_DUTIES](state, payload) {
        state.allDuties = payload;
    },
};

const getters = {
    category: state => {
        return state.category;
    },
    city: state => {
        return state.city;
    },
    duties: state => {
        return state.duties;
    },
    allDuties: state => {
        return state.allDuties;
    },
};

export default {
    state,
    mutations,
    actions,
    getters,
};
