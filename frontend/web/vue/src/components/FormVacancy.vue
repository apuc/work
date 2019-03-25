<template>
  <div>
    <FormTemplate :paramsFile="getFormData()" v-model="formData">
    </FormTemplate>
  </div>
</template>

<script>
  import FormVacancy from '../lk-form/vacancy-form';
  import FormTemplate from "./FormTemplate";
  export default {
    name: "FormVacancy",
    components: {FormTemplate},
    data() {
        return {
            formData: {}
        }
    },
    methods: {
      getFormData() {
        return FormVacancy;
      },
    },
  }
</script>

<style scoped>
</style>