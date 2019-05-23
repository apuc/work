import Field from '../models/Field';
import {VTextarea, VTextField} from 'vuetify/lib'
import AddSocial from "../components/AddSocial";

export default {
  nameCompany: Object.assign({}, Field, {
    name: 'nameCompany',
    label: 'Название компании*',
    rules: [
      v => !!v || 'Название компании обязательно к заполнению',
      v => (v && v.length >= 5) || 'Больше 5 символов'
    ],
    counter: 50,
    component: VTextField,
  }),
  site: Object.assign({}, Field, {
    name: 'site',
    label: 'Сайт*',
    rules: [v => !!v || 'Сайт обязательен к заполнению',],
    counter: 50,
    component: VTextField,
  }),
  scopeOfTheCompany: Object.assign({}, Field, {
    name: 'scopeOfTheCompany',
    label: 'Сфера деятельности компании*',
    rules: [v => !!v || 'Сфера деятельности компании обязателена к заполнению'],
    component: VTextarea,
    counter: 2000,
  }),
  addSocial: Object.assign({}, Field, {
    component: AddSocial,
    rules: [],
  }),
  aboutCompany: Object.assign({}, Field, {
    name: 'aboutCompany',
    label: 'О компании*',
    rules: [v => !!v || 'О компании обязателено к заполнению'],
    component: VTextarea,
    counter: 2000,
  }),
  contactPerson: Object.assign({}, Field, {
    name: 'contactPerson',
    label: 'Контактное лицо*',
    rules: [v => !!v || 'Контактное лицо обязателено к заполнению'],
    counter: 50,
    component: VTextField,
  }),
  companyPhone: Object.assign({}, Field, {
    name: 'companyPhone',
    label: 'Телефон*',
    rules: [
      v => !!v || 'Телефон обязателен к заполнению',
      v => (v && v.length >= 11) || 'Введите 11 символов'
    ],
    component: VTextField,
    maskPhone: '+# (###) ## - ## - ###',
  }),
}