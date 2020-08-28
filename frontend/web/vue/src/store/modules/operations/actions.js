import * as type from './types';
import api from '../../../api';

const actions = {
    purchaseAudit({commit}, payload) {

        return new Promise((resolve, reject) => {
            api.post('/request/resume/audit', payload)
                .then(res => {
                    commit(type.PURCHASE_AUDIT, res.data);
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
