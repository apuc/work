import Field from '../models/Field';
import {VTextField, VSelect} from 'vuetify/lib'

export default {
  name: Object.assign({}, Field, {
    name: 'name',
    label: 'Название университета*',
    component: VTextField,
    rules: [v => !!v  || 'Название университета обязателено к заполнению'],
  }),
  year_from: Object.assign({}, Field, {
    name: 'year_from',
    label: 'Год поступления*',
    component: VTextField,
    type: 'number',
    rules: [
      v => !!v  || 'Год поступления обязателен к заполнению',
      v => /^\d+$/.test(v) || 'Только цыфры'
    ],
  }),
  year_to: Object.assign({}, Field, {
    name: 'year_to',
    label: 'Год окончания*',
    component: VTextField,
    type: 'number',
    rules: [
      v => !!v  || 'Год окончания обязателен к заполнению',
      v => /^\d+$/.test(v) || 'Только цыфры'
    ],
  }),
  academic_degree: Object.assign({}, Field, {
    name: 'academic_degree',
    label: 'Академ степень',
    rules: [],
    component: VSelect,
    items: [
      {
        name: 'Бакалавр'
      },
      {
        name: 'Магистр'
      },
    ],
  }),
  faculty: Object.assign({}, Field, {
    name: 'faculty',
    label: 'Факультет*',
    rules: [v => !!v  || 'Факультет обязателен к заполнению'],
    component: VTextField,
  }),
  specialization: Object.assign({}, Field, {
    name: 'specialization',
    label: 'Специализация',
    rules: [],
    component: VTextField,
  }),
}