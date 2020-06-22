import * as type from './types';
import actions from './actions';

const state = {
    setReadAll: {},
    incoming: [],
    incomingPage: [],
    outgoing: [],
    messageRemove: {},
};

const mutations = {
    [type.SET_READ_ALL](state, payload) {
        state.setReadAll = payload;
    },
    [type.GET_INCOMING](state, payload) {
        state.incoming = payload;
    },
    [type.GET_INCOMING_PAGE](state, payload) {
        state.incomingPage = payload;
    },
    [type.GET_OUTGOING](state, payload) {
        state.outgoing = payload;
    },
    [type.MESSAGE_REMOVE](state, payload) {
        state.messageRemove = payload;
    },
};

const getters = {
    setReadAll: state => {
        return state.setReadAll;
    },
    incoming: state => {
        return state.incoming;
    },
    incomingPage: state => {
        return state.incomingPage;
    },
    outgoing: state => {
        return state.outgoing;
    },
    messageRemove: state => {
        return state.messageRemove;
    },
};

export default {
    state,
    mutations,
    actions,
    getters,
};
