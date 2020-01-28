import Field from '../models/Field';
import {VTextarea, VTextField, VSelect, VSubheader,} from 'vuetify/lib'
import AddWork from "../components/AddWork";
import AddEducation from "../components/AddEducation";
import AddSocial from "../components/AddSocial";
import DutiesSelect from "../components/DutiesSelect";

export default {
  resumeCity: Object.assign({}, Field, {
    name: 'resumeCity',
    label: 'Город*',
    rules: [v => !!v  || 'Город обязателен к заполнению'],
    component: VSelect,
    items: [
      {
        name: '',
        id: ''
      }
    ],
  }),
  careerObjective: Object.assign({}, Field, {
    name: 'careerObjective',
    label: 'Желаемая должность*',
    rules: [v => !!v  || 'Желаемая должность обязателена к заполнению'],
    component: VTextField
  }),
  categoriesResume: Object.assign({}, Field, {
    name: 'categoriesResume',
    label: 'Категория*',
    rules: [v => v.length >= 1  || 'Категория обязателена к заполнению'],
    component: VSelect,
    items: [
      {
        name: '',
        id: ''
      }
    ],
    attach: 'attach',
    chips: 'chips',
    multiple: 'multiple'
  }),
  salaryFrom: Object.assign({}, Field, {
    name: 'salaryFrom',
    label: 'Зарплата в месяц от',
    rules: [v => (v === '') || (/^\d+[\.,]{0,1}\d+$/.test(v) || 'Только цифры')],
    component: VTextField,
    prefix: "₽"
  }),
  salaryBefore: Object.assign({}, Field, {
    name: 'salaryBefore',
    label: 'Зарплата в месяц до',
    rules: [v => (v === '') || (/^\d+[\.,]{0,1}\d+$/.test(v) || 'Только цифры')],
    component: VTextField,
    prefix: "₽"
  }),
  addSocial: Object.assign({}, Field, {
    component: AddSocial,
    rules: []
  }),
  dutiesAndAccomplishments: Object.assign({}, Field, {
    text: 'Навыки',
    rules: [],
    class: 'input-head',
    component: VSubheader
  }),
  dutiesSelect: Object.assign({}, Field, {
    rules: [],
    component: DutiesSelect
  }),
  educationBlock: Object.assign({}, Field, {
    component: AddEducation,
    rules: []
  }),
  workBlock: Object.assign({}, Field, {
    component: AddWork,
    rules: []
  }),
  aboutMe: Object.assign({}, Field, {
    name: 'aboutMe',
    label: 'О себе',
    rules: [],
    counter: 2000,
    component: VTextarea
  })
}