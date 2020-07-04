import * as type from './types';
import api from '../../../api';

const actions = {
    getUserMe({commit}, payload) {

        return new Promise((resolve, reject) => {
            api.get('/request/employer/my-index?expand=phone,user.unreadMessages,companiesCount')
                .then(res => {
                    commit(type.GET_USER_ME, res.data.models[0]);
                    resolve(res.data.models[0]);
                })
                .catch(error => {
                    console.log('Problem', error.message);
                    reject(error);
                });
        })
    },
    updateUserMe({commit}, payload) {

        return new Promise((resolve, reject) => {
            api.patch('/request/employer/' + payload.id, payload.data)
                .then(res => {
                    commit(type.UPDATE_USER_ME, res.data);
                    resolve(res.data);
                })
                .catch(error => {
                    console.log('Problem', error.message);
                    reject(error);
                });
        })
    },
    resetPassword({commit}, payload) {

        return new Promise((resolve, reject) => {
            api.post('/request/security/change-password', payload)
                .then(res => {
                    commit(type.RESET_PASSWORD, res.data);
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
