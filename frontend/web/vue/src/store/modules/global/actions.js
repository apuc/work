import * as type from './types';
import api from '../../../api';

const actions = {
    getCategory({commit}, payload) {

        return new Promise((resolve, reject) => {
            api.get('/request/category')
                .then(res => {
                    commit(type.GET_CATEGORY, res.data);
                    resolve(res.data);
                })
                .catch(error => {
                    console.log('Problem', error.message);
                    reject(error);
                });
        })
    },
    getCity({commit}, payload) {

        return new Promise((resolve, reject) => {
            api.get('/request/city')
                .then(res => {
                    commit(type.GET_CITY, res.data);
                    resolve(res.data);
                })
                .catch(error => {
                    console.log('Problem', error.message);
                    reject(error);
                });
        })
    },
    getDuties({commit}, payload) {

        return new Promise((resolve, reject) => {
            api.get('/request/resume/' + payload + '?expand=skills')
                .then(res => {
                    commit(type.GET_DUTIES, res.data);
                    resolve(res.data);
                })
                .catch(error => {
                    console.log('Problem', error.message);
                    reject(error);
                });
        })
    },
    getAllDuties({commit}, payload) {

        return new Promise((resolve, reject) => {
            api.get('/request/skill?per-page=-1')
                .then(res => {
                    commit(type.GET_ALL_DUTIES, res.data);
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
