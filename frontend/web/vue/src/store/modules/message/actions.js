import * as type from './types';
import api from '../../../api';

const actions = {
    setReadAll({commit}, payload) {

        return new Promise((resolve, reject) => {
            api.post('/request/message/read-all-messages')
                .then(res => {
                    commit(type.SET_READ_ALL, res.data);
                    resolve(res.data);
                })
                .catch(error => {
                    console.log('Problem', error.message);
                    reject(error.message);
                });
        })
    },
    getIncoming({commit}, payload) {

        return new Promise((resolve, reject) => {
            api.get('/request/message?expand=subject0,sender.employer,subject0_from&type=incoming&page=' + payload)
                .then(res => {
                    commit(type.GET_INCOMING, res.data);
                    resolve(res.data);
                })
                .catch(error => {
                    console.log('Problem', error.message);
                    reject(error);
                });
        })
    },
    getOutgoing({commit}, payload) {

        return new Promise((resolve, reject) => {
            api.get('/request/message?expand=subject0,receiver.employer,subject0_from&type=outgoing&page=' + payload)
                .then(res => {
                    commit(type.GET_OUTGOING, res.data);
                    resolve(res.data);
                })
                .catch(error => {
                    console.log('Problem', error.message);
                    reject(error);
                });
        })
    },
    messageRemove({commit}, payload) {

        return new Promise((resolve, reject) => {
            api.post('/request/message/delete-message', payload)
                .then(res => {
                    commit(type.MESSAGE_REMOVE, res);
                    resolve(res);
                })
                .catch(error => {
                    console.log('Problem', error.message);
                    reject(error);
                });
        })
    },
};

export default actions;
