import Vue from 'vue';
import VueSweetalert2 from 'vue-sweetalert2';

// If you don't need the styles, do not connect
import 'sweetalert2/dist/sweetalert2.min.css';

Vue.use(VueSweetalert2);

const state = {

};

const actions = {
    ['state/VIEW_NOTIFICATION'](state, payload) {
        Vue.swal({
            toast: true,
            position: 'bottom-end',
            showConfirmButton: false,
            timer: 4000,
            type: 'error',
            title: payload.message
        });
    },
};


export default {
    state,
    actions,
};
