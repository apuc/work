<template>
  <div>
    <FormTemplate :paramsFile="getFormData()" v-model="formData">

      <image-uploader
        class="input-file"
        :preview="true"
        :className="['fileinput', { 'fileinput--loaded': hasImage }]"
        capture="environment"
        :debug="1"
        doNotResize="gif"
        :autoRotate="true"
        outputFormat="verbose"
        @input="setImage"
      >
        <label for="fileInput" slot="upload-label">
          <span class="upload-caption">Загрузить логотип <img src="../assets/login.png"></span>
        </label>
      </image-uploader>

    </FormTemplate>
  </div>
</template>

<script>
  import FormCompany from '../lk-form/company-form';
  import FormTemplate from "./FormTemplate";
  export default {
    name: "FormVacancy",
    components: {FormTemplate},
    data() {
      return {
        hasImage: false,
        image: null,
        formData: {
          addSocial: {
            vkontakte: '',
            facebook: '',
            instagram: '',
            skype: '',
          }
        }
      }
    },
    methods: {
      getFormData() {
        return FormCompany;
      },
      setImage: function(output) {
        this.hasImage = true;
        this.image = output;
      }
    },
  }
</script>

<style scoped>
</style>