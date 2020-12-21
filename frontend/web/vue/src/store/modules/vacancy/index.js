import * as type from './types';
import actions from './actions';

const state = {
    allVacancy: [],
    updateVacancy: {},
    removeVacancy: {},
    addVacancy: {},
    vacancy: {},
    editVacancy: {},
};

const mutations = {
    [type.GET_ALL_VACANCY](state, payload) {
        state.allVacancy = payload;
    },
    [type.UPDATE_VACANCY](state, payload) {
        state.updateVacancy = payload;
    },
    [type.UPDATE_VACANCY_IN_ALL_VACANCY](state,payload){
      state.allVacancy[payload.index] = payload.item;
    },
    [type.REMOVE_VACANCY](state, payload) {
        state.removeVacancy = payload;
    },
    [type.ADD_VACANCY](state, payload) {
        state.addVacancy = payload;
    },
    [type.GET_VACANCY](state, payload) {
        state.vacancy = payload;
    },
    [type.EDIT_VACANCY](state, payload) {
        state.editVacancy = payload;
    },
};

const getters = {
    allVacancy: state => {
        return state.allVacancy;
    },
    updateVacancy: state => {
        return state.updateVacancy;
    },
    removeVacancy: state => {
        return state.removeVacancy;
    },
    addVacancy: state => {
        return state.addVacancy;
    },
    vacancy: state => {
        return state.vacancy;
    },
    editVacancy: state => {
        return state.editVacancy;
    },
};

export default {
    state,
    mutations,
    actions,
    getters,
};
