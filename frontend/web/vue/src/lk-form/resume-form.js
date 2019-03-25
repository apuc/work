import Field from '../models/Field';
import {VTextarea, VTextField, VSelect, VCheckbox, VSubheader,} from 'vuetify/lib'
import AddWork from "../components/AddWork";
import AddEducation from "../components/AddEducation";
import AddSocial from "../components/AddSocial";

export default {
  name: Object.assign({}, Field, {
    name: 'name',
    label: 'Имя*',
    rules: [
      v => !!v || 'Имя обязательно к заполнению',
      v => (v && v.length >= 3) || 'Больше 3 символов'
    ],
    counter: 15,
    component: VTextField,
  }),
  surname: Object.assign({}, Field, {
    name: 'surname',
    label: 'Фамилия*',
    rules: [v => !!v || 'Фамилия обязательна к заполнению',],
    counter: 20,
    component: VTextField,
  }),
  email: Object.assign({}, Field, {
    name: 'email',
    label: 'E-mail*',
    rules: [
      v => !!v || 'E-mail обязателен к заполнению',
      v => /.+@.+/.test(v) || 'Введите правильный E-mail'
    ],
    component: VTextField,
  }),
  phoneNumber: Object.assign({}, Field, {
    name: 'phoneNumber',
    label: 'Мобильный*',
    rules: [
      v => !!v || 'Мобильный обязателен к заполнению',
      v => (v && v.length >= 11) || 'Введите 11 символов'
    ],
    component: VTextField,
    maskPhone: '+# (###) ## - ## - ###',
  }),
  careerObjective: Object.assign({}, Field, {
    name: 'careerObjective',
    label: 'Желаемая должность*',
    rules: [v => !!v  || 'Желаемая должность обязателена к заполнению'],
    component: VTextField,
  }),
  careerObjectiveCheckbox: Object.assign({}, Field, {
    name: 'careerObjectiveCheckbox',
    label: 'Показать желаемую должность в резюме',
    rules: [],
    component: VCheckbox,
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
  duties1: Object.assign({}, Field, {
    name: 'duties1',
    label: '1.',
    rules: [],
    component: VTextField,
  }),
  duties2: Object.assign({}, Field, {
    name: 'duties2',
    label: '2.',
    rules: [],
    component: VTextField,
  }),
  duties3: Object.assign({}, Field, {
    name: 'duties3',
    label: '3.',
    rules: [],
    component: VTextField,
  }),
  duties4: Object.assign({}, Field, {
    name: 'duties4',
    label: '4.',
    rules: [],
    component: VTextField,
  }),
  duties5: Object.assign({}, Field, {
    name: 'duties5',
    label: '5.',
    rules: [],
    component: VTextField,
  }),
  duties6: Object.assign({}, Field, {
    name: 'duties6',
    label: '6.',
    rules: [],
    component: VTextField,
  }),
}