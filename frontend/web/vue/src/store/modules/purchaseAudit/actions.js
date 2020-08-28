import * as type from './types';
import api from '../../../api';

const actions = {
    addPromocode({commit}, payload) {

        return new Promise((resolve, reject) => {
            api.post('/request/promocode/use', payload)
                .then(res => {
                    commit(type.ADD_PROMOCODE, res.data);
                    resolve(res.data);
                })
                .catch(error => {
                    console.log('Problem', error.response.data.message);
                    reject(error.response.data.message);
                });
        })
    }
};

export default actions;
