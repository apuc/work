import * as type from './types';
import api from '../../../api';

const actions = {
    getStatistics({commit}, payload) {

        return new Promise((resolve, reject) => {
            api.get('/request/employer/statistics')
                .then(res => {
                    commit(type.GET_STATISTICS, res.data);
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
