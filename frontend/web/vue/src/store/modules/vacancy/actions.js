import * as type from './types';
import api from '../../../api';

const actions = {
    prolongVacancy({commit}, payload){
        return new Promise((resolve, reject) => {
            api.post('/request/vacancy/prolong', {id: payload})
                .then(res => {
                    resolve(res.data);
                })
                .catch(error => {
                    console.log('Problem', error.message);
                    reject(error.response.data.message);
                });
        });
    },
    getAllVacancy({commit}, payload) {

        return new Promise((resolve, reject) => {
            api.get('/request/vacancy/my-index?expand=can_update&sort=-update_time&page=' + payload)
                .then(res => {
                    commit(type.GET_ALL_VACANCY, res.data);
                    resolve(res.data);
                })
                .catch(error => {
                    console.log('Problem', error.message);
                    reject(error.response.data.message);
                });
        })
    },
    updateVacancy({commit}, payload) {

        return new Promise((resolve, reject) => {
            api.post('/request/vacancy/update-time', {id: payload})
                .then(res => {
                    commit(type.UPDATE_VACANCY, res.data);
                    resolve(res.data);
                })
                .catch(error => {
                    console.log('Problem', error.message);
                    reject(error.response.data.message);
                });
        })
    },
    removeVacancy({commit}, payload) {

        return new Promise((resolve, reject) => {
            api.delete('/request/vacancy/' + payload)
                .then(res => {
                    commit(type.REMOVE_VACANCY, res.data);
                    resolve(res.data);
                })
                .catch(error => {
                    console.log('Problem', error.message);
                    reject(error.response.data.message);
                });
        })
    },
    addVacancy({commit}, payload) {

        return new Promise((resolve, reject) => {
            api.post('/request/vacancy', payload)
                .then(res => {
                    commit(type.ADD_VACANCY, res.data);
                    resolve(res.data);
                })
                .catch(error => {
                    console.log('Problem', error.message);
                    reject(error.response.data.message);
                });
        })
    },
    getVacancy({commit}, payload) {

        return new Promise((resolve, reject) => {
            api.get('/request/vacancy/' + payload + '?expand=employment-type,category')
                .then(res => {
                    commit(type.GET_VACANCY, res.data);
                    resolve(res.data);
                })
                .catch(error => {
                    console.log('Problem', error.message);
                    reject(error.response.data.message);
                });
        })
    },
    editVacancy({commit}, payload) {

        return new Promise((resolve, reject) => {
            api.patch('/request/vacancy/' + payload.id, payload.data)
                .then(res => {
                    commit(type.EDIT_VACANCY, res.data);
                    resolve(res.data);
                })
                .catch(error => {
                    console.log('Problem', error.message);
                    reject(error.response.data.message);
                });
        })
    },
    buyRenew({commit}, payload) {

        return new Promise((resolve, reject) => {
            api.post('/request/vacancy/buy-renew')
                .then(res => {
                    resolve(res.data);
                })
                .catch(error => {
                    console.log('Problem', error.message);
                    reject(error.response.data.message);
                });
        })
    },
    buyCreate({commit}, payload) {

        return new Promise((resolve, reject) => {
            api.post('/request/vacancy/buy-create')
                .then(res => {
                    resolve(res.data);
                })
                .catch(error => {
                    console.log('Problem', error.message);
                    reject(error.response.data.message);
                });
        })
    },
    vacancyDay({commit}, payload) {

        return new Promise((resolve, reject) => {
            api.post('/request/vacancy/buy-vacancy-day', {vacancy_id: payload})
                .then(res => {
                    resolve(res.data);
                })
                .catch(error => {
                    console.log('Problem', error.message);
                    reject(error.response.data.message);
                });
        })
    },
    onAnchor({commit}, payload) {

        return new Promise((resolve, reject) => {
            api.post('/request/vacancy/anchor-vacancy', {vacancy_id: payload})
                .then(res => {
                    resolve(res.data);
                })
                .catch(error => {
                    console.log('Problem', error.message);
                    reject(error.response.data.message);
                });
        })
    },
};

export default actions;
