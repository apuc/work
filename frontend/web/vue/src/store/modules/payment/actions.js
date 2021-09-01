import * as type from './types';
import api from '../../../api';

const actions = {
    sendPayment({commit}, payload) {

        return new Promise((resolve, reject) => {
            api.get('/request/employer/get-payment-hash?amount=' + payload.amount)
                .then(res => {
                    commit(type.SEND_PAYMENT, res.data);
                    resolve(res.data);
                })
                .catch(error => {
                    console.log('Problem', error.message);
                    reject(error.message);
                });
        })
    },
};

export default actions;
