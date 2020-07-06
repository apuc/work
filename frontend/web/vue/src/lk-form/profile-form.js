import Field from '../models/Field';
import {VTextField} from 'vuetify/lib'
import DatePicker from '../components/DatePicker'

export default {
  first_name: Object.assign({}, Field, {
    name: 'fist_name',
    label: 'Имя',
    rules: [],
    component: VTextField
  }),
  second_name: Object.assign({}, Field, {
    name: 'second_name',
    label: 'Фамилия',
    rules: [],
    component: VTextField
  }),
  email: Object.assign({}, Field, {
    name: 'email',
    label: 'Email*',
    rules: [v => /.+@.+/.test(v) || 'Email должен быть правильным'],
    component: VTextField
  }),
}
