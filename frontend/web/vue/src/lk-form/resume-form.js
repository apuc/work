import Field from '../models/Field';
import {VTextarea, VTextField, VSelect, VCheckbox, VSubheader,} from 'vuetify/lib'
import AddWork from "../components/AddWork";
import AddEducation from "../components/AddEducation";
import AddSocial from "../components/AddSocial";

export default {
  resumeCity: Object.assign({}, Field, {
    name: 'resumeCity',
    label: 'Город*',
    rules: [v => !!v  || 'Город обязателен к заполнению'],
    component: VTextField,
  }),
  careerObjective: Object.assign({}, Field, {
    name: 'careerObjective',
    label: 'Желаемая должность*',
    rules: [v => !!v  || 'Желаемая должность обязателена к заполнению'],
    component: VTextField,
  }),
  categoriesResume: Object.assign({}, Field, {
    name: 'categoriesResume',
    label: 'Категория',
    rules: [v => !!v  || 'Категория обязателена к заполнению'],
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
  // careerObjectiveCheckbox: Object.assign({}, Field, {
  //   name: 'careerObjectiveCheckbox',
  //   label: 'Показать желаемую должность в резюме',
  //   rules: [],
  //   component: VCheckbox,
  // }),
  salaryFrom: Object.assign({}, Field, {
    name: 'salaryFrom',
    label: 'Зарплата в месяц от',
    rules: [v => /^\d+[\.,]{0,1}\d+$/.test(v) || 'Только цифры'],
    component: VTextField,
    prefix: "₽",
  }),
  salaryBefore: Object.assign({}, Field, {
    name: 'salaryBefore',
    label: 'Зарплата в месяц до',
    rules: [v => /^\d+[\.,]{0,1}\d+$/.test(v) || 'Только цифры'],
    component: VTextField,
    prefix: "₽",
  }),
  aboutMe: Object.assign({}, Field, {
    name: 'aboutMe',
    label: 'О себе',
    rules: [],
    counter: 2000,
    component: VTextarea,
  }),
  addSocial: Object.assign({}, Field, {
    component: AddSocial,
    rules: [],
  }),
  educationBlock: Object.assign({}, Field, {
    component: AddEducation,
    rules: [],
  }),
  workBlock: Object.assign({}, Field, {
    component: AddWork,
    rules: [],
  }),
  dutiesAndAccomplishments: Object.assign({}, Field, {
    text: 'Обязанности / Достижения',
    rules: [],
    class: 'input-head',
    component: VSubheader,
  }),
  duties0: Object.assign({}, Field, {
    name: 'duties0',
    label: '1.',
    rules: [],
    class: 'duties',
    component: VTextField,
  }),
  duties1: Object.assign({}, Field, {
    name: 'duties1',
    label: '2.',
    rules: [],
    class: 'duties',
    component: VTextField,
  }),
  duties2: Object.assign({}, Field, {
    name: 'duties2',
    label: '3.',
    rules: [],
    class: 'duties',
    component: VTextField,
  }),
  duties3: Object.assign({}, Field, {
    name: 'duties3',
    label: '4.',
    rules: [],
    class: 'duties',
    component: VTextField,
  }),
  duties4: Object.assign({}, Field, {
    name: 'duties4',
    label: '5.',
    rules: [],
    class: 'duties',
    component: VTextField,
  }),
  duties5: Object.assign({}, Field, {
    name: 'duties5',
    label: '6.',
    rules: [],
    class: 'duties',
    component: VTextField,
  }),
}