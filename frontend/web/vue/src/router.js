import Vue from 'vue'
import Router from 'vue-router'
import MainPage from './components/MainPage.vue'
import MyMessage from './components/MyMessage.vue'
import FormVacancy from './components/FormVacancy.vue'
import FormResume from './components/FormResume.vue'
import FormCompany from './components/FormCompany.vue'
import AllVacancy from './components/AllVacancy.vue'
import EditVacancy from './components/EditVacancy'
import AllResume from './components/AllResume.vue'
import EditResume from './components/EditResume.vue'
import AllCompany from './components/AllCompany.vue'
import EditCompany from './components/EditCompany.vue'
import EditProfile from './components/EditProfile.vue'
import CompanyRight from './components/CompanyRight.vue'

Vue.use(Router);

export default new Router({
  mode: 'history',
  routes: [
    {
      path: '/personal-area/',
      redirect: '/personal-area/statistics'
    },
    {
      path: '/personal-area/statistics',
      name: 'statistics',
      meta: {title: 'Статистика'},
      component: MainPage
    },
    {
      path: '/personal-area/my-message',
      name: 'my-message',
      meta: {title: 'Отклики'},
      component: MyMessage
    },
    {
      path: '/personal-area/add-vacancy',
      name: 'add-vacancy',
      meta: {title: 'Создать вакансию'},
      component: FormVacancy
    },
    {
      path: '/personal-area/add-resume',
      name: 'add-resume',
      meta: {title: 'Создать резюме'},
      component: FormResume
    },
    {
      path: '/personal-area/add-company',
      name: 'add-company',
      meta: {title: 'Создать компанию или частное лицо'},
      component: FormCompany
    },
    {
      path: '/personal-area/all-vacancy',
      name: 'all-vacancy',
      meta: {title: 'Все вакансии'},
      component: AllVacancy,
    },
    {
      path: '/personal-area/edit-vacancy/:id',
      name: 'edit-vacancy/id',
      meta: {title: 'Редактировать вакансию'},
      component: EditVacancy
    },
    {
      path: '/personal-area/all-resume',
      name: 'all-resume',
      meta: {title: 'Все резюме'},
      component: AllResume,
    },
    {
      path: '/personal-area/edit-resume/:id',
      name: 'edit-resume/id',
      meta: {title: 'Редактировать резюме'},
      component: EditResume
    },
    {
      path: '/personal-area/all-company',
      name: 'all-company',
      meta: {title: 'Все компании'},
      component: AllCompany,
    },
    {
      path: '/personal-area/edit-company/:id',
      name: 'edit-company/id',
      meta: {title: 'Редактировать компанию'},
      component: EditCompany
    },
    {
      path: '/personal-area/edit-profile',
      name: 'edit-profile',
      meta: {title: 'Редактировать профиль'},
      component: EditProfile
    },
    {
      path: '/personal-area/company-right/:id',
      name: 'company-right',
      meta: {title: 'Доступ к компании'},
      component: CompanyRight
    }
  ]
})
