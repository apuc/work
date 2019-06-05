import Field from '../models/Field';
import {VTextField, VSelect} from 'vuetify/lib'

export default {
  name: Object.assign({}, Field, {
    name: 'name',
    label: 'Название университета',
    component: VTextField,
    rules: []
  }),
  year_from: Object.assign({}, Field, {
    name: 'year_from',
    label: 'Год поступления',
    component: VTextField,
    type: 'number',
    rules: [v => (v === '') || (/^\d+[\.,]{0,1}\d+$/.test(v) || 'Только цифры')]
  }),
  year_to: Object.assign({}, Field, {
    name: 'year_to',
    label: 'Год окончания',
    component: VTextField,
    type: 'number',
    rules: [v => (v === '') || (/^\d+[\.,]{0,1}\d+$/.test(v) || 'Только цифры')]
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
      }
    ]
  }),
  faculty: Object.assign({}, Field, {
    name: 'faculty',
    label: 'Факультет',
    rules: [],
    component: VTextField
  }),
  specialization: Object.assign({}, Field, {
    name: 'specialization',
    label: 'Специализация',
    rules: [],
    component: VTextField
  }),
}