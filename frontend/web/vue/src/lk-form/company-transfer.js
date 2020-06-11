import Field from '../models/Field';
import {VTextField} from 'vuetify/lib'

export default {
    companyTransfer: Object.assign({}, Field, {
        name: 'companyTransfer',
        label: 'Email',
        rules: [v => /.+@.+/.test(v) || 'Email должен быть правильным'],
        component: VTextField
    })
}