import * as type from './types';
import api from '../../../api';

const actions = {
    getOperations({commit}, payload) {

        return new Promise((resolve, reject) => {
            api.get('/request/operation/my-index?expand=servicePrice')
                .then(res => {
                    commit(type.GET_OPERATIONS, res.data);
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
