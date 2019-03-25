import Field from '../models/Field';
import {VTextField, VSelect} from 'vuetify/lib'

export default {
  universityName: Object.assign({}, Field, {
    name: 'universityName',
    label: 'Название университета*',
    component: VTextField,
    rules: [v => !!v  || 'Название университета обязателено к заполнению'],
  }),
  admissionYear: Object.assign({}, Field, {
    name: 'admissionYear',
    label: 'Год поступления*',
    component: VTextField,
    type: 'number',
    rules: [
      v => !!v  || 'Год поступления обязателен к заполнению',
      v => /^\d+$/.test(v) || 'Только цыфры'
    ],
  }),
  yearOfEnding: Object.assign({}, Field, {
    name: 'yearOfEnding',
    label: 'Год окончания*',
    component: VTextField,
    type: 'number',
    rules: [
      v => !!v  || 'Год окончания обязателен к заполнению',
      v => /^\d+$/.test(v) || 'Только цыфры'
    ],
  }),
  academicDegree: Object.assign({}, Field, {
    name: 'academicDegree',
    label: 'Академ степень',
    rules: [],
    component: VSelect,
    items: [
      'Бакалавр',
      'Магистр',
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