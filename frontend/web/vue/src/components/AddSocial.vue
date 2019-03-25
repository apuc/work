<template>
  <div class="social-block">
    <v-btn v-on:click="show = !show">
      Добавить аккаунты в социальных сетях
    </v-btn>
    <transition name="fade">
      <div v-if="!show">
        <component v-for="(input, index) in getFormData()"
                   :is="input.component"
                   :key="index"
                   :name="input.name"
                   :label="input.label"
                   :rules="input.rules"
                   v-model="value[input.name]"
        >
        </component>
      </div>
    </transition>
  </div>
</template>

<script>
  import Social from '../lk-form/social'

  export default {
    name: 'AddSocial',
    data() {
      return {
        show: true
      }
    },
    props: {
      value: {
        type: [String,Number,Boolean,Array,Object],
      }
    },
    components: {Social},
    methods: {
      getFormData() {
        return Social;
      },
    },
  }
</script>

<style>
  .social-block {
    margin-bottom: 30px;
  }
</style>