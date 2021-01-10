import * as type from './types';
import api from '../../../api';

const actions = {
    async prolongVacancy({commit,dispatch},payload){
        try {
            await api.post('/request/vacancy/prolong', {id: payload.id});
            payload.item.update_time = new Date().toLocaleString().slice(0,-3);
            payload.item.active_until = payload.active_until;
            commit(type.UPDATE_VACANCY_IN_ALL_VACANCY,{index: payload.index,item: payload.item});
        } catch (e){
            this.$swal({
                title: 'У вас недостаточно средств на счету',
                type: 'error',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Пополнить счет',
                cancelButtonText: 'Отмена'
            })
            console.log('Problem', e.message);
            throw (e);
        }
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
};

export default actions;
