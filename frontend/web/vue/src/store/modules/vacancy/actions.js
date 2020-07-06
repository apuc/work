import * as type from './types';
import api from '../../../api';

const actions = {
    getAllVacancy({commit}, payload) {

        return new Promise((resolve, reject) => {
            api.get('/request/vacancy/my-index?expand=can_update&sort=-update_time&page=' + payload)
                .then(res => {
                    commit(type.GET_ALL_VACANCY, res.data);
                    resolve(res.data);
                })
                .catch(error => {
                    console.log('Problem', error.message);
                    reject(error);
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
                    reject(error);
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
                    reject(error);
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
                    reject(error);
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
                    reject(error);
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
                    reject(error);
                });
        })
    },
};

export default actions;
