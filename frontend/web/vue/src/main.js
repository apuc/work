import Vue from 'vue'
import './plugins/vuetify'
import App from './Routing.vue'
import router from './router'
import ImageUploader from "vue-image-upload-resize";
import VueResource from 'vue-resource';
import VueSweetalert2 from 'vue-sweetalert2';
// import VueSelect from 'vue-select'

Vue.use(ImageUploader);
Vue.use(VueResource);
Vue.use(VueSweetalert2);
Vue.config.devtools = true;

// Vue.component('v-select', VueSelect.VueSelect);

// Vue.config.productionTip = false;
new Vue({
  router,
  http: {
    headers: {
      "Accept": "application/json",
      "Content-Type": "application/json",
    }
  },
  render: h => h(App)
}).$mount('#app');