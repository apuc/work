import * as type from './types';
import api from '../../../api';

const actions = {
    setReadAll({commit}, payload) {

        return new Promise((resolve, reject) => {
            api.get('/request/message/read-all-messages')
                .then(res => {
                    commit(type.SET_READ_ALL, res.data);
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
