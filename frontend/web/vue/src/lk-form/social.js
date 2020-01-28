import Field from '../models/Field';
import {VTextField,} from 'vuetify/lib'

export default {
  vkontakte: Object.assign({}, Field, {
    name: 'vkontakte',
    label: 'Vkontakte',
    rules: [],
    component: VTextField,
    prefix: 'https://vk.com/',
    placeholder: 'id'
  }),
  facebook: Object.assign({}, Field, {
    name: 'facebook',
    label: 'Facebook',
    rules: [],
    component: VTextField,
    prefix: 'https://www.facebook.com/',
    placeholder: 'nikname'
  }),
  instagram: Object.assign({}, Field, {
    name: 'instagram',
    label: 'Instagram',
    rules: [],
    component: VTextField,
    prefix: 'https://www.instagram.com/',
    placeholder: 'nikname'
  }),
  skype: Object.assign({}, Field, {
    name: 'skype',
    label: 'Skype',
    rules: [],
    component: VTextField,
    prefix: '',
    placeholder: 'login'
  }),
}