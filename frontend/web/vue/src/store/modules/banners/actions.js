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
            api.get('/request/banner/' + payload + '?expand=city_category,is_active')
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
    removeBanner({commit}, payload) {

        return new Promise((resolve, reject) => {
            api.delete('/request/banner/' + payload)
                .then(res => {
                    commit(type.REMOVE_BANNER, res.data);
                    resolve(res.data);
                })
                .catch(error => {
                    console.log('Problem', error.message);
                    reject(error);
                });
        })
    },
    activateBanner({commit}, payload) {

        return new Promise((resolve, reject) => {
            api.post('/request/banner/activate', {banner_id: payload})
                .then(res => {
                    commit(type.ACTIVATE_BANNER, res.data);
                    resolve(res.data);
                })
                .catch(error => {
                    console.log('Problem', error.response.data.message);
                    reject(error.response.data.message);
                });
        })
    },
    getBannerPrice({commit}, payload) {

        return new Promise((resolve, reject) => {
            api.get('/request/banner/get-price?city_category=' + payload)
                .then(res => {
                    commit(type.GET_BANNER_PRICE, res.data);
                    resolve(res.data);
                })
                .catch(error => {
                    console.log('Problem', error.response.data.message);
                    reject(error.response.data.message);
                });
        })
    },
};

export default actions;
