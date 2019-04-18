<template>
  <div>
    <FormTemplate :paramsFile="getFormData()" v-model="formData" :sendForm="saveData">

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
    name: "FormCompany",
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
    created() {
      document.title = this.$route.meta.title;
    },
    methods: {
      saveData() {
        let data = {
          user_id: '2',
          image_url: '',
          name: this.formData.nameCompany,
          website: this.formData.site,
          max_salary: this.formData.scopeOfTheCompany,
          vk: this.formData.addSocial.vkontakte,
          facebook: this.formData.addSocial.facebook,
          instagram: this.formData.addSocial.instagram,
          skype: this.formData.addSocial.skype,
          description: this.formData.aboutCompany,
          contact_person: this.formData.contactPerson,
          phone: this.formData.companyPhone,
        };
        let image = document.querySelector('.fileinput');
        if(image.classList.contains('fileinput--loaded')) {
          data.image_url = this.image.name;
        }
        this.$http.post(`${process.env.VUE_APP_API_URL}/request/company`, data)
          .then(response => {
              console.log(response);
              console.log('Форма успешно отправлена');
            }, response => {
              console.log(response);
              console.log('Форма не отправлена');
            }
          )
      },
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