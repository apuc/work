<template>
  <v-form
    ref="form"
    v-model="valid"

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
               :autocomplete="false"
               v-model="value[index]"
    >
      {{ input.text }}
    </component>

    <slot name="bottom" />

    <v-btn
      :disabled="!valid"
      color="success"
      id="main-btn"
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
        let valid = this.$refs.form.validate();
        this.$emit('val', valid);
        if (valid && this.value.phoneValid) {
          this.valid = false;
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
    cursor: pointer;
  }
  .input-file img {
    width: auto;
    max-width: 200px;
  }
  .work-image-uploader {
    display: flex;
    flex-direction: row;
    align-items: flex-start;
    margin-bottom: 20px;
  }
  .work-image-uploader button {
    margin-bottom: 20px;
    outline: none;
  }
  .vue-image-crop-upload .vicp-wrap .vicp-step2 .vicp-crop .vicp-crop-right .vicp-preview .vicp-preview-item span {
    left: 0;
  }
  .custom-error {
    height: 18px;
    margin: 8px 0 0;
    font-size: 12px;
    color: #ff5252;
  }
  .all-banners .v-list--two-line .v-list__tile {
    height: auto !important;
  }

  .disabled-banner .v-select__slot {
      background: #d2d2d2;
  }
  .widthMC {
      width: max-content !important;
  }
  .mr5 {
      margin-right: 5px;
  }
  .ml5 {
      margin-left: 5px;
  }
</style>
