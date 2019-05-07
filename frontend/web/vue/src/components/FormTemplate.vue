<template>
  <v-form
    ref="form"
    v-model="valid"
    lazy-validation
  >
    <slot />
    <component v-for="(input, index) in formTemplate()"
               :is="input.component"
               :key="index"
               :name="input.name"
               :label="input.label"
               :id="input.id"
               :rules="input.rules"
               :counter="input.counter"
               :items="input.items"
               item-text="name"
               item-value="id"
               :prefix="input.prefix"
               :mask="input.maskPhone"
               :class="input.class"
               :type="input.type"
               :attach="input.attach"
               :multiple="input.multiple"
               :chips="input.chips"
               v-model="value[index]"
    >
      {{ input.text }}
    </component>

    <v-btn
      :disabled="!valid"
      color="success"
      @click="validate"
      type="button"
    >
      Сохранить
    </v-btn>

  </v-form>
</template>

<script>
  export default {
    name: "FormTemplate",
    data: () => ({
      valid: true,
    }),
    props: {
      sendForm: Function,
      paramsFile: Object,
      value: {
        type: Object,
      },
    },
    methods: {
      formTemplate() {
        return this.paramsFile;
      },
      validate () {
        if (this.$refs.form.validate()) {
          this.snackbar = true;
          this.sendForm();
        }
      },
    },
  }
</script>

<style>
  .theme--light.v-subheader.input-head {
    color: rgba(0,0,0,0.74);
  }
  .input-head {
    margin-top: 10px;
    margin-bottom: 15px;
    padding: 0;
    font-size: 22px;
    border-bottom: 3px solid rgba(0,0,0,0.74);
  }
  .input-file img {
    width: auto;
    max-width: 200px;
  }
</style>