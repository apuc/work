import * as type from './types';
import api from '../../../api';

const actions = {
    setReadAllUpdates({commit}, payload) {

        return new Promise((resolve, reject) => {
            api.post('/request/update/read-all')
                .then(res => {
                    commit(type.SET_READ_ALL_UPDATES, res.data);
                    resolve(res.data);
                })
                .catch(error => {
                    console.log('Problem', error.message);
                    reject(error.message);
                });
        })
    },
    getUpdates({commit}, payload) {

        return new Promise((resolve, reject) => {
            api.get('/request/update?expand=is_read')
                .then(res => {
                    commit(type.GET_UPDATES, res.data);
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
