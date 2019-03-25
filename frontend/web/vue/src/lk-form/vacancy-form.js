import Field from '../models/Field';
import {VTextarea, VTextField, VSelect} from 'vuetify/lib'

export default {
  post: Object.assign({}, Field, {
    name: 'post',
    label: 'Должность*',
    rules: [
      v => !!v || 'Должность обязательна к заполнению',
      v => (v && v.length >= 5) || 'Больше 5 символов'
    ],
    counter: 50,
    component: VTextField,
  }),
  duties: Object.assign({}, Field, {
    name: 'duties',
    label: 'Обязанности*',
    rules: [v => !!v || 'Обязанность обязательна к заполнению',],
    counter: 2000,
    component: VTextarea,
  }),
  typeOfEmployment: Object.assign({}, Field, {
    name: 'TypeOfEmployment',
    label: 'Тип занятости*',
    rules: [v => !!v || 'Тип занятости обязателен к заполнению'],
    component: VSelect,
    items: ['Полный рабочий день', 'Удаленная работа', 'Студент'],
  }),
  schedule: Object.assign({}, Field, {
    name: 'Schedule',
    label: 'График работы*',
    rules: [v => !!v || 'График работы обязателен к заполнению'],
    component: VSelect,
    items: [
      'Полный рабочий день',
      'Удаленная работа',
      'Студент'
    ],
  }),
  salaryFrom: Object.assign({}, Field, {
    name: 'salaryFrom',
    label: 'Зарплата в месяц от',
    rules: [v => /^\d+$/.test(v) || 'Только цыфры'],
    component: VTextField,
    prefix: "₽",
  }),
  salaryBefore: Object.assign({}, Field, {
    name: 'salaryBefore',
    label: 'Зарплата в месяц до',
    rules: [v => /^\d+$/.test(v) || 'Только цыфры'],
    component: VTextField,
    prefix: "₽",
  }),
  qualificationRequirements: Object.assign({}, Field, {
    name: 'qualificationRequirements',
    label: 'Требования к квалификации*',
    rules: [ v => !!v || 'Требования к квалификации обязательна к заполнению'],
    counter: 2000,
    component: VTextarea,
  }),
  experience: Object.assign({}, Field, {
    name: 'experience',
    label: 'Опыт работы',
    component: VSelect,
    rules: [],
    items: [
      'Не имеет значения',
      'Менее года',
      '1 год',
      '2 года',
    ],
  }),
  education: Object.assign({}, Field, {
    name: 'education',
    label: 'Образование',
    component: VSelect,
    rules: [],
    items: [
      'Не имеет значения',
      'Среднее',
      'Неполное высшее',
      'Высшее',
    ],
  }),
  workingConditions: Object.assign({}, Field, {
    name: 'workingConditions',
    label: 'Условия работы*',
    rules: [ v => !!v || 'Условия работы обязательна к заполнению'],
    counter: 2000,
    component: VTextarea,
  }),
  vacancyVideo: Object.assign({}, Field, {
    name: 'vacancyVideo',
    label: 'Видео о вакансии',
    rules: [],
    component: VTextField,
  }),
  officeAdress: Object.assign({}, Field, {
    name: 'officeAdress',
    label: 'Адрес офиса',
    rules: [v => (v && v.length >= 5) || 'Больше 5 символов'],
    component: VTextField,
  }),
  houseNumber: Object.assign({}, Field, {
    name: 'houseNumber',
    label: 'Номер дома',
    rules: [],
    component: VTextField,
  }),
}