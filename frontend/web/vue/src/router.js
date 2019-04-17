import Vue from 'vue'
import Router from 'vue-router'
import FormVacancy from './components/FormVacancy.vue'
import FormResume from './components/FormResume.vue'
import FormCompany from './components/FormCompany.vue'
import AllResume from './components/AllResume.vue'
import EditResume from './components/EditResume.vue'

Vue.use(Router);

export default new Router({
  mode: 'history',
  routes: [
    {
      path: '/personal-area/add-vacancy',
      name: 'add-vacancy',
      component: FormVacancy
    },
    {
      path: '/personal-area/add-resume',
      name: 'add-resume',
      component: FormResume
    },
    {
      path: '/personal-area/add-company',
      name: 'add-company',
      component: FormCompany
    },
    {
      path: '/personal-area/all-resume',
      name: 'all-resume',
      component: AllResume,
    },
    {
      path: '/personal-area/edit-resume/:id',
      name: 'edit-resume/id',
      component: EditResume
    }
  ]
})
