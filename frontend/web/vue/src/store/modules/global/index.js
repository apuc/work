import * as type from './types';
import actions from './actions';

const state = {
    category: [],
    categoryById: [],
    city: [],
    duties: [],
    allDuties: [],
    employmentType: [],
    companyName: [],
    experience: [],
};

const mutations = {
    [type.GET_CATEGORY](state, payload) {
        state.category = payload;
    },
    [type.GET_CATEGORY_BY_ID](state, payload) {
        state.categoryById = payload;
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
    [type.GET_EMPLOYMENT_TYPE](state, payload) {
        state.employmentType = payload;
    },
    [type.GET_COMPANY_NAME](state, payload) {
        state.companyName = payload;
    },
    [type.GET_EXPERIENCE](state, payload) {
        state.experience = payload;
    },
};

const getters = {
    category: state => {
        return state.category;
    },
    categoryById: state => {
        return state.categoryById;
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
    employmentType: state => {
        return state.employmentType;
    },
    companyName: state => {
        return state.companyName;
    },
    experience: state => {
        return state.experience;
    },
};

export default {
    state,
    mutations,
    actions,
    getters,
};
