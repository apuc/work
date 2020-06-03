import Vue from 'vue'
import './plugins/vuetify'
import App from './Routing.vue'
import router from './router'
import store from './store';
import ImageUploader from "vue-image-upload-resize";
import VueResource from 'vue-resource';
import VueSweetalert2 from 'vue-sweetalert2';
import VueTelInput from 'vue-tel-input';
import 'sweetalert2/dist/sweetalert2.min.css';

Vue.use(ImageUploader);
Vue.use(VueResource);
Vue.use(VueSweetalert2);
Vue.use(VueTelInput)

Vue.config.devtools = true;

// Vue.config.productionTip = false;

router.afterEach( async (to, from, next) => {

  function getCookie(name){
    let matches = document.cookie.match(new RegExp(
        "(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"
    ));
    let key = decodeURI(matches[1]);
    key = key.match(/"[a-zA-Z0-9-_]{5,}"/)[0];
    key = key.replace(/"/g, '');
    return key ? key : undefined;
  }

  if (location.hostname === "localhost"){
    Vue.http.headers.common['Authorization'] = 'Bearer lCLRMuK9jOXl_ZUiHiVO0Lj1mZR9feEg';
  } else {
    let getCookKey = getCookie('key');
    localStorage.localKey = getCookKey;
    Vue.http.headers.common['Authorization'] = `Bearer ${localStorage.getItem('localKey')}`;
  }


});

new Vue({
  router,
  store,
  http: {
    headers: {
      "Accept": "application/json",
      "Content-Type": "application/json",
    }
  },
  render: h => h(App)
}).$mount('#app');