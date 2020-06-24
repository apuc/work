import * as type from './types';
import api from '../../../api';

const actions = {
    getAllResume({commit}, payload) {

        return new Promise((resolve, reject) => {
            api.get('/request/resume/my-index?expand=can_update&sort=-update_time&page=' + payload)
                .then(res => {
                    commit(type.GET_ALL_RESUME, res.data);
                    resolve(res.data);
                })
                .catch(error => {
                    console.log('Problem', error.message);
                    reject(error);
                });
        })
    },
    updateResume({commit}, payload) {

        return new Promise((resolve, reject) => {
            api.post('/request/resume/update-time', {id: payload})
                .then(res => {
                    commit(type.UPDATE_RESUME, res.data);
                    resolve(res.data);
                })
                .catch(error => {
                    console.log('Problem', error.message);
                    reject(error);
                });
        })
    },
    removeResume({commit}, payload) {

        return new Promise((resolve, reject) => {
            api.delete('/request/resume/' + payload)
                .then(res => {
                    commit(type.REMOVE_RESUME, res.data);
                    resolve(res.data);
                })
                .catch(error => {
                    console.log('Problem', error.message);
                    reject(error);
                });
        })
    },
    addResume({commit}, payload) {

        return new Promise((resolve, reject) => {
            api.post('/request/resume', payload)
                .then(res => {
                    commit(type.ADD_RESUME, res.data);
                    resolve(res.data);
                })
                .catch(error => {
                    console.log('Problem', error.message);
                    reject(error);
                });
        })
    },
    getResume({commit}, payload) {

        return new Promise((resolve, reject) => {
            api.get('/request/resume/' + payload + '?expand=experience,education,skills,category')
                .then(res => {
                    commit(type.GET_RESUME, res.data);
                    resolve(res.data);
                })
                .catch(error => {
                    console.log('Problem', error.message);
                    reject(error);
                });
        })
    },
    editResume({commit}, payload) {

        return new Promise((resolve, reject) => {
            api.patch('/request/resume/' + payload.id, payload)
                .then(res => {
                    commit(type.EDIT_RESUME, res.data);
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
