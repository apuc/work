import Vue from 'vue'
import Vuex from 'vuex';
import './plugins/vuetify'
import App from './Routing.vue'
import router from './router'
import store from '@/store';
import ImageUploader from "vue-image-upload-resize";
import VueResource from 'vue-resource';
import VueSweetalert2 from 'vue-sweetalert2';
import VueTelInput from 'vue-tel-input';
import 'sweetalert2/dist/sweetalert2.min.css';

Vue.use(Vuex);
Vue.use(ImageUploader);
Vue.use(VueResource);
Vue.use(VueSweetalert2);
Vue.use(VueTelInput)

Vue.config.devtools = true;

// Vue.config.productionTip = false;

new Vue({
  router,
  store,
  render: h => h(App)
}).$mount('#app');