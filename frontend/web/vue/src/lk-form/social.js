import Field from '../models/Field';
import {VTextField,} from 'vuetify/lib'

export default {
  vkontakte: Object.assign({}, Field, {
    name: 'vkontakte',
    label: 'Vkontakte',
    rules: [],
    component: VTextField,
  }),
  facebook: Object.assign({}, Field, {
    name: 'facebook',
    label: 'Facebook',
    rules: [],
    component: VTextField,
  }),
  instagram: Object.assign({}, Field, {
    name: 'instagram',
    label: 'Instagram',
    rules: [],
    component: VTextField,
  }),
  skype: Object.assign({}, Field, {
    name: 'skype',
    label: 'Skype',
    rules: [],
    component: VTextField,
  }),
}