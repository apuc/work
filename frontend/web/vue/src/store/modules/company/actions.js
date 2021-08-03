import * as type from './types';
import api from '../../../api';

const actions = {
    getAllCompany({commit}, payload) {

        return new Promise((resolve, reject) => {
            api.get('/request/company/my-index')
                .then(res => {
                    commit(type.GET_ALL_COMPANY, res.data);
                    resolve(res.data);
                })
                .catch(error => {
                    console.log('Problem', error.message);
                    reject(error);
                });
        })
    },
    removeCompany({commit}, payload) {

        return new Promise((resolve, reject) => {
            api.delete('/request/company/' + payload)
                .then(res => {
                    commit(type.REMOVE_COMPANY, res.data);
                    resolve(res.data);
                })
                .catch(error => {
                    console.log('Problem', error.message);
                    reject(error);
                });
        })
    },
    addCompany({commit}, payload) {

        return new Promise((resolve, reject) => {
            api.post('/request/company', payload)
                .then(res => {
                    commit(type.ADD_COMPANY, res.data);
                    resolve(res.data);
                })
                .catch(error => {
                    console.log('Problem', error.message);
                    reject(error);
                });
        })
    },
    getCompany({commit}, payload) {

        return new Promise((resolve, reject) => {
            api.get('/request/company/' + payload + '?expand=phone')
                .then(res => {
                    commit(type.GET_COMPANY, res.data);
                    resolve(res.data);
                })
                .catch(error => {
                    console.log('Problem', error.message);
                    reject(error);
                });
        })
    },
    editCompany({commit}, payload) {

        return new Promise((resolve, reject) => {
            api.patch('/request/company/' + payload.id, payload.data)
                .then(res => {
                    commit(type.EDIT_COMPANY, res.data);
                    resolve(res.data);
                })
                .catch(error => {
                    console.log('Problem', error.message);
                    reject(error);
                });
        })
    },
    addHr({commit}, payload) {

        return new Promise((resolve, reject) => {
            api.post('/request/company/register-hr', payload)
                .then(res => {
                    resolve(res.data);
                })
                .catch(error => {
                    console.log('Problem:', error.response.data.message);
                    reject(error.response.data);
                });
        })
    },
    rightCompany({commit}, payload) {

        return new Promise((resolve, reject) => {
            api.get('/request/company/' + payload + '?expand=users.employer')
                .then(res => {
                    commit(type.RIGHT_COMPANY, res.data);
                    resolve(res.data);
                })
                .catch(error => {
                    console.log('Problem', error.message);
                    reject(error);
                });
        })
    },
    addRightCompany({commit}, payload) {

        return new Promise((resolve, reject) => {
            api.post('/request/company/add-user', payload)
                .then(res => {
                    commit(type.ADD_RIGHT_COMPANY, res.data);
                    resolve(res.data);
                })
                .catch(error => {
                    console.log('Problem', error.message);
                    reject(error);
                });
        })
    },
    removeRightCompany({commit}, payload) {

        return new Promise((resolve, reject) => {
            api.post('/request/company/delete-user', payload)
                .then(res => {
                    resolve(res.data);
                })
                .catch(error => {
                    console.log('Problem', error.message);
                    reject(error);
                });
        })
    },
    getCompanyUsers({commit}, payload) {

        return new Promise((resolve, reject) => {
            api.post('/request/company/added-users', payload)
                .then(res => {
                    commit(type.COMPANY_USERS, res.data);
                    resolve(res.data);
                })
                .catch(error => {
                    console.log('Problem', error.response.data.message);
                    reject(error.response.data);
                });
        })
    },
};

export default actions;
