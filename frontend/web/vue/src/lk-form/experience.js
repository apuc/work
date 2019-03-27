import Field from '../models/Field';
import {VTextField, VSelect} from 'vuetify/lib'

export default {
  name: Object.assign({}, Field, {
    name: 'name',
    label: 'Название компании*',
    component: VTextField,
    rules: [v => !!v || 'Название компании обязателено к заполнению'],
  }),
  post: Object.assign({}, Field, {
    name: 'post',
    label: 'Должность*',
    component: VTextField,
    rules: [v => !!v || 'Должность обязателена к заполнению'],
  }),
  department: Object.assign({}, Field, {
    name: 'department',
    label: 'Отдел',
    component: VTextField,
    rules: [],
  }),
  month_from: Object.assign({}, Field, {
    name: 'month_from',
    label: 'Месяц начала*',
    rules: [v => !!v || 'Месяц начала обязателен к заполнению'],
    component: VSelect,
    items: [
      {
        name: 'Январь'
      },
      {
        name: 'Февраль'
      },
      {
        name: 'Март'
      },
      {
        name: 'Апрель'
      },
      {
        name: 'Май'
      },
      {
        name: 'Июнь'
      },
      {
        name: 'Июль'
      },
      {
        name: 'Август'
      },
      {
        name: 'Сентябрь'
      },
      {
        name: 'Октябрь'
      },
      {
        name: 'Ноябрь',
      },
      {
        name: 'Декабрь'
      },
    ],
  }),
  year_from: Object.assign({}, Field, {
    name: 'year_from',
    label: 'Год начала*',
    component: VTextField,
    type: 'number',
    rules: [
      v => !!v || 'Год начала обязателен к заполнению',
      v => /^\d+$/.test(v) || 'Только цыфры'
    ],
  }),
  month_to: Object.assign({}, Field, {
    name: 'month_to',
    label: 'Месяц окончания*',
    rules: [v => !!v || 'Месяц окончания обязателен к заполнению'],
    component: VSelect,
    items: [
      {
        name: 'Январь',
      },
      {
        name: 'Февраль'
      },
      {
        name: 'Март'
      },
      {
        name: 'Апрель'
      },
      {
        name: 'Май'
      },
      {
        name: 'Июнь'
      },
      {
        name: 'Июль'
      },
      {
        name: 'Август'
      },
      {
        name: 'Сентябрь'
      },
      {
        name: 'Октябрь'
      },
      {
        name: 'Ноябрь'
      },
      {
        name: 'Декабрь'
      },
    ],
  }),
  year_to: Object.assign({}, Field, {
    name: 'year_to',
    label: 'Год окончания*',
    component: VTextField,
    type: 'number',
    rules: [
      v => !!v || 'Год окончания обязателен к заполнению',
      v => /^\d+$/.test(v) || 'Только цыфры'
    ],
  }),
}