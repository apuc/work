import * as type from './types';
import api from '../../../api';

const actions = {
    getAllBanners({commit}, payload) {

        return new Promise((resolve, reject) => {
            api.get('/request/banner/my-index?page=' + payload)
                .then(res => {
                    commit(type.GET_ALL_BANNERS, res.data);
                    resolve(res.data);
                })
                .catch(error => {
                    console.log('Problem', error.message);
                    reject(error);
                });
        })
    },
    addBanner({commit}, payload) {

        return new Promise((resolve, reject) => {
            api.post('/request/banner', payload)
                .then(res => {
                    commit(type.ADD_BANNER, res.data);
                    resolve(res.data);
                })
                .catch(error => {
                    console.log('Problem', error.message);
                    reject(error);
                });
        })
    },
    getBanner({commit}, payload) {

        return new Promise((resolve, reject) => {
            api.get('/request/banner/' + payload)
                .then(res => {
                    commit(type.GET_BANNER, res.data);
                    resolve(res.data);
                })
                .catch(error => {
                    console.log('Problem', error.message);
                    reject(error);
                });
        })
    },
    editBanner({commit}, payload) {

        return new Promise((resolve, reject) => {
            api.patch('/request/banner/' + payload.id, payload)
                .then(res => {
                    commit(type.EDIT_BANNER, res.data);
                    resolve(res.data);
                })
                .catch(error => {
                    console.log('Problem', error.message);
                    reject(error);
                });
        })
    },
};

export default actions;
