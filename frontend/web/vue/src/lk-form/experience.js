import Field from '../models/Field';
import {VTextField, VSelect} from 'vuetify/lib'

export default {
  companyName: Object.assign({}, Field, {
    name: 'companyName',
    label: 'Название компании*',
    component: VTextField,
    rules: [v => !!v || 'Название компании обязателено к заполнению'],
  }),
  positionWork: Object.assign({}, Field, {
    name: 'positionWork',
    label: 'Должность*',
    component: VTextField,
    rules: [v => !!v || 'Должность обязателена к заполнению'],
  }),
  departmentWork: Object.assign({}, Field, {
    name: 'departmentWork',
    label: 'Отдел',
    component: VTextField,
    rules: [],
  }),
  monthBeganWork: Object.assign({}, Field, {
    name: 'monthBeganWork',
    label: 'Месяц начала*',
    rules: [v => !!v || 'Месяц начала обязателен к заполнению'],
    component: VSelect,
    items: [
      'Январь',
      'Февраль',
      'Март',
      'Апрель',
      'Май',
      'Июнь',
      'Июль',
      'Август',
      'Сентябрь',
      'Октябрь',
      'Ноябрь',
      'Декабрь',
    ],
  }),
  startYearWork: Object.assign({}, Field, {
    name: 'startYearWork',
    label: 'Год начала*',
    component: VTextField,
    type: 'number',
    rules: [
      v => !!v || 'Год начала обязателен к заполнению',
      v => /^\d+$/.test(v) || 'Только цыфры'
    ],
  }),
  endMonthWork: Object.assign({}, Field, {
    name: 'endMonthWork',
    label: 'Месяц окончания*',
    rules: [v => !!v || 'Месяц окончания обязателен к заполнению'],
    component: VSelect,
    items: [
      'Январь',
      'Февраль',
      'Март',
      'Апрель',
      'Май',
      'Июнь',
      'Июль',
      'Август',
      'Сентябрь',
      'Октябрь',
      'Ноябрь',
      'Декабрь',
    ],
  }),
  yearOfEndingWork: Object.assign({}, Field, {
    name: 'yearOfEndingWork',
    label: 'Год окончания*',
    component: VTextField,
    type: 'number',
    rules: [
      v => !!v || 'Год окончания обязателен к заполнению',
      v => /^\d+$/.test(v) || 'Только цыфры'
    ],
  }),
}