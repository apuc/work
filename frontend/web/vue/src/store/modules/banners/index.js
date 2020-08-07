import * as type from './types';
import actions from './actions';

const state = {
    allBanners: [],
    addBanner: {},
    banner: {}
};

const mutations = {
    [type.GET_ALL_BANNERS](state, payload) {
        state.allBanners = payload;
    },
    [type.ADD_BANNER](state, payload) {
        state.addBanner = payload;
    },
    [type.GET_BANNER](state, payload) {
        state.banner = payload;
    },
    [type.EDIT_BANNER](state, payload) {
        state.banner = payload;
    },
};

const getters = {
    allBanners: state => {
        return state.allBanners;
    },
    addBanner: state => {
        return state.addBanner;
    },
    banner: state => {
        return state.banner;
    },
};

export default {
    state,
    mutations,
    actions,
    getters,
};
