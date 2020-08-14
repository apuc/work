import * as type from './types';
import actions from './actions';

const state = {
    allBanners: [],
    addBanner: {},
    banner: {},
    removeBanner: {},
    activateBanner: {},
    bannerPrice: {},
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
    [type.REMOVE_BANNER](state, payload) {
        state.removeBanner = payload;
    },
    [type.ACTIVATE_BANNER](state, payload) {
        state.activateBanner = payload;
    },
    [type.GET_BANNER_PRICE](state, payload) {
        state.bannerPrice = payload;
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
    removeBanner: state => {
        return state.removeBanner;
    },
    activateBanner: state => {
        return state.activateBanner;
    },
    bannerPrice: state => {
        return state.bannerPrice;
    },
};

export default {
    state,
    mutations,
    actions,
    getters,
};
