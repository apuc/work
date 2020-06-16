import * as type from './types';
import actions from './actions';

const state = {
    userMe: {}
};

const mutations = {
    [type.GET_USER_ME](state, payload) {
        state.userMe = payload;
    },
};

const getters = {
    userMe: state => {
        return state.userMe;
    }
};

export default {
    state,
    mutations,
    actions,
    getters,
};
