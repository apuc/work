<template>
  <div class="item-block">
    <v-subheader class="input-head" v-on:click="show = !show">Образование</v-subheader>
    <transition name="fade">
      <div v-if="!show">
        <div class="education-block" v-for="(item, index) in education" :key="index">

          <v-btn class="remove-education"
                 :id="'removeEducation'+index"
                 @click="removeEducation(index)"
                 v-if="education.length > 1">
            Удалить
          </v-btn>

          <component v-for="(input, indexEducation) in item"
                     :is="input.component"
                     :key="indexEducation"
                     :name="input.name"
                     :label="input.label"
                     :rules="input.rules"
                     :items="input.items"
                     item-text="name"
                     :class="input.class"
                     :type="input.type"
                     v-model="value[index][input.name]"
          >
            {{ input.text }}
          </component>
        </div>
        <v-btn type="button"
               class="btnEducation"
               @click="addNewEducation()"
               v-if="education.length < 5"
        >
          Добавить образование
        </v-btn>
      </div>
    </transition>
  </div>
</template>

<script>
  import FormEducation from '../lk-form/education';
  import Field from '../models/Field';
  import {VTextField, VSelect} from 'vuetify/lib'
  export default {
    name: "AddEducation",
    data() {
      return {
        education: [FormEducation],
        show: false
      };
    },
    props: {
      value: {
        type: [Array],
      }
    },
    methods: {
      removeEducation(index) {
        this.education.splice(index, 1);
        this.value.splice(index, 1);
      },
      addNewEducation() {
        const template = {
          name: Object.assign({}, Field, {
            name: 'name',
            label: 'Название университета*',
            component: VTextField,
            rules: [v => !!v  || 'Название университета обязателено к заполнению'],
          }),
          year_from: Object.assign({}, Field, {
            name: 'year_from',
            label: 'Год поступления*',
            component: VTextField,
            type: 'number',
            rules: [
              v => !!v  || 'Год поступления обязателен к заполнению',
              v => /^\d+$/.test(v) || 'Только цыфры'
            ],
          }),
          year_to: Object.assign({}, Field, {
            name: 'year_to',
            label: 'Год окончания*',
            component: VTextField,
            type: 'number',
            rules: [
              v => !!v  || 'Год окончания обязателен к заполнению',
              v => /^\d+$/.test(v) || 'Только цыфры'
            ],
          }),
          academic_degree: Object.assign({}, Field, {
            name: 'academic_degree',
            label: 'Академ степень',
            rules: [],
            component: VSelect,
            items: [
              {
                name: 'Бакалавр'
              },
              {
                name: 'Магистр'
              },
            ],
          }),
          faculty: Object.assign({}, Field, {
            name: 'faculty',
            label: 'Факультет*',
            rules: [v => !!v  || 'Факультет обязателен к заполнению'],
            component: VTextField,
          }),
          specialization: Object.assign({}, Field, {
            name: 'specialization',
            label: 'Специализация',
            rules: [],
            component: VTextField,
          }),
        };
        this.education.push(template);
        this.value.push({});
      },
    },
  }
</script>

<style scoped>
</style>