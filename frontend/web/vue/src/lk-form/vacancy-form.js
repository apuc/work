import Field from '../models/Field';
import {VTextarea, VTextField, VSelect} from 'vuetify/lib'

export default {
  vacancyCity: Object.assign({}, Field, {
    name: 'vacancyCity',
    label: 'Город*',
    rules: [v => !!v || 'Город обязателен к заполнению'],
    component: VSelect,
    items: [
      {
        name: '',
        id: ''
      }
    ],
  }),
  companyName: Object.assign({}, Field, {
    name: 'companyName',
    label: 'Компания*',
    rules: [v => !!v || 'Компания обязателен к заполнению'],
    component: VSelect,
    items: [
      {
        name: '',
        id: ''
      }
    ]
  }),
  categoriesVacancy: Object.assign({}, Field, {
    name: 'categoriesVacancy',
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
  post: Object.assign({}, Field, {
    name: 'post',
    label: 'Должность*',
    rules: [v => !!v || 'Должность обязательна к заполнению'],
    component: VTextField
  }),
  duties: Object.assign({}, Field, {
    name: 'duties',
    label: 'Обязанности*',
    rules: [v => !!v || 'Обязанность обязательна к заполнению',],
    counter: 2000,
    component: VTextarea
  }),
  typeOfEmployment: Object.assign({}, Field, {
    name: 'TypeOfEmployment',
    label: 'Тип занятости',
    rules: [],
    component: VSelect,
    items: [
      {
        name: '',
        id: ''
      }
    ]
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
  qualificationRequirements: Object.assign({}, Field, {
    name: 'qualificationRequirements',
    label: 'Требования к квалификации',
    rules: [],
    counter: 2000,
    component: VTextarea
  }),
  experience: Object.assign({}, Field, {
    name: 'experience',
    label: 'Опыт работы',
    component: VSelect,
    rules: [],
    items: [
      {
        name: '',
        id: ''
      }
    ]
  }),
  education: Object.assign({}, Field, {
    name: 'education',
    label: 'Образование',
    component: VSelect,
    rules: [],
    items: [
      {
        name: 'Не имеет значения'
      },
      {
        name: 'Среднее'
      },
      {
        name: 'Неполное высшее'
      },
      {
        name: 'Высшее'
      }
    ]
  }),
  workingConditions: Object.assign({}, Field, {
    name: 'workingConditions',
    label: 'Условия работы',
    rules: [],
    counter: 2000,
    component: VTextarea
  }),
  vacancyVideo: Object.assign({}, Field, {
    name: 'vacancyVideo',
    label: 'Видео о вакансии',
    rules: [],
    component: VTextField
  }),
  officeAddress: Object.assign({}, Field, {
    name: 'officeAddress',
    label: 'Адрес офиса',
    rules: [],
    component: VTextField
  }),
  houseNumber: Object.assign({}, Field, {
    name: 'houseNumber',
    label: 'Номер дома',
    rules: [],
    component: VTextField
  }),
}