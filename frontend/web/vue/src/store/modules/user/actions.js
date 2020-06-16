import * as type from './types';
import api from '../../../api';

const actions = {
    getUserMe({commit}, payload) {

        return new Promise((resolve, reject) => {
            api.get('/request/employer/my-index?expand=phone,user.unreadMessages,companiesCount')
                .then(res => {
                    commit(type.GET_USER_ME, res.data[0]);
                    resolve(res.data[0]);
                })
                .catch(error => {
                    console.log('Problem', error.message);
                    reject(error);
                });
        })
    },
};

export default actions;
