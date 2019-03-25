<template>
  <div class="item-block">
    <v-subheader class="input-head" v-on:click="show = !show">Опыт работы</v-subheader>
    <transition name="fade">
      <div v-if="!show">
        <div class="work-block" v-for="(item, index) in works" :key="index">

          <v-btn class="remove-work" :id="'removeWork'+index" @click="removeWork(index)" v-if="works.length > 1">
            Удалить
          </v-btn>

          <component v-for="(input, indexInput) in item"
                     :is="input.component"
                     :key="indexInput"
                     :name="indexInput"
                     :label="input.label"
                     :rules="input.rules"
                     :items="input.items"
                     :class="input.class"
                     :type="input.type"
                     v-model="value[index][input.name]"
          >
            {{ input.text }}
          </component>
        </div>
        <v-btn type="button" class="btnWork"
               @click="addNewWork()"
               v-if="works.length < 5"
        >
          Добавить опыт работы
        </v-btn>
      </div>
    </transition>

  </div>
</template>

<script>
  import FormExperience from '../lk-form/experience';
  import Field from '../models/Field';
  import {VTextField, VSelect} from 'vuetify/lib'

  export default {
    name: "AddWork",
    props: {
      value: {
        type: [Array],
      }
    },
    data() {
      return {
        works: [FormExperience],
        show: false
      };
    },
    methods: {
      removeWork(index) {
        this.works.splice(index, 1);
        this.value.splice(index, 1);
      },
      addNewWork() {
        const template = {
          companyName: Object.assign({}, Field, {
            name: `companyName${this.works.length}`,
            label: 'Название компании*',
            component: VTextField,
            rules: [v => !!v || 'Название компании обязателено к заполнению'],
          }),
          positionWork: Object.assign({}, Field, {
            name: `positionWork${this.works.length}`,
            label: 'Должность*',
            component: VTextField,
            rules: [v => !!v || 'Должность обязателена к заполнению'],
          }),
          departmentWork: Object.assign({}, Field, {
            name: `departmentWork${this.works.length}`,
            label: 'Отдел',
            component: VTextField,
            rules: [],
          }),
          monthBeganWork: Object.assign({}, Field, {
            name: `monthBeganWork${this.works.length}`,
            label: 'Месяц начала*',
            rules: [v => !!v || 'Месяц начала обязателен к заполнению'],
            component: VSelect,
            items: [
              'Январь',
              'Февраль',
              'Март',
              'Апрель',
              'Май',
              'Июнь',
              'Июль',
              'Август',
              'Сентябрь',
              'Октябрь',
              'Ноябрь',
              'Декабрь',
            ],
          }),
          startYearWork: Object.assign({}, Field, {
            name: `startYearWork${this.works.length}`,
            label: 'Год начала*',
            component: VTextField,
            type: 'number',
            rules: [
              v => !!v || 'Год начала обязателен к заполнению',
              v => /^\d+$/.test(v) || 'Только цыфры'
            ],
          }),
          endMonthWork: Object.assign({}, Field, {
            name: `endMonthWork${this.works.length}`,
            label: 'Месяц окончания*',
            rules: [v => !!v || 'Месяц окончания обязателен к заполнению'],
            component: VSelect,
            items: [
              'Январь',
              'Февраль',
              'Март',
              'Апрель',
              'Май',
              'Июнь',
              'Июль',
              'Август',
              'Сентябрь',
              'Октябрь',
              'Ноябрь',
              'Декабрь',
            ],
          }),
          yearOfEndingWork: Object.assign({}, Field, {
            name: `yearOfEndingWork${this.works.length}`,
            label: 'Год окончания*',
            component: VTextField,
            type: 'number',
            rules: [
              v => !!v || 'Год окончания обязателен к заполнению',
              v => /^\d+$/.test(v) || 'Только цыфры'
            ],
          }),
        };
        this.works.push(template);
        this.value.push({});
      },
    },
  }
</script>

<style scoped>

</style>