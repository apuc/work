import Field from '../models/Field';
import {VTextField} from 'vuetify/lib'
import DatePicker from '../components/DatePicker'

export default {
    old_password: Object.assign({}, Field, {
        name: 'old_password',
        label: 'Старый пароль',
        rules: [],
        type: 'password',
        component: VTextField
    }),
    new_password_1: Object.assign({}, Field, {
        name: 'new_password_1',
        label: 'Новый пароль',
        rules: [],
        type: 'password',
        component: VTextField
    }),
    new_password_2: Object.assign({}, Field, {
        name: 'new_password_2',
        label: 'Повторите новый пароль',
        rules: [],
        type: 'password',
        component: VTextField
    }),
}