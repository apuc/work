import Vue from 'vue'
import Router from 'vue-router'
import FormVacancy from './components/FormVacancy.vue'
import FormResume from './components/FormResume.vue'
import FormCompany from './components/FormCompany.vue'

Vue.use(Router);

export default new Router({
  mode: 'history',
  routes: [
    {
      path: '/vacancy',
      name: 'vacancy',
      component: FormVacancy
    },
    {
      path: '/resume',
      name: 'resume',
      component: FormResume
    },
    {
      path: '/company',
      name: 'company',
      component: FormCompany
    }
  ]
})
