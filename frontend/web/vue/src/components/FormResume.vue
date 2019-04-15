<template>
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
        <span class="upload-caption">Выбрать фото <img src="../assets/login.png"></span>
      </label>
    </image-uploader>

  </FormTemplate>
</template>

<script>
  import FormResume from '../lk-form/resume-form';
  import FormTemplate from "./FormTemplate";
  import Resume from "../mixins/resume";
  export default {
    name: 'FormResume',
    mixins: [Resume],
    components: {FormTemplate},
    methods: {
      saveData() {
        let data = {
          image_url: '',
          title: this.formData.careerObjective,
          min_salary: this.formData.salaryFrom.replace(",","."),
          max_salary: this.formData.salaryBefore.replace(",","."),
          description: this.formData.aboutMe,
          vk: this.formData.addSocial.vkontakte,
          facebook: this.formData.addSocial.facebook,
          instagram: this.formData.addSocial.instagram,
          skype: this.formData.addSocial.skype,
          education: this.formData.educationBlock,
          work: this.formData.workBlock,
          skills: [],
        };
        let image = document.querySelector('.fileinput');
        if(image.classList.contains('fileinput--loaded')) {
          data.image_url = this.image.name;
        }

        let dutiesVal = document.querySelectorAll('.duties input');
        for (let i = 0; i < dutiesVal.length; i++) {
          if (dutiesVal[i].value !== '') {
            data.skills.push({name: dutiesVal[i].value})
          }
        }
        this.$http.post(`${process.env.VUE_APP_API_URL}/request/resume`, data)
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
        return FormResume;
      },
      setImage: function(output) {
        this.hasImage = true;
        this.image = output;
      },
      // setValue(data) {
      //   console.log('setValue --->', data)
      //   this.formData.careerObjective = data.title;
      // }
    },
  }
</script>

<style>
  .input-file {
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    margin-top: 20px;
  }
  #fileInput {
    display: none;
  }
  .input-file label {
    margin-top: 20px;
    color: rgba(0,0,0,0.54);
    cursor: pointer;
  }
  .showRemoveBtn {
    display: inline-flex !important;
  }
  .upload-caption {
    display: flex;
    align-items: center;
    margin-bottom: 30px;
  }
  .upload-caption img {
    width: 20px;
    margin-left: 10px;
  }
  .fade-enter-active, .fade-leave-active {
    transition: opacity .3s;
  }
  .fade-enter, .fade-leave-to {
    opacity: 0;
  }
  .remove-work, .remove-education {
    margin-top: 30px;
  }
  .item-block {
    margin-bottom: 20px;
  }
</style>