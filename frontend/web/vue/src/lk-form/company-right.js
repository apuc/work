import Field from '../models/Field';
import {VTextField} from 'vuetify/lib'

export default {
    companyRight: Object.assign({}, Field, {
        name: 'companyRight',
        label: 'Email',
        rules: [v => /.+@.+/.test(v) || 'Email должен быть правильным'],
        component: VTextField
    })
}