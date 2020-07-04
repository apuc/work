import * as type from './types';
import actions from './actions';

const state = {
    allCompany: [],
    removeCompany: {},
    addCompany: {},
    company: {},
    editCompany: {},
    companyRight: [],
};

const mutations = {
    [type.GET_ALL_COMPANY](state, payload) {
        state.allCompany = payload;
    },
    [type.REMOVE_COMPANY](state, payload) {
        state.removeCompany = payload;
    },
    [type.ADD_COMPANY](state, payload) {
        state.addCompany = payload;
    },
    [type.GET_COMPANY](state, payload) {
        state.company = payload;
    },
    [type.EDIT_COMPANY](state, payload) {
        state.editCompany = payload;
    },
    [type.RIGHT_COMPANY](state, payload) {
        state.companyRight = payload;
    },
    [type.ADD_RIGHT_COMPANY](state, payload) {
        state.companyRight.push(payload);
    },
};

const getters = {
    allCompany: state => {
        return state.allCompany;
    },
    removeCompany: state => {
        return state.removeCompany;
    },
    addCompany: state => {
        return state.addCompany;
    },
    company: state => {
        return state.company;
    },
    editCompany: state => {
        return state.editCompany;
    },
    companyRight: state => {
        return state.companyRight;
    },
};

export default {
    state,
    mutations,
    actions,
    getters,
};
