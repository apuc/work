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
    getCategoryById({commit}, payload) {

        return new Promise((resolve, reject) => {
            api.get('/request/vacancy/' + payload + '?expand=employment-type,category')
                .then(res => {
                    commit(type.GET_CATEGORY_BY_ID, res.data);
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
    getEmploymentType({commit}, payload) {

        return new Promise((resolve, reject) => {
            api.get('/request/employment-type')
                .then(res => {
                    commit(type.GET_EMPLOYMENT_TYPE, res.data);
                    resolve(res.data);
                })
                .catch(error => {
                    console.log('Problem', error.message);
                    reject(error);
                });
        })
    },
    getCompanyName({commit}, payload) {

        return new Promise((resolve, reject) => {
            api.get('/request/company/my-index')
                .then(res => {
                    commit(type.GET_COMPANY_NAME, res.data.models);
                    resolve(res.data.models);
                })
                .catch(error => {
                    console.log('Problem', error.message);
                    reject(error);
                });
        })
    },
    getExperience({commit}, payload) {

        return new Promise((resolve, reject) => {
            api.get('/request/vacancy/get-experiences')
                .then(res => {
                    commit(type.GET_EXPERIENCE, res.data);
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
