import Field from '../models/Field';
import {VTextarea, VTextField, VSelect, VSubheader, VCheckbox, VAutocomplete} from 'vuetify/lib'
import AddWork from "../components/AddWork";
import AddEducation from "../components/AddEducation";
import AddSocial from "../components/AddSocial";
import DutiesSelect from "../components/DutiesSelect";

export default {
  resumeCity: Object.assign({}, Field, {
    name: 'resumeCity',
    label: 'Город*',
    rules: [v => !!v  || 'Город обязателен к заполнению'],
    component: VAutocomplete,
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
    component: VAutocomplete,
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
    rules: [v => v.length <= 11 || 'Не более 11 символов', v => new RegExp('^\\d*(\\.\\d+)?$').test(v) || 'Только цифры'],
    component: VTextField,
    prefix: "₽"
  }),
  salaryBefore: Object.assign({}, Field, {
    name: 'salaryBefore',
    label: 'Зарплата в месяц до',
    rules: [v => v.length <= 11 || 'Не более 11 символов', v => new RegExp('^\\d*(\\.\\d+)?$').test(v) || 'Только цифры'],
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
    counter: 10000,
    component: VTextarea
  }),
  hideResume: Object.assign({}, Field, {
    name: 'hideResume',
    label: 'Скрыть резюме (не отображается на сайте, доступно для откликов)',
    rules: [],
    component: VCheckbox
  }),
}