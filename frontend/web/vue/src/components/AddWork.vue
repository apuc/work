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
                     item-text="name"
                     item-value="id"
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
          name: Object.assign({}, Field, {
            name: 'name',
            label: 'Название компании*',
            component: VTextField,
            rules: [v => !!v || 'Название компании обязателено к заполнению'],
          }),
          post: Object.assign({}, Field, {
            name: 'post',
            label: 'Должность*',
            component: VTextField,
            rules: [v => !!v || 'Должность обязателена к заполнению'],
          }),
          department: Object.assign({}, Field, {
            name: 'department',
            label: 'Отдел',
            component: VTextField,
            rules: [],
          }),
          month_from: Object.assign({}, Field, {
            name: 'month_from',
            label: 'Месяц начала*',
            rules: [v => !!v || 'Месяц начала обязателен к заполнению'],
            component: VSelect,
            items: [
              {
                name: 'Январь',
                id: 1
              },
              {
                name: 'Февраль',
                id: 2
              },
              {
                name: 'Март',
                id: 3
              },
              {
                name: 'Апрель',
                id: 4
              },
              {
                name: 'Май',
                id: 5
              },
              {
                name: 'Июнь',
                id: 6
              },
              {
                name: 'Июль',
                id: 7
              },
              {
                name: 'Август',
                id: 8
              },
              {
                name: 'Сентябрь',
                id: 9
              },
              {
                name: 'Октябрь',
                id: 10
              },
              {
                name: 'Ноябрь',
                id: 11
              },
              {
                name: 'Декабрь',
                id: 12
              },
            ],
          }),
          year_from: Object.assign({}, Field, {
            name: 'year_from',
            label: 'Год начала*',
            component: VTextField,
            type: 'number',
            rules: [
              v => !!v || 'Год начала обязателен к заполнению',
              v => /^\d+$/.test(v) || 'Только цыфры'
            ],
          }),
          month_to: Object.assign({}, Field, {
            name: 'month_to',
            label: 'Месяц окончания*',
            rules: [v => !!v || 'Месяц окончания обязателен к заполнению'],
            component: VSelect,
            items: [
              {
                name: 'Январь',
                id: 1
              },
              {
                name: 'Февраль',
                id: 2
              },
              {
                name: 'Март',
                id: 3
              },
              {
                name: 'Апрель',
                id: 4
              },
              {
                name: 'Май',
                id: 5
              },
              {
                name: 'Июнь',
                id: 6
              },
              {
                name: 'Июль',
                id: 7
              },
              {
                name: 'Август',
                id: 8
              },
              {
                name: 'Сентябрь',
                id: 9
              },
              {
                name: 'Октябрь',
                id: 10
              },
              {
                name: 'Ноябрь',
                id: 11
              },
              {
                name: 'Декабрь',
                id: 12
              },
            ],
          }),
          year_to: Object.assign({}, Field, {
            name: 'year_to',
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